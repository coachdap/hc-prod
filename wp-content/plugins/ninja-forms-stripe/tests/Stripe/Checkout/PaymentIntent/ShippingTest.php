<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class ShippingTest extends TestCase
{
    public function testFactoryReturnType()
    {
        $shipping = \NinjaForms\Stripe\Checkout\PaymentIntent\Shipping::create([]);
        $this->assertTrue($shipping instanceof \NinjaForms\Stripe\Checkout\PaymentIntent\Shipping);
        $this->assertTrue($shipping instanceof \NinjaForms\Stripe\Checkout\Arrayable);
    }

    public function testCreate()
    {
        $action_settings = [
            'stripe_checkout_shipping_name' => 'Saturday Drive',
            'stripe_checkout_shipping_city' => 'Cleveland',
            'stripe_checkout_shipping_country' => 'United States',
            'stripe_checkout_shipping_address' => '285 Church Street',
            'stripe_checkout_shipping_postal_code' => '37312',
            'stripe_checkout_shipping_state' => 'TN',
        ];
        $shipping = \NinjaForms\Stripe\Checkout\PaymentIntent\Shipping::create($action_settings);
        $this->assertTrue($shipping instanceof \NinjaForms\Stripe\Checkout\PaymentIntent\Shipping);
        $this->assertTrue($shipping instanceof \NinjaForms\Stripe\Checkout\Arrayable);
        $this->assertTrue($shipping->has_shipping());
        $this->assertEquals($shipping->toArray(), [
            'name' => 'Saturday Drive',
            'address' => [
                'city' => 'Cleveland',
                'country' => 'United States',
                'line1' => '285 Church Street',
                'postal_code' => '37312',
                'state' => 'TN'
            ]
        ]);
    }

    public function testCreateEmpty()
    {
        $shipping = \NinjaForms\Stripe\Checkout\PaymentIntent\Shipping::create([]);
        $this->assertFalse($shipping->has_shipping());
        $this->assertEquals($shipping->toArray(), [
            'name' => '',
            'address' => [
                'city' => '',
                'country' => '',
                'line1' => '',
                'postal_code' => '',
                'state' => ''
            ]
        ]);
    }
}
