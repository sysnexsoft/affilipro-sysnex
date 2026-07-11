<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('childrenRecursive')->whereNull('parent_id')->latest()->paginate(20);
        $allCategories = Category::with('childrenRecursive')->latest()->paginate(20);
        return view('backEnd.category.index', compact('categories','allCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $category = new Category();

        $category->parent_id        = $request->parent_id;
        $category->name             = $request->name;
        $category->slug             = $this->generateUniqueSlug($request->name);
        $category->description      = $request->description;
        $category->icon             = $request->icon;
        $category->position         = $request->position ?? 0;
        $category->featured         = $request->featured ?? 0;

        $category->meta_title       = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords    = $request->meta_keywords;

        $category->status           = $request->status;

        if ($request->hasFile('image')) {
            $category->image =  ImageHelper::upload($request->file('image'), 'uploads/category');
        }

        $category->save();

        return redirect()
            ->back()
            ->with('success', 'Category Added Successfully');
    }
    public function quickStore(Request $request)
    {
        $exists = \App\Models\Category::where('name', $request->name)
            ->orWhere('slug', $request->slug)
            ->first();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This Category Name or Slug already exists!'
            ]);
        }

        // নতুন ক্যাটাগরি তৈরি
        $category = new \App\Models\Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->parent_id = $request->parent_id ?: null;
        $category->status = 1; // Default active
        $category->save();

        return response()->json([
            'success' => true,
            'data' => $category
        ]);
    }
    public function edit($id)
    {
        return Category::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);
        $category = Category::findOrFail($id);
        $category->parent_id        = $request->parent_id;
        $category->name             = $request->name;
        $category->slug             = $this->generateUniqueSlug($request->name, $id);
        $category->description      = $request->description;
        $category->icon             = $request->icon;
        $category->position         = $request->position ?? 0;
        $category->featured         = $request->featured ?? 0;
        $category->meta_title       = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords    = $request->meta_keywords;
        $category->status           = $request->status;
        // Image Update
        if ($request->hasFile('image')) {
            $category->image = ImageHelper::upload(
                $request->file('image'),
                'uploads/category',
                null,
                null,
                $category->image
            );
        }

        $category->save();

        return redirect()
            ->back()
            ->with('success', 'Category Updated Successfully');
    }

    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->id);

        if ($category->children()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'This category has subcategories.'
            ]);
        }

        if ($category->image &&
            file_exists(public_path('uploads/category/' . $category->image))
        ) {
            unlink(public_path('uploads/category/' . $category->image));
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category Deleted Successfully'
        ]);
    }
    private function generateUniqueSlug($name, $id = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (
        Category::where('slug', $slug)
            ->when($id, function ($q) use ($id) {
                return $q->where('id', '!=', $id);
            })
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}
