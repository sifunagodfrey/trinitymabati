<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\WalletTopupRequest;
use App\Http\Requests\Client\WalletWithdrawRequest;
use App\Models\Client\Wallet;
use App\Models\Client\WalletTransaction;
use App\Models\Payment\PendingWalletMpesa;
use App\Models\User;
use App\Services\Payment\MpesaService;
use App\Services\WalletEmailService;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    // ---------------
    // Wallet overview - balance card + last 10 transactions
    // ---------------
    public function index()
    {
        $userId = Auth::id();
        $wallet = Wallet::where('user_id', $userId)->first();
        $recent = WalletTransaction::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('client.wallet.index', compact('wallet', 'recent'));
    }

    // ---------------
    // Top-up form
    // ---------------
    public function topup()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();

        return view('client.wallet.topup', compact('wallet'));
    }

    // ---------------
    // Initiate Mpesa STK push for wallet top-up
    // Route: POST /account/wallet/topup/mpesa  (AJAX)
    // ---------------
    public function initiateTopupMpesa(WalletTopupRequest $request)
    {
        try {
            $response = app(MpesaService::class)->initiateWalletTopup(
                $request->phone,
                (float) $request->amount,
                Auth::id()
            );

            $cid = $response['CheckoutRequestID'] ?? null;

            if (! $cid) {
                return response()->json([
                    'success' => false,
                    'message' => 'M-Pesa did not return a checkout request ID. Please try again.',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'cid'     => $cid,
                'gateway' => 'mpesa',
                'message' => 'STK push sent. Enter your M-Pesa PIN to top up your wallet.',
            ]);
        } catch (\Exception $e) {
            Log::error('Wallet Mpesa top-up initiation failed', [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
            ]);

            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // ---------------
    // Poll top-up status (AJAX) - called every 5 s by the topup view.
    // Mirrors the dual-path strategy from MpesaController::pollStatus():
    //   1. check local pending record status (set by callback)
    //   2. if still pending, query the gateway directly
    // Route: GET /account/wallet/topup/poll?cid=...&gateway=mpesa
    // ---------------
    public function pollTopupStatus(Request $request)
    {
        $request->validate([
            'cid'     => 'required|string',
            'gateway' => 'required|in:mpesa',
        ]);

        $cid    = $request->query('cid');
        $userId = Auth::id();

        return $this->pollMpesaTopup($cid, $userId);
    }

    // ---------------
    // Report a top-up timeout - frontend JS calls this after 90 s with no confirmation.
    // Route: POST /account/wallet/topup/timeout  (AJAX)
    // ---------------
    public function reportTopupTimeout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'cid'     => 'required|string',
            'gateway' => 'required|in:mpesa',
        ]);

        $cid    = $request->input('cid');
        $userId = Auth::id();

        $pending = PendingWalletMpesa::where('checkout_request_id', $cid)
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->first();

        if (! $pending) {
            return response()->json(['recorded' => false]);
        }

        $pending->update(['status' => 'failed']);

        $this->sendTopupFailedEmail(
            $userId,
            (float) $pending->amount,
            'No confirmation received within 90 seconds. Please try again.'
        );

        Log::warning('Wallet top-up timed out on polling screen', [
            'cid'     => $cid,
            'gateway' => 'mpesa',
            'user_id' => $userId,
        ]);

        return response()->json(['recorded' => true]);
    }

    // ---------------
    // Full paginated transaction history
    // Route: GET /account/wallet/transactions
    // ---------------
    public function transactions()
    {
        $userId = Auth::id();
        $wallet = Wallet::where('user_id', $userId)->first();

        $transactions = WalletTransaction::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('client.wallet.transactions', compact('wallet', 'transactions'));
    }

    // ---------------
    // Withdrawal request form
    // Route: GET /account/wallet/withdraw
    // ---------------
    public function withdraw()
    {
        $wallet = Wallet::where('user_id', Auth::id())->first();

        return view('client.wallet.withdraw', compact('wallet'));
    }

    // ---------------
    // Process withdrawal request.
    // Debits the wallet immediately so the balance cannot be double-spent
    // while the request awaits admin processing.
    // Route: POST /account/wallet/withdraw
    // ---------------
    public function processWithdraw(WalletWithdrawRequest $request)
    {
        $userId = Auth::id();
        $amount = (float) $request->amount;
        $method = $request->method;

        // ---------------
        // Server-side balance check before calling debit -
        // WalletService::debit() also checks inside the transaction,
        // but this gives a user-friendly redirect rather than an exception.
        // ---------------
        $wallet = Wallet::where('user_id', $userId)->first();

        if (! $wallet || (float) $wallet->balance < $amount) {
            return redirect()->back()
                ->withErrors(['amount' => 'Insufficient wallet balance.'])
                ->withInput();
        }

        $details = $method === 'Mpesa'
            ? 'Mpesa ' . $request->phone
            : 'Bank Transfer - ' . $request->bank_name . ' / ' . $request->account_number;

        $reference = 'WDR-' . $userId . '-' . date('YmdHis');

        try {
            app(WalletService::class)->debit(
                $userId,
                $amount,
                'Withdrawal requested: ' . $details,
                null,
                $reference
            );
        } catch (\RuntimeException $e) {
            return redirect()->back()
                ->withErrors(['amount' => $e->getMessage()])
                ->withInput();
        }

        try {
            app(WalletEmailService::class)->sendWithdrawSubmitted(Auth::user(), $amount, $method);
        } catch (\Throwable $e) {
            Log::warning('Wallet withdraw email failed', [
                'user_id' => $userId,
                'error'   => $e->getMessage(),
            ]);
        }

        return redirect()->route('client.wallet.index')
            ->with('success', 'Withdrawal request submitted (ref: ' . $reference . '). Processing takes 1–2 business days.');
    }

    // ---------------
    // Poll Mpesa wallet top-up status.
    // ---------------
    private function pollMpesaTopup(string $cid, int $userId): \Illuminate\Http\JsonResponse
    {
        $pending = PendingWalletMpesa::where('checkout_request_id', $cid)
            ->where('user_id', $userId)
            ->first();

        if (! $pending) {
            return response()->json(['status' => 'pending']);
        }

        if ($pending->status === 'completed') {
            return response()->json(['status' => 'successful']);
        }
        if ($pending->status === 'failed') {
            return response()->json(['status' => 'failed', 'reason' => 'Payment was not completed.']);
        }

        // ---------------
        // Still pending - query Safaricom directly so we don't depend solely
        // on the callback. Same pattern as MpesaController::pollStatus().
        // ---------------
        try {
            $result     = app(MpesaService::class)->queryStatus($cid);
            $resultCode = $result['ResultCode'] ?? null;
            $resultDesc = $result['ResultDesc'] ?? 'Payment was not completed.';

            if ($resultCode === 0 || $resultCode === '0') {
                // ---------------
                // Re-check before crediting - the callback may have already
                // processed this while we were querying Safaricom.
                // WalletService::credit() also has an idempotency guard on
                // $cid as reference, so a double-call is safe.
                // ---------------
                $pending->refresh();
                if ($pending->status === 'completed') {
                    return response()->json(['status' => 'successful']);
                }

                app(WalletService::class)->credit(
                    $userId,
                    (float) $pending->amount,
                    $cid,
                    'Top-up via M-Pesa'
                );
                $pending->update(['status' => 'completed']);
                $this->sendTopupSuccessEmail($userId, (float) $pending->amount, $cid);

                return response()->json(['status' => 'successful']);
            }

            // Safaricom says still processing - stay pending
            if (str_contains(strtolower((string) $resultDesc), 'being processed')
                || str_contains(strtolower((string) $resultDesc), 'transaction is pending')) {
                return response()->json(['status' => 'pending']);
            }

            // Race-condition guard - callback may have just arrived
            $pending->refresh();
            if ($pending->status === 'completed') {
                return response()->json(['status' => 'successful']);
            }

            // ---------------
            // Only treat as definitive failure on unambiguous codes:
            //   1032 = cancelled by user, 2001 = wrong PIN,
            //   1019 = expired, 1037 = DS timeout
            // ---------------
            $definitiveFailureCodes = ['1032', '2001', '1019', '1037'];
            if (! in_array((string) $resultCode, $definitiveFailureCodes)) {
                return response()->json(['status' => 'pending']);
            }

            $pending->update(['status' => 'failed']);
            $this->sendTopupFailedEmail($userId, (float) $pending->amount, $resultDesc);

            return response()->json(['status' => 'failed', 'reason' => $resultDesc]);

        } catch (\Throwable $e) {
            Log::warning('Wallet: Mpesa direct status query failed during polling', [
                'cid'   => $cid,
                'error' => $e->getMessage(),
            ]);
        }

        return response()->json(['status' => 'pending']);
    }

    // ---------------
    // Send top-up success email - wrapped so failures never break the payment flow
    // ---------------
    private function sendTopupSuccessEmail(int $userId, float $amount, string $reference): void
    {
        try {
            $user       = User::find($userId);
            $newBalance = (float) Wallet::where('user_id', $userId)->value('balance');

            if ($user) {
                app(WalletEmailService::class)->sendTopupSuccess($user, $amount, $newBalance, $reference);
            }
        } catch (\Throwable $e) {
            Log::warning('Wallet top-up success email failed', [
                'user_id' => $userId,
                'error'   => $e->getMessage(),
            ]);
        }
    }

    // ---------------
    // Send top-up failed email - wrapped so failures never break the payment flow
    // ---------------
    private function sendTopupFailedEmail(int $userId, float $amount, string $reason): void
    {
        try {
            $user = User::find($userId);
            if ($user) {
                app(WalletEmailService::class)->sendTopupFailed($user, $amount, $reason);
            }
        } catch (\Throwable $e) {
            Log::warning('Wallet top-up failed email failed', [
                'user_id' => $userId,
                'error'   => $e->getMessage(),
            ]);
        }
    }
}
