<?php

/* -------------------
   SMS log model mapped to su_sms_logs. One row per outbound SMS with the
   delivery status, provider message id, cost and any error returned.
------------------- */

namespace App\Models\Manage\System;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $table = 'su_sms_logs';

    public $timestamps = false;

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    // --------------- Relationships ---------------
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
