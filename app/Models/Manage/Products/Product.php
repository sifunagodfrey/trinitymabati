<?php

namespace App\Models\Manage\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'su_products';

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'is_variant'      => 'boolean',
            'allow_custom_length' => 'boolean',
            'default_length_m' => 'decimal:2',
            'default_gauge' => 'string',
            'default_finish' => 'string',
            'is_active'       => 'boolean',
            'is_vat_exempt'   => 'boolean',
            'price'           => 'decimal:2',
            'sale_price'      => 'decimal:2',
            'original_price'  => 'decimal:2',
            'weight'          => 'decimal:2',
            'length'          => 'decimal:2',
            'width'           => 'decimal:2',
            'height'          => 'decimal:2',
        ];
    }

    // --------------- Relationships ---------------
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }



    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function label()
    {
        return $this->belongsTo(Label::class, 'label_id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class, 'product_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'product_id');
    }

    public function flashSale()
    {
        return $this->hasOne(FlashSale::class, 'product_id');
    }

    public function lowStockAlerts()
    {
        return $this->hasMany(\App\Models\Manage\Products\LowStockAlert::class, 'product_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'su_product_category', 'product_id', 'category_id');
    }

    public function labels()
    {
        return $this->belongsToMany(Label::class, 'su_product_label', 'product_id', 'label_id');
    }

}