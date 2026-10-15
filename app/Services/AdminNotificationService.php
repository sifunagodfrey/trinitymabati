<?php

namespace App\Services;

use App\Models\Manage\Quotations\Quotation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminNotificationService
{
    // ---------------
    // Quotation submitted by a customer
    // ---------------
    public function quotationSubmitted(Quotation $quotation): void
    {
        $this->attempt(function () use ($quotation) {
            $this->push(
                'New Quotation Request: ' . $quotation->quotation_code,
                implode("\n", [
                    'Customer: ' . $this->quotationCustomer($quotation),
                    'Phone: ' . ($quotation->customer_phone ?: '-'),
                    'Email: ' . ($quotation->customer_email ?: '-'),
                    'Estimated total: ' . $this->money($quotation->total, $quotation->currency),
                ]),
                route('manage.quotations.show', $quotation->id)
            );
        });
    }

    // ---------------
    // Quotation status changed (sent, accepted, rejected, expired)
    // ---------------
    public function quotationStatusChanged(Quotation $quotation, string $old, string $new): void
    {
        $this->attempt(function () use ($quotation, $old, $new) {
            $this->push(
                'Quotation ' . ucfirst($new) . ': ' . $quotation->quotation_code,
                implode("\n", [
                    'Status changed from ' . ucfirst($old) . ' to ' . ucfirst($new) . ' by ' . $this->actorName() . '.',
                    'Customer: ' . $this->quotationCustomer($quotation),
                    'Total: ' . $this->money($quotation->total, $quotation->currency),
                ]),
                route('manage.quotations.show', $quotation->id),
                auth()->id()
            );
        });
    }

    // ---------------
    // Quotation converted to an order
    // ---------------
    public function quotationConverted(Quotation $quotation, $order): void
    {
        $this->attempt(function () use ($quotation, $order) {
            $this->push(
                'Quotation Converted to Order: ' . $quotation->quotation_code,
                implode("\n", [
                    $quotation->quotation_code . ' was converted to order ' . $order->order_code . ' by ' . $this->actorName() . '.',
                    'Customer: ' . $this->quotationCustomer($quotation),
                    'Total: ' . $this->money($order->total, $quotation->currency),
                ]),
                route('manage.ecommerce.orders.show', $order->id),
                auth()->id()
            );
        });
    }

    // ---------------
    // New order placed
    // ---------------
    public function orderPlaced($order): void
    {
        $this->attempt(function () use ($order) {
            $this->push(
                'New Order: ' . $order->order_code,
                implode("\n", [
                    'Customer: ' . $this->orderCustomer($order),
                    'Phone: ' . ($order->phone ?: '-'),
                    'Total: ' . $this->money($order->total, $order->currency ?? null),
                    'Payment status: ' . ucwords(str_replace('_', ' ', $order->payment_status ?: 'pending')),
                ]),
                route('manage.ecommerce.orders.show', $order->id)
            );
        });
    }

    // ---------------
    // Cash on delivery order confirmed (admins)
    // ---------------
    public function codOrderPlaced($order): void
    {
        $this->attempt(function () use ($order) {
            $this->push(
                'COD Order Confirmed: ' . $order->order_code,
                implode("\n", [
                    'Customer: ' . $this->orderCustomer($order),
                    'Phone: ' . ($order->phone ?: '-'),
                    'Total to collect: ' . $this->money($order->total, $order->currency ?? null),
                    'Stock has been reserved. Dispatch and collect cash on delivery.',
                ]),
                route('manage.ecommerce.orders.show', $order->id)
            );
        });
    }

    // ---------------
    // Cash on delivery order confirmed (the customer's own Messages inbox)
    // ---------------
    public function codOrderForCustomer($order): void
    {
        $this->attempt(function () use ($order) {
            DB::table('su_system_messages')->insert([
                'sender_id'    => null,
                'recipient_id' => $order->user_id,
                'subject'      => 'Order ' . $order->order_code . ' confirmed',
                'message'      => 'Your order is confirmed. Please have ' . $this->money($order->total, $order->currency ?? null) . ' ready to pay in cash on delivery.',
                'related_url'  => route('client.orders.show', $order->id),
                'is_read'      => 0,
                'is_user_read' => 0,
                'created_at'   => now(),
            ]);
        });
    }

    // ---------------
    // Payment received
    // ---------------
    public function paymentReceived($order): void
    {
        $this->attempt(function () use ($order) {
            $this->push(
                'Payment Received: Order ' . $order->order_code,
                implode("\n", [
                    'Customer: ' . $this->orderCustomer($order),
                    'Amount: ' . $this->money($order->total, $order->currency ?? null),
                ]),
                route('manage.ecommerce.orders.show', $order->id)
            );
        });
    }

    // ---------------
    // Payment failed or timed out
    // ---------------
    public function paymentFailed($order, string $reason = ''): void
    {
        $this->attempt(function () use ($order, $reason) {
            $this->push(
                'Payment Failed: Order ' . $order->order_code,
                implode("\n", [
                    'Customer: ' . $this->orderCustomer($order),
                    'Amount: ' . $this->money($order->total, $order->currency ?? null),
                    'Reason: ' . ($reason ?: 'The payment could not be completed.'),
                ]),
                route('manage.ecommerce.orders.show', $order->id)
            );
        });
    }

    // ---------------
    // Insert one broadcast row (visible to all admins in Messages).
    // Skips an identical notice raised in the last 2 minutes.
    // ---------------
    private function push(string $subject, string $message, ?string $relatedUrl = null, ?int $senderId = null): void
    {
        $duplicate = DB::table('su_system_messages')
            ->where('subject', $subject)
            ->where('related_url', $relatedUrl)
            ->where('created_at', '>=', now()->subMinutes(2))
            ->exists();

        if ($duplicate) {
            return;
        }

        DB::table('su_system_messages')->insert([
            'sender_id'    => $senderId,
            'recipient_id' => null,
            'subject'      => $subject,
            'message'      => $message,
            'related_url'  => $relatedUrl,
            'is_read'      => 0,
            'is_user_read' => 0,
            'created_at'   => now(),
        ]);
    }

    // ---------------
    // Never let a notification failure break checkout, payment or quotations
    // ---------------
    private function attempt(callable $build): void
    {
        try {
            $build();
        } catch (\Throwable $e) {
            Log::warning('AdminNotificationService failed', ['error' => $e->getMessage()]);
        }
    }

    private function quotationCustomer(Quotation $quotation): string
    {
        return trim($quotation->customer_first_name . ' ' . $quotation->customer_last_name) ?: 'Customer';
    }

    private function orderCustomer($order): string
    {
        $order->loadMissing('user');

        return trim(($order->user?->first_name ?? '') . ' ' . ($order->user?->last_name ?? '')) ?: 'Customer';
    }

    private function actorName(): string
    {
        $user = auth()->user();

        return $user ? trim($user->first_name . ' ' . $user->last_name) : 'System';
    }

    private function money($amount, ?string $currency = null): string
    {
        return ($currency ?: 'KES') . ' ' . number_format((float) $amount, 2);
    }
}