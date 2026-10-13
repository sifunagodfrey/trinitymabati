<?php

namespace App\Models\Manage\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class ProductReview extends Model
{
    use HasFactory;

    protected $table = 'su_product_reviews';

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'rating' => 'integer',
        ];
    }

    // --------------- Relationships ---------------
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
