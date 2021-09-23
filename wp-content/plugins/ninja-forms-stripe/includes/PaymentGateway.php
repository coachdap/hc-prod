<?php if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'NF_Abstracts_PaymentGateway' ) ) return;

use NinjaForms\Stripe\Checkout\URL;
use NinjaForms\Stripe\Checkout\Payment;
use NinjaForms\Stripe\Checkout\Subscription;
use NinjaForms\Stripe\Checkout\LineItemFactory;
use NinjaForms\Stripe\Checkout\PaymentIntent\Metadata;
use NinjaForms\Stripe\Checkout\PaymentIntent\Shipping;

/**
 * The Stripe payment gateway for the Collect Payment action.
 */
class NF_Stripe_Checkout_PaymentGateway extends NF_Abstracts_PaymentGateway
{
    protected $_slug = 'stripe';

    protected $forms = array();

    protected $test_secret_key;

    protected $test_publishable_key;

    protected $live_secret_key;

    protected $live_publishable_key;

    public function __construct()
    {
        parent::__construct();

        $this->tmp_product_name = 'Stripe Payment';

        if( isset( $_GET[ 'form_id' ] ) ) {
            $form_name = Ninja_Forms()->form( $_GET[ 'form_id' ] )->get()->get_setting('title');
            $this->tmp_product_name = $form_name . " " 
                . $this->tmp_product_name;
        }

        $this->_name = __( 'Stripe', 'ninja-forms-stripe' );

        add_action( 'init', array( $this, 'init' ) );

        add_action( 'ninja_forms_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        
        add_action( 'nf_admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
        
        $api_url = add_query_arg( array(
                                    'page' => 'nf-settings'
                                ), admin_url() . 'admin.php' );
        
        // Include settings directly to maintain scope of variables in the config.
        $this->_settings = include NF_Stripe_Checkout::$dir . 'includes/Config/ActionSettings.php';

        add_action( 'ninja_forms_builder_templates', array( $this, 'nf_stripe_load_templates' ) );
    }

    /**
     * Function to output display templates.
     */
    public function nf_stripe_load_templates()
    {
        // Template path.
        $file_path = plugin_dir_path( __FILE__ ) . 'Templates' . DIRECTORY_SEPARATOR;
        // Template file list.
        $template_list = array(
            'drawer-settings',
	        'Modal'
        );
        
        foreach( $template_list as $template ){
            if ( file_exists( $file_path . "$template.html.php" ) ) {
	            NF_Stripe_Checkout()->template( "$template.html.php" );
            }
        }
        ?>
	    <div id="nfStripe"></div>
	    <?php
    }

    /**
     * Process
     *
     * The main function for processing submission data.
     *
     * @param array $action_settings Action specific settings.
     * @param int $form_id The ID of the submitted form.
     * @param array $data Form submission data.
     * @return array $data Modified submission data.
     */
    public function process($action_settings, $form_id, $data)
    {
        $settings = new NF_Stripe_Checkout_ActionSettings($action_settings);
        $form_data = new NF_Stripe_Checkout_FormData($data);
        $stripe_customer_id = '';
        $card_brand = '';
        $card_last_four = '';

        if ( ( 0 == $settings->has_total() || ! $settings->has_total() ) && ! $settings->has_plan()) {
            return $form_data->toArray();
        }

        $dir = NF_Stripe_Checkout::$dir . "vendor/autoload.php";
        require $dir;

        $api_secret_key_code = 'stripe_test_secret_key';

        if (! $action_settings[ 'stripe_test_mode' ]) {
            $api_secret_key_code = 'stripe_live_secret_key';
        }

        $secret_key = Ninja_Forms()->get_setting($api_secret_key_code);
        \Stripe\Stripe::setApiKey($secret_key);

        if ($form_data->is_success()) {
            if ($form_data->has_submission_id()) {
                $submission = NF_Stripe_Checkout_Submission::create($form_data->get_submission_id());

                if ($submission->get_payment_intent_id()) {
                    try {
                        $payment_intent = \Stripe\PaymentIntent::retrieve($submission->get_payment_intent_id());

                        $stripe_customer_id = $payment_intent->customer;

                        if ( ! empty($action_settings['stripe_product_description'] ) ) {
                            $payment_intent::update($submission->get_payment_intent_id(), array('description' => $action_settings['stripe_product_description']) );
                        }

                        $charge = reset($payment_intent->charges->data);
                        if ($charge) {
                            $submission->set_charge_id($charge->id);
                            Ninja_Forms()->merge_tags['stripe']->set('chargeID', $charge->id);
                            $card_brand = $charge->payment_method_details->card->brand;
                            $card_last_four = $charge->payment_method_details->card->last4;
                        }
                    } catch (Exception $e) {
                        if (current_user_can('manage_options')) {
                            $form_data->add_form_error('stripe', $e->getMessage());
                        } else {
                            $form_data->add_form_error(
                                'stripe',
                                __(
                                    'Error completing payment session.',
                                    'ninja-forms-stripe'
                                )
                            );
                        }
                        return $form_data->toArray(); // Return early with error.
                    }
                } else {
                    $session_obj = \Stripe\Checkout\Session::retrieve($submission->get_stripe_session_id());

                    $sub_id = $session_obj->subscription;

                    $submission->set_stripe_subscription_id($sub_id);

                    $subscription = \Stripe\Subscription::retrieve($sub_id);
                    $payment_method_id = $subscription->default_payment_method;

                    $payment_method = \Stripe\PaymentMethod::retrieve($payment_method_id);

                    $stripe_customer_id = $subscription->customer;
                    $card_brand = $payment_method->card->brand;
                    $card_last_four = $payment_method->card->last4;

                    // Handle subscription metadata.
                    $metadata = Metadata::create( $action_settings );
                    try {
                        $customer = \Stripe\Customer::update( $stripe_customer_id, array( 'metadata' => $metadata->toArray() ) );
                    } catch( Exception $e ) {
                        $submission->set_stripe_error($e->getMessage());
                    }
                }

                $submission->set_customer_id($stripe_customer_id);
                Ninja_Forms()->merge_tags['stripe']->set('customerID', $stripe_customer_id);
                $submission->set_payment_status('Complete');
                $submission->set_card_brand($card_brand);
                Ninja_Forms()->merge_tags['stripe']->set('cardtype', $card_brand);
                $submission->set_card_last_four($card_last_four);
                Ninja_Forms()->merge_tags['stripe']->set('last4', $card_last_four);

                $submission->save();
            }
        } elseif ($form_data->isCancelled()) {
            $form_data->add_form_error('stripe', __('Payment Cancelled', 'ninja-forms-stripe'));
        } else {
            $payment = new Payment();

            if ($settings->has_plan()) {
                $plan = $settings->get_plan();

                $sub = new Subscription($plan);

                if ($settings->hasTrial()) {
                    $sub->setTrialPeriod($settings->getTrialPeriod());
                }

                $payment->attach_subscription($sub);
            } else {
                $line_item = LineItemFactory::create( $action_settings, $form_data->get_currency() );
                $payment->attach_line_item( $line_item );
                $payment->attach_metadata( Metadata::create( $action_settings ) );
            }

            $payment->attach_customer_email( $settings->get_email()) ;
            $payment->attach_shipping( Shipping::create( $action_settings ) );

            $payment->set_success_url( URL::create($form_id, 'success') );
            $payment->set_cancel_url( URL::create($form_id, 'cancel') );

            try {
                $session = \Stripe\Checkout\Session::create( $payment->toArray() );
            } catch( Exception $e ) {
                if(current_user_can('manage_options')){
                    $form_data->add_form_error('stripe', $e->getMessage());
                } else {
                    $form_data->add_form_error('stripe', __('Error creating payment session.', 'ninja-forms-stripe'));
                }
                return $form_data->toArray(); // Return early with error.
            }
 
            $form_data->attach_session($session);

            if($form_data->has_submission_id()){
                $submission = NF_Stripe_Checkout_Submission::create($form_data->get_submission_id());
                $submission->set_payment_status('Pending');
                if(! $action_settings[ 'stripe_test_mode' ]) $submission->set_stripe_live( true );
                $submission->set_stripe_session_id( $session->id );
                $submission->set_payment_intent_id($session->payment_intent);
                $submission->save();
            }

            $form_data->halt();
        }

        return $form_data->toArray();
    }

    public function init()
    {
        $this->test_secret_key      = Ninja_Forms()->get_setting( 'stripe_test_secret_key' );
        $this->test_publishable_key = Ninja_Forms()->get_setting( 'stripe_test_publishable_key' );

        $this->live_secret_key      = Ninja_Forms()->get_setting( 'stripe_live_secret_key' );
        $this->live_publishable_key = Ninja_Forms()->get_setting( 'stripe_live_publishable_key' );
    }

    public function enqueue_scripts( $data )
    {
        // Account for a form instance ID;
        $form_instance_id = $data['form_id'];
        list($form_id) = explode('_', $form_instance_id);

        $stripe_actions = $this->get_active_stripe_actions($form_id);
        if( empty( $stripe_actions ) ) return;

        wp_enqueue_script( 'stripe', 'https://js.stripe.com/v3/', array( 'jquery' ) );
        wp_enqueue_script( 'nf-stripe', NF_Stripe_Checkout::$url . 'assets/js/stripe.js', array( 'nf-front-end' ) );

        array_push( $this->forms, array( 'id' => $form_instance_id, 'actions' => $stripe_actions ) );
        $publishable_key = '';

        $preview_settings = get_user_option( 'nf_form_preview_' . $form_id );

        if( $preview_settings ){
            foreach( $preview_settings[ 'actions' ] as $action ){
	            // check for collectpayment and stripe
	            if( ! in_array( $action[ 'settings' ][ 'type' ], array( 'stripe',
		            'collectpayment' ) ) ) {
		            continue;
	            }
                if( $this->_slug != $action[ 'settings' ][ 'payment_gateways' ] ) continue;

                $publishable_key = $this->get_publishable_key( $action[ 'settings' ][ 'stripe_test_mode' ] );
            }
        } else {
            foreach( Ninja_Forms()->form( $form_id )->get_actions() as $action ) {
	            // check for collectpayment and stripe
	            if( ! in_array( $action->get_setting( 'type' ), array( 'stripe', 'collectpayment' ) ) ) {
		            continue;
	            }
                if( $this->_slug != $action->get_setting( 'payment_gateways' ) ) continue;

                $publishable_key = $this->get_publishable_key( $action->get_setting( 'stripe_test_mode' ) );
            }
        }

        wp_localize_script( 'nf-stripe', 'nfStripe',
            array(
                'forms' => $this->forms, // array of forms.
                'publishable_key' => $publishable_key,
                'genericError' => __( 'Unkown Stripe Error. Please try again.', 'ninja-forms-stripe' )
            )
        );
    }
    
    public function enqueue_admin_scripts( $data )
    {
        wp_enqueue_script( 'nf-stripe-metadata', NF_Stripe_Checkout::$url . 'assets/js/metadata.js', array( 'nf-builder' ) );

        wp_enqueue_script( 'nf-stripe-key-modal', NF_Stripe_Checkout::$url . 'assets/js/actionListener.js', array( 'nf-builder' ) );

        wp_enqueue_style( 'nf-stripe-admin', NF_Stripe_Checkout::$url . 'assets/css/stripe-builder.css' );

        wp_localize_script( 'nf-stripe-metadata', 'nfStripe',
            array(
                'creditCardFieldDeprecation' => sprintf( __( 'The method our Credit Card Fields use to send information to Stripe has been deprecated.%sIn order to maintain PCI compliance on your site, we recommend removing any Credit Card Fields from your Forms, which will allow your Forms to submit data to Stripe through the Checkout modal.%sFor more information on these changes and PCI compliance, please visit %s', 'ninja-forms-stripe' ), '<br />', '<br />', '<a href="https://stripe.com/docs/security#validating-pci-compliance" target="_blank">https://stripe.com/docs/security#validating-pci-compliance</a>' )
            )
        );

        // if the form isn't set yet, then we don't have a form id
        $form_id = '';
        if( isset( $data[ 'form_id' ] ) && 0 < strlen( $data[ 'form_id ' ] ) ) {
            $form_id = $data[ 'form_id' ];
        }

        wp_localize_script( 'nf-stripe-key-modal', 'nfStripeKeys',
	        array (
	        		'hasKeys' => $this->has_api_keys(),
		            'hasStripeAction' => $this->has_active_stripe_action( $form_id ),
		            'keyFormatError' => sprintf( __( 'One or more of your entries are incorrectly formatted.' ) )

	        )
        );
    }

    public function has_api_keys() {
    	if( ( $this->test_secret_key && $this->test_publishable_key ) ||
	        ( $this->live_secret_key && $this-> live_publishable_key ) ) {
    		return TRUE;
	    }

    	return FALSE;
    }

    // Check to see if the form currently has a stripe payment action
    private function has_active_stripe_action( $form_id ) {

    	if( 0 === strlen( $form_id ) ) {
	        if ( ! $_REQUEST[ 'form_id' ]
	             || 0 === strlen( $_REQUEST[ 'form_id' ] )
	             || 'new' === $_REQUEST[ 'form_id' ] ) {
	            return false;
	        } else {
	            $form_id = $_REQUEST[ 'form_id' ];
	        }
	    }


	    $form_actions = Ninja_Forms()->form( $form_id )->get_actions();

	    foreach( $form_actions as $action ){
		    // check for collectpayment and stripe
		    if( ! in_array( $action->get_setting( 'type' ), array( 'stripe', 'collectpayment' ) ) ) {
			    continue;
		    }
		    if( $this->_slug == $action->get_setting( 'payment_gateways' ) ) {
		    	return true;
		    }
	    }

	    return false;
    }

    private function get_active_stripe_actions( $form_id ) {
        $form_actions = Ninja_Forms()->form( $form_id )->get_actions();
        $currency = Ninja_Forms()->form( $form_id )->get()->get_setting( 'currency' );
        $stripe_actions = array();
        foreach( $form_actions as $action ) {
	        // check for collectpayment and stripe
	        if( ! in_array( $action->get_setting( 'type' ), array( 'stripe', 'collectpayment' ) ) ) {
		        continue;
	        }
            if( $this->_slug != $action->get_setting( 'payment_gateways' ) ) continue;

	        /*
	         * There was an issue where inactive stripe action were still
	         * being passed to the front-end and being process based on the
	         * order they came in in the array. This line removes 'inactive'
	         * Stripe actions from being passed to the front end
	         */
	        if( 1 != $action->get_setting( 'active' ) ) continue;

            $this->has_active_stripe_action = true;

            $settings = array( 
                'id'        => $action->get_id(),
                'title'     => $action->get_setting( 'stripe_checkout_title', '' ),
                'sub_title' => $action->get_setting( 'stripe_checkout_sub_title', '' ),
                'bitcoin'   => $action->get_setting( 'stripe_checkout_bitcoin', '' ),
                'email'     => $action->get_setting( 'stripe_customer_email', '' ),
                'logo'      => $action->get_setting( 'stripe_checkout_logo', 'https://stripe.com/img/documentation/checkout/marketplace.png' ),
                'plan'      => $action->get_setting( 'stripe_recurring_plan', '' ),
                'total'     => $action->get_setting( 'payment_total', '' ),
                'currency'  => $currency
            );
            $stripe_actions[] = $settings;
        }
        return $stripe_actions;
    }

    private function get_secret_key( $test_mode = false )
    {
        return ( 1 == $test_mode ) ? $this->test_secret_key : $this->live_secret_key;
    }

    private function get_publishable_key( $test_mode = false )
    {
        return ( 1 == $test_mode ) ? $this->test_publishable_key : $this->live_publishable_key;
    }

    private function get_form_field_by_type( $field_type, $data )
    {
        foreach( $data[ 'fields' ] as $field ){
            if( $field_type == $field[ 'type' ] ) return $field[ 'id' ];
        }

        return false;
    }

    /**
      * This will be called on error when creating customer to update the
	  * submission data to add the error to the customer id
     * */
    private function update_sub_customer_data( $data, $error ) {
	    $this->update_submission( $this->get_sub_id( $data ), array(
		    'stripe_customer_id' => $error
	    ));
    }

	/**
	 * This will be called on error when creating charge to update the
	 * submission data to add the error to the charge id
	 * */
	private function update_sub_charge_data( $data, $error ) {
		$this->update_submission( $this->get_sub_id( $data ), array(
			'stripe_charge_id' => $error
		));
	}

    private function update_submission( $sub_id, $data = array() )
    {
        if( ! $sub_id ) return;

        $sub = Ninja_Forms()->form()->sub( $sub_id )->get();

        foreach( $data as $key => $value ){
            $sub->update_extra_value( $key, $value );
        }

        $sub->save();
    }

    private function get_sub_id( $data )
    {
        if( isset( $data[ 'actions' ][ 'save' ][ 'sub_id' ] ) ){
            return $data[ 'actions' ][ 'save' ][ 'sub_id' ];
        }
        return FALSE;
    }

} // END CLASS NF_Stripe_PaymentGateway
