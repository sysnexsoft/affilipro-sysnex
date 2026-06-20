<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductReview;
use App\Models\Product; // প্রোডাক্ট লিস্ট তুলে আনার জন্য
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function index()
    {
        // প্রোডাক্ট এবং রিভিউ একসাথে অল ডাটা লোড
        $reviews = ProductReview::with('product')->latest()->paginate(20);
        $products = Product::where('status', 1)->get();

        return view('backEnd.product-review.index', compact('reviews', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'rating'     => 'required|integer|min:1|max:5',
            'review'     => 'required|string',
        ]);

        ProductReview::create([
            'product_id' => $request->product_id,
            'name'       => $request->name,
            'email'      => $request->email,
            'rating'     => $request->rating,
            'review'     => $request->review,
            'approved'   => $request->has('approved') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Review added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'rating'     => 'required|integer|min:1|max:5',
            'review'     => 'required|string',
        ]);

        $productReview = ProductReview::findOrFail($id);
        $productReview->update([
            'product_id' => $request->product_id,
            'name'       => $request->name,
            'email'      => $request->email,
            'rating'     => $request->rating,
            'review'     => $request->review,
            'approved'   => $request->has('approved') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Review updated successfully!');
    }

    public function destroy($id)
    {
        $productReview = ProductReview::findOrFail($id);
        $productReview->delete();

        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
}
