<?php

namespace App\Services;

use App\Models\Manage\Ecommerce\Order;
use App\Models\Manage\Ecommerce\OrderStatusHistory;
use App\Models\Manage\Payments\PaymentLog;
use App\Models\Payment\PaymentTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ManualPaymentService
{
    // Called inside the checkout/order transaction, with the order locked.
    public function submit($order, $method, ?string $reference, ?string $proofPath): PaymentTransaction
    {
        if (!$method->is_manual || !$method->is_active || !$method->isConfigured()) {
            throw ValidationException::withMessages(['payment_method_id' => 'This payment option is unavailable.']);
        }
        if (in_array($order->status, ['cancelled', 'refunded']) || $order->payment_status === 'paid') {
            throw ValidationException::withMessages(['payment_reference' => 'This order cannot accept another payment submission.']);
        }
        $pending = PaymentTransaction::where('order_id', $order->id)->where('is_manual', true)->where('status', 'pending')->exists();
        if ($pending) throw ValidationException::withMessages(['payment_reference' => 'This order already has a payment awaiting review.']);
        $payment = PaymentTransaction::where('order_id', $order->id)->where('is_manual', true)
            ->where('status', 'failed')->orderByDesc('id')->lockForUpdate()->first() ?? new PaymentTransaction();
        $reference = trim((string) $reference);
        $reference = $reference === '' ? null : strtoupper($reference);
        $duplicate = $reference !== null && PaymentTransaction::where('manual_reference', $reference)
            ->when($payment->exists, fn ($query) => $query->where('id', '!=', $payment->id))->exists();
        if ($duplicate) throw ValidationException::withMessages(['payment_reference' => 'This payment reference has already been submitted.']);
        $previous = $payment->exists ? $payment->only(['reference', 'proof_path', 'payment_details', 'method_id', 'amount', 'reviewed_by', 'reviewed_at', 'review_notes']) : null;
        $payment->fill([
            'user_id' => $order->user_id, 'order_id' => $order->id, 'amount' => $order->total,
            'method_id' => $method->id, 'status' => 'pending', 'reference' => $reference,
            'is_manual' => true, 'manual_reference' => $reference, 'proof_path' => $proofPath ?? $payment->proof_path,
            'payment_details' => array_merge($method->config ?? [], ['method_name' => $method->name]),
            'review_notes' => null, 'reviewed_by' => null, 'reviewed_at' => null, 'paid_at' => null,
        ])->save();
        $order->update(['payment_status' => 'pending']);
        PaymentLog::create(['payment_id' => $payment->id, 'status' => 'manual_submitted', 'gateway_response' => [
            'submitted_by' => $order->user_id, 'reference' => $reference, 'previous_review' => $previous,
        ]]);
        OrderStatusHistory::record($order->id, 'payment_status:pending', 'Payment submitted for manual verification', $order->user_id);
        return $payment;
    }

    public function review(int $paymentId, int $reviewerId, bool $approve, ?string $notes): array
    {
        return DB::transaction(function () use ($paymentId, $reviewerId, $approve, $notes) {
            $candidate = PaymentTransaction::findOrFail($paymentId);
            abort_unless($candidate->is_manual, 404);
            $order = Order::whereKey($candidate->order_id)->lockForUpdate()->firstOrFail();
            $payment = PaymentTransaction::whereKey($paymentId)->lockForUpdate()->firstOrFail();
            if ($approve && $payment->status === 'successful') return ['changed' => false, 'order' => $order];
            if (!$approve && $payment->status === 'failed') return ['changed' => false, 'order' => $order];
            if ($payment->status !== 'pending' || $order->payment_status === 'paid'
                || in_array($order->status, ['cancelled', 'refunded'])) {
                throw ValidationException::withMessages(['review' => 'This payment can no longer be reviewed. Refresh the page.']);
            }
            if (number_format((float) $payment->amount, 2, '.', '') !== number_format((float) $order->total, 2, '.', '')) {
                throw ValidationException::withMessages(['review' => 'The recorded payment amount does not match the order total.']);
            }
            $payment->update([
                'status' => $approve ? 'successful' : 'failed', 'paid_at' => $approve ? now() : null,
                'reviewed_by' => $reviewerId, 'reviewed_at' => now(), 'review_notes' => $notes,
            ]);
            $order->update($approve
                ? ['payment_status' => 'paid', 'status' => in_array($order->status, ['pending', 'paid']) ? 'processing' : $order->status, 'admin_confirmed' => true, 'admin_confirmed_at' => now(), 'admin_confirmed_by' => $reviewerId]
                : ['payment_status' => 'failed']);
            if ($approve) {
                app(StockService::class)->deductForOrder($order);
                if ((int) DB::table('su_orders')->where('id', $order->id)->value('stock_deducted') !== 1) {
                    throw ValidationException::withMessages(['review' => 'Inventory could not be updated. Payment approval was not saved; please try again.']);
                }
            }
            PaymentLog::create(['payment_id' => $payment->id, 'status' => $approve ? 'manual_approved' : 'manual_rejected', 'gateway_response' => [
                'reviewed_by' => $reviewerId, 'reference' => $payment->manual_reference, 'notes' => $notes,
            ]]);
            OrderStatusHistory::record($order->id, 'payment_status:' . ($approve ? 'paid' : 'failed'), $notes ?: ($approve ? 'Manual payment approved' : 'Manual payment rejected'), $reviewerId);
            return ['changed' => true, 'order' => $order];
        }, 3);
    }
}
