<?php

/**
 * Module Configuration 
 * 
 * Lists modules in order of handling
 */
return [
    // define requires of each specific module in the API
    'modules' => [
        // Programmatic key - not necessarily endpoint or module name
        'contacts' => [
            // used for associations - value is used to link this module to other
            // modules upon form submission
            'associationKey' => 'contact'
        ],
        'companies' => [
            'associationKey' => 'company'
        ],
        'deals' => [
            'associationKey' => 'deal'
        ],
        'tickets' => [
            'associationKey' => 'ticket'
        ],
    ]
    ,
    // define how to link entries together
    'relationships' => [
        // secondary association
        'company'=>[
            // primary association => association name
            'contact'=>'contact_to_company'
        ]
        ,
                // secondary association
        'deal'=>[
            // primary association => association name
            'contact'=>'contact_to_deal',
            'company'=>'company_to_deal'
        ]
        ,
        // secondary association
        'ticket'=>[
            // primary association => association name
            'contact'=>'contact_to_ticket',
            'company'=>'company_to_ticket',
            'deal'=>'deal_to_ticket',
        ]
    ]
];
