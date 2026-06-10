<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('backend.category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:categories,name'
        ]);

        $image = null;
        if($request->hasFile('image'))
        {
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/category'), $image);
        }
        Category::create([
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
            'description'=>$request->description,
            'image'=>$image,
            'meta_title'=>$request->meta_title,
            'meta_description'=>$request->meta_description,
            'meta_keywords'=>$request->meta_keywords,
            'status'=>$request->status ?? 1
        ]);
        return back()->with('success','Category Added Successfully');
    }

    public function edit($id)
    {
        return Category::findOrFail($id);
    }

    public function update(Request $request,$id)
    {
        $category = Category::findOrFail($id);
        $image = $category->image;
        if($request->hasFile('image'))
        {
            if($category->image && file_exists(public_path('uploads/category/'.$category->image))){
                unlink(public_path('uploads/category/'.$category->image));
            }
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/category'), $image);
        }

        $category->update([
            'name'=>$request->name,
            'slug'=>Str::slug($request->name),
            'description'=>$request->description,
            'image'=>$image,
            'meta_title'=>$request->meta_title,
            'meta_description'=>$request->meta_description,
            'meta_keywords'=>$request->meta_keywords,
            'status'=>$request->status
        ]);

        return back()->with('success','Category Updated Successfully');
    }

    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->id);

        if($category->image && file_exists(public_path('uploads/category/'.$category->image))){
            unlink(public_path('uploads/category/'.$category->image));
        }
        $category->delete();
        return response()->json([
            'status'=>true
        ]);
    }
}
