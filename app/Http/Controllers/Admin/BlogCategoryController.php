<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::latest()->paginate(20);
        return view('backEnd.blog_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('backEnd.blog_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:blog_categories,slug',
        ]);

        BlogCategory::create([
            'name'        => $request->name,
            'slug'        => Str::slug($request->slug),
            'description' => $request->description,
            'status'      => $request->status ?? 0,
        ]);

        return redirect()->route('admin.blogs-categories.index')->with('success', 'Category created successfully!');
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('backEnd.blog_categories.edit', compact('blogCategory'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:blog_categories,slug,' . $id,
        ]);
        $blogCategory = BlogCategory::find($id);
        $blogCategory->update([
            'name'        => $request->name,
            'slug'        => Str::slug($request->slug),
            'description' => $request->description,
            'status'      => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('admin.blogs-categories.index')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $blogCategory = BlogCategory::find($id);
        $blogCategory->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
}
