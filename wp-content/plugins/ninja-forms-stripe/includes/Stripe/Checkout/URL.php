<?php

namespace NinjaForms\Stripe\Checkout;

class URL
{
    public static function create($form_id, $action)
    {
        return add_query_arg( array( 'nf_resume' => $form_id, 'nfs_checkout' => $action ), wp_get_referer() );
    }
}