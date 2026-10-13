<?php

namespace App\Models\Manage\Shipping;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Town extends Model
{
    use HasFactory;

    protected $table = 'su_towns';

    protected $guarded = [];

    public $timestamps = false;

    // --------------- Relationships ---------------
    public function county()
    {
        return $this->belongsTo(County::class, 'county_id');
    }

    public function locationPricing()
    {
        return $this->hasOne(LocationPricing::class, 'town_id');
    }
}
