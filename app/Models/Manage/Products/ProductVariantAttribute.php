<?php

namespace App\Models\Manage\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariantAttribute extends Model
{
    use HasFactory;

    protected $table = 'su_product_variant_attributes';

    protected $guarded = [];

    public $timestamps = false;

    // --------------- Relationships ---------------
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'attribute_id');
    }

    public function attributeValue()
    {
        return $this->belongsTo(ProductAttributeValue::class, 'attribute_value_id');
    }
}
