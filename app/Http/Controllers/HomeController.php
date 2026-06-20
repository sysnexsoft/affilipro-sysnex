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
    public function productDetails($slug){
        $product = Product::where('slug',$slug)->where('status',1)->first();
        return view('frontEnd.product.details',compact('product'));
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
