<?php

/**
 * A decorator/wrapper of the Ninja Forms Submission object.
 * 
 * Adds method access to get/set Stripe specific extra data.
 */
class NF_Stripe_Checkout_Submission
{
    /** @var NF_Database_Models_Submission */
    protected $submission;

    public static function create($submission_id)
    {
        $submission = Ninja_Forms()->form()->sub( $submission_id )->get();
        return new static($submission);
    }

    public function __construct( \NF_Database_Models_Submission $submission)
    {
        $this->submission = $submission;
    }

    /**
     * Forward undeclared methods calls to the decorated/wrapped submission object.
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->submission, $method), $arguments);
    }

    public function get_stripe_session_id() {
        return $this->submission->get_extra_value( 'stripe_session_id' );
    }

    public function set_stripe_session_id( $session_id )
    {
        $this->submission->update_extra_value( 'stripe_session_id', $session_id );
    }

    public function get_payment_intent_id()
    {
        return $this->submission->get_extra_value( 'stripe_payment_intent_id' );
    }

    public function set_payment_intent_id( $payment_intent_id )
    {
        $this->submission->update_extra_value( 'stripe_payment_intent_id', $payment_intent_id );
    }

    public function set_stripe_subscription_id( $subscription_id ) {
        $this->submission->update_extra_value( 'stripe_subscription_id', $subscription_id );
    }

    public function set_payment_status($value)
    {
        $this->submission->update_extra_value('stripe_payment_status', $value);
    }

    public function set_payment_error($value)
    {
        $this->submission->update_extra_value('stripe_payment_error', $value);
    }

    public function set_customer_id($value)
    {
        $this->submission->update_extra_value('stripe_customer_id', $value);
    }

    public function set_charge_id($value)
    {
        $this->submission->update_extra_value('stripe_charge_id', $value);
    }

    public function set_card_brand($value)
    {
        $this->submission->update_extra_value('stripe_brand', $value);
    }

    public function set_card_last_four($value)
    {
        $this->submission->update_extra_value('stripe_last_four', $value);
    }

    public function set_stripe_error($value)
    {
        $this->submission->update_extra_value('stripe_error', $value);
    }

    public function set_stripe_live($value)
    {
        $this->submission->update_extra_value('stripe_live', $value);
    }
}