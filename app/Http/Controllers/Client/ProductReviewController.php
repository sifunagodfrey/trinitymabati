<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client\ProductReview;
use App\Models\Frontend\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:su_products,id',
            'order_id'   => 'required|integer|exists:su_orders,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:500',
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;
        $orderId = $request->order_id;

        // Verify that the order belongs to the user and is completed
        $order = Order::where('id', $orderId)
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->first();

        if (!$order) {
            return back()->with('error', 'You can only review products from completed orders.');
        }

        // Verify that the product was actually part of this order
        $itemExists = DB::table('su_order_items')
            ->where('order_id', $orderId)
            ->where('product_id', $productId)
            ->exists();

        if (!$itemExists) {
            return back()->with('error', 'This product was not found in the selected order.');
        }

        // Check if user already reviewed this product (optional: allow update? We'll forbid duplicate)
        $existing = ProductReview::where('product_id', $productId)
            ->where('user_id', $userId)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        // Create review (status pending by default)
        ProductReview::create([
            'product_id' => $productId,
            'user_id'    => $userId,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'status'     => 'pending', // admin will approve
        ]);

        return back()->with('success', 'Thank you for your review! It will appear after moderation.');
    }
}