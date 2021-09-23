<?php

namespace NinjaForms\Stripe\Checkout\PaymentIntent;

use NinjaForms\Stripe\Checkout\Arrayable;

class Metadata implements Arrayable
{

    protected $metadata = array();

    public static function create($action_settings)
    {
        $payment_intent_metadata = new static();
        if (isset($action_settings['stripe_metadata'])) {
            foreach ($action_settings['stripe_metadata'] as $metadata) {
                $payment_intent_metadata->metadata[$metadata['key']] = $metadata['value'];
            }
        }
        return $payment_intent_metadata;
    }

    public function has_metadata()
    {
        return 0 < count($this->metadata);
    }

    public function toArray()
    {
        return $this->metadata;
    }
}
