<?php

/* -------------------
   Folds a guest session cart into the authenticated user's database
   cart. Call this right after Auth::login() (both the regular login
   and 2FA paths) and right after a new account is created, so items
   added before signing in or registering are not lost.
------------------- */

namespace App\Services;

use App\Models\Frontend\Cart;
use App\Models\Frontend\CartItem;
use App\Models\Manage\Products\Product;

class CartMergeService
{
    // ---------------
    // Merge the guest session cart into $userId's database cart, then
    // clear the session cart. Safe to call even if there is nothing
    // to merge.
    // ---------------
    public static function merge(int $userId): void
    {
        $sessionCart = session('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        foreach ($sessionCart as $item) {
            $productId = $item['product_id'] ?? null;
            $variantId = $item['variant_id'] ?? null;
            $quantity  = max(1, (int) ($item['quantity'] ?? 1));

            if (! $productId) {
                continue;
            }

            $existing = CartItem::where([
                'cart_id'    => $cart->id,
                'product_id' => $productId,
                'variant_id' => $variantId,
            ])->first();

            if ($existing) {
                $existing->increment('quantity', $quantity);
                continue;
            }

            $product = Product::find($productId);

            if (! $product) {
                continue;
            }

            CartItem::create([
                'cart_id'       => $cart->id,
                'product_id'    => $productId,
                'variant_id'    => $variantId,
                'quantity'      => $quantity,
                'price_at_time' => $item['price_at_time'] ?? ($product->sale_price ?? $product->price),
                'weight'        => $product->weight ?? 0,
                'length'        => $product->length ?? 0,
                'width'         => $product->width ?? 0,
                'height'        => $product->height ?? 0,
            ]);
        }

        session()->forget('cart');
    }
}
