<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Product;
use App\Services\SearchIndexerService; // ⚡ কিওয়ার্ড ইনডেক্সার সার্ভিস ইমপোর্ট করা হলো
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    protected $indexerService;

    // ⚡ কনস্ট্রাক্টরের মাধ্যমে সার্চ সার্ভিসটি ইনজেক্ট করা হলো যাতে মেথডগুলো ব্যবহার করা যায়
    public function __construct(SearchIndexerService $indexerService)
    {
        $this->indexerService = $indexerService;
    }

    public function index()
    {
        $blogs = Blog::with('category')->latest()->paginate(20);
        return view('backEnd.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        return view('backEnd.blogs.create', compact('categories','products'));
    }

    public function store(Request $request)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string',
            'description' => 'required',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'product_ids' => 'nullable|array', // প্রোডাক্ট আইডি অ্যারে ভ্যালিডেশন
        ]);

        // ২. ডাটাবেজ ট্রানজেকশন শুরু
        $blog = DB::transaction(function () use ($request) {

            // অটোমেটিক ইউনিক স্ল্যাগ জেনারেটর
            $slug = Str::slug($request->slug ?? $request->title);
            $originalSlug = $slug;
            $count = 1;
            while (\App\Models\Blog::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            // থাম্বনেইল ইমেজ আপলোড
            $thumbnailPath = null;
            if($request->hasFile('thumbnail')){
                $thumbnailPath = ImageHelper::upload($request->file('thumbnail'), 'uploads/blogs/thumbnails');
            }

            // ৩. ব্লগ পোস্ট তৈরি (product_ids সহ)
            $createdBlog = \App\Models\Blog::create([
                'title'            => $request->title,
                'slug'             => $slug,
                'description'      => $request->description,
                'category_id'      => $request->category_id,
                'product_ids'      => $request->product_ids,
                'affiliate_url'    => $request->affiliate_url,
                'affiliate_source' => $request->affiliate_source,
                'featured'         => $request->has('featured'),
                'status'           => $request->has('status'),
                'thumbnail'        => $thumbnailPath,
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords'    => $request->meta_keywords,
                'canonical_url'    => $request->canonical_url,
            ]);

            // ⚡ [SEARCH INDEX] ব্লগের জন্য কিওয়ার্ড তৈরি ও Raw SQL এর মাধ্যমে রিয়েল-টাইমে সেভ
            $keywords = $this->indexerService->generateKeywords(
                [$createdBlog->title, $createdBlog->description, $createdBlog->affiliate_source ?? ''],
                'blog article review tech' // এক্সট্রা ট্যাগ বা কিওয়ার্ড
            );
            $this->indexerService->updateBlogKeywords($createdBlog->id, $keywords);

            // ৪. SEO হেল্পার মেথড কল
            \App\Helpers\SeoHelper::generateAutoSeo($createdBlog, $request, 'Article');

            return $createdBlog; // ট্রানজেকশন ব্লক থেকে অবজেক্টটি রিটার্ন করা হলো
        });

        // ৫. ট্রানজেকশন সফলভাবে শেষ হওয়ার পর রিডাইরেক্ট
        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully!');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::where('status', 1)->get();
        $products = Product::where('status', 1)->get();
        return view('backEnd.blogs.edit', compact('blog', 'categories','products'));
    }

    public function update(Request $request, Blog $blog)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|unique:blogs,slug,' . $blog->id,
            'description' => 'required',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'product_ids' => 'nullable|array', // প্রোডাক্ট আইডি অ্যারে ভ্যালিডেশন
        ]);

        // ২. ডাটাবেজ ট্রানজেকশন শুরু
        DB::transaction(function () use ($request, $blog) {

            // অটোমেটিক ইউনিক স্ল্যাগ জেনারেটর (নিজের আইডি ইগনোর করে চেক করবে)
            $slug = Str::slug($request->slug ?? $request->title);
            $originalSlug = $slug;
            $count = 1;
            while (\App\Models\Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            // থাম্বনেইল ইমেজ আপডেট
            $thumbnailPath = $blog->thumbnail;
            if($request->hasFile('thumbnail')){
                $thumbnailPath = ImageHelper::upload(
                    $request->file('thumbnail'),
                    'uploads/blogs/thumbnails',
                    null,
                    null,
                    $blog->thumbnail
                );
            }

            // ৩. ব্লগ পোস্ট আপডেট (product_ids সহ)
            $blog->update([
                'title'            => $request->title,
                'slug'             => $slug,
                'description'      => $request->description,
                'category_id'      => $request->category_id,
                'product_ids'      => $request->product_ids, // এডিট ফর্ম থেকে আসা নতুন প্রোডাক্ট আইডি লিস্ট আপডেট হবে
                'affiliate_url'    => $request->affiliate_url, // এডিট ফর্ম থেকে আসা নতুন প্রোডাক্ট আইডি লিস্ট আপডেট হবে
                'affiliate_source' => $request->affiliate_source, // এডিট ফর্ম থেকে আসা নতুন প্রোডাক্ট আইডি লিস্ট আপডেট হবে
                'featured'         => $request->has('featured'),
                'status'           => $request->has('status'),
                'thumbnail'        => $thumbnailPath,
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords'    => $request->meta_keywords,
                'canonical_url'    => $request->canonical_url,
            ]);

            // ⚡ [SEARCH INDEX UPDATE] ব্লগ এডিট/আপডেট হলে কিওয়ার্ড রি-জেনারেট হয়ে অটো আপডেট হবে
            $keywords = $this->indexerService->generateKeywords(
                [$blog->title, $blog->description, $blog->affiliate_source ?? ''],
                'blog article review tech'
            );
            $this->indexerService->updateBlogKeywords($blog->id, $keywords);

            // ৪. SEO হেল্পার মেথড কল (স্কিমা স্ক্রিপ্ট রিয়েল-টাইমে রি-জেনারেট হবে)
            \App\Helpers\SeoHelper::generateAutoSeo($blog, $request, 'Article');
        });

        // ৫. ট্রানজেকশন সফল হলে রিডাইরেক্ট
        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully!');
    }

    public function destroy(Blog $blog)
    {
        $blog->load('seo');
        return DB::transaction(function () use ($blog) {
            if ($blog->thumbnail && file_exists(public_path($blog->thumbnail))) {
                @unlink(public_path($blog->thumbnail));
            }
            if ($blog->seo) {
                $blog->seo()->delete();
            }
            $blog->delete();
            return redirect()->back()->with('success', 'Blog post and associated SEO assets deleted successfully!');
        });
    }
}
