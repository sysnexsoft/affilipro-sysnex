<?php

namespace App\Http\Controllers;

use App\Models\ComparisonField;
use App\Models\Product;
use Illuminate\Http\Request;

class ComparisonController extends Controller
{
    public function index()
    {
        $productIds = session()->get('compare_products', []);
        if (empty($productIds)) {
            return view('frontEnd.compare.index', [
                'products' => collect(),
                'comparisonFields' => collect()
            ]);
        }

        $products = Product::whereIn('id', $productIds)
            ->where('allow_compare', 1)
            ->with(['specifications', 'brand'])
            ->get();

        $firstProduct = $products->first();
        $comparisonFields = collect();

        if ($firstProduct) {
            $categoryIds = $firstProduct->category_ids;
            if (!is_array($categoryIds)) {
                $categoryIds = [$categoryIds];
            }
            $comparisonFields = ComparisonField::whereHas('categories', function($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })->get();
        }
        return view('frontEnd.compare.index', compact('products', 'comparisonFields'));
    }

    // টেবিলের HTML এবং কাউন্ট জেনারেট করার জন্য ফিক্সড হেল্পার মেথড
    private function getCompareData()
    {
        $productIds = session()->get('compare_products', []);

        if (empty($productIds)) {
            $html = view('frontEnd.compare.compare_table', [
                'products' => collect(),
                'comparisonFields' => collect()
            ])->render();

            return [
                'html' => $html,
                'count' => 0
            ];
        }

        // index() মেথডের সাথে মিল রেখে specifications লোড করা হলো
        $products = Product::whereIn('id', $productIds)
            ->where('allow_compare', 1)
            ->with(['specifications', 'brand'])
            ->get();

        $firstProduct = $products->first();
        $comparisonFields = collect();

        // index() মেথডের হুবহু লজিক এখানেও ব্যবহার করা হয়েছে যেন AJAX রেসপন্সে ফিচার লিস্ট না হারায়
        if ($firstProduct) {
            $categoryIds = $firstProduct->category_ids;
            if (!is_array($categoryIds)) {
                $categoryIds = [$categoryIds];
            }
            $comparisonFields = ComparisonField::whereHas('categories', function($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })->get();
        }

        // ভিউ ফাইলকে HTML এ রূপান্তর করা
        $html = view('frontEnd.compare.compare_table', compact('products', 'comparisonFields'))->render();

        return [
            'html' => $html,
            'count' => $products->count() // সেশনের বদলে ফিল্টার হওয়া একচুয়াল প্রোডাক্ট কাউন্ট
        ];
    }

    // সেশনে প্রোডাক্ট যোগ করা (AJAX) - ৩টি প্রোডাক্টের কন্ডিশন ফিক্সড
    public function add($id)
    {
        $compareList = session()->get('compare_products', []);

        if (in_array($id, $compareList)) {
            return response()->json(['status' => 'info', 'message' => 'This product is already in the compare list.']);
        }

        // আপনি যেহেতু মোবাইলে ৩টি প্রোডাক্ট পাশাপাশি দেখাচ্ছেন, তাই সর্বোচ্চ লিমিট ৩ রাখা হলো
        if (count($compareList) >= 3) {
            return response()->json(['status' => 'error', 'message' => 'You can compare a maximum of 3 products.']);
        }

        $compareList[] = (int)$id;
        session()->put('compare_products', $compareList);

        return response()->json(array_merge([
            'status' => 'success',
            'message' => 'Product added to compare list!'
        ], $this->getCompareData()));
    }

// সেশন থেকে প্রোডাক্ট রিমুভ করা (AJAX)
    public function remove($id)
    {
        $compareList = session()->get('compare_products', []);

        if (($key = array_search($id, $compareList)) !== false) {
            unset($compareList[$key]);
        }

        session()->put('compare_products', array_values($compareList));

        return response()->json(array_merge([
            'status' => 'success',
            'message' => 'Product removed.'
        ], $this->getCompareData()));
    }

// সম্পূর্ণ লিস্ট ক্লিয়ার করার মেথড (যদি অলরেডি না থেকে থাকে)
    public function clear()
    {
        session()->forget('compare_products');

        return response()->json(array_merge([
            'status' => 'success',
            'message' => 'Comparison list cleared.'
        ], $this->getCompareData()));
    }
}
