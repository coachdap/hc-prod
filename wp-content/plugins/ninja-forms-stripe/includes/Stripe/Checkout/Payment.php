<?php

namespace NinjaForms\Stripe\Checkout;

use NinjaForms\Stripe\Checkout\Subscription;
use NinjaForms\Stripe\Checkout\LineItem;

class Payment implements Arrayable
{

    /** @var array */
    protected $payment_method_types = array('card');

    /** @var string */
    protected $customer_email;

    /** @var array [LineItem] */
    protected $line_items;

    /** @var Subscription */
    protected $subscription;

    /** @var PaymentIntent\Metadata */
    protected $metadata;

    /** @var PaymentIntent\Shipping */
    protected $shipping;

    /** @var string */
    protected $success_url;

    /** @var string */
    protected $cancel_url;

    public function attach_customer_email($customer_email)
    {
        $this->customer_email = $customer_email;
    }

    public function attach_subscription(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }

    public function attach_line_item(LineItem $line_item)
    {
        $this->line_items[] = $line_item;
    }

    public function attach_metadata(PaymentIntent\Metadata $metadata)
    {
        $this->metadata = $metadata;
    }

    public function attach_shipping(PaymentIntent\Shipping $shipping)
    {
        $this->shipping = $shipping;
    }

    public function set_success_url($success_url)
    {
        $this->success_url = $success_url;
    }

    public function set_cancel_url($cancel_url)
    {
        $this->cancel_url = $cancel_url;
    }

    public function toArray()
    {
        $payment_data = [
            'payment_method_types' => $this->payment_method_types,
            'success_url' => $this->success_url,
            'cancel_url' => $this->cancel_url,
        ];

        if ($this->customer_email) {
            $payment_data['customer_email'] = $this->customer_email;
        }

        if ($this->subscription) {
            $payment_data['subscription_data'] = $this->subscription->toArray();
        }

        if (!empty($this->line_items)) {
            $payment_data['line_items'] = array_map(function ($line_item) {
                return $line_item->toArray();
            }, $this->line_items);
        }

        if ($this->metadata) {
            if( $this->subscription ) {
                $payment_data[ 'subscription_data' ][ 'metadata' ] = $this->metadata->toArray();
            } else {
                $payment_data['payment_intent_data']['metadata'] = $this->metadata->toArray();
            }
        }

        if ($this->shipping && !$this->subscription) {
            $payment_data['payment_intent_data']['shipping'] = $this->shipping->toArray();
        }

        return $payment_data;
    }
}
