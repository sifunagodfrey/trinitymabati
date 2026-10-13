<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // ---------------
    // Wishlist Index
    // ---------------
    public function index()
    {
        $items = Wishlist::with(['product' => fn ($q) => $q->with('brand', 'label', 'variants')])
            ->where('user_id', Auth::id())
            ->latest('created_at')
            ->get();

        return view('client.wishlist.index', compact('items'));
    }

    // ---------------
    // Toggle (Add / Remove) - JSON endpoint
    // ---------------
    public function toggle(int $productId)
    {
        $userId   = Auth::id();
        $existing = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existing) {
            $existing->delete();
            return response()->json(['status' => 'removed']);
        }

        Wishlist::create([
            'user_id'    => $userId,
            'product_id' => $productId,
        ]);

        return response()->json(['status' => 'added']);
    }

    // ---------------
    // Remove (form POST from wishlist page)
    // ---------------
    public function remove(int $productId)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        return redirect()->route('client.wishlist.index')
            ->with('success', 'Item removed from your wishlist.');
    }
}
