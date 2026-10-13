<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class PendingMpesa extends Model
{
    protected $table = 'su_pending_mpesa';
    public $timestamps = false;

    protected $fillable = [
        'checkout_request_id', 'phone', 'amount', 'user_id', 'order_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
