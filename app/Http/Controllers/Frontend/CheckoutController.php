<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Cart;
use App\Models\Frontend\Order;
use App\Models\Frontend\OrderItem;
use App\Models\Manage\Ecommerce\AbandonedCart;
use App\Models\Manage\Ecommerce\AbandonedCartLog;
use App\Models\Manage\Shipping\LocationPricing;
use App\Models\Manage\Shipping\ShippingSetting;
use App\Models\Manage\Payments\PaymentMethod;
use App\Models\Payment\PaymentTransaction;
use App\Services\LoyaltyService;
use App\Services\OrderEmailService;
use App\Services\Payment\MpesaService;
use App\Services\Payment\PaystackService;
use App\Services\Payment\PesapalService;
use App\Models\Payment\PendingPesapal;
use App\Services\WalletEmailService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    // ---------------
    // Generate incrementing order code - NAW + 8-digit sequence starting at 111000.
    // ---------------
    private function generateOrderCode(): string
    {
        $last   = DB::table('su_orders')
            ->where('order_code', 'like', 'NAW%')
            ->orderByDesc('id')
            ->value('order_code');
        $suffix = $last ? substr($last, 3) : null;
        $next   = ($suffix && ctype_digit($suffix)) ? ((int) $suffix + 1) : 111000;

        return 'NAW' . str_pad($next, 8, '0', STR_PAD_LEFT);
    }

    // ---------------
    // Shipping cost calculation
    // ---------------
    private function calcShipping(Collection $items, ?LocationPricing $location, float $subtotal): float
    {
        $s = ShippingSetting::first();

        $totalWeight = $items->sum(
            fn($item) => ((float) ($item->product?->weight ?? 0)) * $item->quantity
        );
        $totalVolume = $items->sum(
            fn($item) => ((float) ($item->product?->length ?? 0))
                * ((float) ($item->product?->width  ?? 0))
                * ((float) ($item->product?->height ?? 0))
                * $item->quantity
        );

        $baseRate      = (float) ($s?->base_rate               ?? 130);
        $threshold     = (float) ($s?->weight_threshold        ?? 0);
        $weightRate    = (float) ($s?->weight_rate             ?? 0);
        $volumeDiv     = (float) ($s?->volume_divisor          ?? 5000);
        $volumeMult    = (float) ($s?->volume_multiplier       ?? 0);
        $distRate      = (float) ($s?->distance_rate           ?? 0);
        $freeThold     = (float) ($s?->free_shipping_threshold ?? 0);
        $distKm        = (float) ($location?->distance         ?? 0);

        $weightCharge   = $totalWeight > $threshold ? ($totalWeight - $threshold) * $weightRate : 0;
        $volumeCharge   = $volumeDiv > 0 ? ($totalVolume / $volumeDiv) * $volumeMult : 0;
        $distCharge     = $distKm > 10  ? ($distKm - 10) * $distRate : 0;

        $shipping = $baseRate + $weightCharge + $volumeCharge + $distCharge;

        if ($freeThold > 0 && $subtotal >= $freeThold) {
            $shipping = 0;
        }

        return round($shipping, 2);
    }

    // ---------------
    // Show checkout form
    // ---------------
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->with([
                'items.product',
                'items.variant.variantAttributes.attributeValue',
            ])
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('frontend.cart')->with('error', 'Your cart is empty.');
        }

        $items    = $cart->items;
        $subtotal = $items->sum(fn($item) => $item->price_at_time * $item->quantity);
        $counties = DB::table('su_counties')
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('su_towns')
                ->join('su_location_pricing', 'su_location_pricing.town_id', '=', 'su_towns.id')
                ->whereColumn('su_towns.county_id', 'su_counties.id');
        })
        ->orderBy('name')
        ->get();

        // ---------------
        // Prefill from the user's saved delivery address (su_user_profiles),
        // if they've set one. The profile stores a town_id; checkout needs the
        // matching su_location_pricing.id, so resolve it via the town.
        // ---------------
        $savedAddress = DB::table('su_user_profiles')
            ->where('user_id', auth()->id())
            ->first(['county_id', 'town_id']);

        $prefillCountyId   = $savedAddress?->county_id;
        $prefillLocationId = $savedAddress?->town_id
            ? DB::table('su_location_pricing')->where('town_id', $savedAddress->town_id)->value('id')
            : null;

        $s = ShippingSetting::first();
        $shippingSettings = [
            'base_rate'               => (float) ($s?->base_rate               ?? 130),
            'weight_threshold'        => (float) ($s?->weight_threshold        ?? 0),
            'weight_rate'             => (float) ($s?->weight_rate             ?? 0),
            'volume_divisor'          => (float) ($s?->volume_divisor          ?? 5000),
            'volume_multiplier'       => (float) ($s?->volume_multiplier       ?? 0),
            'distance_rate'           => (float) ($s?->distance_rate           ?? 0),
            'free_shipping_threshold' => (float) ($s?->free_shipping_threshold ?? 0),
        ];

        $cartDimensions = $items->map(fn($item) => [
            'weight' => ((float) ($item->product?->weight ?? 0)) * $item->quantity,
            'volume' => ((float) ($item->product?->length ?? 0))
                * ((float) ($item->product?->width  ?? 0))
                * ((float) ($item->product?->height ?? 0))
                * $item->quantity,
        ])->values();

        $paymentMethods = PaymentMethod::active()->orderBy('id')->get();

        return view('frontend.checkout.index', compact(
            'items', 'subtotal', 'counties', 'shippingSettings', 'cartDimensions',
            'paymentMethods', 'prefillCountyId', 'prefillLocationId'
        ));
    }

    // ---------------
    // AJAX - fetch delivery locations
    // su_location_pricing has no county_id/location_name/distance columns of
    // its own - it's keyed by town_id, and the town belongs to a county - so
    // this joins through su_towns and aliases the columns back to what the
    // checkout JS expects.
    // ---------------
    public function locations(Request $request)
    {
        $request->validate(['county_id' => 'required|integer|exists:su_counties,id']);

        $locations = LocationPricing::query()
            ->join('su_towns', 'su_towns.id', '=', 'su_location_pricing.town_id')
            ->where('su_towns.county_id', $request->query('county_id'))
            ->orderBy('su_towns.name')
            ->get([
                'su_location_pricing.id',
                'su_towns.name as location_name',
                'su_location_pricing.price',
                'su_location_pricing.distance_km as distance',
                'su_location_pricing.estimated_delivery_days as estimated_delivery',
            ]);

        return response()->json($locations);
    }

    // ---------------
    // Validate shipping details and store in session
    // ---------------
    public function store(Request $request)
    {
        $request->validate([
            'county_id'   => 'required|integer|exists:su_counties,id',
            'location_id' => 'required|integer|exists:su_location_pricing,id',
            'notes'       => 'nullable|string|max:500',
        ]);

        $cart = Cart::where('user_id', auth()->id())
            ->with(['items.product'])
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('frontend.cart')->with('error', 'Your cart is empty.');
        }

        $location     = LocationPricing::find($request->location_id);
        $items        = $cart->items;
        $subtotal     = $items->sum(fn($item) => $item->price_at_time * $item->quantity);
        $shippingCost = $this->calcShipping($items, $location, $subtotal);

        session(['checkout' => [
            'county_id'    => (int) $request->county_id,
            'location_id'  => (int) $request->location_id,
            'notes'        => $request->notes,
            'subtotal'     => $subtotal,
            'shipping'     => $shippingCost,
            'total'        => $subtotal + $shippingCost,
        ]]);

        return redirect()->route('frontend.checkout.payment');
    }

    // ---------------
    // Payment page - includes virtual wallet method
    // ---------------
    public function payment(Request $request)
    {
        $orderCode = $request->query('order');

        if ($orderCode) {
            $order = Order::where('order_code', $orderCode)
                ->where('user_id', auth()->id())
                ->with(['items.product', 'items.variant'])
                ->firstOrFail();

            return view('frontend.checkout.payment', [
                'mode'  => 'confirmation',
                'order' => $order,
            ]);
        }

        $checkout = session('checkout');
        if (! $checkout) {
            return redirect()->route('frontend.checkout')
                ->with('error', 'Your session expired. Please fill in your shipping details again.');
        }

        $cart = Cart::where('user_id', auth()->id())
            ->with([
                'items.product',
                'items.variant.variantAttributes.attributeValue',
            ])
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('frontend.cart')->with('error', 'Your cart is empty.');
        }

        // ---------------
        // Only configured, active payment methods are offered.
        // ---------------
        $paymentMethods = PaymentMethod::active()->orderBy('id')->get();

        return view('frontend.checkout.payment', [
            'mode'           => 'payment',
            'items'          => $cart->items,
            'subtotal'       => $checkout['subtotal'],
            'shipping'       => $checkout['shipping'],
            'total'          => $checkout['total'],
            'paymentMethods' => $paymentMethods,
        ]);
    }

    // ---------------
    // Process payment - includes virtual wallet
    // ---------------
    public function processPayment(Request $request)
    {
        $paymentMethodId = $request->input('payment_method_id');

        $request->validate([
            'payment_method_id' => 'required|integer|exists:su_payment_methods,id',
            'phone'             => 'nullable|string|max:15',
        ]);

        $checkout = session('checkout');
        if (! $checkout) {
            return redirect()->route('frontend.checkout')
                ->with('error', 'Your session expired. Please restart checkout.');
        }

        $cart = Cart::where('user_id', auth()->id())
            ->with([
                'items.product',
                'items.variant.variantAttributes.attributeValue',
            ])
            ->first();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()->route('frontend.cart')->with('error', 'Your cart is empty.');
        }

        $paymentMethod = PaymentMethod::findOrFail($paymentMethodId);

        if ($paymentMethod->slug === 'mpesa') {
            $request->validate(['phone' => 'required|string|max:15']);
        }

        $location      = LocationPricing::find($checkout['location_id']);
        $items         = $cart->items;
        $subtotal      = $items->sum(fn($item) => $item->price_at_time * $item->quantity);
        $shippingCost  = $this->calcShipping($items, $location, $subtotal);

        $grossTotal = $subtotal + $shippingCost;

        $loyaltyDiscount = 0.0;
        $orderTotal      = $grossTotal;
        $orderCode       = $this->generateOrderCode();

        $order = Order::create([
            'user_id'              => auth()->id(),
            'order_code'           => $orderCode,
            'status'               => 'pending',
            'payment_status'       => 'pending',
            'shipping_status'      => 'pending',
            'total'                => $orderTotal,
            'shipping_cost'        => $shippingCost,
            'discount'             => $loyaltyDiscount,
            'shipping_county_id'   => $checkout['county_id'],
            'shipping_town_id' => $location?->town_id,
            'notes'                => $checkout['notes'],
            'currency'             => 'KES',
            'stock_deducted'       => 0,
            'customer_confirmed'   => false,
            'admin_confirmed'      => false,
            'phone'                => $request->phone ?? auth()->user()->phone,
        ]);

        \App\Models\Manage\Ecommerce\OrderStatusHistory::record(
            $order->id, 'status:pending', 'Order placed', auth()->id()
        );

        foreach ($items as $cartItem) {
            $variantLabel = null;
            if ($cartItem->variant) {
                $parts = $cartItem->variant->variantAttributes
                    ->map(fn ($va) => optional($va->attributeValue)->value)
                    ->filter()
                    ->values();
                $variantLabel = $parts->isNotEmpty()
                    ? $parts->implode(' / ')
                    : ($cartItem->variant->variant_code ?: null);
            }

            OrderItem::create([
                'order_id'      => $order->id,
                'product_id'    => $cartItem->product_id,
                'variant_id'    => $cartItem->variant_id,
                'variant_label' => ($cartItem->sheet_length_m ? trim(($variantLabel ? $variantLabel . ' / ' : '') . number_format($cartItem->sheet_length_m, 2) . ' m') : $variantLabel),
                'product_name'  => $cartItem->product?->name ?? 'Unknown Product',
                'quantity'      => $cartItem->quantity,
                'price'         => $cartItem->price_at_time,
            ]);
        }

        $cart->items()->delete();
        session()->forget('checkout');

        AbandonedCart::where('user_id', auth()->id())->delete();
        AbandonedCartLog::where('user_id', auth()->id())->delete();

        // Order placement emails
        try {
            $orderEmailService = app(OrderEmailService::class);
            $order->loadMissing(['user', 'items']);
            $orderEmailService->sendNewOrderToClient($order);
        } catch (\Throwable $e) {
            Log::warning('Order placement email failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
        }

        // ---------------
        // Staff alert (never blocks checkout)
        // ---------------
        app(OrderEmailService::class)->sendNewOrderToStaff($order);
        // ---------------
        // Admin Messages notification
        // ---------------
        app(\App\Services\AdminNotificationService::class)->orderPlaced($order);
        // ---------------
        // Mpesa handling
        // ---------------
        if ($paymentMethod && $paymentMethod->slug === 'mpesa') {
            try {
                $mpesaService  = app(MpesaService::class);
                $mpesaResponse = $mpesaService->initiateStkPush(
                    $request->phone,
                    $orderTotal,
                    $orderCode,
                    $order->id
                );

                $checkoutRequestId = $mpesaResponse['CheckoutRequestID'] ?? null;

                PaymentTransaction::create([
                    'user_id'   => auth()->id(),
                    'order_id'  => $order->id,
                    'amount'    => $orderTotal,
                    'method_id' => $paymentMethod->id,
                    'status'    => 'pending',
                    'reference' => $checkoutRequestId,
                ]);

                $order->update(['mpesa_checkout_request_id' => $checkoutRequestId]);

                if ($request->wantsJson()) {
                    return response()->json([
                        'success'    => true,
                        'order_code' => $orderCode,
                        'cid'        => $checkoutRequestId,
                    ]);
                }

                return redirect()->route('frontend.checkout.mpesa.polling', [
                    'order' => $orderCode,
                    'cid'   => $checkoutRequestId,
                ]);
            } catch (\Exception $e) {
                Log::error('Mpesa STK push failed at checkout', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);

                if ($request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $e->getMessage(),
                    ], 500);
                }

                return redirect()->route('client.orders.index')
                    ->with('error', 'Your order was placed but M-Pesa could not be initiated: ' . $e->getMessage() . ' Please contact support or try again.');
            }
        }

// ---------------
        // Paystack handling - hosted checkout redirect
        // ---------------
        if ($paymentMethod && $paymentMethod->slug === 'paystack') {
            $email = trim((string) $request->input('payment_input')) ?: auth()->user()->email;

            try {
                $paystack  = app(PaystackService::class);
                $reference = 'PSK-' . $order->id . '-' . strtoupper(substr(uniqid(), -6));

                $init = $paystack->initializeTransaction(
                    $email,
                    (float) $orderTotal,
                    $reference,
                    route('frontend.checkout.paystack.callback'),
                    ['order_id' => $order->id, 'order_code' => $orderCode]
                );

                PaymentTransaction::create([
                    'user_id'   => auth()->id(),
                    'order_id'  => $order->id,
                    'amount'    => $orderTotal,
                    'method_id' => $paymentMethod->id,
                    'status'    => 'pending',
                    'reference' => $init['reference'],
                ]);

                $order->update(['paystack_reference' => $init['reference']]);

                return redirect()->away($init['authorization_url']);
            } catch (\Exception $e) {
                Log::error('Paystack initialization failed at checkout', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);

                return redirect()->route('client.orders.index')
                    ->with('error', 'Your order was placed but Paystack could not be initiated: ' . $e->getMessage() . ' Please contact support or try again.');
            }
        }

        // ---------------
        // Pesapal handling - hosted checkout redirect
        // ---------------
        if ($paymentMethod && $paymentMethod->slug === 'pesapal') {
            $email = trim((string) $request->input('payment_input')) ?: auth()->user()->email;

            try {
                $pesapal   = app(PesapalService::class);
                $reference = 'PSP-' . $order->id . '-' . strtoupper(substr(uniqid(), -6));

                $submission = $pesapal->submitOrder(
                    $reference,
                    (float) $orderTotal,
                    'Order ' . $orderCode,
                    route('frontend.checkout.pesapal.callback'),
                    $email,
                    $order->phone,
                    auth()->user()->first_name,
                    auth()->user()->last_name
                );

                PendingPesapal::create([
                    'order_tracking_id'  => $submission['order_tracking_id'],
                    'merchant_reference' => $reference,
                    'phone'              => $order->phone,
                    'amount'             => $orderTotal,
                    'currency'           => 'KES',
                    'user_id'            => auth()->id(),
                    'order_id'           => $order->id,
                    'status'             => 'pending',
                    'created_at'         => now(),
                ]);

                PaymentTransaction::create([
                    'user_id'   => auth()->id(),
                    'order_id'  => $order->id,
                    'amount'    => $orderTotal,
                    'method_id' => $paymentMethod->id,
                    'status'    => 'pending',
                    'reference' => $submission['order_tracking_id'],
                ]);

                $order->update(['pesapal_tracking_id' => $submission['order_tracking_id']]);

                return redirect()->away($submission['redirect_url']);
            } catch (\Exception $e) {
                Log::error('Pesapal initialization failed at checkout', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);

                return redirect()->route('client.orders.index')
                    ->with('error', 'Your order was placed but Pesapal could not be initiated: ' . $e->getMessage() . ' Please contact support or try again.');
            }
        }

        // ---------------
        // Cash on delivery - reserve stock immediately
        // ---------------
        if ($paymentMethod && $paymentMethod->slug === 'cash_on_delivery') {
            PaymentTransaction::create([
                'user_id'   => auth()->id(),
                'order_id'  => $order->id,
                'amount'    => $orderTotal,
                'method_id' => $paymentMethod->id,
                'status'    => 'pending',
                'reference' => 'COD-' . $order->id,
            ]);

            $order->update(['status' => 'processing']);

            app(\App\Services\StockService::class)->deductForOrder($order);
            \App\Models\Manage\Ecommerce\OrderStatusHistory::record(
                $order->id, 'status:processing', 'Cash on delivery order confirmed'
            );

            if ($request->wantsJson()) {
                return response()->json([
                    'success'    => true,
                    'order_code' => $orderCode,
                ]);
            }

            return redirect()->route('frontend.checkout.payment', ['order' => $orderCode])
                ->with('success', 'Your order has been placed! You will pay in cash on delivery.');
        }

        // ---------------
        // All other real payment methods (fallback)
        // ---------------
        PaymentTransaction::create([
            'user_id'   => auth()->id(),
            'order_id'  => $order->id,
            'amount'    => $orderTotal,
            'method_id' => $paymentMethod->id,
            'status'    => 'pending',
            'reference' => null,
        ]);

        return redirect()->route('frontend.checkout.payment', ['order' => $orderCode])
            ->with('success', 'Your order has been placed successfully!');
    }
}