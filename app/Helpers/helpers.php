<?php

if (!function_exists('format_price')) {
    function format_price($price_in_base_currency)
    {
        // ১. সেশন থেকে বর্তমান কারেন্সি কোড নেওয়া (না থাকলে ডিফল্ট USD)
        $currentCurrencyCode = session('current_currency', 'USD');

        // (পারফরম্যান্স বুস্ট করার জন্য আপনি চাইলে এখানে Cache ব্যবহার করতে পারেন)
        $currency = \App\Models\Currency::where('code', $currentCurrencyCode)->where('status', 1)->first();

        // যদি কোনো কারণে কারেন্সি না পাওয়া যায়, তবে বেস প্রাইসটাই ডিফল্ট হিসেবে দেখাবে
        if (!$currency) {
            return '$' . number_format($price_in_base_currency, 2);
        }

        // ৩. মেইন ম্যাজিক ক্যালকুলেশন: বেস প্রাইস * এক্সচেঞ্জ রেট
        $convertedPrice = $price_in_base_currency * $currency->exchange_rate;

        // ৪. কারেন্সি সিম্বল সহ ফরম্যাট করা প্রাইস রিটার্ন (যেমন: ৳১,২০০.০০ বা $১০.৫০)
        return $currency->symbol . number_format($convertedPrice, 2);
    }
}
