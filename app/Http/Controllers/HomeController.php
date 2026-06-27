<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Brand;
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
    public function product(Request $request)
    {
        $query = Product::query()->where('status', '1');

        // ১. ক্যাটাগরি স্লাগ ফিল্টার
        if ($request->has('category') && $request->category != 'all') {
            $category = Category::where('slug', $request->category)->where('status', '1')->first();
            if ($category) {
                $query->whereJsonContains('category_ids', (string)$category->id);
            } else {
                $query->whereNull('id');
            }
        }

        // ২. ব্র্যান্ড স্লাগ ফিল্টার
        if ($request->has('brand') && $request->brand != 'all') {
            $brand = Brand::where('slug', $request->brand)->where('status', '1')->first();
            if ($brand) {
                $query->where('brand_id', $brand->id); // আপনার টেবিলের কলাম অনুযায়ী brand_id
            } else {
                $query->whereNull('id');
            }
        }

        // ৩. লাইভ সার্চ ফিল্টার
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('sku', 'LIKE', '%' . $search . '%');
            });
        }

        // ৪. সর্টিং লজিক (এখানে শেষে একটি ->orderBy('id', 'desc') দেওয়া হয়েছে যেন ডাটা রিপিট না হয়)
        if ($request->has('sort')) {
            switch ($request->sort) {
                case 'low':
                    $query->orderByRaw('COALESCE(sale_price, regular_price) ASC');
                    break;
                case 'high':
                    $query->orderByRaw('COALESCE(sale_price, regular_price) DESC');
                    break;
                case 'reviews':
                    $query->orderBy('review_count', 'desc');
                    break;
                case 'rating':
                default:
                    $query->orderBy('rating', 'desc');
                    break;
            }
        } else {
            $query->orderBy('rating', 'desc');
        }

        // ৫. রেসপন্স হ্যান্ডেল করা (AJAX এবং নরমাল পেজ লোড উভয় ক্ষেত্রেই পেজিনেশন)
        $perPage = 9; // প্রতিবারে ৯টি করে প্রোডাক্ট লোড হবে
        $productsPaginated = $query->paginate($perPage);

        if ($request->ajax()) {
            $html = '';
            foreach($productsPaginated as $product) {
                $html .= view('frontEnd.component.productcard', compact('product'))->render();
            }

            return response()->json([
                'html' => $html,
                'count' => $productsPaginated->total(),      // মোট ম্যাচিং প্রোডাক্ট সংখ্যা
                'has_more' => $productsPaginated->hasMorePages() // আরও প্রোডাক্ট বাকি আছে কি না
            ]);
        }

        // প্রথমবার পেজ লোড হওয়ার জন্য ডেটা
        $products = $productsPaginated;
        $categories = Category::where('status', '1')->get();
        $brands = Brand::where('status', '1')->get(); // ব্র্যান্ড ভেরিয়েবল পাঠানো হলো

        return view('frontEnd.product.index', compact('products', 'categories', 'brands'));
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
        $categories = Category::where('status',1)->get();
        return view('frontEnd.category.index',compact('categories'));
    }
    public function blog(){
        $blogs = Blog::with('category')->paginate(18);
        $categories = BlogCategory::where('status',1)->get();
        return view('frontEnd.blog.index',compact('blogs','categories'));
    }
    public function compare(){
        return view('frontEnd.compare.index');
    }
    public function review(Request $request)
    {
        $reviews = ProductReview::with('product')
            ->where('approved', 1)
            ->latest()
            ->paginate(9);

        if ($request->ajax()) {
            $html = '';
            foreach ($reviews as $review) {
                // আপনার এক্সিসটিং 'reviewCard' ব্লেড ভিউকে ডাটা সহ সরাসরি রেণ্ডার করা হচ্ছে
                $html .= view('frontEnd.component.reviewCard', compact('review'))->render();
            }

            return response()->json([
                'html' => $html,
                'has_more' => $reviews->hasMorePages()
            ]);
        }

        return view('frontEnd.review.index', compact( 'reviews'));
    }
}
