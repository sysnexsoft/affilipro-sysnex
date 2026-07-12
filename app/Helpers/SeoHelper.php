<?php

namespace App\Helpers; // আপনার প্রজেক্টের সঠিক নেমস্পেস অনুযায়ী পরিবর্তন করে নেবেন

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\WebSetting;
use App\Models\SeoManagement;

class SeoHelper
{
    public static function generateAutoSeo($model, $request, $type = 'Product')
    {
        $siteUrl = url('/');
        $web_Setting = WebSetting::latest()->first();

        // ১. সাইটের লোগো ডাইনামিক করা হলো
        $logo = ($web_Setting && $web_Setting->header_logo) ? asset($web_Setting->header_logo) : $siteUrl . '/assets/images/logo.png';

        // 🚀 ২. কাস্টম বা স্ট্যাটিক পেজের জন্য লজিক
        if ($type === 'Custom') {
            $slugField = $request->page_slug;
            $pageUrl = url("/{$slugField}");
            $title = $request->page_name;

            $schema = '<script type="application/ld+json">' . "\n" .
                json_encode([
                    "@context" => "https://schema.org",
                    "@type" => "WebPage",
                    "name" => $title,
                    "url" => $pageUrl,
                    "description" => $title . " page of " . env('APP_NAME'),
                    "publisher" => [
                        "@type" => "Organization",
                        "name" => env('APP_NAME'),
                        "logo" => $logo,
                        "url" => $siteUrl
                    ]
                ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n" .
                '</script>';

            $dataLayerJson = json_encode([
                "event" => "view_item",
                "page_type" => "custom_page",
                "page_title" => $title
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            return SeoManagement::create([
                'page_name'        => $title . ' - Custom Page',
                'page_slug'        => $slugField,
                'meta_title'       => $title,
                'meta_description' => $title . " - Explore more details on our official website.",
                'canonical_url'    => $pageUrl,
                'meta_robots'      => 'index, follow',
                'schema_script'    => $schema,
                'datalayer_json'   => $dataLayerJson,
                'meta_image'       => $logo,
            ]);
        }

        // $model থেকে স্ল্যাগ নেওয়া হচ্ছে (Product ও Blog দুটোরই 'slug' কলাম আছে)
        $slugField = $model->slug;

        // 🚀 ৩. আপনার প্রোডাক্ট এবং ব্লগ টেবিলের কলাম অনুযায়ী ডেটা ম্যাপিং
        if ($type === 'Article') {
            $pageUrl = url("/blog/{$slugField}");
            $title = $model->title;
            $description = $model->description; // ব্লগের 'description' কলাম
            $page_slug = "blog/{$slugField}";
            $imageUrl = $model->thumbnail ? asset($model->thumbnail) : $siteUrl . '/default.jpg'; // ব্লগের 'thumbnail'
        } else {
            // Default: Product
            $pageUrl = url("/product/{$slugField}");
            $title = $model->title; // প্রোডাক্টের 'title' কলাম
            $description = $model->short_description ?? $model->description; // প্রোডাক্টের ডেসক্রিপশন
            $page_slug = "product/{$slugField}";
            $imageUrl = $model->featured_image ? asset($model->featured_image) : $siteUrl . '/default.jpg'; // প্রোডাক্টের 'featured_image'
        }

        // HTML ট্যাগ ক্লিন করা (মেটা ডেসক্রিপশনের জন্য)
        $cleanDesc = strip_tags($description);

        // 🚀 ৪. কলাম-স্পেসিফিক অ্যাডভান্সড স্কিমা জেনারেশন
        $schema = '<script type="application/ld+json">' . "\n";

        if ($type === 'Article') {
            // ব্লগের জন্য গুগল নিউজ-ফ্রেন্ডলি টাইপ
            $schema .= json_encode([
                "@context" => "https://schema.org",
                "@type" => "NewsArticle",
                "mainEntityOfPage" => ["@type" => "WebPage", "@id" => $pageUrl],
                "headline" => Str::limit($title, 100),
                "description" => Str::limit($cleanDesc, 160),
                "image" => $imageUrl,
                "datePublished" => $model->created_at ? $model->created_at->toIso8601String() : now()->toIso8601String(),
                "dateModified" => $model->updated_at ? $model->updated_at->toIso8601String() : now()->toIso8601String(),
                "author" => [
                    "@type" => "Organization",
                    "name" => env('APP_NAME'),
                    "url" => $siteUrl
                ],
                "publisher" => [
                    "@type" => "Organization",
                    "name" => env('APP_NAME'),
                    "logo" => [
                        "@type" => "ImageObject",
                        "url" => $logo
                    ]
                ]
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        } else {
            // প্রোডাক্টের বেস প্রাইস ক্যালকুলেশন (sale_price থাকলে সেটা আগে নিবে)
            $basePrice = !empty($model->sale_price) && $model->sale_price > 0 ? $model->sale_price : ($model->regular_price ?? 0);

            // ডাটাবেজ থেকে একটিভ সব কারেন্সি নিয়ে আসা
            $allCurrencies = DB::table('currencies')->where('status', 1)->get();
            $offersArray = [];
            $defaultCurrencyCode = 'USD';

            // লুপ চালিয়ে প্রতিটি কারেন্সির জন্য আলাদা অফার তৈরি করা
            foreach ($allCurrencies as $curr) {
                // exchange_rate দিয়ে গুণ করে ওই কারেন্সির প্রাইস বের করা
                $convertedPrice = floatval($basePrice) * floatval($curr->exchange_rate);

                if($curr->is_default == 1) {
                    $defaultCurrencyCode = $curr->code;
                }

                $offersArray[] = [
                    "@type" => "Offer",
                    "url" => $model->affiliate_url ?? $pageUrl, // সরাসরি আপনার অ্যাফিলিয়েট ইউআরএল ট্র্যাক করবে
                    "priceCurrency" => $curr->code, // যেমন: USD, BDT, INR
                    "price" => round($convertedPrice, 2), // দশমিকের পর ২ ঘর রাখা হলো
                    "priceValidUntil" => now()->addYear()->toDateString(),
                    "itemCondition" => "https://schema.org/NewCondition",
                    "availability" => "https://schema.org/InStock"
                ];
            }

            // রিলেশনশিপ থেকে ব্র্যান্ড নেম লোড (যদি থাকে, নয়তো সাইটের নাম)
            $brandName = ($model->brand && isset($model->brand->name)) ? $model->brand->name : (env('APP_NAME') ?? 'Generic');

            $productSchemaObj = [
                "@context" => "https://schema.org",
                "@type" => "Product",
                "name" => $title,
                "image" => $imageUrl,
                "description" => Str::limit($cleanDesc, 200),
                "sku" => $model->sku ?? "SKU-{$model->id}",
                "brand" => [
                    "@type" => "Brand",
                    "name" => $brandName
                ],
                // এখানে আমরা একক Offer এর বদলে AggregateOffer এবং সম্পূর্ণ কারেন্সি অ্যারে পাস করছি
                "offers" => [
                    "@type" => "AggregateOffer",
                    "priceCurrency" => $defaultCurrencyCode,
                    "lowPrice" => count($offersArray) > 0 ? min(array_column($offersArray, 'price')) : round($basePrice, 2),
                    "highPrice" => count($offersArray) > 0 ? max(array_column($offersArray, 'price')) : round($basePrice, 2),
                    "offerCount" => count($offersArray),
                    "offers" => $offersArray
                ]
            ];

            // গুগল রিভিউ রেটিং বুস্ট: যদি প্রোডাক্টে রেটিং থাকে তবেই কেবল স্কিমাতে অ্যাড হবে (গুগল এরর এড়াতে)
            if ($model->review_count > 0) {
                $productSchemaObj["aggregateRating"] = [
                    "@type" => "AggregateRating",
                    "ratingValue" => floatval($model->rating ?? 5),
                    "reviewCount" => intval($model->review_count)
                ];
            }

            $schema .= json_encode($productSchemaObj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        $schema .= "\n</script>";

        // 🚀 ৫. ট্র্যাকিং ইভেন্ট ডাটালায়ার (GA4 ই-কমার্স ফ্রেন্ডলি)
        $itemPrice = $type === 'Article' ? 0.00 : (!empty($model->sale_price) && $model->sale_price > 0 ? $model->sale_price : ($model->regular_price ?? 0.00));

        $dataLayerObj = [
            "event" => $type === 'Article' ? "view_article" : "view_item",
            "page_type" => strtolower($type) . "_detail",
            "ecommerce" => [
                "currency" => "USD", // ডাটালায়ার ট্র্যাকিং এর জন্য গ্লোবাল স্ট্যান্ডার্ড USD রাখা হলো
                "value" => floatval($itemPrice),
                "items" => [[
                    "item_name" => $title,
                    "item_category" => $type . "s",
                    "item_id" => (string)$model->id,
                    "price" => floatval($itemPrice)
                ]]
            ]
        ];
        $dataLayerJson = json_encode($dataLayerObj, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        // 🚀 ৬. আপনার `seo_management` টেবিলের সাথে রিলেশন অনুযায়ী ডাটাবেজে আপসার্ট (Update or Create)
        return $model->seo()->updateOrCreate(
            [
                'model_type' => get_class($model),
                'model_id'   => $model->id,
            ],
            [
                'page_name'        => $title . " - {$type} Page",
                'page_slug'        => $page_slug,
                'meta_title'       => $request->meta_title ?? ($model->meta_title ?? $title),
                'meta_description' => $request->meta_description ?? ($model->meta_description ?? Str::limit($cleanDesc, 160)),
                'meta_keywords'    => $request->meta_keywords ?? $model->meta_keywords,
                'canonical_url'    => $request->canonical_url ?? ($model->canonical_url ?? $pageUrl),
                'meta_robots'      => $request->meta_robots ?? 'index, follow',
                'schema_script'    => $request->schema_script ?? $schema,
                'datalayer_json'   => $request->datalayer_json ?? $dataLayerJson,
                'meta_image'       => $imageUrl,
            ]
        );
    }
}
