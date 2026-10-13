<?php

namespace App\Models\Manage\System;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = 'su_newsletters';

    // su_newsletters has no updated_at column
    const UPDATED_AT = null;

    protected $guarded = [];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'created_at'   => 'datetime',
    ];
}