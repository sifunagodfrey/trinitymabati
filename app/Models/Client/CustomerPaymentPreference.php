<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Payment\PaymentMethod;

class CustomerPaymentPreference extends Model
{
    protected $table = 'su_customer_payment_preferences';

    protected $fillable = [
        'user_id',
        'payment_method_id',
    ];

    public $timestamps = true; // uses created_at & updated_at

    // ---------------
    // Relationships
    // ---------------
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}