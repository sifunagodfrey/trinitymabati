<?php

namespace App\Models\Manage\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlashSale extends Model
{
    use HasFactory;

    protected $table = 'su_flash_sales';

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'discount_percentage' => 'decimal:2',
            'start_time'          => 'datetime',
            'end_time'            => 'datetime',
        ];
    }

    // --------------- Relationships ---------------
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
