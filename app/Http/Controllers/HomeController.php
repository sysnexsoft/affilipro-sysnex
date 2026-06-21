<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)->take(6)->get();
        $featuredProducts = Product::where('status', 1)
            ->where('featured', 1)
            ->latest()
            ->take(4)
            ->get();
        $bestRatedProducts = Product::withAvg('reviews', 'rating')
        ->where('status', 1)
            ->orderByDesc('reviews_avg_rating')
            ->take(4)
            ->get();

        $latestReviews = ProductReview::with('product')
            ->where('approved', 1)
            ->latest()
            ->take(3)
            ->get();

        return view('frontEnd.home.index', compact(
            'categories',
            'featuredProducts',
            'bestRatedProducts',
            'latestReviews'
        ));
    }
    public function contactUs(){
        return view('frontEnd.contact-us.index');
    }
    public function aboutUs(){
        return view('frontEnd.about-us.index');
    }
    public function product(){
        return view('frontEnd.product.index');
    }
    public function productDetails($slug)
    {
        // ১. মূল প্রোডাক্টটি খুঁজে বের করা
        $product = Product::where('slug', $slug)->where('status', 1)->firstOrFail();

        // ২. রিলেটেড প্রোডাক্ট বের করার কুয়েরি
        // কারেন্ট প্রোডাক্টের ক্যাটাগরি অ্যারে থেকে আইডিগুলো নেওয়া হচ্ছে (ফেলব্যাক হিসেবে খালি অ্যারে)
        $categoryIds = $product->category_ids ?? [];

        $relatedProducts = Product::where('status', 1)
            ->where('id', '!=', $product->id) // বর্তমান প্রোডাক্টটিকে লিস্ট থেকে বাদ দেওয়ার জন্য
            ->where(function ($query) use ($categoryIds) {
                foreach ($categoryIds as $id) {
                    // JSON Array-এর ভেতরে কোনো একটি আইডি ম্যাচ করলেই তা রিলেটেড হিসেবে গণ্য হবে
                    $query->orWhereJsonContains('category_ids', (int)$id)
                        ->orWhereJsonContains('category_ids', (string)$id); // টাইপ কাস্টিং সেফটি
                }
            })
            ->take(4) // কয়টা রিলেটেড প্রোডাক্ট দেখাতে চান (যেমন: ৪ টা)
            ->inRandomOrder() // র্যান্ডমাইজড আকারে দেখানোর জন্য (ঐচ্ছিক)
            ->get();

        return view('frontEnd.product.details', compact('product', 'relatedProducts'));
    }
    public function categories(){
        return view('frontEnd.category.index');
    }
    public function blog(){
        return view('frontEnd.blog.index');
    }
    public function compare(){
        return view('frontEnd.compare.index');
    }
    public function review(){
        return view('frontEnd.review.index');
    }
}
