<?php

namespace App\Http\Controllers;

use App\Models\ComparisonField;
use App\Models\Product;
use Illuminate\Http\Request;

class ComparisonController extends Controller
{
    // মূল পেজ ভিউ করা (প্রথমবার পেজ লোডের জন্য)
    public function index()
    {
        $productIds = session()->get('compare_products', []);

        $products = Product::whereIn('id', $productIds)
            ->where('allow_compare', true)
            ->with(['comparisonFields', 'brand'])
            ->get();

        $comparisonFields = ComparisonField::whereHas('products', function($query) use ($productIds) {
            $query->whereIn('product_id', $productIds);
        })->get();

        return view('frontEnd.compare.index', compact('products', 'comparisonFields'));
    }

    // টেবিলের HTML এবং কাউন্ট জেনারেট করার জন্য একটি প্রাইভেট হেল্পার মেথড
    private function getCompareData()
    {
        $productIds = session()->get('compare_products', []);

        $products = Product::whereIn('id', $productIds)
            ->where('allow_compare', true)
            ->with(['comparisonFields', 'brand'])
            ->get();

        $comparisonFields = ComparisonField::whereHas('products', function($query) use ($productIds) {
            $query->whereIn('product_id', $productIds);
        })->get();

        // ভিউ ফাইলকে স্ট্রিং/HTML এ রূপান্তর করা
        $html = view('frontEnd.compare.compare_table', compact('products', 'comparisonFields'))->render();

        return [
            'html' => $html,
            'count' => count($productIds)
        ];
    }

    // সেশনে প্রোডাক্ট যোগ করা (AJAX)
    public function add($id)
    {
        $compareList = session()->get('compare_products', []);

        if (in_array($id, $compareList)) {
            return response()->json(['status' => 'info', 'message' => 'This product is already in the compare list.']);
        }

        if (count($compareList) >= 4) {
            return response()->json(['status' => 'error', 'message' => 'You can compare a maximum of 4 products.']);
        }

        $compareList[] = (int)$id;
        session()->put('compare_products', $compareList);

        return response()->json(array_merge(['status' => 'success', 'message' => 'Product added to compare list!'], $this->getCompareData()));
    }

    // সেশন থেকে প্রোডাক্ট রিমুভ করা (AJAX)
    public function remove($id)
    {
        $compareList = session()->get('compare_products', []);

        if (($key = array_search($id, $compareList)) !== false) {
            unset($compareList[$key]);
        }

        session()->put('compare_products', array_values($compareList));

        return response()->json(array_merge(['status' => 'success', 'message' => 'Product removed.'], $this->getCompareData()));
    }

    // পুরো লিস্ট খালি করা (AJAX)
    public function clear()
    {
        session()->forget('compare_products');
        return response()->json(array_merge(['status' => 'success', 'message' => 'Compare list cleared.'], $this->getCompareData()));
    }
}
