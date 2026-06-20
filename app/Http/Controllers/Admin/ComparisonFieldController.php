<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ComparisonField;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ComparisonFieldController extends Controller
{
    public function index()
    {
        $fields = ComparisonField::with('categories')->latest()->paginate(20);
        $categories = Category::orderBy('name', 'asc')->get();
        return view('backEnd.comparison_fields.index', compact('fields', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:comparison_fields,name',
            'category_ids' => 'nullable|array'
        ]);

        $field = ComparisonField::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        // ক্যাটাগরি সিলেক্ট করা থাকলে পিভট টেবিলে সিঙ্ক (Sync) হবে
        if ($request->has('category_ids')) {
            $field->categories()->sync($request->category_ids);
        }

        return redirect()->back()->with('success', 'Comparison field created and mapped successfully!');
    }

    public function update(Request $request, $id)
    {
        $field = ComparisonField::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255|unique:comparison_fields,name,' . $field->id,
            'category_ids' => 'nullable|array'
        ]);

        $field->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        $field->categories()->sync($request->category_ids ?? []);

        return redirect()->back()->with('success', 'Field updated successfully!');
    }

    public function destroy($id)
    {
        $field = ComparisonField::findOrFail($id);
        $field->categories()->detach(); // পিভট টেবিল থেকে রিলেশন কাটা
        $field->delete();

        return redirect()->back()->with('success', 'Field deleted successfully!');
    }
    public function getFieldsByCategories(Request $request)
    {
        // সিলেক্ট করা ক্যাটাগরি আইডিগুলোর আন্ডারে যে ফিল্ডগুলো ম্যাপ করা আছে, সেগুলো তুলে আনা
        $categoryIds = $request->category_ids ?? [];

        $fields = \App\Models\ComparisonField::whereHas('categories', function($query) use ($categoryIds) {
            $query->whereIn('category_id', $categoryIds);
        })->distinct()->get(['name']); // ইউনিক নামগুলো নেওয়া হচ্ছে

        return response()->json($fields);
    }
}
