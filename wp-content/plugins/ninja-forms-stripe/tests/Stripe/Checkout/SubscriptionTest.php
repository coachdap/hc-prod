<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class SubscriptionTest extends TestCase
{
    public function testToArray()
    {
        $subscription = new \NinjaForms\Stripe\Checkout\Subscription('my_plan');
        $this->assertEquals($subscription->toArray(), [
            'items' => [
                [ 'plan' => 'my_plan' ],
            ],
        ]);
    }
}
