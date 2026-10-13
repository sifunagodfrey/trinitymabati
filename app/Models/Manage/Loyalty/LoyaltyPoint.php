<?php

namespace App\Models\Manage\Loyalty;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    protected $table = 'su_loyalty_points';

    // ---------------
    // su_loyalty_points has updated_at but no created_at
    // ---------------
    public const CREATED_AT = null;

    protected $fillable = [
        'user_id',
        'tier_id',
        'points_balance',
        'lifetime_points',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tier()
    {
        return $this->belongsTo(LoyaltyTier::class, 'tier_id');
    }
}
