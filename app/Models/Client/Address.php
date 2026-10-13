<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    // ---------------
    // Table Configuration
    // ---------------
    protected $table = 'su_user_profiles';

    protected $fillable = [
        'user_id',
        'county',
        'delivery_location',
    ];
}
