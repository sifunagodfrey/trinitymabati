<?php

namespace App\Http\Controllers\Manage\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Manage\Ecommerce\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InvoicesController extends Controller
{
    // ---------------
    // List orders as invoices with search and payment status filter
    // ---------------
    public function index(): View
    {
        $query = Order::with('user')
            ->when(request('search'), function ($q) {
                $search = request('search');
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) =>
                      $u->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%"));
            })
            ->when(request('status'), fn ($q) => $q->where('payment_status', request('status')));

        $orders = $query->latest()->paginate(20)->withQueryString();

        return view('manage.ecommerce.invoices.index', compact('orders'));
    }

    // ---------------
    // Invoice detail - VAT and commission breakdown from order items
    // ---------------
    public function show(string $id): View
    {
        $order = Order::with('user')->findOrFail($id);

        $vatRate = (float) (DB::table('su_vat')
            ->where('is_active', 1)
            ->orderByDesc('id')
            ->value('rate') ?? 0.0);

        $items = DB::table('su_order_items as oi')
            ->leftJoin('su_products as p', 'oi.product_id', '=', 'p.id')
            ->leftJoin('su_product_categories as pc', 'p.category_id', '=', 'pc.id')
            ->where('oi.order_id', $order->id)
            ->select([
                'oi.*',
                DB::raw('COALESCE(oi.product_name, p.name) as display_name'),
            ])
            ->get();

        $subtotal = $vatTotal = 0.0;

        $calcItems = $items->map(function ($item) use ($vatRate, &$subtotal, &$vatTotal) {
            $lineGross = (float) $item->price * (int) $item->quantity;
            $vat       = $lineGross * ($vatRate / 100);

            $subtotal += $lineGross;
            $vatTotal += $vat;

            return (object) [
                'name' => $item->display_name ?? 'Product',
                'qty'  => (int) $item->quantity,
                'unit' => (float) $item->price,
                'line' => $lineGross,
                'vat'  => $vat,
            ];
        });

        $shipping   = (float) ($order->shipping_cost ?? 0);
        $discount   = (float) ($order->discount ?? 0);
        $grandTotal = $subtotal + $shipping - $discount;

        return view('manage.ecommerce.invoices.show', compact(
            'order', 'vatRate', 'calcItems',
            'subtotal', 'vatTotal',
            'shipping', 'discount', 'grandTotal'
        ));
    }
}
