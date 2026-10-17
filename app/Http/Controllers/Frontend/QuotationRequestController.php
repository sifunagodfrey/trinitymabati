<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Manage\Products\Product;
use App\Models\Manage\Quotations\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Services\QuotationEmailService;
use App\Services\StockAvailability;
class QuotationRequestController extends Controller
{
    private array $productCache = [];

    private function product(int $id): Product
    {
        return $this->productCache[$id] ??= Product::where('is_active', 1)
            ->with(['variants.variantAttributes.attribute', 'variants.variantAttributes.attributeValue'])->findOrFail($id);
    }

    private function configuration(Product $product): array
    {
        $groups = [];
        $variants = [];
        if ($product->is_variant) {
            foreach ($product->variants as $variant) {
                $rate = $variant->sale_price ?? $variant->price ?? $product->sale_price ?? $product->price;
                if (!StockAvailability::isAvailable($variant->stock_quantity) || (float) $rate <= 0) continue;
                $attributes = [];
                foreach ($variant->variantAttributes as $selection) {
                    if (!$selection->attribute || !$selection->attributeValue) continue;
                    $id = (string) $selection->attribute_id;
                    $value = (string) $selection->attributeValue->value;
                    $attributes[$id] = $value;
                    if (!isset($groups[$id])) $groups[$id] = ['id' => $id, 'name' => $selection->attribute->name, 'values' => []];
                    if (!in_array($value, $groups[$id]['values'], true)) $groups[$id]['values'][] = $value;
                }
                $variants[] = ['id' => $variant->id, 'label' => $variant->variant_code ?: 'Option ' . $variant->id, 'attributes' => (object) $attributes];
            }
        }
        return ['attributes' => array_values($groups), 'variants' => $variants];
    }

    private function present(array $items): array
    {
        foreach ($items as &$item) {
            $product = $this->product((int) $item['product_id']);
            $item['configuration'] = $this->configuration($product);
            $item['image_url'] = $product->thumbnail ? asset($product->thumbnail) : null;
        }
        unset($item);
        return $items;
    }

    private function resolve(int $productId, ?int $variantId, $metres, int $quantity): array
    {
        $product = $this->product($productId);
        if ($quantity < 1 || $quantity > 10000) throw ValidationException::withMessages(['quantity' => 'Quantity must be between 1 and 10,000.']);
        $variant = null;
        if ($product->is_variant) {
            if (!$variantId) throw ValidationException::withMessages(['variant_id' => 'Please select the product options.']);
            $variant = $product->variants->firstWhere('id', $variantId);
            if (!$variant) throw ValidationException::withMessages(['variant_id' => 'This option does not belong to this product.']);
        } elseif ($variantId) {
            throw ValidationException::withMessages(['variant_id' => 'This product has no variants.']);
        }
        if (!StockAvailability::isAvailable($variant ? $variant->stock_quantity : $product->stock_quantity)) {
            throw ValidationException::withMessages(['product_id' => 'This product option is currently unavailable.']);
        }
        $lengthEnabled = (bool) $product->allow_custom_length;
        $length = $lengthEnabled ? (float) $metres : null;
        if ($lengthEnabled && (!is_numeric($metres) || !preg_match('/^\d+(?:\.\d{1,2})?$/', (string) $metres) || $length < 0.1 || $length > 30)) {
            throw ValidationException::withMessages(['metres' => 'Length must be 0.10 to 30 metres, maximum two decimal places.']);
        }
        $rate = (float) (($variant?->sale_price !== null) ? $variant->sale_price : ($variant?->price ?? $product->sale_price ?? $product->price));
        if ($rate <= 0) throw ValidationException::withMessages(['product_id' => 'Price is not available for this selection.']);
        $labels = [];
        $selectedAttributes = [];
        if ($variant) {
            $variant->loadMissing('variantAttributes.attribute', 'variantAttributes.attributeValue');
            foreach ($variant->variantAttributes as $attribute) {
                if ($attribute->attribute && $attribute->attributeValue) $selectedAttributes[(string) $attribute->attribute_id] = (string) $attribute->attributeValue->value;
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
            'selected_attributes' => (object) $selectedAttributes,
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
        return view('frontend.quotation.index', ['items' => $this->present($this->basket($request))]);
    }

    public function search(Request $request)
    {
        $term = trim((string)$request->query('q', ''));
        $products = Product::query()->where('is_active', 1)
            ->when($term !== '', fn($q) => $q->where('name', 'like', '%' . str_replace(['%', '_'], ['\%', '\_'], $term) . '%'))
            ->where(function ($query) {
                $query->where(function ($simple) {
                    $simple->where('is_variant', 0)
                        ->whereRaw('COALESCE(sale_price, price, 0) > 0')
                        ->where(fn($stock) => $stock->whereNull('stock_quantity')->orWhere('stock_quantity', '>', 0));
                })->orWhere(function ($variable) {
                    $variable->where('is_variant', 1)->whereHas('variants', function ($variants) {
                        $variants->whereRaw('COALESCE(su_product_variants.sale_price, su_product_variants.price, su_products.sale_price, su_products.price, 0) > 0')
                            ->where(fn($stock) => $stock->whereNull('stock_quantity')->orWhere('stock_quantity', '>', 0));
                    });
                });
            })
            ->with(['variants.variantAttributes.attribute', 'variants.variantAttributes.attributeValue'])
            ->orderByDesc('id')->limit(8)->get();
        $options = [];
        foreach ($products as $product) {
            $this->productCache[$product->id] = $product;
            $configuration = $this->configuration($product);
            $variantId = null;
            if ($product->is_variant) {
                $available = collect($configuration['variants']);
                $preferred = $available->first(function ($variant) use ($product, $configuration) {
                    foreach ($configuration['attributes'] as $attribute) {
                        $slug = \Illuminate\Support\Str::slug($attribute['name']);
                        $desired = match ($slug) { 'gauge' => $product->default_gauge, 'finish' => $product->default_finish, default => null };
                        if ($desired && strcasecmp((string) ($variant['attributes']->{$attribute['id']} ?? ''), (string) $desired) !== 0) return false;
                    }
                    return true;
                }) ?? $available->first();
                if (!$preferred) continue;
                $variantId = $preferred['id'];
            }
            $length = $product->allow_custom_length ? max(0.1, min(30, (float) ($product->default_length_m ?? 1))) : null;
            $options[] = ['product_id' => $product->id, 'product_name' => $product->name,
                'variant_id' => $variantId, 'metres' => $length];
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
        return response()->json(['ok' => true, 'count' => count($items), 'items' => $this->present($items)]);
    }

    public function update(Request $request)
    {
        $data = $request->validate(['key' => 'required|string|max:150', 'quantity' => 'required|integer|min:1|max:10000', 'metres' => 'nullable', 'variant_id' => 'nullable|integer']);
        $items = $this->basket($request);
        $target = collect($items)->firstWhere('key', $data['key']);
        if (!$target) return response()->json(['message' => 'Quotation item not found.'], 404);
        $variantId = array_key_exists('variant_id', $data) ? $data['variant_id'] : $target['variant_id'];
        $candidate = $this->resolve((int) $target['product_id'], $variantId !== null ? (int) $variantId : null,
            $data['metres'] ?? $target['metres'], (int) $data['quantity']);
        // Remove the old configuration first, then merge matching configurations
        // independently of their order in the basket.
        $updated = [];
        foreach ($items as $item) {
            if ($item['key'] === $target['key']) continue;
            if ($item['key'] === $candidate['key']) {
                $candidate['quantity'] = min(10000, $candidate['quantity'] + $item['quantity']);
                continue;
            }
            $updated[] = $item;
        }
        $updated[] = $candidate;
        $request->session()->put('trinity_quote', $updated);
        return response()->json(['ok' => true, 'items' => $this->present($updated)]);
    }

    public function remove(Request $request)
    {
        $key = $request->validate(['key' => 'required|string'])['key'];
        $items = array_values(array_filter($this->basket($request), fn($item) => $item['key'] !== $key));
        $request->session()->put('trinity_quote', $items);
        return response()->json(['ok' => true, 'items' => $this->present($items)]);
    }

    public function submit(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100', 'last_name' => 'nullable|string|max:100',
            'phone' => ['required','regex:/^\+?[0-9 ]{9,16}$/'], 'email' => 'nullable|email|max:190',
        ]);
        $items = $this->basket($request);
        if (!$items) return back()->withErrors(['items' => 'Add at least one product before submitting.'])->withInput();
        $quote = DB::transaction(function () use ($items, $data, $request) {
            $subtotal = 0;
            foreach ($items as $item) $subtotal += $item['unit_price'] * $item['quantity'];
            $quote = Quotation::create([
                'quotation_code' => Quotation::generateCode(), 'user_id' => $request->user()?->id,
                'customer_first_name' => $data['first_name'], 'customer_last_name' => $data['last_name'] ?? null,
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

        // Preserve the incoming admin Messages notification and local Analytics flash.
        try {
            app(\App\Services\AdminNotificationService::class)->quotationSubmitted($quote);
        } catch (\Throwable $exception) {
            \Illuminate\Support\Facades\Log::warning('Quotation admin notification failed', [
                'quotation_id' => $quote->id, 'error' => $exception->getMessage(),
            ]);
        }

        return redirect()->route('frontend.quotation.index')->with('analytics_lead', 'quotation')->with('quote_success', $quote->quotation_code);
    }
}
