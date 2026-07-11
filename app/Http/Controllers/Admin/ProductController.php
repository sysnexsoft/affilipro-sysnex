<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\SearchIndexerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected $indexerService;

    public function __construct(SearchIndexerService $indexerService)
    {
        $this->indexerService = $indexerService;
    }

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
            'title' => 'required|string|max:255',
            'slug' => 'required|string',
            'affiliate_url' => 'required|url'
        ]);

        return DB::transaction(function () use ($request) {
            $product = new Product();
            $product->fill($request->only([
                'title', 'sku', 'brand_id', 'short_description', 'description', 'pros', 'cons',
                'regular_price', 'sale_price', 'coupon', 'affiliate_url', 'affiliate_network', 'commission_rate',
                'meta_title', 'meta_description', 'meta_keywords', 'canonical_url'
            ]));

            $slug = Str::slug($request->slug ?? $request->title);
            $originalSlug = $slug;
            $count = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $product->slug = $slug;
            $product->category_ids = $request->category_ids;

            foreach (['allow_compare', 'featured', 'trending', 'best_seller', 'editors_choice'] as $field) {
                $product->$field = $request->has($field);
            }

            if($request->hasFile('featured_image')) {
                $product->featured_image = ImageHelper::upload($request->file('featured_image'), 'uploads/products/thumbnails',800,800);
            }

            $product->save();

            // ⚡ [SEARCH INDEX] কিওয়ার্ড তৈরি ও ডাটাবেজে আপডেট
            $keywords = $this->indexerService->generateKeywords(
                [$product->title, $product->short_description ?? ''],
                'product gadget shop'
            );
            $this->indexerService->updateProductKeywords($product->id, $keywords);
            if ($request->hasFile('gallery_images')) {
                $gallery = collect($request->file('gallery_images'))->map(fn($img, $i) => [
                    'image' => ImageHelper::upload($img, 'uploads/products/gallery',800,800),
                    'position' => $i
                ])->toArray();
                $product->images()->createMany($gallery);
            }

            if ($request->has('specs')) {
                $specs = collect($request->specs)->filter(fn($s) => !empty($s['name']) && !empty($s['value']))
                    ->map(fn($s) => ['spec_name' => $s['name'], 'spec_value' => $s['value']])->toArray();
                $product->specifications()->createMany($specs);
            }

            if ($request->has('faqs')) {
                $faqs = collect($request->faqs)->filter(fn($f) => !empty($f['question']) && !empty($f['answer']))->toArray();
                $product->faqs()->createMany($faqs);
            }

            $product->load('brand');
            \App\Helpers\SeoHelper::generateAutoSeo($product, $request, 'Product');

            return redirect()->route('admin.product.index')->with('success', 'Product created successfully!');
        });
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
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:products,slug,' . $id,
            'affiliate_url' => 'required|url',
        ]);

        return DB::transaction(function () use ($request, $id) {
            $product = Product::findOrFail($id);
            $product->fill($request->only([
                'title', 'sku', 'brand_id', 'short_description', 'description', 'pros', 'cons',
                'regular_price', 'sale_price', 'coupon', 'affiliate_url', 'affiliate_network', 'commission_rate',
                'meta_title', 'meta_description', 'meta_keywords', 'canonical_url'
            ]));

            $slug = Str::slug($request->slug ?? $request->title);
            $originalSlug = $slug;
            $count = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $product->slug = $slug;
            $product->category_ids = $request->category_ids;

            foreach (['allow_compare', 'featured', 'trending', 'best_seller', 'editors_choice', 'status'] as $field) {
                $product->$field = $request->has($field);
            }

            if($request->hasFile('featured_image')){
                $product->featured_image = ImageHelper::upload($request->file('featured_image'), 'uploads/products/thumbnails', 800, 800, $product->featured_image);
            }
            $product->save();

            // ⚡ [SEARCH INDEX UPDATE]
            $keywords = $this->indexerService->generateKeywords(
                [$product->title, $product->short_description ?? ''],
                'product gadget shop'
            );
            $this->indexerService->updateProductKeywords($product->id, $keywords);

            if ($request->hasFile('gallery_images')) {
                $currentImagesCount = $product->images()->count();
                $gallery = collect($request->file('gallery_images'))->map(fn($img, $i) => [
                    'product_id' => $product->id,
                    'image' => ImageHelper::upload($img, 'uploads/products/gallery',800,800),
                    'position' => $currentImagesCount + $i,
                    'created_at' => now(),
                    'updated_at' => now()
                ])->toArray();
                $product->images()->insert($gallery);
            }

            $product->specifications()->delete();
            if ($request->has('specs')) {
                $specs = collect($request->specs)->filter(fn($s) => !empty($s['name']) && !empty($s['value']))
                    ->map(fn($s) => ['spec_name' => $s['name'], 'spec_value' => $s['value']])->toArray();
                $product->specifications()->createMany($specs);
            }

            $product->faqs()->delete();
            if ($request->has('faqs')) {
                $faqs = collect($request->faqs)->filter(fn($f) => !empty($f['question']) && !empty($f['answer']))->toArray();
                $product->faqs()->createMany($faqs);
            }

            $product->load('brand');
            \App\Helpers\SeoHelper::generateAutoSeo($product, $request, 'Product');

            return redirect()->route('admin.product.index')->with('success', 'Product updated successfully!');
        });
    }

    public function destroy(Request $request)
    {
        $product = Product::with(['images', 'seo'])->findOrFail($request->id);
        return DB::transaction(function () use ($product) {
            if ($product->featured_image && file_exists(public_path($product->featured_image))) {
                @unlink(public_path($product->featured_image));
            }
            $product->images->each(function ($galleryImg) {
                if ($galleryImg->image && file_exists(public_path($galleryImg->image))) {
                    @unlink(public_path($galleryImg->image));
                }
            });
            if ($product->seo) {
                $product->seo()->delete();
            }
            $product->images()->delete();
            $product->specifications()->delete();
            $product->faqs()->delete();
            $product->delete();
            return redirect()->route('admin.product.index')->with('success', 'Product, SEO Data, and all assets deleted successfully!');
        });
    }

    public function deleteGalleryImage($id)
    {
        $image = ProductImage::findOrFail($id);
        if ($image->image && file_exists(public_path($image->image))) {
            @unlink(public_path($image->image));
        }
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully!'
        ]);
    }
}
