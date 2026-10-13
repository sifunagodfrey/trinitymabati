<?php

namespace App\Http\Controllers\Manage\Quotations;

use App\Http\Controllers\Controller;
use App\Models\Manage\Ecommerce\Order;
use App\Models\Manage\Ecommerce\OrderItem;
use App\Models\Manage\Products\Product;
use App\Models\Manage\Quotations\Quotation;
use App\Models\Manage\Quotations\QuotationItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuotationsController extends Controller
{
    // ---------------
    // List quotations with basic filters
    // ---------------
    public function index(Request $request)
    {
        $query = Quotation::query()->with(['customer', 'preparedBy']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('quotation_code', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($c) use ($search) {
                        $c->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $quotations = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('manage.quotations.index', compact('quotations'));
    }

    // ---------------
    // Show the create form - customers and products for the picker
    // ---------------
    public function create()
    {
        $customers = User::orderBy('first_name')->get(['id', 'first_name', 'last_name', 'email']);
        $products  = Product::where('is_active', 1)->orderBy('name')->get(['id', 'name', 'price', 'sale_price']);

        return view('manage.quotations.create', compact('customers', 'products'));
    }

    // ---------------
    // Save a new quotation with its line items
    // ---------------
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'                 => 'required|exists:su_users,id',
            'valid_until'             => 'nullable|date',
            'notes'                   => 'nullable|string',
            'tax'                     => 'nullable|numeric|min:0',
            'discount'                => 'nullable|numeric|min:0',
            'items'                   => 'required|array|min:1',
            'items.*.item_name'       => 'required|string|max:255',
            'items.*.product_id'      => 'nullable|exists:su_products,id',
            'items.*.quantity'        => 'required|integer|min:1',
            'items.*.unit_price'      => 'required|numeric|min:0',
        ]);

        $quotation = DB::transaction(function () use ($data) {
            $subtotal = collect($data['items'])->sum(fn ($item) => $item['quantity'] * $item['unit_price']);
            $tax      = $data['tax'] ?? 0;
            $discount = $data['discount'] ?? 0;

            $quotation = Quotation::create([
                'quotation_code' => Quotation::generateCode(),
                'user_id'        => $data['user_id'],
                'prepared_by'    => Auth::id(),
                'status'         => 'draft',
                'subtotal'       => $subtotal,
                'tax'            => $tax,
                'discount'       => $discount,
                'total'          => max($subtotal + $tax - $discount, 0),
                'valid_until'    => $data['valid_until'] ?? null,
                'notes'          => $data['notes'] ?? null,
            ]);

            foreach ($data['items'] as $item) {
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id'   => $item['product_id'] ?? null,
                    'item_name'    => $item['item_name'],
                    'quantity'     => $item['quantity'],
                    'unit_price'   => $item['unit_price'],
                ]);
            }

            return $quotation;
        });

        return redirect()->route('manage.quotations.show', $quotation->id)
            ->with('success', 'Quotation created successfully.');
    }

    // ---------------
    // View a single quotation and its items
    // ---------------
    public function show(string $id)
    {
        $quotation = Quotation::with(['customer', 'preparedBy', 'items.product'])->findOrFail($id);

        return view('manage.quotations.show', compact('quotation'));
    }

    // ---------------
    // Update status (draft, sent, accepted, rejected, expired)
    // ---------------
    public function updateStatus(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:draft,sent,accepted,rejected,expired',
        ]);

        Quotation::findOrFail($id)->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Quotation status updated.');
    }

    // ---------------
    // Convert an accepted quotation into a real order, copying its items
    // ---------------
    public function convert(string $id)
    {
        $quotation = Quotation::with('items')->findOrFail($id);

        if ($quotation->converted_order_id) {
            return redirect()->back()->with('error', 'This quotation was already converted to an order.');
        }

        $order = DB::transaction(function () use ($quotation) {
            $order = Order::create([
                'user_id'    => $quotation->user_id,
                'order_code' => 'QOR-' . strtoupper(substr(uniqid(), -10)),
                'status'     => 'pending',
                'subtotal'   => $quotation->subtotal,
                'tax'        => $quotation->tax,
                'discount'   => $quotation->discount,
                'total'      => $quotation->total,
                'notes'      => 'Converted from quotation ' . $quotation->quotation_code,
            ]);

            foreach ($quotation->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->item_name,
                    'quantity'     => $item->quantity,
                    'price'        => $item->unit_price,
                ]);
            }

            $quotation->update([
                'status'             => 'converted',
                'converted_order_id' => $order->id,
            ]);

            return $order;
        });

        return redirect()->route('manage.ecommerce.orders.index')
            ->with('success', 'Quotation converted to order ' . $order->order_code . '.');
    }

    // ---------------
    // Delete a quotation and its items
    // ---------------
    public function destroy(string $id)
    {
        Quotation::findOrFail($id)->delete();

        return redirect()->route('manage.quotations.index')->with('success', 'Quotation deleted.');
    }
}
