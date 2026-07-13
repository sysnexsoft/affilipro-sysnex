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
        // 💡 names array and specific item validation rule check pattern setup
        $request->validate([
            'names' => 'required|array|min:1',
            'names.*' => 'required|string|max:255',
            'category_ids' => 'nullable|array'
        ]);

        // Track sequential save elements or warnings flags checks
        $savedCount = 0;
        foreach ($request->names as $nameItem) {
            $cleanName = trim($nameItem);
            $slug = Str::slug($cleanName);
            // Already dynamically entry processing exist checking logic configuration mapping
            $field = ComparisonField::where('slug', $slug)->first();
            if (!$field) {
                $field = ComparisonField::create([
                    'name' => $cleanName,
                    'slug' => $slug,
                ]);
                $savedCount++;
            }

            // Catch relation mapping category binding sync attachments multi rows array
            if ($request->has('category_ids') && !empty($request->category_ids)) {
                $field->categories()->syncWithoutDetaching($request->category_ids);
            }
        }

        return redirect()->back()->with('success', $savedCount . ' Comparison fields updated and mapped successfully inside loop logic context matrix layer!');
    }

    public function update(Request $request, $id)
    {
        // Update logic system single data change format rules preserve runtime matching validation logic:
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
        return redirect()->back()->with('success', 'Field modified and sync schema saved successfully!');
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
