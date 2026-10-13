<?php

namespace App\Models\Manage\Payments;

use Illuminate\Database\Eloquent\Model;
use App\Models\Payment\PaymentTransaction;

class PaymentLog extends Model
{
    protected $table = 'su_payment_logs';
    public $timestamps = false;

    protected $fillable = ['payment_id', 'gateway_response', 'status'];

    protected $casts = [
        'gateway_response' => 'array',
        'created_at' => 'datetime'
    ];

    public function payment()
    {
        return $this->belongsTo(PaymentTransaction::class, 'payment_id');
    }
}