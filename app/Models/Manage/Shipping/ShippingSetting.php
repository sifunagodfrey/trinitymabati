<?php

namespace App\Models\Manage\Shipping;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingSetting extends Model
{
    use HasFactory;

    protected $table = 'su_shipping_settings';

    protected $guarded = [];

    // su_shipping_settings has created_at but no updated_at
    const UPDATED_AT = null;
}