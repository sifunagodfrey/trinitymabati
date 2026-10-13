<?php

namespace App\Models\Manage\Shipping;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LocationPricing extends Model
{
    use HasFactory;

    protected $table = 'su_location_pricing';

    protected $guarded = [];

    // su_location_pricing has updated_at but no created_at
    const CREATED_AT = null;

    // --------------- Relationships ---------------
    public function town()
    {
        return $this->belongsTo(Town::class, 'town_id');
    }
}
