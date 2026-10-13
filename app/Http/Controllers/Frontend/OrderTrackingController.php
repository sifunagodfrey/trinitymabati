<?php

/* -------------------
   Public Order Tracking
   Lets anyone look up an order by its code plus the email on the
   account that placed it. No authentication required.
------------------- */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Manage\Ecommerce\Order;
use App\Models\Manage\Ecommerce\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderTrackingController extends Controller
{
    // ---------------
    // Show the tracking form (and results after a successful lookup)
    // ---------------
    public function show(Request $request): View
    {
        return view('frontend.track-order.index', [
            'order'    => null,
            'timeline' => collect(),
            'searched' => false,
            'old'      => ['order_code' => '', 'email' => ''],
        ]);
    }

    // ---------------
    // Look up an order by code + the account email that placed it
    // ---------------
    public function track(Request $request): View
    {
        $data = $request->validate([
            'order_code' => ['required', 'string', 'max:60'],
            'email'      => ['required', 'email', 'max:150'],
        ]);

        $code  = trim($data['order_code']);
        $email = trim(mb_strtolower($data['email']));

        $order = Order::where('order_code', $code)
            ->with([
                'items',
                'user:id,email,first_name,last_name',
            ])
            ->first();

        // Match the email against the account that placed the order.
        $matches = $order
            && $order->user
            && mb_strtolower((string) $order->user->email) === $email;

        if (! $matches) {
            if ($request->ajax() || $request->boolean('ajax')) {
                return view('frontend.track-order.partials.result', [
                    'order'    => null,
                    'timeline' => collect(),
                    'searched' => true,
                ]);
            }

            return view('frontend.track-order.index', [
                'order'    => null,
                'timeline' => collect(),
                'searched' => true,
                'old'      => ['order_code' => $code, 'email' => $data['email']],
            ]);
        }

        $timeline = OrderStatusHistory::where('order_id', $order->id)
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        if ($request->ajax() || $request->boolean('ajax')) {
            return view('frontend.track-order.partials.result', [
                'order'    => $order,
                'timeline' => $timeline,
                'searched' => true,
            ]);
        }

        return view('frontend.track-order.index', [
            'order'    => $order,
            'timeline' => $timeline,
            'searched' => true,
            'old'      => ['order_code' => $code, 'email' => $data['email']],
        ]);
    }
}
