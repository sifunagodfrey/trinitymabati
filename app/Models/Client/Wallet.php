<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Wallet extends Model
{
    protected $table = 'su_wallets';

    protected $fillable = ['user_id', 'balance', 'currency', 'is_active'];

    protected $casts = [
        'balance'    => 'decimal:2',
        'is_active'  => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class)->orderByDesc('created_at');
    }
}
