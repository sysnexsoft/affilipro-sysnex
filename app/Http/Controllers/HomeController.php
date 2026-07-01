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
        $product = Product::where('slug', $slug)->where('status', 1)->firstOrFail();
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
            ->take(4)
            ->inRandomOrder()
            ->get();

        $reviews = $product->reviews()->latest()->paginate(10);

        return view('frontEnd.product.details', compact('product', 'relatedProducts','reviews'));
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
    public function blogDetails($slug)
    {
        // মেইন ব্লগ কন্টেন্ট (ক্যাটাগরি রিলেশনসহ)
        $blog = Blog::with('category')->where('slug', $slug)->where('status', 1)->firstOrFail();

        // পেজ ভিউ বা রিড কাউন্ট ১ বাড়িয়ে দেওয়া (অপশনাল কিন্তু প্রিমিয়াম ফিচারের জন্য দারুণ)
        $blog->increment('views');

        // ২. রিলেটেড ব্লগস (একই ক্যাটাগরির অন্য ৩টি পোস্ট, বর্তমান পোস্টটি বাদে)
        $relatedBlogs = Blog::with('category')
            ->where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->where('status', 1)
            ->latest()
            ->take(3)
            ->get();

        // ৩. সাইডবারের জন্য লেটেস্ট ৫টি ব্লগ পাবলিকেশন
        $latestBlogs = Blog::with('category')
            ->where('id', '!=', $blog->id)
            ->where('status', 1)
            ->latest()
            ->take(5)
            ->get();

        // ৪. ক্যাটাগরি লিস্ট (যদি সাইডবারে পরে উইজেট হিসেবে দেখাতে চান)
        $categories = BlogCategory::where('status', 1)->get();

        return view('frontEnd.blog.blogdetails', compact('blog', 'relatedBlogs', 'latestBlogs', 'categories'));
    }
    public function getReviews(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $reviews = $product->reviews()->latest()->paginate(10);
        $html = '';
        foreach($reviews as $rev) {
            $html .= view('frontEnd.product.single_review', compact('rev'))->render();
        }

        return response()->json([
            'html' => $html,
            'hasMorePages' => $reviews->hasMorePages() // আরও পেজ আছে কিনা তা ফ্রন্টএন্ডকে জানাবে
        ]);
    }
// সাইডবার লাইভ সার্চের জন্য AJAX এপিআই মেথড
    public function blogSearch(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->get('query');

            $blogs = Blog::where('status', 1)
                ->where(function($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                        ->orWhere('description', 'LIKE', "%{$query}%");
                })
                ->latest()
                ->take(6)
                ->get();

            $html = '';
            foreach ($blogs as $item) {
                $url = route('blog.details', $item->slug);
                $thumbnail = $item->thumbnail ? asset($item->thumbnail) : asset('default-thumbnail.jpg');

                // ড্রপডাউনের জন্য প্রিমিয়াম ডিজাইন লিস্ট আইটেম স্ট্রাকচার
                $html .= "
            <a href='{$url}' class='flex items-center gap-3 p-2.5 hover:bg-slate-50 transition border-b border-slate-100 last:border-0 no-underline group'>
                <img src='{$thumbnail}' alt='{$item->title}' class='w-10 h-10 rounded-lg object-cover flex-shrink-0 bg-slate-100'>
                <div class='min-w-0'>
                    <h6 class='text-xs font-semibold text-slate-800 line-clamp-1 group-hover:text-primary transition-colors m-0'>{$item->title}</h6>
                    <span class='text-[10px] text-slate-400'><i class='fa-regular fa-calendar me-1'></i> " . $item->created_at->format('M d, Y') . "</span>
                </div>
            </a>";
            }

            return response()->json([
                'html'  => $html,
                'count' => $blogs->count()
            ]);
        }

        return abort(404);
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
