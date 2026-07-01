<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('category')->latest()->paginate(20);
        return view('backEnd.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::where('status', 1)->get();
        return view('backEnd.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string',
            'description' => 'required',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        return DB::transaction(function () use ($request) {
            $slug = Str::slug($request->slug ?? $request->title);
            $originalSlug = $slug;
            $count = 1;
            while (\App\Models\Blog::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $thumbnailPath = null;
            if($request->hasFile('thumbnail')){
                $thumbnailPath = ImageHelper::upload($request->file('thumbnail'), 'uploads/blogs/thumbnails');
            }

            $blog = \App\Models\Blog::create([
                'title'            => $request->title,
                'slug'             => $slug, // গ্যারান্টেড ইউনিক স্ল্যাগ
                'description'      => $request->description,
                'category_id'      => $request->category_id,
                'featured'         => $request->has('featured') ? true : false, // চেকবক্স ট্রিক
                'status'           => $request->has('status') ? true : false,   // চেকবক্স ট্রিক
                'thumbnail'        => $thumbnailPath,
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords'    => $request->meta_keywords,
                'canonical_url'    => $request->canonical_url,
            ]);
            \App\Helpers\SeoHelper::generateAutoSeo($blog, $request, 'Article');
            return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully!');
        });
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::where('status', 1)->get();
        return view('backEnd.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        // ১. ভ্যালিডেশন (স্ল্যাগ ইউনিক চেক করার সময় এই ব্লগের আইডি ইগনোর করা হয়েছে)
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|unique:blogs,slug,' . $blog->id,
            'description' => 'required',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // ⚡ অপ্টিমাইজেশন ১: Database Transaction
        return DB::transaction(function () use ($request, $blog) {

            // ⚡ অপ্টিমাইজেশন ২: অটোমেটিক ইউনিক স্ল্যাগ জেনারেটর (নিজের আইডি ইগনোর করে চেক করবে)
            $slug = Str::slug($request->slug ?? $request->title);
            $originalSlug = $slug;
            $count = 1;
            while (\App\Models\Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            // থাম্বনেইল ইমেজ আপডেট (পুরাতন ইমেজ ডিলিট করার জন্য $blog->thumbnail পাস করা হলো)
            $thumbnailPath = $blog->thumbnail;
            if($request->hasFile('thumbnail')){
                $thumbnailPath = ImageHelper::upload(
                    $request->file('thumbnail'),
                    'uploads/blogs/thumbnails',
                    null,
                    null,
                    $blog->thumbnail // এখানে আগের কোডে featured_image ছিল, যা ভুল ছিল
                );
            }

            // ⚡ অপ্টিমাইজেশন ৩: Mass Update
            $blog->update([
                'title'            => $request->title,
                'slug'             => $slug, // গ্যারান্টেড ইউনিক স্ল্যাগ
                'description'      => $request->description,
                'category_id'      => $request->category_id,
                'featured'         => $request->has('featured') ? true : false,
                'status'           => $request->has('status') ? true : false,
                'thumbnail'        => $thumbnailPath,
                'meta_title'       => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords'    => $request->meta_keywords,
                'canonical_url'    => $request->canonical_url,
            ]);

            // 🚀 ৪. SEO হেল্পার মেথড কল (ব্লগের ডেটা আপডেট বা ওভাররাইট করার জন্য)
            \App\Helpers\SeoHelper::generateAutoSeo($blog, $request, 'Article');

            return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully!');
        });
    }

    public function destroy(Blog $blog)
    {
        if ($blog->thumbnail && file_exists($blog->thumbnail)) {
            unlink($blog->thumbnail);
        }
        $blog->delete();

        return redirect()->back()->with('success', 'Blog post deleted successfully!');
    }
}
