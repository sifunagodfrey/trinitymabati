<?php

namespace App\Models\Manage\Loyalty;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LoyaltyTransaction extends Model
{
    protected $table = 'su_loyalty_transactions';

    // ---------------
    // su_loyalty_transactions has created_at but no updated_at
    // ---------------
    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'order_id',
        'type',
        'points',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
