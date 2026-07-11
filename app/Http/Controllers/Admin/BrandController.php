<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest()->paginate(10);
        return view('backEnd.brand.index', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp'
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = $this->generateSlug($request->name);
        $brand->description = $request->description;
        $brand->website = $request->website;
        $brand->status = $request->status ?? 1;
        $brand->meta_title = $request->meta_title;
        $brand->meta_description = $request->meta_description;
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $filename = time() . '_' . rand(1111,9999) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/brands'), $filename);
            $brand->logo = 'uploads/brands/' . $filename;
        }
        $brand->save();
        return back()->with('success', 'brand Created Successfully');
    }
    public function quickStore(Request $request)
    {
        $exists = \App\Models\Brand::where('name', $request->name)->orWhere('slug', $request->slug)->first();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This Brand Name or Slug already exists!'
            ]);
        }
        $brand = new \App\Models\Brand();
        $brand->name = $request->name;
        $brand->slug = $request->slug;
        $brand->status = 1;
        $brand->save();
        return response()->json([
            'success' => true,
            'data' => $brand
        ]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp'
        ]);

        $brand = Brand::find($id);
        $data = $request->except('logo');

        $data['slug'] = $this->generateSlug(
            $request->name,
            $brand->id
        );

        if ($request->hasFile('logo')) {

            if ($brand->logo && file_exists(public_path($brand->logo))) {
                unlink(public_path($brand->logo));
            }

            $image = $request->file('logo');

            $filename = time().'_'.$image->getClientOriginalName();

            $image->move(public_path('uploads/brands'), $filename);

            $data['logo'] = 'uploads/brands/'.$filename;
        }

        $brand->update($data);

        return back()->with('success','Brand Updated Successfully');
    }

    public function destroy(Request $request)
    {
        $brand = Brand::find($request->id);
        if ($brand->logo && file_exists(public_path($brand->logo))) {
            unlink(public_path($brand->logo));
        }
        $brand->delete();
        return back()->with('success', 'brand Deleted Successfully');
    }

    private function generateSlug($name, $id = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;
        while (Brand::where('slug', $slug)->when($id, function ($query) use ($id) {
                $query->where('id', '!=', $id);
        })
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

}
