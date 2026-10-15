<?php

namespace App\Http\Controllers\Manage\Payments;

use App\Http\Controllers\Controller;
use App\Models\Payment\PaymentTransaction;
use Illuminate\Support\Facades\DB;

class TransactionsController extends Controller
{
    // ---------------
    // Paginated view over order payments recorded in su_payments.
    // su_payments rows with order_id = 0 are excluded - those are ghost records
    // created by the Mpesa callback for unrelated STK pushes.
    // ---------------
    public function index()
    {
        // ---------------
        // Source 1: standard e-commerce order payments
        // ---------------
        $standardSql = "
            SELECT
                p.id,
                'order'                                                                     AS source,
                'Order Payment'                                                             AS type_label,
                COALESCE(p.reference, CONCAT('PMT-', p.id))                                AS reference,
                COALESCE(o.order_code, '')                                                  AS order_ref,
                TRIM(CONCAT(COALESCE(u.first_name,''), ' ', COALESCE(u.last_name,'')))     AS user_name,
                COALESCE(u.email, '')                                                       AS user_email,
                p.amount,
                COALESCE(m.name, 'Unknown')                                                 AS method_name,
                CASE p.status
                    WHEN 'successful' THEN 'paid'
                    ELSE p.status
                END                                                                         AS status_normalized,
                p.created_at
            FROM su_payments p
            LEFT JOIN su_users u           ON p.user_id   = u.id
            LEFT JOIN su_payment_methods m ON p.method_id = m.id
            LEFT JOIN su_orders o          ON p.order_id  = o.id
            WHERE p.order_id > 0
        ";

        // ---------------
        // Paginate the result set
        // ---------------
        $transactions = DB::table(DB::raw("({$standardSql}) as all_transactions"))
            ->orderByDesc('created_at')
            ->paginate(25);

        return view('manage.payments.transactions.index', compact('transactions'));
    }

    // ---------------
    // Detail view - scoped to su_payments which has the richest linked data
    // ---------------
    public function show(int $id)
    {
        $transaction = PaymentTransaction::with(['user', 'order', 'method', 'logs'])
            ->findOrFail($id);

        $reviewer = $transaction->reviewed_by ? \App\Models\User::find($transaction->reviewed_by) : null;
        return view('manage.payments.transactions.show', compact('transaction', 'reviewer'));
    }

    public function approve(\Illuminate\Http\Request $request, int $id)
    {
        $data = $request->validate(['review_notes' => ['nullable', 'string', 'max:2000']]);
        $result = app(\App\Services\ManualPaymentService::class)->review($id, (int) auth()->id(), true, $data['review_notes'] ?? null);
        if ($result['changed']) {
            try { app(\App\Services\OrderEmailService::class)->sendPaymentSuccessToClient($result['order']); }
            catch (\Throwable $exception) { \Illuminate\Support\Facades\Log::warning('Manual payment email failed', ['payment_id' => $id, 'error' => $exception->getMessage()]); }
        }
        return back()->with('success', $result['changed'] ? 'Payment approved and order marked paid.' : 'This payment was already approved.');
    }

    public function reject(\Illuminate\Http\Request $request, int $id)
    {
        $data = $request->validate(['review_notes' => ['required', 'string', 'max:2000']]);
        $result = app(\App\Services\ManualPaymentService::class)->review($id, (int) auth()->id(), false, $data['review_notes']);
        if ($result['changed']) {
            try { app(\App\Services\OrderEmailService::class)->sendPaymentFailedToClient($result['order'], $data['review_notes']); }
            catch (\Throwable $exception) { \Illuminate\Support\Facades\Log::warning('Manual payment rejection email failed', ['payment_id' => $id, 'error' => $exception->getMessage()]); }
        }
        return back()->with('success', $result['changed'] ? 'Payment rejected. The customer can correct and resubmit the details.' : 'This payment was already rejected.');
    }

    public function proof(int $id)
    {
        $payment = PaymentTransaction::findOrFail($id);
        abort_unless($payment->is_manual && $payment->proof_path && str_starts_with($payment->proof_path, 'payment-proofs/') && !str_contains($payment->proof_path, '..'), 404);
        $disk = \Illuminate\Support\Facades\Storage::disk('local');
        abort_unless($disk->exists($payment->proof_path), 404);
        return $disk->download($payment->proof_path);
    }
}
