<?php

if (!function_exists('format_price')) {
    function format_price($price_in_base_currency)
    {
        $currentCurrencyCode = session('current_currency', 'USD');
        $currency = \App\Models\Currency::where('code', $currentCurrencyCode)->where('status', 1)->first();
        if (!$currency) {
            return '$' . number_format($price_in_base_currency, 2);
        }
        $convertedPrice = $price_in_base_currency * $currency->exchange_rate;
        $price = $currency->symbol . number_format($convertedPrice, 2);
        return $price;
    }
}
