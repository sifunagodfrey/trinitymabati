<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;
use App\Models\Manage\Payments\PaymentLog;
use App\Models\Manage\Payments\PaymentMethod;
use App\Models\Manage\Ecommerce\Order;
use App\Models\User;

class PaymentTransaction extends Model
{
    protected $table = 'su_payments';
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'order_id', 'amount', 'method_id', 'status',
        'reference', 'paid_at', 'order_type',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'created_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function method()
    {
        return $this->belongsTo(PaymentMethod::class, 'method_id');
    }

    public function logs()
    {
        return $this->hasMany(PaymentLog::class, 'payment_id');
    }

    public function markSuccessful($receipt = null)
    {
        $this->update([
            'status'    => 'successful',
            'reference' => $receipt,
            'paid_at'   => now(),
        ]);
        if ($this->order) {
            $this->order->update(['payment_status' => 'paid']);
        }
    }

    public function markFailed()
    {
        $this->update(['status' => 'failed']);
        if ($this->order) {
            $this->order->update(['payment_status' => 'failed']);
        }
    }
}