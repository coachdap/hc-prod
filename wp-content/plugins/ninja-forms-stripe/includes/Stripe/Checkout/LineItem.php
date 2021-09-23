<?php

namespace NinjaForms\Stripe\Checkout;

class LineItem implements Arrayable
{

    protected $item_name = '';

    protected $item_description = '';

    protected $item_images = array();

    protected $item_amount = '';

    protected $item_currency = '';

    protected $item_quantity = 1;

    public function __construct($name, $amount, $currency, $quantity = 1)
    {
        $this->item_name = $name;

        $this->item_amount = $amount;

        $this->item_currency = $currency;

        $this->item_quantity = $quantity;
    }

    public function set_description($description)
    {
        $this->item_description = $description;
    }

    public function add_image($image)
    {
        $this->item_images[] = $image;
    }

    public function toArray()
    {
        $return_item = [
            'name' => $this->item_name,
            'description' => $this->item_description,
            'images' => $this->item_images,
            'amount' => $this->item_amount,
            'quantity' => $this->item_quantity,
            'currency' => $this->item_currency,
        ];

        if( 0 === strlen( $this->item_description ) ) {
            unset( $return_item[ 'description' ] );
        }

        return $return_item;
    }
}
