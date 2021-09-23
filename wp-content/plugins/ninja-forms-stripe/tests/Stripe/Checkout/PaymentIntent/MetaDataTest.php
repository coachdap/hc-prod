<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class MetaDataTest extends TestCase
{
    public function testFactoryReturnType()
    {
        $metadata = \NinjaForms\Stripe\Checkout\PaymentIntent\MetaData::create([]);
        $this->assertTrue($metadata instanceof \NinjaForms\Stripe\Checkout\PaymentIntent\MetaData);
        $this->assertTrue($metadata instanceof \NinjaForms\Stripe\Checkout\Arrayable);
    }
    
    public function testCreate()
    {
        $action_settings = [
            'stripe_metadata' => [[
                    'key' => 'foo',
                    'value' => 'bar'
            ]]
        ];
        $metadata = \NinjaForms\Stripe\Checkout\PaymentIntent\MetaData::create($action_settings);
        $this->assertTrue($metadata->has_metadata());
        $this->assertEquals($metadata->toArray(), [
            'foo' => 'bar'
        ]);
    }

    public function testCreateEmpty()
    {
        $metadata = \NinjaForms\Stripe\Checkout\PaymentIntent\MetaData::create([]);
        $this->assertFalse($metadata->has_metadata());
        $this->assertEquals($metadata->toArray(), []);
    }
}
