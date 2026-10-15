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
use App\Services\OrderEmailService;
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

        // A configured location price is the complete delivery charge, including zero.
        if ($location !== null && $location->price !== null) {
            $freeThreshold = (float) ($s?->free_shipping_threshold ?? 0);
            return $freeThreshold > 0 && $subtotal >= $freeThreshold
                ? 0.0
                : round((float) $location->price, 2);
        }

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
        $distKm        = (float) ($location?->distance_km      ?? 0);

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

        $paymentMethods = PaymentMethod::availableManual()->orderByDesc('is_default')->orderBy('id')->get();

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

        $location = LocationPricing::whereHas('town', fn ($query) => $query->where('county_id', $request->county_id))
            ->find($request->location_id);
        if (!$location) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'location_id' => 'Please choose a delivery location in the selected county.',
            ]);
        }
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
    // Payment selection and manual verification status
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
                'payment' => PaymentTransaction::where('order_id', $order->id)->orderByDesc('id')->first(),
                'paymentMethods' => PaymentMethod::availableManual()->orderByDesc('is_default')->orderBy('id')->get(),
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
        $paymentMethods = PaymentMethod::availableManual()->orderByDesc('is_default')->orderBy('id')->get();

        $preferredId = \App\Models\Client\CustomerPaymentPreference::where('user_id', auth()->id())->value('payment_method_id');
        if ($preferredId) $paymentMethods = $paymentMethods->sortBy(fn ($method) => (int) $method->id === (int) $preferredId ? 0 : 1)->values();

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
    // Submit a manual payment for staff verification
    // ---------------
    public function processPayment(Request $request)
    {
        $data = $this->manualPaymentInput($request);
        $checkout = session('checkout');
        if (!$checkout) return redirect()->route('frontend.checkout')->with('error', 'Your session expired. Please enter shipping details again.');
        $proofPath = $request->hasFile('proof') ? $request->file('proof')->store('payment-proofs', 'local') : null;
        try {
            $order = DB::transaction(function () use ($request, $data, $checkout, $proofPath) {
                $cart = Cart::where('user_id', auth()->id())->lockForUpdate()->first();
                if (!$cart) throw \Illuminate\Validation\ValidationException::withMessages(['payment' => 'Your cart is empty.']);
                $items = $cart->items()->with(['product', 'variant.variantAttributes.attributeValue'])->get();
                if ($items->isEmpty()) throw \Illuminate\Validation\ValidationException::withMessages(['payment' => 'Your cart is empty.']);
                // Serialize manual order-code generation and recheck live method settings.
                $methods = PaymentMethod::manual()->orderBy('id')->lockForUpdate()->get();
                $method = $methods->firstWhere('id', (int) $data['payment_method_id']);
                $this->assertManualMethod($method);
                $location = LocationPricing::whereHas('town', fn ($query) => $query->where('county_id', $checkout['county_id']))
                    ->find($checkout['location_id']);
                if (!$location) throw \Illuminate\Validation\ValidationException::withMessages(['payment' => 'Please choose a valid delivery location.']);
                $subtotal = $items->sum(fn ($item) => $item->price_at_time * $item->quantity);
                $shipping = $this->calcShipping($items, $location, $subtotal);
                $order = Order::create([
                    'user_id' => auth()->id(), 'order_code' => $this->generateOrderCode(),
                    'status' => 'pending', 'payment_status' => 'pending', 'shipping_status' => 'pending',
                    'total' => $subtotal + $shipping, 'shipping_cost' => $shipping, 'discount' => 0,
                    'shipping_county_id' => $checkout['county_id'], 'shipping_town_id' => $location->town_id,
                    'notes' => $checkout['notes'] ?? null, 'currency' => 'KES', 'stock_deducted' => 0,
                    'customer_confirmed' => false, 'admin_confirmed' => false, 'phone' => auth()->user()->phone,
                ]);
                foreach ($items as $cartItem) {
                    $variantLabel = null;
                    if ($cartItem->variant) {
                        $parts = $cartItem->variant->variantAttributes->map(fn ($value) => optional($value->attributeValue)->value)->filter()->values();
                        $variantLabel = $parts->isNotEmpty() ? $parts->implode(' / ') : $cartItem->variant->variant_code;
                    }
                    OrderItem::create([
                        'order_id' => $order->id, 'product_id' => $cartItem->product_id, 'variant_id' => $cartItem->variant_id,
                        'variant_label' => $cartItem->sheet_length_m ? trim(($variantLabel ? $variantLabel . ' / ' : '') . number_format($cartItem->sheet_length_m, 2) . ' m') : $variantLabel,
                        'product_name' => $cartItem->product?->name ?? 'Product', 'quantity' => $cartItem->quantity, 'price' => $cartItem->price_at_time,
                    ]);
                }
                app(\App\Services\ManualPaymentService::class)->submit($order, $method, $data['payment_reference'] ?? null, $proofPath);
                \App\Models\Manage\Ecommerce\OrderStatusHistory::record($order->id, 'status:pending', 'Order placed; awaiting manual payment verification', auth()->id());
                $cart->items()->delete();
                AbandonedCart::where('user_id', auth()->id())->delete();
                AbandonedCartLog::where('user_id', auth()->id())->delete();
                return $order;
            }, 3);
        } catch (\Throwable $exception) {
            if ($proofPath) \Illuminate\Support\Facades\Storage::disk('local')->delete($proofPath);
            $this->rethrowManualPaymentError($exception);
        }
        session()->forget('checkout');
        try {
            $order->loadMissing(['user', 'items']);
            app(OrderEmailService::class)->sendNewOrderToClient($order);
            app(OrderEmailService::class)->sendNewOrderToStaff($order);
        } catch (\Throwable $exception) {
            Log::warning('Manual order email failed', ['order_id' => $order->id, 'error' => $exception->getMessage()]);
        }
        return redirect()->route('frontend.checkout.payment', ['order' => $order->order_code])->with('success', 'Order placed. Your payment is awaiting manual verification.');
    }

    public function resubmitPayment(Request $request, string $code)
    {
        $data = $this->manualPaymentInput($request);
        $proofPath = $request->hasFile('proof') ? $request->file('proof')->store('payment-proofs', 'local') : null;
        try {
            $order = DB::transaction(function () use ($data, $code, $proofPath) {
                $order = Order::where('order_code', $code)->where('user_id', auth()->id())->lockForUpdate()->firstOrFail();
                if ($order->payment_status !== 'failed'
                    || !PaymentTransaction::where('order_id', $order->id)->where('is_manual', true)->where('status', 'failed')->exists()) {
                    throw \Illuminate\Validation\ValidationException::withMessages(['payment' => 'Only a rejected manual payment can be resubmitted.']);
                }
                $method = PaymentMethod::manual()->whereKey($data['payment_method_id'])->lockForUpdate()->first();
                $this->assertManualMethod($method);
                app(\App\Services\ManualPaymentService::class)->submit($order, $method, $data['payment_reference'] ?? null, $proofPath);
                return $order;
            }, 3);
        } catch (\Throwable $exception) {
            if ($proofPath) \Illuminate\Support\Facades\Storage::disk('local')->delete($proofPath);
            $this->rethrowManualPaymentError($exception);
        }
        return redirect()->route('frontend.checkout.payment', ['order' => $order->order_code])->with('success', 'Payment resubmitted for review.');
    }

    private function manualPaymentInput(Request $request): array
    {
        $reference = $request->input('payment_reference');
        if (is_string($reference)) $request->merge(['payment_reference' => trim($reference) === '' ? null : strtoupper(trim($reference))]);
        return $request->validate([
            'payment_method_id' => ['required', 'integer'],
            'payment_reference' => ['nullable', 'string', 'min:4', 'max:100'],
            'proof' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ]);
    }

    private function assertManualMethod($method): void
    {
        if (!$method || !$method->is_manual || !$method->is_active || !$method->isConfigured()) {
            throw \Illuminate\Validation\ValidationException::withMessages(['payment_method_id' => 'This payment option is unavailable. Please select an enabled payment option.']);
        }
    }

    private function rethrowManualPaymentError(\Throwable $exception): void
    {
        if ($exception instanceof \Illuminate\Database\QueryException && in_array((string) $exception->getCode(), ['23000', '23505'], true) && str_contains($exception->getMessage(), 'manual_reference')) {
            throw \Illuminate\Validation\ValidationException::withMessages(['payment_reference' => 'This payment reference has already been submitted.']);
        }
        throw $exception;
    }
}
