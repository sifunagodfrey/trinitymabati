<?php

namespace App\Models\Manage\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Media extends Model
{
    use HasFactory;

    protected $table = 'su_media';

    protected $guarded = [];

    public $timestamps = false;
    
    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'position' => 'integer',
        ];
    }

    // --------------- Relationships ---------------
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
