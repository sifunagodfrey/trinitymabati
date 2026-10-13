<?php

namespace App\Models\Manage\Shipping;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class County extends Model
{
    use HasFactory;

    protected $table = 'su_counties';

    protected $guarded = [];

    public $timestamps = false;

    // --------------- Relationships ---------------
    public function towns()
    {
        return $this->hasMany(\App\Models\Manage\Shipping\Town::class, 'county_id');
    }
}
