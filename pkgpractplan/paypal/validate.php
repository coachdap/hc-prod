<?php namespace JF;
/**
Copyright 2017 JQueryForm.com
License: http://www.jqueryform.com/license.php
*/

class PaypalPayment extends PaymentBase{

    private $paypal_url;

    function __construct( $paymentFieldConfig ) {
        parent::__construct( $paymentFieldConfig );
        $this->init();
    }

    private function init(){
        $pp = $this->config['payments']['paypal'];
        $isLive = $pp['isLive'];
        $webscr = $isLive ? 'https://www.paypal.com/cgi-bin/webscr' : 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        $this->paypal_url = $webscr;
    }

    public function validate( $data ){
        $this->isPaid = true; // always is true, since it's directed to paypal website
        $url = $this->getPaypalRedirectLink( $data );
        $this->log( $url );
        
        Form::setValue( 'serverRedirect', $url ); // pass it to client side, javascript will redirect form to this url
        Form::setValue( 'serverRedirect.setTimeout', 1 ); // seconds before redirection

        return false;
    }

    private function getPaypalRedirectLink( $data ){
        $payment  = $this->config['payment'];
        $pp = $this->config['payments']['paypal'];

        // minimal variables
        $vars = array(
            'cmd' => '_xclick',
            'business' => $pp['email'],
            'amount' => $this->getAmount( $data ),
            'currency_code' => $payment['currency'],
            'item_name' => empty($payment['description']) ? 'Paypal Charge' : $payment['description'],
        );

        $ipn = $pp['ipn'];
        if( $ipn['emailToMerchant'] || $ipn['emailToBuyer'] ){
            $defaultUrl = str_replace( 'admin.php', 'paypal/ipnhandler.php', Form::getAdminUrl() );
            $vars['notify_url'] = empty($ipn['notify_url']) ? $defaultUrl : $ipn['notify_url'];
        };

        // extra variables by user
        $vlines = explode("\n", trim($pp['variables']) );
        if( is_array($vlines) ){
            foreach( $vlines as $line ){
                $n = strpos( $line, '=' );
                if( $n !== false ){
                    $name  = trim(substr( $line, 0, $n ));
                    $value = trim(substr( $line, $n+1 ));
                    $vars[$name] = $value;
                };
            }; // foreach
        }; // if

        $this->paypal_url .= '?' . http_build_query( $vars );

        $id = $this->config['id'];
        Form::addColumnValue( $id . '.amount', 'Amount', $vars['amount'] );
        Form::addColumnValue( $id . '.description', 'Description', $vars['item_name'] );
        
        return $this->paypal_url;
    }

}
# end of class StripePayment