<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Cart;
use App\Models\Frontend\CartItem;
use App\Models\Manage\Ecommerce\AbandonedCart;
use App\Models\Manage\Ecommerce\AbandonedCartLog;
use App\Models\Manage\Products\Product;
use App\Models\Manage\Products\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    // ---------------
    // Total item quantity across the cart (auth or guest)
    // ---------------
    private function currentCount(): int
    {
        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->with('items')->first();
            return $cart ? (int) $cart->items->sum('quantity') : 0;
        }
        return (int) collect(session('cart', []))->sum('quantity');
    }

    // ---------------
    // Cart count - AJAX endpoint used by the topbar badge
    // ---------------
    public function count()
    {
        return response()->json(['count' => $this->currentCount()]);
    }

    // ---------------
    // Normalise cart items
    // Auth users  → CartItem Eloquent models with eager-loaded product/variant
    // Guest users → plain objects built from the session array
    // ---------------
    private function resolveItems(): Collection
    {
        if (auth()->check()) {
            $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
            return $cart->items()
                ->with(['product', 'variant'])
                ->get();
        }

        return collect(session('cart', []))->values()->map(function ($data, $index) {
            $product = Product::find($data['product_id']);
            if (! $product) {
                return null;
            }
            $variant = ! empty($data['variant_id']) ? ProductVariant::find($data['variant_id']) : null;

            return (object) [
                'id'            => $index,
                'product_id'    => $data['product_id'],
                'variant_id'    => $data['variant_id'] ?? null,
                'quantity'      => $data['quantity'],
                'price_at_time' => $data['price_at_time'],
                'product'       => $product,
                'variant'       => $variant,
            ];
        })->filter()->values();
    }

    // ---------------
    // Cart index
    // ---------------
    public function index()
    {
        $items    = $this->resolveItems();
        $subtotal = $items->sum(fn($item) => $item->price_at_time * $item->quantity);

        return view('frontend.cart.index', compact(
            'items', 'subtotal'
        ));
    }

    // ---------------
    // Add item to cart
    // ---------------
    public function add(Request $request)
    {
        $request->validate([
            'product_id'  => 'required|integer|exists:su_products,id',
            'variant_id'  => 'nullable|integer|exists:su_product_variants,id',
            'quantity'    => 'required|integer|min:1',
        ]);

        $productId = (int) $request->input('product_id');
        $variantId = $request->input('variant_id') ? (int) $request->input('variant_id') : null;
        $quantity  = (int) $request->input('quantity', 1);
        $product   = Product::findOrFail($productId);

        $price = $product->sale_price ?? $product->price;
        if ($variantId) {
            $variant = ProductVariant::findOrFail($variantId);
            $price   = $variant->sale_price ?? $variant->price;
        }

        if (auth()->check()) {
            $cart     = Cart::firstOrCreate(['user_id' => auth()->id()]);
            $existing = CartItem::where([
                'cart_id'    => $cart->id,
                'product_id' => $productId,
                'variant_id' => $variantId,
            ])->first();

            if ($existing) {
                // set_quantity=true sets the absolute quantity (used by the
                // product page stepper); otherwise add to what is there.
                if ($request->boolean('set_quantity')) {
                    $existing->update(['quantity' => max(1, $quantity)]);
                } else {
                    $existing->increment('quantity', $quantity);
                }
            } else {
                CartItem::create([
                    'cart_id'       => $cart->id,
                    'product_id'    => $productId,
                    'variant_id'    => $variantId,
                    'quantity'      => $quantity,
                    'price_at_time' => $price,
                    'weight'        => $product->weight ?? 0,
                    'length'        => $product->length ?? 0,
                    'width'         => $product->width ?? 0,
                    'height'        => $product->height ?? 0,
                ]);
            }
        } else {
            $sessionCart = session('cart', []);
            $found       = false;

            foreach ($sessionCart as &$item) {
                if ($item['product_id'] === $productId && ($item['variant_id'] ?? null) === $variantId) {
                    $item['quantity'] = $request->boolean('set_quantity')
                        ? max(1, $quantity)
                        : $item['quantity'] + $quantity;
                    $found = true;
                    break;
                }
            }
            unset($item);

            if (! $found) {
                $sessionCart[] = [
                    'product_id'    => $productId,
                    'variant_id'    => $variantId,
                    'quantity'      => $quantity,
                    'price_at_time' => (float) $price,
                ];
            }

            session(['cart' => $sessionCart]);
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'count' => $this->currentCount()]);
        }

        return redirect()->back()->with('success', 'Item added to cart!');
    }

    // ---------------
    // Remove item from cart
    // ---------------
    public function remove(Request $request)
    {
        $request->validate(['item_id' => 'required']);

        $itemId = $request->input('item_id');

        if (auth()->check()) {
            CartItem::where('id', (int) $itemId)
                ->whereHas('cart', fn($q) => $q->where('user_id', auth()->id()))
                ->delete();
        } else {
            $sessionCart = session('cart', []);
            unset($sessionCart[(int) $itemId]);
            session(['cart' => array_values($sessionCart)]);
        }

        return redirect()->route('frontend.cart')->with('success', 'Item removed from cart.');
    }

    // ---------------
    // Beacon endpoint - record an abandoned cart when the user leaves the cart page.
    // Called via navigator.sendBeacon() on beforeunload / visibilitychange.
    // Only records for authenticated users; idempotent (updates timestamp on repeat).
    // ---------------
    public function abandon(Request $request): \Illuminate\Http\JsonResponse
    {
        if (! auth()->check()) {
            return response()->json(['ok' => false]);
        }

        $cart = Cart::where('user_id', auth()->id())
            ->with(['items.product'])
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            return response()->json(['ok' => false]);
        }

        try {
            // ---------------
            // Idempotent - update timestamp if a record already exists so the admin
            // always sees the most recent cart-page visit without duplicate rows
            // ---------------
            $existing = AbandonedCart::where('user_id', auth()->id())->first();

            if ($existing) {
                $existing->update(['last_updated' => now()]);
                return response()->json(['ok' => true]);
            }

            $items    = $cart->items;
            $subtotal = $items->sum(fn($item) => $item->price_at_time * $item->quantity);

            $itemsPayload = $items->map(fn($item) => [
                'product_id'   => $item->product_id,
                'product_name' => $item->product?->name ?? 'Unknown Product',
                'quantity'     => (int) $item->quantity,
                'price'        => (float) $item->price_at_time,
                'subtotal'     => round((float) $item->price_at_time * (int) $item->quantity, 2),
            ])->toArray();

            AbandonedCart::create([
                'user_id'       => auth()->id(),
                'cart_data'     => [
                    'total'       => round($subtotal, 2),
                    'total_items' => (int) $items->sum('quantity'),
                    'items'       => $itemsPayload,
                ],
                'last_updated'  => now(),
                'recovered'     => false,
                'reminder_sent' => false,
            ]);

            // ---------------
            // One log entry per product line for admin product-level tracking
            // ---------------
            foreach ($items as $item) {
                AbandonedCartLog::create([
                    'user_id'    => auth()->id(),
                    'product_id' => $item->product_id,
                    'sent_at'    => now(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to record abandoned cart from beacon', [
                'user_id' => auth()->id(),
                'error'   => $e->getMessage(),
            ]);
        }

        return response()->json(['ok' => true]);
    }

    // ---------------
    // Update cart quantities
    // ---------------
    public function update(Request $request)
    {
        $request->validate(['quantities' => 'required|array']);

        $quantities = $request->input('quantities');

        if (auth()->check()) {
            $cart = Cart::where('user_id', auth()->id())->first();
            if ($cart) {
                $cartItems = CartItem::where('cart_id', $cart->id)
                    ->whereIn('id', array_map('intval', array_keys($quantities)))
                    ->get()
                    ->keyBy('id');

                foreach ($quantities as $itemId => $qty) {
                    $qty  = (int) $qty;
                    $item = $cartItems->get((int) $itemId);
                    if (! $item) continue;

                    $qty > 0 ? $item->update(['quantity' => $qty]) : $item->delete();
                }
            }
        } else {
            $sessionCart = session('cart', []);
            foreach ($quantities as $index => $qty) {
                $qty = (int) $qty;
                if (array_key_exists((int) $index, $sessionCart) && $qty > 0) {
                    $sessionCart[(int) $index]['quantity'] = $qty;
                }
            }
            session(['cart' => $sessionCart]);
        }

        return redirect()->route('frontend.cart')->with('success', 'Cart updated.');
    }
}
