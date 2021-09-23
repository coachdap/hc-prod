<?php

namespace NinjaForms\Stripe\Checkout;

class LineItemFactory
{
    public static function create($action_settings, $currency)
    {

        if (isset($action_settings['stripe_product_name']) && 0 < strlen($action_settings['stripe_product_name'])) {
            $name = $action_settings['stripe_product_name'];
        } else {
            $name = 'Ninja Forms Collected Payment';
        }

        $amount = $action_settings['payment_total'] * 100;

        $lineitem = new LineItem($name, $amount, $currency);

        if (isset($action_settings['stripe_product_description']) && 0 < strlen($action_settings['stripe_product_description'])) {
            $lineitem->set_description($action_settings['stripe_product_description']);
        }

        if (isset($action_settings['stripe_product_image']) && 0 < strlen($action_settings['stripe_product_image'])) {
            $lineitem->add_image($action_settings['stripe_product_image']);
        }

        return $lineitem;
    }
}
