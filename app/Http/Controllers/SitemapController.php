<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        // একটিভ প্রোডাক্টস
        $products = Product::where('status', 1)->select('slug', 'updated_at')->latest()->get();
        $categories = Category::select('slug', 'updated_at')->get();
        $blogs = Blog::select('slug', 'updated_at')->latest()->get();
        // রিভিউ পেজের জন্য লেটেস্ট রিভিউর আপডেট টাইম (ঐচ্ছিক)
        $latestReview = ProductReview::latest()->first();
        $reviewUpdatedAt = $latestReview ? $latestReview->updated_at : now();
        // ভিউ ফাইলে সব ডাটা পাস করা এবং XML হেডার সেট করা
        return response()->view('sitemap', [
            'products'        => $products,
            'categories'      => $categories,
            'blogs'           => $blogs,
            'reviewUpdatedAt' => $reviewUpdatedAt
        ])->header('Content-Type', 'text/xml');
    }
}
