<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class PaymentTest extends TestCase
{
    public function testToArrayEmpty()
    {
        $payment = new \NinjaForms\Stripe\Checkout\Payment();
        $this->assertEquals($payment->toArray(), [
            'payment_method_types' => ['card'],
            'success_url' => '',
            'cancel_url' => '',
        ]);
    }

    public function testToArrayWithCustomerEmail()
    {
        $payment = new \NinjaForms\Stripe\Checkout\Payment();
        $payment->attach_customer_email('test@test.test');
        $payment_data = $payment->toArray();
        $this->assertEquals($payment_data['customer_email'], 'test@test.test');
    }

    public function testToArrayWithSubscription()
    {
        $payment = new \NinjaForms\Stripe\Checkout\Payment();
        $subscription = new \NinjaForms\Stripe\Checkout\Subscription('my_plan');
        $payment->attach_subscription($subscription);
        $payment_data = $payment->toArray();
        $this->assertEquals($payment_data['subscription_data'], $subscription->toArray());
    }

    public function testToArrayWithLineItem()
    {
        $payment = new \NinjaForms\Stripe\Checkout\Payment();
        $lineitem = new \NinjaForms\Stripe\Checkout\LineItem('my_lineitem', '100', 'usd');
        $payment->attach_line_item($lineitem);
        $payment_data = $payment->toArray();
        $this->assertEquals($payment_data['line_items'], [$lineitem->toArray()]);
    }

    public function testToArrayWithLineItems()
    {
        $payment = new \NinjaForms\Stripe\Checkout\Payment();
        $lineitem1 = new \NinjaForms\Stripe\Checkout\LineItem('my_lineitem', '100', 'usd');
        $payment->attach_line_item($lineitem1);
        $lineitem2 = new \NinjaForms\Stripe\Checkout\LineItem('my_other_lineitem', '200', 'usd');
        $payment->attach_line_item($lineitem2);
        $payment_data = $payment->toArray();
        $this->assertEquals($payment_data['line_items'], [$lineitem1->toArray(), $lineitem2->toArray()]);
    }

    public function testToArrayWithMetaDataForSubscription()
    {
        $payment = new \NinjaForms\Stripe\Checkout\Payment();
        $payment->attach_subscription(new \NinjaForms\Stripe\Checkout\Subscription('my_plan'));
        $metadata = \NinjaForms\Stripe\Checkout\PaymentIntent\MetaData::create([ 'stripe_metadata' => [[ 'key' => 'foo','value' => 'bar']]]);
        $payment->attach_metadata($metadata);
        $payment_data = $payment->toArray();
        $this->assertEquals($payment_data['subscription_data']['metadata'], $metadata->toArray());
    }

    public function testToArrayWithMetaDataForPayment()
    {
        $payment = new \NinjaForms\Stripe\Checkout\Payment();
        $metadata = \NinjaForms\Stripe\Checkout\PaymentIntent\MetaData::create([ 'stripe_metadata' => [[ 'key' => 'foo','value' => 'bar']]]);
        $payment->attach_metadata($metadata);
        $payment_data = $payment->toArray();
        $this->assertEquals($payment_data['payment_intent_data']['metadata'], $metadata->toArray());
    }

    public function testToArrayWithShipping()
    {
        $payment = new \NinjaForms\Stripe\Checkout\Payment();
        $shipping = \NinjaForms\Stripe\Checkout\PaymentIntent\Shipping::create(['stripe_checkout_shipping_name' => 'Saturday Drive','stripe_checkout_shipping_city' => 'Cleveland','stripe_checkout_shipping_country' => 'United States','stripe_checkout_shipping_address' => '285 Church Street','stripe_checkout_shipping_postal_code' => '37312','stripe_checkout_shipping_state' => 'TN']);
        $payment->attach_shipping($shipping);
        $payment_data = $payment->toArray();
        $this->assertEquals($payment_data['payment_intent_data']['shipping'], $shipping->toArray());
    }    

    public function testToArrayWithShippingAndSubscription()
    {
        $payment = new \NinjaForms\Stripe\Checkout\Payment();
        $payment->attach_subscription(new \NinjaForms\Stripe\Checkout\Subscription('my_plan'));
        $payment->attach_shipping(\NinjaForms\Stripe\Checkout\PaymentIntent\Shipping::create(['stripe_checkout_shipping_name' => 'Saturday Drive','stripe_checkout_shipping_city' => 'Cleveland','stripe_checkout_shipping_country' => 'United States','stripe_checkout_shipping_address' => '285 Church Street','stripe_checkout_shipping_postal_code' => '37312','stripe_checkout_shipping_state' => 'TN']));
        $payment_data = $payment->toArray();
        $this->assertFalse(isset($payment_data['payment_intent_data']['shipping']));
    }

    public function testToArrayWithSuccessUrl()
    {
        $payment = new \NinjaForms\Stripe\Checkout\Payment();
        $payment->set_success_url('?nfs_checkout=success');
        $this->assertEquals($payment->toArray(), [
            'payment_method_types' => ['card'],
            'success_url' => '?nfs_checkout=success',
            'cancel_url' => '',
        ]);
    }

    public function testToArrayWithCancelUrl()
    {
        $payment = new \NinjaForms\Stripe\Checkout\Payment();
        $payment->set_cancel_url('?nfs_checkout=cancel');
        $this->assertEquals($payment->toArray(), [
            'payment_method_types' => ['card'],
            'success_url' => '',
            'cancel_url' => '?nfs_checkout=cancel',
        ]);
    }

}
