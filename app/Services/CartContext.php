<?php

/* -------------------
   Cart context helper. Request-memoized lookup of the product ids
   currently in the visitor's cart, used by the shared product card to
   show "View Cart" instead of "Add To Cart".
------------------- */

namespace App\Services;

use App\Models\Frontend\Cart;
use Illuminate\Support\Facades\Auth;

class CartContext
{
    private static ?array $productIds = null;

    // ---------------
    // Product ids in the current cart (computed once per request)
    // ---------------
    public static function productIds(): array
    {
        if (static::$productIds !== null) {
            return static::$productIds;
        }

        try {
            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())->with('items:id,cart_id,product_id')->first();

                static::$productIds = $cart
                    ? $cart->items->pluck('product_id')->map(fn ($id) => (int) $id)->all()
                    : [];
            } else {
                static::$productIds = collect(session('cart', []))
                    ->pluck('product_id')
                    ->map(fn ($id) => (int) $id)
                    ->all();
            }
        } catch (\Throwable $e) {
            static::$productIds = [];
        }

        return static::$productIds;
    }

    // ---------------
    // Whether a product is already in the cart
    // ---------------
    public static function has(int $productId): bool
    {
        return in_array($productId, static::productIds(), true);
    }

    // ---------------
    // Total quantity of items in the current cart, used to seed the
    // header and bottom-nav badges on first paint.
    // ---------------
    public static function count(): int
    {
        try {
            if (Auth::check()) {
                $cart = Cart::where('user_id', Auth::id())->with('items:id,cart_id,quantity')->first();

                return $cart ? (int) $cart->items->sum('quantity') : 0;
            }

            return (int) collect(session('cart', []))->sum('quantity');
        } catch (\Throwable $e) {
            return 0;
        }
    }
}
