<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Client\Wallet;
use App\Models\Client\WalletTransaction;
use App\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletController extends Controller
{
    // ---------------
    // List all customer wallets with search and status filter.
    // Joins su_users so we can search by name / email without loading
    // all rows into PHP.
    // ---------------
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));
        $status = $request->input('status', '');

        $query = DB::table('su_wallets as w')
            ->join('su_users as u', 'u.id', '=', 'w.user_id')
            ->select(
                'w.id',
                'w.user_id',
                'w.balance',
                'w.currency',
                'w.is_active',
                'w.created_at',
                'w.updated_at',
                DB::raw("CONCAT(u.first_name, ' ', u.last_name) as user_name"),
                'u.email'
            )
            ->orderByDesc('w.updated_at');

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($q) use ($like) {
                $q->where('u.first_name', 'like', $like)
                  ->orWhere('u.last_name', 'like', $like)
                  ->orWhere('u.email', 'like', $like);
            });
        }

        if ($status === 'active') {
            $query->where('w.is_active', 1);
        } elseif ($status === 'frozen') {
            $query->where('w.is_active', 0);
        }

        $wallets = $query->paginate(25)->withQueryString();

        return view('manage.wallet.index', compact('wallets', 'search', 'status'));
    }

    // ---------------
    // Show a single wallet with its full transaction history.
    // ---------------
    public function show(int $id)
    {
        $wallet = DB::table('su_wallets as w')
            ->join('su_users as u', 'u.id', '=', 'w.user_id')
            ->select(
                'w.id',
                'w.user_id',
                'w.balance',
                'w.currency',
                'w.is_active',
                'w.created_at',
                'w.updated_at',
                DB::raw("CONCAT(u.first_name, ' ', u.last_name) as user_name"),
                'u.email'
            )
            ->where('w.id', $id)
            ->first();

        abort_if(! $wallet, 404);

        $transactions = DB::table('su_wallet_transactions')
            ->where('wallet_id', $id)
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('manage.wallet.show', compact('wallet', 'transactions'));
    }

    // ---------------
    // Toggle wallet active / frozen status.
    // ---------------
    public function freeze(int $id)
    {
        $wallet = Wallet::findOrFail($id);
        $wallet->is_active = ! $wallet->is_active;
        $wallet->save();

        $label = $wallet->is_active ? 'unfrozen' : 'frozen';

        return redirect()
            ->route('manage.wallet.show', $id)
            ->with('success', 'Wallet has been ' . $label . ' successfully.');
    }

    // ---------------
    // Show manual credit / debit form for a given wallet.
    // ---------------
    public function showAdjust(int $id)
    {
        $wallet = DB::table('su_wallets as w')
            ->join('su_users as u', 'u.id', '=', 'w.user_id')
            ->select(
                'w.id',
                'w.user_id',
                'w.balance',
                'w.currency',
                'w.is_active',
                DB::raw("CONCAT(u.first_name, ' ', u.last_name) as user_name"),
                'u.email'
            )
            ->where('w.id', $id)
            ->first();

        abort_if(! $wallet, 404);

        return view('manage.wallet.adjust', compact('wallet'));
    }

    // ---------------
    // Apply a manual credit or debit to the wallet.
    // Uses WalletService so the same atomic transaction + idempotency
    // logic is enforced for admin adjustments.
    // ---------------
    public function applyAdjustment(Request $request, int $id, WalletService $walletService)
    {
        $request->validate([
            'type'        => ['required', 'in:credit,debit'],
            'amount'      => ['required', 'numeric', 'min:1'],
            'description' => ['required', 'string', 'max:255'],
        ]);

        $wallet = Wallet::findOrFail($id);

        $type        = $request->input('type');
        $amount      = (float) $request->input('amount');
        $description = $request->input('description');
        $reference   = 'ADJ-' . $id . '-' . now()->format('YmdHis');

        try {
            if ($type === 'credit') {
                $walletService->credit(
                    $wallet->user_id,
                    $amount,
                    $reference,
                    $description,
                    null,
                    'credit'
                );
            } else {
                $walletService->debit(
                    $wallet->user_id,
                    $amount,
                    $description,
                    null,
                    $reference
                );
            }
        } catch (\Throwable $e) {
            Log::warning('Admin wallet adjustment failed: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors($e->getMessage())
                ->withInput();
        }

        return redirect()
            ->route('manage.wallet.show', $id)
            ->with('success', ucfirst($type) . ' of KES ' . number_format($amount, 2) . ' applied successfully.');
    }
}
