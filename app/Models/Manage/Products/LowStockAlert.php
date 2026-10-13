<?php

/* -------------------
   Low stock alert model mapped to su_low_stock_alerts. Tracks products
   that fell to or below their stock threshold and notification state.
------------------- */

namespace App\Models\Manage\Products;

use Illuminate\Database\Eloquent\Model;

class LowStockAlert extends Model
{
    protected $table = 'su_low_stock_alerts';

    public $timestamps = false;

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'notified_email' => 'boolean',
            'notified_sms'   => 'boolean',
            'resolved_at'    => 'datetime',
            'created_at'     => 'datetime',
        ];
    }

    // --------------- Relationships ---------------
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
