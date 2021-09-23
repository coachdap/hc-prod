<?php

/**
 * A decorator/wrapper of the Ninja Forms form data array.
 * 
 * Adds method access for the nested array structure.
 */
class NF_Stripe_Checkout_FormData
{
    /** @var array  */
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function add_form_error($error_id, $message)
    {
        $this->data[ 'errors' ][ 'form' ][$error_id] = $message;
    }

    public function is_success()
    {
        if( ! is_array( $this->data ) ) return false;
        
        if( ! isset($this->data[ 'resume' ] ) ) return false;

        if( ! isset( $this->data[ 'resume' ][ 'nfs_checkout' ] ) ) return false;

        if( 'success' !== $this->data[ 'resume' ][ 'nfs_checkout'] ) return false;

        return true;
    }

    public function isCancelled()
    {
        if (! is_array($this->data)) {
            return false;
        }
        
        if (! isset($this->data[ 'resume' ])) {
            return false;
        }

        if (! isset($this->data[ 'resume' ][ 'nfs_checkout' ])) {
            return false;
        }

        if ('cancel' === $this->data[ 'resume' ][ 'nfs_checkout']) {
            return true;
        }

        return false;
    }

    public function get_currency()
    {
        /**
         * Currency Setting Priority
         *
         * 3. Stripe Currency Setting (deprecated)
         * 2. Ninja Forms Currency Setting
         * 1. Form Currency Setting (default)
         */
        $stripe_currency = Ninja_Forms()->get_setting( 'stripe_currency', 'USD' );
        $plugin_currency = Ninja_Forms()->get_setting( 'currency', $stripe_currency );
        $form_currency   = ( isset( $this->data[ 'settings' ][ 'currency' ] ) && $this->data[ 'settings' ][ 'currency' ] ) ? $this->data[ 'settings' ][ 'currency' ] : $plugin_currency;
        return $form_currency;
    }

    public function attach_session(\Stripe\Checkout\Session $session)
    {
        $this->data[ 'extra' ][ 'stripe_checkout' ][ 'session' ] = $session;
    }

    public function has_submission_id()
    {
        return isset($this->data[ 'actions' ][ 'save' ][ 'sub_id' ]);
    }

    public function get_submission_id()
    {
        return $this->data[ 'actions' ][ 'save' ][ 'sub_id' ];
    }

    public function halt()
    {
        $this->data[ 'halt' ] = TRUE;
    }

    public function toArray()
    {
        return $this->data;
    }
}
