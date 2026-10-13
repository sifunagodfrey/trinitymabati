<?php

/* -------------------
   SMS settings model mapped to su_sms_settings. Holds the Africa's Talking
   credentials, sender id, environment and the on/off switch for SMS.
------------------- */

namespace App\Models\Manage\System;

use Illuminate\Database\Eloquent\Model;

class SmsSetting extends Model
{
    protected $table = 'su_sms_settings';

    public $timestamps = false;

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'is_active'  => 'boolean',
            'updated_at' => 'datetime',
        ];
    }
}
