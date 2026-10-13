<?php

/* -------------------
   Coupon model mapped to su_discounts. Holds promotional discount codes
   with type, value, usage limits and validity dates.
------------------- */

namespace App\Models\Manage\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $table = 'su_discounts';

    public $timestamps = false;

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'value'       => 'decimal:2',
            'usage_limit' => 'integer',
            'used_count'  => 'integer',
            'start_date'  => 'date',
            'end_date'    => 'date',
            'created_at'  => 'datetime',
        ];
    }

    // --------------- Scope: currently usable codes ---------------
    public function scopeUsable($query)
    {
        return $query->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhereDate('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')->orWhereColumn('used_count', '<', 'usage_limit');
            });
    }
}
