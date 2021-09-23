<?php

/**
 * A decorator/wrapper of the Ninja Forms action settings array.
 * 
 * Adds method access for known array keys without needing `isset` checks.
 */
class NF_Stripe_Checkout_ActionSettings {

    protected $stripe_recurring_plan;
    protected $payment_total;
    protected $stripe_test_mode;
    protected $stripe_customer_email;
    protected $stripe_sub_trial_period;

    public function __construct($settings){
        foreach($settings as $setting => $value){
            $this->$setting = $value;
        };
    }

    public function has_plan() {
        $plan = $this->get_plan();
        return ($plan && !empty($plan));
    }

    public function get_plan() {
        return $this->stripe_recurring_plan;
    }

    public function has_total() {
        return ($this->get_total());
    }

    public function get_total_in_cents() {
        return $this->get_total() * 100;
    }
    
    public function get_total() {
        return $this->payment_total;
    }

    public function has_email() {
        $email = $this->get_email();
        return ($email && !empty($email));
    }

    public function get_email() {
        return $this->stripe_customer_email;
    }

    public function hasTrial()
    {
        return ($this->stripe_sub_trial_period);
    }

    public function getTrialPeriod()
    {
        return $this->stripe_sub_trial_period;
    }
}