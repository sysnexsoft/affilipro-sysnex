<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['brand'])->latest()->paginate(20);
        $categories = Category::where('status',1)->get();
        $brands = Brand::where('status',1)->get();
        return view('backEnd.product.index', compact('products','categories','brands'));
    }
    public function create()
    {
        $categories = Category::where('status',1)->get();
        $brands = Brand::where('status',1)->get();
        return view('backEnd.product.create', compact('categories','brands'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'affiliate_url' => 'required'
        ]);

        $product = new Product();
        $product->category_ids = $request->category_ids;
        $product->brand_id = $request->brand_id;
        $product->title = $request->title;
        $product->slug = Str::slug($request->title);
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->pros = $request->pros;
        $product->cons = $request->cons;
        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;
        $product->affiliate_url = $request->affiliate_url;
        $product->affiliate_network = $request->affiliate_network;
        $product->featured = $request->featured ?? 0;
        $product->trending = $request->trending ?? 0;
        $product->best_seller = $request->best_seller ?? 0;
        $product->editors_choice = $request->editors_choice ?? 0;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keywords = $request->meta_keywords;
        $product->status = $request->status ?? 1;
        if($request->hasFile('featured_image'))
        {
            $image = $request->file('featured_image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move('uploads/product', $imageName);
            $product->featured_image = $imageName;
        }
        $product->save();
        return redirect()->route('admin.product.index')->with('success','Product Created Successfully');
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.edit', compact('product', 'categories', 'brands'));
    }
    public function update(Request $request,$id)
    {
        $product = Product::findOrFail($id);

        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        $product->title = $request->title;
        $product->slug = Str::slug($request->title);

        $product->short_description = $request->short_description;
        $product->description = $request->description;

        $product->pros = $request->pros;
        $product->cons = $request->cons;

        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;

        $product->affiliate_url = $request->affiliate_url;
        $product->affiliate_network = $request->affiliate_network;

        $product->featured = $request->featured ?? 0;
        $product->trending = $request->trending ?? 0;
        $product->best_seller = $request->best_seller ?? 0;
        $product->editors_choice = $request->editors_choice ?? 0;

        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keywords = $request->meta_keywords;

        $product->status = $request->status ?? 1;

        if($request->hasFile('featured_image'))
        {
            if(
                $product->featured_image &&
                file_exists(
                    public_path(
                        'uploads/product/'.
                        $product->featured_image
                    )
                )
            )
            {
                unlink(
                    public_path(
                        'uploads/product/'.
                        $product->featured_image
                    )
                );
            }

            $image = $request->file('featured_image');

            $imageName = time().'.'.$image->getClientOriginalExtension();

            $image->move(
                public_path('uploads/product'),
                $imageName
            );

            $product->featured_image = $imageName;
        }

        $product->save();

        return redirect()
            ->route('product.index')
            ->with('success','Product Updated Successfully');
    }
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if($product->featured_image && file_exists(public_path('uploads/product/'. $product->featured_image)))
        {
            unlink(public_path('uploads/product/'. $product->featured_image));
        }
        $product->delete();
        return redirect()->route('product.index')->with('success','Product Deleted Successfully');
    }
}
