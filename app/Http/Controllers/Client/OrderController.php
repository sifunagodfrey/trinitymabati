<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Order;
use App\Models\Manage\Ecommerce\OrderStatusHistory;
use App\Services\StockService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // ---------------
    // Order History
    // ---------------
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->withCount('items')
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('client.orders.index', compact('orders'));
    }

    // ---------------
    // Order Detail
    // ---------------
    public function show(int $id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['items' => fn ($q) => $q->with('variant.variantAttributes.attributeValue', 'product.reviews' )])
            ->findOrFail($id);

        $county    = DB::table('su_counties')->find($order->shipping_county_id);
        $location  = DB::table('su_location_pricing')->find($order->shipping_location_id);

        $history = OrderStatusHistory::where('order_id', $order->id)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        return view('client.orders.show', compact('order', 'county', 'location', 'history'));
    }

    // ---------------
    // Cancel Order
    // ---------------
    public function cancel(int $id)
    {
        $order = Order::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'processing'])
            ->findOrFail($id);

        $order->update(['status' => 'cancelled']);

        OrderStatusHistory::record($order->id, 'status:cancelled', 'Order cancelled by the customer.', Auth::id());

        app(StockService::class)->restoreForOrder($order);

        return redirect()->route('client.orders.show', $id)
            ->with('success', 'Your order has been cancelled successfully.');
    }

    // ---------------
    // Print Invoice
    // ---------------
    public function invoice(int $id)
    {
        $order    = Order::where('user_id', Auth::id())
            ->with('items')
            ->findOrFail($id);

        $user     = Auth::user();
        $county   = DB::table('su_counties')->find($order->shipping_county_id);
        $location = DB::table('su_towns')->find($order->shipping_town_id);

        return view('client.orders.invoice', compact('order', 'user', 'county', 'location'));
    }
}
