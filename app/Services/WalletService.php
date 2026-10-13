<?php

namespace App\Services;

use App\Models\Client\Wallet;
use App\Models\Client\WalletTransaction;
use Illuminate\Support\Facades\DB;

class WalletService
{
    // ---------------
    // Get or create a wallet for the given user.
    // Called on first top-up so the record is provisioned lazily.
    // ---------------
    public function getOrCreate(int $userId): Wallet
    {
        return Wallet::firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0, 'currency' => 'KES', 'is_active' => 1]
        );
    }

    // ---------------
    // Credit the wallet - top-ups, refunds, and reversals.
    // Amount is always positive; direction is conveyed by $type.
    //
    // Wrapped in DB::transaction with lockForUpdate so concurrent
    // credits cannot produce a split-brain balance.
    //
    // Idempotency guard: if a WalletTransaction for the same $reference
    // already exists for this user we return silently. This prevents
    // the rare race between the callback and the polling path both
    // trying to credit the same top-up simultaneously.
    // ---------------
    public function credit(
        int    $userId,
        float  $amount,
        string $reference,
        string $description,
        ?int   $orderId = null,
        string $type    = 'credit'
    ): void {
        DB::transaction(function () use ($userId, $amount, $reference, $description, $orderId, $type) {
            // ---------------
            // Idempotency check inside the transaction so two concurrent
            // processes cannot both pass it and double-credit.
            // ---------------
            $alreadyProcessed = WalletTransaction::where('user_id', $userId)
                ->where('reference', $reference)
                ->lockForUpdate()
                ->exists();

            if ($alreadyProcessed) {
                return;
            }

            $wallet = Wallet::where('user_id', $userId)
                ->lockForUpdate()
                ->first();

            if (! $wallet) {
                $wallet = Wallet::create([
                    'user_id'   => $userId,
                    'balance'   => 0,
                    'currency'  => 'KES',
                    'is_active' => 1,
                ]);
            }

            $newBalance      = round((float) $wallet->balance + $amount, 2);
            $wallet->balance = $newBalance;
            $wallet->save();

            WalletTransaction::create([
                'user_id'       => $userId,
                'wallet_id'     => $wallet->id,
                'type'          => $type,
                'amount'        => $amount,
                'balance_after' => $newBalance,
                'reference'     => $reference,
                'description'   => $description,
                'order_id'      => $orderId,
            ]);
        });
    }

    // ---------------
    // Debit the wallet - purchases and withdrawal requests.
    // Throws RuntimeException if balance is insufficient or wallet is frozen.
    // Wrapped in DB::transaction with lockForUpdate.
    // ---------------
    public function debit(
        int     $userId,
        float   $amount,
        string  $description,
        ?int    $orderId   = null,
        ?string $reference = null
    ): void {
        DB::transaction(function () use ($userId, $amount, $description, $orderId, $reference) {
            $wallet = Wallet::where('user_id', $userId)
                ->lockForUpdate()
                ->first();

            if (! $wallet || ! $wallet->is_active) {
                throw new \RuntimeException('Wallet is not available or has been frozen.');
            }

            if ((float) $wallet->balance < $amount) {
                throw new \RuntimeException(
                    'Insufficient wallet balance. Current balance: KES ' . number_format($wallet->balance, 2)
                );
            }

            $newBalance      = round((float) $wallet->balance - $amount, 2);
            $wallet->balance = $newBalance;
            $wallet->save();

            WalletTransaction::create([
                'user_id'       => $userId,
                'wallet_id'     => $wallet->id,
                'type'          => 'debit',
                'amount'        => $amount,
                'balance_after' => $newBalance,
                'reference'     => $reference ?? ('WDR-' . $userId . '-' . date('YmdHis')),
                'description'   => $description,
                'order_id'      => $orderId,
            ]);
        });
    }
}
