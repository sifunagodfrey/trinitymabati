<?php

namespace App\Models\Manage\Loyalty;

use Illuminate\Database\Eloquent\Model;

class LoyaltySetting extends Model
{
    protected $table = 'su_loyalty_settings';

    protected $fillable = [
        'loyalty_enabled',
        'kes_per_point',
        'redemption_rate',
        'min_redeem_points',
    ];
}
