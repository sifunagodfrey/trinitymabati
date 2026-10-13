<?php

namespace App\Models\Manage\Media;

use Illuminate\Database\Eloquent\Model;
use App\Models\Manage\Products\Product;
use App\Models\Manage\Products\ProductVariant;

class Media extends Model
{
    protected $table = 'su_media';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'product_id', 'variant_id', 'type', 'file_path', 'caption', 'position'
    ];

    protected $casts = [
        'product_id' => 'integer',
        'variant_id' => 'integer',
        'position' => 'integer',
        'created_at' => 'datetime',
    ];

    // Optional relationships
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}