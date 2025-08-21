<?php

namespace App\Helpers;

class CurrencyHelper
{
    /**
     * Format a number as currency based on the default currency settings
     */
    public static function format($amount, $currency = null)
    {
        $currency = $currency ?: config('currency.default');
        $currencyConfig = config("currency.currencies.{$currency}");
        
        if (!$currencyConfig) {
            // Fallback to PKR if currency not found
            $currencyConfig = config('currency.currencies.PKR');
        }
        
        $formatted = number_format(
            $amount,
            $currencyConfig['decimal_places'],
            $currencyConfig['decimal_separator'],
            $currencyConfig['thousand_separator']
        );
        
        if ($currencyConfig['symbol_placement'] === 'before') {
            return $currencyConfig['symbol'] . ' ' . $formatted;
        } else {
            return $formatted . ' ' . $currencyConfig['symbol'];
        }
    }
    
    /**
     * Get the currency symbol for the default or specified currency
     */
    public static function symbol($currency = null)
    {
        $currency = $currency ?: config('currency.default');
        return config("currency.currencies.{$currency}.symbol", 'Rs.');
    }
    
    /**
     * Get all available currencies
     */
    public static function getAvailableCurrencies()
    {
        return config('currency.currencies', []);
    }
    
    /**
     * Get the default currency code
     */
    public static function getDefaultCurrency()
    {
        return config('currency.default', 'PKR');
    }
    
    /**
     * Get currency name
     */
    public static function getName($currency = null)
    {
        $currency = $currency ?: config('currency.default');
        return config("currency.currencies.{$currency}.name", 'Pakistani Rupee');
    }
}