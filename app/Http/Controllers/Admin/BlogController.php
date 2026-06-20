<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
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
            'slug'        => 'required|string|unique:blogs,slug',
            'description' => 'required',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $thumbnailPath = null;
        if($request->hasFile('thumbnail')){
            $thumbnailPath =  ImageHelper::upload($request->file('thumbnail'), 'uploads/blogs/thumbnails');
        }

        Blog::create([
            'title'            => $request->title,
            'slug'             => Str::slug($request->slug),
            'description'      => $request->description,
            'category_id'      => $request->category_id,
            'featured'         => $request->featured ?? 0,
            'status'           => $request->status ?? 0,
            'thumbnail'        => $thumbnailPath,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'canonical_url'    => $request->canonical_url,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post created successfully!');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::where('status', 1)->get();
        return view('backEnd.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'slug'        => 'required|string|unique:blogs,slug,' . $blog->id,
            'description' => 'required',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $thumbnailPath = $blog->thumbnail;
        if($request->hasFile('thumbnail')){
            $blog->thumbnail = ImageHelper::upload(
                $request->file('thumbnail'),
                'uploads/blogs/thumbnails',
                null,
                null,
                $blog->featured_image
            );
        }

        $blog->update([
            'title'            => $request->title,
            'slug'             => Str::slug($request->slug),
            'description'      => $request->description,
            'category_id'      => $request->category_id,
            'featured'         => $request->featured ?? 0,
            'status'           => $request->status ?? 0,
            'thumbnail'        => $thumbnailPath,
            'meta_title'       => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords'    => $request->meta_keywords,
            'canonical_url'    => $request->canonical_url,
        ]);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog post updated successfully!');
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
