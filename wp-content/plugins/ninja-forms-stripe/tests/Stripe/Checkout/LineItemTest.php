<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class LineItemTest extends TestCase
{
    public function testToArray()
    {
        $lineitem = new \NinjaForms\Stripe\Checkout\LineItem('my_lineitem', '100', 'usd');
        $this->assertEquals($lineitem->toArray(), [
            'name' => 'my_lineitem',
            'images' => [],
            'amount' => '100',
            'quantity' => '1',
            'currency' => 'usd',
        ]);
    }

    public function testToArrayWithQuantity()
    {
        $lineitem = new \NinjaForms\Stripe\Checkout\LineItem('my_lineitem', '100', 'usd', 2);
        $this->assertEquals($lineitem->toArray(), [
            'name' => 'my_lineitem',
            'images' => [],
            'amount' => '100',
            'quantity' => '2',
            'currency' => 'usd',
        ]);
    }

    public function testToArrayWithImages()
    {
        $lineitem = new \NinjaForms\Stripe\Checkout\LineItem('my_lineitem', '100', 'usd');
        $lineitem->add_image('https://placehold.it/100');
        $this->assertEquals($lineitem->toArray(), [
            'name' => 'my_lineitem',
            'images' => ['https://placehold.it/100'],
            'amount' => '100',
            'quantity' => '1',
            'currency' => 'usd',
        ]);
    }

    public function testToArrayWithMultipleImages()
    {
        $lineitem = new \NinjaForms\Stripe\Checkout\LineItem('my_lineitem', '100', 'usd');
        $lineitem->add_image('https://placehold.it/100');
        $lineitem->add_image('https://placehold.it/200');
        $this->assertEquals($lineitem->toArray(), [
            'name' => 'my_lineitem',
            'images' => [
                'https://placehold.it/100',
                'https://placehold.it/200',
            ],
            'amount' => '100',
            'quantity' => '1',
            'currency' => 'usd',
        ]);
    }

    public function testToArrayWithDescription()
    {
        $lineitem = new \NinjaForms\Stripe\Checkout\LineItem('my_lineitem', '100', 'usd');
        $lineitem->set_description('my_description');
        $this->assertEquals($lineitem->toArray(), [
            'name' => 'my_lineitem',
            'description' => 'my_description',
            'images' => [],
            'amount' => '100',
            'quantity' => '1',
            'currency' => 'usd',
        ]);
    }
}
