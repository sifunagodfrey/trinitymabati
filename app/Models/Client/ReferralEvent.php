<?php

/* -------------------
   Referral event model mapped to su_referral_events. One row per signup
   attributed to a referral code, tracking status and reward issued.
------------------- */

namespace App\Models\Client;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ReferralEvent extends Model
{
    protected $table = 'su_referral_events';

    public $timestamps = false;

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'reward_amount' => 'decimal:2',
            'rewarded_at'   => 'datetime',
            'created_at'    => 'datetime',
        ];
    }

    // --------------- Relationships ---------------
    public function code()
    {
        return $this->belongsTo(ReferralCode::class, 'referral_code_id');
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_user_id');
    }

    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
}
