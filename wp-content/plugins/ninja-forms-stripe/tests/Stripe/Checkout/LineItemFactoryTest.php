<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class LineItemFactoryTest extends TestCase
{
    public function testCreate()
    {
        $action_settings = [
            'payment_total' => '9.95',
        ];
        $lineitem = \NinjaForms\Stripe\Checkout\LineItemFactory::create($action_settings, 'usd');
        $this->assertTrue($lineitem instanceof \NinjaForms\Stripe\Checkout\LineItem);
        $this->assertTrue($lineitem instanceof \NinjaForms\Stripe\Checkout\Arrayable);
        $this->assertEquals($lineitem->toArray(), [
            'name' => 'Ninja Forms Collected Payment',
            'images' => [],
            'amount' => '995',
            'quantity' => '1',
            'currency' => 'usd',
        ]);
    }

    public function testCreateProductName()
    {
        $action_settings = [
            'stripe_product_name' => 'My Stripe Product',
            'payment_total' => '9.95',
        ];
        $lineitem = \NinjaForms\Stripe\Checkout\LineItemFactory::create($action_settings, 'usd');
        $this->assertEquals($lineitem->toArray(), [
            'name' => 'My Stripe Product',
            'images' => [],
            'amount' => '995',
            'quantity' => '1',
            'currency' => 'usd',
        ]);
    }

    public function testCreateProductDescription()
    {
        $action_settings = [
            'stripe_product_description' => 'This is my Stripe product.',
            'payment_total' => '9.95',
        ];
        $lineitem = \NinjaForms\Stripe\Checkout\LineItemFactory::create($action_settings, 'usd');
        $this->assertEquals($lineitem->toArray(), [
            'name' => 'Ninja Forms Collected Payment',
            'description' => 'This is my Stripe product.',
            'images' => [],
            'amount' => '995',
            'quantity' => '1',
            'currency' => 'usd',
        ]);
    }

    public function testCreateProductImages()
    {
        $action_settings = [
            'stripe_product_image' => 'https://placehold.it/100',
            'payment_total' => '9.95',
        ];
        $lineitem = \NinjaForms\Stripe\Checkout\LineItemFactory::create($action_settings, 'usd');
        $this->assertEquals($lineitem->toArray(), [
            'name' => 'Ninja Forms Collected Payment',
            'images' => ['https://placehold.it/100'],
            'amount' => '995',
            'quantity' => '1',
            'currency' => 'usd',
        ]);
    }
}
