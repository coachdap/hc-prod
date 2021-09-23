<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'nf_stripe_action_settings', array(

        'api_keys' => array(
            'name' => 'api_keys',
            'type' => 'html',
            'label' => __( 'HTML', 'ninja-forms'),
            'width' => 'full',
            'group' => 'primary',
            'deps' => array(
                'payment_gateways' => $this->_slug
            ),
            'value' => sprintf( __( 'To edit your API keys, %sclick here%s.', 'ninja-forms-stripe'), '<a href="' . $api_url . '#nf-stripe" target="_blank" >', '</a>' ),
        ),

        'stripe_customer_email' => array(
            'name'                  => 'stripe_customer_email',
            'type'                  => 'textbox',
            'label'                 => __( 'Customer Email Address', 'ninja-forms-stripe' ),
            'width'                 => 'full',
            'group'                 => 'primary',
            'deps'                  => array(
                'payment_gateways'  => $this->_slug
            ),
            'use_merge_tags'        => TRUE
        ),

        'stripe_checkout_bitcoin' => array(
            'name'                  => 'stripe_checkout_bitcoin',
            'type'                  => 'toggle',
            'label'                 => __( 'Accept Bitcoin With Stripe', 'ninja-forms-stripe' ),
            'width'                 => 'full',
            'group'                 => 'advanced',
            'deps'                  => array(
                'payment_gateways'  => $this->_slug,
                'stripe_checkout_bitcoin' => true
            ),
        ),

        'stripe_shipping_details' => array (
            'name'                  => 'stripe_checkout_shipping_address1',
            'type'                  => 'fieldset',
            'label'                 => __( 'Shipping Address Details', 'ninja-forms-stripe' ),
            'width'                 => 'full',
            'group'                 => 'advanced',
            'deps'                  => array(
                'payment_gateways'  => $this->_slug,
            ),
            'settings'              => array(
                array(
                    'name'                  => 'stripe_show_shipping_address_toggle',
                    'type'                  => 'toggle',
                    'label'                 => __( 'Show Shipping Address', 'ninja-forms-stripe' ),
                    'width'                 => 'full',
                    'group'                 => 'advanced',
                    'deps'                  => array(
                        'payment_gateways'  => $this->_slug,
                    ),
                ),
                array(
                    'name'                  => 'stripe_checkout_shipping_name',
                    'type'                  => 'textbox',
                    'label'                 => __( 'Customer Name', 'ninja-forms-stripe' ) . ' <small style="color:red">'
                                            . __( '(required)', 'ninja-forms-stripe' ). '</small>',
                    'width'                 => 'full',
                    'group'                 => 'advanced',
                    'deps'                  => array(
                        'payment_gateways'  => $this->_slug,
                        'stripe_show_shipping_address_toggle' => 1,
                    ),
                    'use_merge_tags'        => TRUE
                ),
                array(
                    'name'                  => 'stripe_checkout_shipping_address',
                    'type'                  => 'textbox',
                    'label'                 => __( 'Address', 'ninja-forms-stripe' ) . ' <small style="color:red">'
                                            . __( '(required)', 'ninja-forms-stripe' ) . '</small>',
                    'width'                 => 'full',
                    'group'                 => 'advanced',
                    'deps'                  => array(
                        'payment_gateways'  => $this->_slug,
                        'stripe_show_shipping_address_toggle' => 1,
                    ),
                    'use_merge_tags'        => TRUE
                ),
                array(
                    'name'                  => 'stripe_checkout_shipping_city',
                    'type'                  => 'textbox',
                    'label'                 => __( 'City', 'ninja-forms-stripe' ),
                    'width'                 => 'full',
                    'group'                 => 'advanced',
                    'deps'                  => array(
                        'payment_gateways'  => $this->_slug,
                        'stripe_show_shipping_address_toggle' => 1,
                    ),
                    'use_merge_tags'        => TRUE
                ),
                array(
                    'name'                  => 'stripe_checkout_shipping_state',
                    'type'                  => 'textbox',
                    'label'                 => __( 'State', 'ninja-forms-stripe' ),
                    'width'                 => 'full',
                    'group'                 => 'advanced',
                    'deps'                  => array(
                        'payment_gateways'  => $this->_slug,
                        'stripe_show_shipping_address_toggle' => 1,
                    ),
                    'use_merge_tags'        => TRUE
                ),
                array(
                    'name'                  => 'stripe_checkout_shipping_postal_code',
                    'type'                  => 'textbox',
                    'label'                 => __( 'Postal Code', 'ninja-forms-stripe' ),
                    'width'                 => 'full',
                    'group'                 => 'advanced',
                    'deps'                  => array(
                        'payment_gateways'  => $this->_slug,
                        'stripe_show_shipping_address_toggle' => 1,
                    ),
                    'use_merge_tags'        => TRUE
                ),
                array(
                    'name'                  => 'stripe_checkout_shipping_country',
                    'type'                  => 'textbox',
                    'label'                 => __( 'Country', 'ninja-forms-stripe' ),
                    'width'                 => 'full',
                    'group'                 => 'advanced',
                    'deps'                  => array(
                        'payment_gateways'  => $this->_slug,
                        'stripe_show_shipping_address_toggle' => 1,
                    ),
                    'use_merge_tags'        => TRUE
                )
            )
        ),

        'stripe_recurring_plan' => array(
            'name'                  => 'stripe_recurring_plan',
            'type'                  => 'textbox',
            'label'                 => __( 'Recurring Payment Plan ID', 'ninja-forms-stripe' ),
            'width'                 => 'full',
            'group'                 => 'advanced',
            'deps'                  => array(
                'payment_gateways'  => $this->_slug,
            ),
            'help'                  => __('If you do not want to create a recurring payment, leave this field blank.', 'ninja-forms-stripe'),
            'use_merge_tags'        => true
        ),

        'stripe_sub_trial_period' => array(
            'name'                  => 'stripe_sub_trial_period',
            'type'                  => 'number',
            'label'                 => __('Subscription Trial Period', 'ninja-forms-stripe'),
            'width'                 => 'full',
            'group'                 => 'advanced',
            'deps'                  => array(
                'payment_gateways'  => $this->_slug,
            ),
            'default'               => 0,
            'help'                  => __('This allows you to set a trial period (in days) for the subscription plan. Trial periods set in the Stripe Dashboard return errors from the Stripe Connect API.', 'ninja-forms-stripe'),
        ),

        'stripe_test_mode' => array(
            'name'                  => 'stripe_test_mode',
            'type'                  => 'toggle',
            'label'                 => __( 'Test Mode', 'ninja-forms' ),
            'width'                 => 'full',
            'group'                 => 'advanced',
            'deps'                  => array(
                'payment_gateways'  => $this->_slug
            ),
            'help'                  => __( 'Use Stripe test credentials to test transaction.', 'ninja-forms-stripe' ),
        ),

        'stripe_product_name' => array(
            'name'                  => 'stripe_product_name',
            'type'                  => 'textbox',
            'label'                 => __( 'Product Name (Required By Stripe)', 'ninja-forms-stripe' ),
            'value'                 => $this->tmp_product_name,
            'width'                 => 'full',
            'group'                 => 'advanced',
            'deps'                  => array(
                'payment_gateways'  => $this->_slug
            ),
            'use_merge_tags'        => TRUE
        ),

        'stripe_product_description' => array(
            'name'                  => 'stripe_product_description',
            'type'                  => 'textarea',
            'label'                 => __( 'Product Description', 'ninja-forms-stripe' ),
            'width'                 => 'full',
            'group'                 => 'advanced',
            'deps'                  => array(
                'payment_gateways'  => $this->_slug
            ),
            'use_merge_tags'        => TRUE
        ),

        'stripe_product_image' => array(
            'name'                  => 'stripe_product_image',
            'type'                  => 'textbox',
            'label'                 => __( 'Product Image Url', 'ninja-forms-stripe' ),
            'width'                 => 'full',
            'group'                 => 'advanced',
            'deps'                  => array(
                'payment_gateways'  => $this->_slug
            ),
            'help'                  => __( 'This must be a valid url to the image you want to use.', 'ninja-forms-stripe' ),
            'use_merge_tags'        => TRUE
        ),

        'stripe_metadata' => array(
            'name' => 'stripe_metadata',
            'type' => 'option-repeater',
            'label' => __( 'Metadata' ) . ' <a href="#" class="nf-add-new">' . __( 'Add New' ) . '</a>',
            'width' => 'full',
            'group' => 'advanced',
            'deps'                  => array(
                'payment_gateways'  => $this->_slug
            ),
            'columns'           => array(
                'key'          => array(
                    'header'    => __( 'Key' ),
                    'default'   => '',
                ),
                'value'          => array(
                    'header'    => __( 'Value' ),
                    'default'   => '',
                ),
            ),
            'tmpl_row'              => 'tmpl-nf-stripe-meta-repeater-row',
            'use_merge_tags'        => TRUE,
            'max_options'           => 20,
        ),

));
