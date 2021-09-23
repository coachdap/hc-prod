<?php

namespace NinjaForms\Stripe\Checkout\PaymentIntent;

use NinjaForms\Stripe\Checkout\Arrayable;

class Shipping implements Arrayable
{

    protected $name;
    protected $city;
    protected $country;
    protected $address;
    protected $postal_code;
    protected $state;

    public static function create($action_settings)
    {
        $shipping = new static();

        if (isset($action_settings['stripe_checkout_shipping_name'])) {
            $shipping->name = $action_settings['stripe_checkout_shipping_name'];
        }

        if (isset($action_settings['stripe_checkout_shipping_city'])) {
            $shipping->city = $action_settings['stripe_checkout_shipping_city'];
        }

        if (isset($action_settings['stripe_checkout_shipping_country'])) {
            $shipping->country = $action_settings['stripe_checkout_shipping_country'];
        }

        if (isset($action_settings['stripe_checkout_shipping_address'])) {
            $shipping->address = $action_settings['stripe_checkout_shipping_address'];
        }

        if (isset($action_settings['stripe_checkout_shipping_postal_code'])) {
            $shipping->postal_code = $action_settings['stripe_checkout_shipping_postal_code'];
        }

        if (isset($action_settings['stripe_checkout_shipping_state'])) {
            $shipping->state = $action_settings['stripe_checkout_shipping_state'];
        }

        return $shipping;
    }

    public function has_shipping()
    {
        return ($this->name);
    }

    public function toArray()
    {
        return array(
            'name' => $this->name,
            'address' => array(
                'city' => $this->city,
                'country' => $this->country,
                'line1' => $this->address,
                'postal_code' => $this->postal_code,
                'state' => $this->state
            )
        );
    }
}
