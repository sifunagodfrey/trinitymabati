<?php

/* -------------------
   Referral code model mapped to su_referral_codes. Each customer owns one
   shareable code used to attribute new signups and rewards.
------------------- */

namespace App\Models\Client;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReferralCode extends Model
{
    protected $table = 'su_referral_codes';

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'reward_value'          => 'decimal:2',
            'referred_reward_value' => 'decimal:2',
            'clicks'                => 'integer',
            'is_active'             => 'boolean',
        ];
    }

    // --------------- Relationships ---------------
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function events()
    {
        return $this->hasMany(ReferralEvent::class, 'referral_code_id');
    }

    // --------------- Helpers ---------------
    public static function generateUniqueCode(): string
    {
        do {
            $code = strtoupper(Str::random(8));
        } while (static::where('code', $code)->exists());

        return $code;
    }

    public function shareUrl(): string
    {
        return route('frontend.referral.visit', ['code' => $this->code]);
    }
}
