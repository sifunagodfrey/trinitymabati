<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use App\Models\Frontend\Product;
use App\Models\User;

class ProductReview extends Model
{
    protected $table = 'su_product_reviews';
    protected $fillable = ['product_id', 'user_id', 'rating', 'comment', 'status'];
    public $timestamps = false; // uses created_at only

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scope for approved reviews (if needed)
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}