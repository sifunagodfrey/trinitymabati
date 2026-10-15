<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Manage\Products\Product;
use App\Models\Manage\Products\ProductVariant;
use App\Models\Manage\Quotations\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\QuotationEmailService;
class QuotationRequestController extends Controller
{
    private function resolve(int $productId, ?int $variantId, $metres, int $quantity): array
    {
        $product = Product::where('is_active', 1)->findOrFail($productId);
        if ($quantity < 1 || $quantity > 10000) throw ValidationException::withMessages(['quantity' => 'Quantity must be between 1 and 10,000.']);
        $variant = null;
        if ($product->is_variant) {
            if (!$variantId) throw ValidationException::withMessages(['variant_id' => 'Please select gauge and finish.']);
            $variant = ProductVariant::where('product_id', $product->id)->findOrFail($variantId);
        } elseif ($variantId) {
            throw ValidationException::withMessages(['variant_id' => 'This product has no variants.']);
        }
        $lengthEnabled = (bool) $product->allow_custom_length;
        $length = $lengthEnabled ? (float) $metres : null;
        if ($lengthEnabled && (!is_numeric($metres) || !preg_match('/^\d+(?:\.\d{1,2})?$/', (string) $metres) || $length < 0.1 || $length > 30)) {
            throw ValidationException::withMessages(['metres' => 'Length must be 0.10 to 30 metres, maximum two decimal places.']);
        }
        $rate = (float) (($variant?->sale_price !== null) ? $variant->sale_price : ($variant?->price ?? $product->sale_price ?? $product->price));
        if ($rate <= 0) throw ValidationException::withMessages(['product_id' => 'Price is not available for this selection.']);
        $labels = [];
        if ($variant) {
            $variant->load('variantAttributes.attribute', 'variantAttributes.attributeValue');
            foreach ($variant->variantAttributes as $attribute) {
                $labels[] = ($attribute->attribute?->name ?? 'Option') . ' ' . ($attribute->attributeValue?->value ?? '');
            }
        }
        $name = $product->name . (count($labels) ? ' · ' . implode(' · ', $labels) : '') . ($lengthEnabled ? ' · ' . number_format($length, 2, '.', '') . ' Metres' : '');
        return [
            'key' => implode(':', [$product->id, $variant?->id ?? 0, $lengthEnabled ? number_format($length, 2, '.', '') : 'unit']),
            'product_id' => $product->id,
            'variant_id' => $variant?->id,
            'name' => $name,
            'product_name' => $product->name,
            'options' => implode(' · ', $labels),
            'metres' => $length,
            'length_enabled' => $lengthEnabled,
            'rate' => round($rate, 2),
            'unit_price' => round($rate * ($lengthEnabled ? $length : 1), 2),
            'quantity' => $quantity,
        ];
    }

    private function basket(Request $request): array
    {
        $items = $request->session()->get('trinity_quote', []);
        $result = [];
        foreach ($items as $item) {
            try { $result[] = $this->resolve((int)$item['product_id'], $item['variant_id'] ? (int)$item['variant_id'] : null, $item['metres'] ?? null, (int)$item['quantity']); }
            catch (\Throwable $e) { /* An unpublished or removed product is skipped. */ }
        }
        $request->session()->put('trinity_quote', $result);
        return $result;
    }

    public function index(Request $request)
    {
        return view('frontend.quotation.index', ['items' => $this->basket($request)]);
    }

    public function search(Request $request)
    {
        $term = trim((string)$request->query('q', ''));
        if ($term === '') return response()->json(['results' => []]);
        $products = Product::query()->where('is_active', 1)
            ->when($term !== '', fn($q) => $q->where('name', 'like', '%' . str_replace(['%', '_'], ['\%', '\_'], $term) . '%'))
            ->with(['variants.variantAttributes.attribute', 'variants.variantAttributes.attributeValue'])
            ->orderByDesc('id')->limit(5)->get();
        $options = [];
        foreach ($products as $product) {
            $variants = $product->is_variant ? $product->variants : collect([null]);
            foreach ($variants as $variant) {
                if ($product->is_variant && (!$variant || $variant->stock_quantity < 1)) continue;
                $length = $product->allow_custom_length ? 3 : null;
                try {
                    $candidate = $this->resolve($product->id, $variant?->id, $length, 1);
                    $candidate['name'] = $product->name . ($candidate['options'] ? ' · ' . $candidate['options'] : '') . ($length !== null ? ' · 3 Metres' : '');
                    $options[] = $candidate;
                    if (count($options) >= 5) break 2;
                } catch (\Throwable $e) { continue; }
            }
        }
        return response()->json(['results' => $options]);
    }

    public function add(Request $request)
    {
        $data = $request->validate(['product_id' => 'required|integer', 'variant_id' => 'nullable|integer', 'metres' => 'nullable', 'quantity' => 'required|integer|min:1|max:10000']);
        $candidate = $this->resolve((int)$data['product_id'], isset($data['variant_id']) ? (int)$data['variant_id'] : null, $data['metres'] ?? null, (int)$data['quantity']);
        $items = $this->basket($request);
        $found = false;
        foreach ($items as &$item) {
            if ($item['key'] === $candidate['key']) { $item['quantity'] = min(10000, $item['quantity'] + $candidate['quantity']); $found = true; break; }
        }
        unset($item);
        if (!$found) $items[] = $candidate;
        $request->session()->put('trinity_quote', $items);
        return response()->json(['ok' => true, 'count' => count($items)]);
    }

    public function update(Request $request)
    {
        $data = $request->validate(['key' => 'required|string|max:150', 'quantity' => 'required|integer|min:1|max:10000', 'metres' => 'nullable']);
        $items = $this->basket($request);
        $updated = [];
        $found = false;
        foreach ($items as $item) {
            if ($item['key'] !== $data['key']) { $updated[$item['key']] = $item; continue; }
            $found = true;
            $candidate = $this->resolve((int)$item['product_id'], $item['variant_id'], $data['metres'] ?? $item['metres'], (int)$data['quantity']);
            if (isset($updated[$candidate['key']])) $candidate['quantity'] = min(10000, $candidate['quantity'] + $updated[$candidate['key']]['quantity']);
            $updated[$candidate['key']] = $candidate;
        }
        if (!$found) return response()->json(['message' => 'Quotation item not found.'], 404);
        $request->session()->put('trinity_quote', array_values($updated));
        return response()->json(['ok' => true]);
    }

    public function remove(Request $request)
    {
        $key = $request->validate(['key' => 'required|string'])['key'];
        $request->session()->put('trinity_quote', array_values(array_filter($this->basket($request), fn($item) => $item['key'] !== $key)));
        return response()->json(['ok' => true]);
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100', 'last_name' => 'required|string|max:100',
            'phone' => ['required','regex:/^\+?[0-9 ]{9,16}$/'], 'email' => 'nullable|email|max:190',
        ]);
        $items = $this->basket($request);
        if (!$items) return back()->withErrors(['items' => 'Add at least one product before submitting.'])->withInput();
        $quote = DB::transaction(function () use ($items, $data, $request) {
            $subtotal = 0;
            foreach ($items as $item) $subtotal += $item['unit_price'] * $item['quantity'];
            $quote = Quotation::create([
                'quotation_code' => Quotation::generateCode(), 'user_id' => $request->user()?->id,
                'customer_first_name' => $data['first_name'], 'customer_last_name' => $data['last_name'],
                'customer_phone' => $data['phone'], 'customer_email' => $data['email'] ?? null,
                'status' => 'sent', 'subtotal' => round($subtotal, 2), 'tax' => 0,
                'discount' => 0, 'total' => round($subtotal, 2), 'currency' => 'KES',
                'notes' => 'Customer-submitted quotation request. Prices shown are estimates subject to confirmation.',
            ]);
            foreach ($items as $item) {
                $quote->items()->create([
                    'product_id' => $item['product_id'], 'variant_id' => $item['variant_id'],
                    'item_name' => $item['name'], 'quantity' => $item['quantity'], 'unit_price' => $item['unit_price'],
                ]);
            }
            return $quote;
        });
        $request->session()->forget('trinity_quote');

        // ---------------
        // Receipt to the customer and alert to staff (never blocks the request)
        // ---------------
        $emails = app(QuotationEmailService::class);
        $emails->sendRequestReceivedToClient($quote);
        $emails->sendNewRequestToStaff($quote);
        // ---------------
        // Admin Messages notification
        // ---------------
        app(\App\Services\AdminNotificationService::class)->quotationSubmitted($quote);
        return redirect()->route('frontend.quotation.index')->with('quote_success', $quote->quotation_code);
    }
}
