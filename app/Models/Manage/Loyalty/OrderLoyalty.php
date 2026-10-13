<?php

namespace App\Models\Manage\Loyalty;

use Illuminate\Database\Eloquent\Model;

class OrderLoyalty extends Model
{
    protected $table = 'su_order_loyalty';

    protected $fillable = [
        'order_id',
        'user_id',
        'points_earned',
        'points_redeemed',
        'discount_amount',
    ];
}
