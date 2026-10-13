<?php

namespace App\Models\Manage\Loyalty;

use Illuminate\Database\Eloquent\Model;

class LoyaltyTier extends Model
{
    protected $table = 'su_loyalty_tiers';

    // ---------------
    // su_loyalty_tiers has no updated_at column
    // ---------------
    public const UPDATED_AT = null;

    protected $fillable = [
        'name',
        'min_points',
        'discount_percent',
        'points_multiplier',
        'badge_icon',
        'is_active',
    ];
}
