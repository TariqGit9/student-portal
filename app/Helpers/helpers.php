<?php

use App\Helpers\CurrencyHelper;

if (!function_exists('currency')) {
    /**
     * Format amount as currency
     *
     * @param float $amount
     * @param string|null $currency
     * @return string
     */
    function currency($amount, $currency = null)
    {
        return CurrencyHelper::format($amount, $currency);
    }
}

if (!function_exists('currency_symbol')) {
    /**
     * Get currency symbol
     *
     * @param string|null $currency
     * @return string
     */
    function currency_symbol($currency = null)
    {
        return CurrencyHelper::symbol($currency);
    }
}

if (!function_exists('currency_name')) {
    /**
     * Get currency name
     *
     * @param string|null $currency
     * @return string
     */
    function currency_name($currency = null)
    {
        return CurrencyHelper::getName($currency);
    }
}