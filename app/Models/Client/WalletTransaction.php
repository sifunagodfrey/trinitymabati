<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class WalletTransaction extends Model
{
    protected $table = 'su_wallet_transactions';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'wallet_id', 'type', 'amount', 'balance_after',
        'reference', 'description', 'order_id',
    ];

    protected $casts = [
        'amount'        => 'decimal:2',
        'balance_after' => 'decimal:2',
        'created_at'    => 'datetime',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
