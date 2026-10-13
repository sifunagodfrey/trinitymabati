<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class PendingWalletMpesa extends Model
{
    protected $table = 'su_pending_wallet_mpesa';

    protected $fillable = [
        'user_id', 'checkout_request_id', 'amount', 'phone', 'status',
    ];

    protected $casts = [
        'amount'     => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
