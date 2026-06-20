<?php

namespace App\Http\Controllers\Admin;
use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug',
            'affiliate_url' => 'required|url',
        ]);

        $product = new Product();
        $product->title = $request->title;
        $product->slug = Str::slug($request->slug);
        $product->category_ids = $request->category_ids;
        $product->sku = $request->sku;
        $product->brand_id = $request->brand_id;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->pros = $request->pros;
        $product->cons = $request->cons;

        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;

        $product->affiliate_url = $request->affiliate_url;
        $product->affiliate_network = $request->affiliate_network;
        $product->commission_rate = $request->commission_rate;

        $product->allow_compare = $request->has('allow_compare');
        $product->featured = $request->has('featured');
        $product->trending = $request->has('trending');
        $product->best_seller = $request->has('best_seller');
        $product->editors_choice = $request->has('editors_choice');

        $product->meta_title = $request->has('meta_title');
        $product->meta_description = $request->has('meta_description');
        $product->meta_keywords = $request->has('meta_keywords');
        $product->canonical_url = $request->has('canonical_url');

        if($request->hasFile('featured_image')){
            $product->featured_image =  ImageHelper::upload($request->file('featured_image'), 'uploads/products/thumbnails');
        }
        $product->save();

        // গ্যালারি ইমেজ সেভ
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $image) {
                $path = ImageHelper::upload($image, 'uploads/products/gallery');
                $product->images()->create([
                    'image' => $path,
                    'position' => $index
                ]);
            }
        }

        // স্পেসিফিকেশন সেভ
        if ($request->has('specs')) {
            foreach ($request->specs as $spec) {
                if (!empty($spec['name']) && !empty($spec['value'])) {
                    $product->specifications()->create([
                        'spec_name' => $spec['name'],
                        'spec_value' => $spec['value']
                    ]);
                }
            }
        }

        // এফএকিউ (FAQs) সেভ
        if ($request->has('faqs')) {
            foreach ($request->faqs as $faq) {
                if (!empty($faq['question']) && !empty($faq['answer'])) {
                    $product->faqs()->create([
                        'question' => $faq['question'],
                        'answer' => $faq['answer']
                    ]);
                }
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product created successfully!');
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('backEnd.product.edit', compact('product', 'categories', 'brands'));
    }
    public function update(Request $request, $id)
    {
        // ১. প্রোডাক্টটি খুঁজে বের করা
        $product = Product::with(['images', 'specifications', 'faqs'])->findOrFail($id);

        // ২. ভ্যালিডেশন (স্ল্যাগ ইউনিক চেক করার সময় এই প্রোডাক্টের আইডি বাদ দেওয়া হয়েছে)
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $product->id,
            'affiliate_url' => 'required|url',
        ]);

        // ৩. মেইন প্রোডাক্ট ডেটা আপডেট
        $product->title = $request->title;
        $product->slug = Str::slug($request->slug);
        $product->category_ids = $request->category_ids;
        $product->sku = $request->sku;
        $product->brand_id = $request->brand_id;
        $product->short_description = $request->short_description;
        $product->description = $request->description;
        $product->pros = $request->pros;
        $product->cons = $request->cons;

        $product->regular_price = $request->regular_price;
        $product->sale_price = $request->sale_price;

        $product->affiliate_url = $request->affiliate_url;
        $product->affiliate_network = $request->affiliate_network;
        $product->commission_rate = $request->commission_rate;

        // চেকবক্স/টগল ফিল্ডস (অন না থাকলে ০/false সেভ হবে)
        $product->allow_compare = $request->has('allow_compare');
        $product->featured = $request->has('featured');
        $product->trending = $request->has('trending');
        $product->best_seller = $request->has('best_seller');
        $product->editors_choice = $request->has('editors_choice');
        $product->status = $request->has('status');

        // এসইও মেটা ফিল্ডস ফিক্সড (has() এর বদলে সরাসরি ইনপুট নেওয়া হয়েছে)
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_keywords = $request->meta_keywords;
        $product->canonical_url = $request->canonical_url;

        // ৪. থাম্বনেইল ইমেজ আপডেট (পুরাতন ইমেজ অটো ডিলিট হবে হেল্পারের মাধ্যমে)
        if($request->hasFile('featured_image')){
            $product->featured_image = ImageHelper::upload(
                $request->file('featured_image'),
                'uploads/products/thumbnails',
                null,
                null,
                $product->featured_image
            );
        }

        $product->save();

        // ৫. নতুন গ্যালারি ইমেজ সেভ (পুরাতনগুলো রেখে নতুনগুলো অ্যাপেন্ড হবে)
        if ($request->hasFile('gallery_images')) {
            // নতুন পজিশন কাউন্ট করার জন্য কারেন্ট ইমেজের সংখ্যা বের করা
            $currentImagesCount = $product->images()->count();

            foreach ($request->file('gallery_images') as $index => $image) {
                $path = ImageHelper::upload($image, 'uploads/products/gallery');
                $product->images()->create([
                    'image' => $path,
                    'position' => $currentImagesCount + $index
                ]);
            }
        }

        // ৬. স্পেসিফিকেশন সিঙ্ক (পুরাতনগুলো ডিলিট করে নতুনগুলো ইনসার্ট করা সবচেয়ে ক্লিন উপায়)
        $product->specifications()->delete();
        if ($request->has('specs')) {
            foreach ($request->specs as $spec) {
                if (!empty($spec['name']) && !empty($spec['value'])) {
                    $product->specifications()->create([
                        'spec_name' => $spec['name'],
                        'spec_value' => $spec['value']
                    ]);
                }
            }
        }

        // ৭. এফএকিউ (FAQs) সিঙ্ক
        $product->faqs()->delete();
        if ($request->has('faqs')) {
            foreach ($request->faqs as $faq) {
                if (!empty($faq['question']) && !empty($faq['answer'])) {
                    $product->faqs()->create([
                        'question' => $faq['question'],
                        'answer' => $faq['answer']
                    ]);
                }
            }
        }

        return redirect()->route('admin.product.index')->with('success', 'Product updated successfully!');
    }
    public function destroy(Request $request)
    {
        $product = Product::with('images')->findOrFail($request->id);
        if ($product->featured_image && file_exists(public_path($product->featured_image))) {
            @unlink(public_path($product->featured_image));
        }
        if ($product->images->count() > 0) {
            foreach ($product->images as $galleryImg) {
                if ($galleryImg->image && file_exists(public_path($galleryImg->image))) {
                    @unlink(public_path($galleryImg->image));
                }
            }
        }
        $product->delete();
        return redirect()->route('admin.product.index')->with('success', 'Product and all associated assets deleted successfully!');
    }
    public function deleteGalleryImage($id)
    {
        $image = ProductImage::findOrFail($id);

        // ১. public ফোল্ডার থেকে ফাইলটি পার্মানেন্টলি ডিলিট করা
        if ($image->image && file_exists(public_path($image->image))) {
            @unlink(public_path($image->image));
        }

        // ২. ডাটাবেজ থেকে রো ডিলিট করা
        $image->delete();

        // ৩. Ajax এর জন্য সাকসেস রেসপন্স পাঠানো
        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully!'
        ]);
    }
}
