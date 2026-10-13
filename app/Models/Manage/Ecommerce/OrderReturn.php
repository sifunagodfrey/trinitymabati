<?php

namespace App\Models\Manage\Ecommerce;

use App\Models\User;
use App\Models\Manage\Products\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderReturn extends Model
{
    use HasFactory;

    protected $table = 'su_order_returns';

    protected $guarded = [];

    // ---------------
    // Table has no updated_at column
    // ---------------
    const UPDATED_AT = null;

    // ---------------
    // Relationships
    // ---------------
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}