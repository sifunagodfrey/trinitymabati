<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Manage\Products\Product;
use App\Models\Manage\Products\ProductVariant;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'su_cart_items';

    protected $guarded = [];

    // ---------------
    // Casts - ensures arithmetic in shipping calculation uses proper numeric types
    // ---------------
    protected function casts(): array
    {
        return [
            'quantity'      => 'integer',
            'price_at_time' => 'float',
            'weight'        => 'float',
            'length'        => 'float',
            'width'         => 'float',
            'height'        => 'float',
        ];
    }

    // ---------------
    // Relationships
    // ---------------
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
