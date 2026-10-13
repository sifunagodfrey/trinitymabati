<?php

namespace App\Models\Client;

use App\Models\Manage\Products\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    // ---------------
    // Table & Timestamps
    // ---------------
    protected $table = 'su_wishlists';

    const UPDATED_AT = null;

    // ---------------
    // Mass Assignable
    // ---------------
    protected $fillable = [
        'user_id',
        'product_id',
        'variation_id',
    ];

    // ---------------
    // Relationships
    // ---------------
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
