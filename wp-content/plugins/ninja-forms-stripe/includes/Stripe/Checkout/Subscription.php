<?php

namespace NinjaForms\Stripe\Checkout;

class Subscription implements Arrayable
{

    protected $plan;
    protected $trial_period_in_days = 0;

    public function __construct($plan)
    {
        $this->plan = $plan;
    }

    public function setTrialPeriod($trial_period)
    {
        if (is_numeric($trial_period) && 0 < intval($trial_period)) {
            $this->trial_period_in_days = intval($trial_period);
        }
    }

    public function toArray()
    {
        $sub_array = array(
            'items' => array(
                array('plan' => $this->plan),
            ),
        );

        if (0 < $this->trial_period_in_days) {
            $sub_array['trial_period_days'] = $this->trial_period_in_days;
        }

        return $sub_array;
    }
}
