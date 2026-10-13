<?php

namespace App\Models\Manage\System;

use Illuminate\Database\Eloquent\Model;

class Vat extends Model
{
    protected $table = 'su_vat';

    // ---------------
    // su_vat has no updated_at column
    // ---------------
    public const UPDATED_AT = null;

    protected $fillable = ['rate', 'start_date', 'end_date', 'is_active'];
}
