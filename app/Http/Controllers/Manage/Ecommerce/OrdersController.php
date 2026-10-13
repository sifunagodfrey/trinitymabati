<?php

namespace App\Http\Controllers\Manage\Ecommerce;

use App\Http\Controllers\Controller;
use App\Models\Manage\Ecommerce\Order;
use App\Services\OrderEmailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    // ---------------
    // Valid status values from su_orders schema
    // ---------------
    private const ORDER_STATUSES = [
        'pending', 'processing', 'in_transit', 'delivered', 'completed', 'cancelled', 'refunded',
    ];

    private const PAYMENT_STATUSES = [
        'pending', 'paid', 'processing', 'failed', 'refunded',
    ];

    private const SHIPPING_STATUSES = [
        'pending', 'shipped', 'in_transit', 'delivered', 'cancelled',
    ];

    // ---------------
    // All orders listing
    // ---------------
    public function index(): View
    {
        $query = Order::with(['user'])
            ->withCount('items');

        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhereHas('user', fn ($u) => $u->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name',  'like', "%{$search}%")
                      ->orWhere('email',      'like', "%{$search}%"));
            });
        }

        if (request()->boolean('pending_attention')) {
            // ---------------
            // Matches the dashboard's "Pending orders" count: order status
            // pending OR payment still pending - kept as its own branch so
            // it isn't narrowed by the AND logic the two selects below use.
            // ---------------
            $query->where(function ($q) {
                $q->where('status', 'pending')
                  ->orWhere('payment_status', 'pending');
            });
        } else {
            if (request('status') && in_array(request('status'), self::ORDER_STATUSES)) {
                $query->where('status', request('status'));
            }

            if (request('payment_status') && in_array(request('payment_status'), self::PAYMENT_STATUSES)) {
                $query->where('payment_status', request('payment_status'));
            }
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        return view('manage.ecommerce.orders.index', compact('orders'));
    }

    // ---------------
    // Single order detail
    // ---------------
     public function show(string $id): View
    {
        $order = Order::with([
                'user',
                'items.product',
                'items.variant.variantAttributes.attributeValue',
                'paymentTransactions.method'
            ])
            ->findOrFail($id);

        // Determine payment method
        $paymentMethod = null;
        $paymentRef = null;

        // 1. Check successful payment transaction
        $paidTransaction = $order->paymentTransactions->where('status', 'successful')->first();
        if ($paidTransaction && $paidTransaction->method) {
            $paymentMethod = $paidTransaction->method->name;
            $paymentRef = $paidTransaction->reference;
        }

        // 2. If still null, infer from order data
        if (!$paymentMethod && $order->payment_status === 'paid') {
            if ($order->mpesa_checkout_request_id) {
                $paymentMethod = 'M-Pesa';
                $paymentRef = $order->mpesa_checkout_request_id;
            } elseif ($order->coopbank_message_reference) {
                $paymentMethod = 'Co-operative Bank';
                $paymentRef = $order->coopbank_message_reference;
            } elseif ($order->total == 0) {
                // Could be loyalty points only? But you'd have a transaction. Not needed.
            } else {
                // Check if there's a pending transaction that might be wallet/cash
                $anyTransaction = $order->paymentTransactions->first();
                if ($anyTransaction && $anyTransaction->method) {
                    $paymentMethod = $anyTransaction->method->name;
                    $paymentRef = $anyTransaction->reference;
                }
            }
        }

        // 3. Special handling: if payment method still null but order is paid, check wallet/cash
        if (!$paymentMethod && $order->payment_status === 'paid') {
            // Could be wallet (which uses method_id = null in PaymentTransaction)
            // Check if there's any transaction with method_id null and amount > 0
            $walletTransaction = $order->paymentTransactions->where('method_id', null)->where('status', 'successful')->first();
            if ($walletTransaction) {
                $paymentMethod = 'Wallet';
                $paymentRef = $walletTransaction->reference;
            } else {
                $paymentMethod = 'Cash on Delivery (or unknown)';
            }
        }

        $orderStatuses    = self::ORDER_STATUSES;
        $paymentStatuses  = self::PAYMENT_STATUSES;
        $shippingStatuses = self::SHIPPING_STATUSES;

        return view('manage.ecommerce.orders.show', compact(
            'order',
            'orderStatuses',
            'paymentStatuses',
            'shippingStatuses',
            'paymentMethod',
            'paymentRef'
        ));
    }

    // ---------------
    // Update status - admin may change order, payment, and shipping status
    // ---------------
    public function updateStatus(Request $request, string $id): RedirectResponse
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'status'          => 'nullable|in:' . implode(',', self::ORDER_STATUSES),
            'payment_status'  => 'nullable|in:' . implode(',', self::PAYMENT_STATUSES),
            'shipping_status' => 'nullable|in:' . implode(',', self::SHIPPING_STATUSES),
        ]);

        // Capture old statuses before update
        $oldStatuses = [
            'status'          => $order->status,
            'payment_status'  => $order->payment_status,
            'shipping_status' => $order->shipping_status,
        ];

        // Update the order
        $order->update($request->only(['status', 'payment_status', 'shipping_status']));

        // Refresh to get new values
        $order->refresh();
        $newStatuses = [
            'status'          => $order->status,
            'payment_status'  => $order->payment_status,
            'shipping_status' => $order->shipping_status,
        ];

        // Record each changed status in the order timeline
        foreach ($newStatuses as $field => $value) {
            if ($oldStatuses[$field] !== $value) {
                \App\Models\Manage\Ecommerce\OrderStatusHistory::record(
                    $order->id,
                    $field . ':' . $value,
                    $request->input('note'),
                    auth()->id()
                );
            }
        }

        // Keep inventory in sync with the new statuses
        $stockService = app(\App\Services\StockService::class);
        if ($oldStatuses['payment_status'] !== 'paid' && $newStatuses['payment_status'] === 'paid') {
            $stockService->deductForOrder($order);
        }
        if (! in_array($oldStatuses['status'], ['cancelled', 'refunded'])
            && in_array($newStatuses['status'], ['cancelled', 'refunded'])) {
            $stockService->restoreForOrder($order);
        }

        // SMS notification for meaningful status changes
        if ($oldStatuses != $newStatuses) {
            try {
                $sms = app(\App\Services\Sms\SmsService::class);
                if ($sms->isActive() && $order->phone) {
                    $changes = [];
                    foreach ($newStatuses as $field => $value) {
                        if ($oldStatuses[$field] !== $value) {
                            $changes[] = str_replace('_', ' ', $field) . ' is now ' . str_replace('_', ' ', $value);
                        }
                    }
                    $sms->sendOrderUpdate($order->phone, $order->order_code, implode(', ', $changes), (int) $order->user_id);
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Order update SMS failed', [
                    'order_id' => $order->id,
                    'error'    => $e->getMessage(),
                ]);
            }
        }

        // Send emails only if something actually changed
        if ($oldStatuses != $newStatuses) {
            try {
                (new OrderEmailService())->sendOrderUpdateEmails($order, $oldStatuses, $newStatuses, 'admin');
            } catch (\Throwable $e) {
                Log::warning('Admin order update emails failed: ' . $e->getMessage());
            }
        }

        return redirect()->back()
            ->with('success', 'Order status updated successfully.');
    }
}