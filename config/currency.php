<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Currency
    |--------------------------------------------------------------------------
    |
    | This option controls the default currency used throughout the application.
    | You can change this to any supported currency code.
    |
    */
    'default' => env('CURRENCY_DEFAULT', 'PKR'),

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    |
    | Define currency symbols, names, and formatting options
    |
    */
    'currencies' => [
        'PKR' => [
            'name' => 'Pakistani Rupee',
            'symbol' => 'Rs.',
            'symbol_placement' => 'before', // 'before' or 'after'
            'decimal_places' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ],
        'USD' => [
            'name' => 'US Dollar',
            'symbol' => '$',
            'symbol_placement' => 'before',
            'decimal_places' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ],
        'EUR' => [
            'name' => 'Euro',
            'symbol' => '€',
            'symbol_placement' => 'before',
            'decimal_places' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ],
        'GBP' => [
            'name' => 'British Pound',
            'symbol' => '£',
            'symbol_placement' => 'before',
            'decimal_places' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ],
        'INR' => [
            'name' => 'Indian Rupee',
            'symbol' => '₹',
            'symbol_placement' => 'before',
            'decimal_places' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ],
    ],
];