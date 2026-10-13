<?php

namespace App\Models\Manage\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttributeValue extends Model
{
    use HasFactory;

    protected $table = 'su_product_attribute_values';

    protected $guarded = [];

    public $timestamps = false;

    // --------------- Relationships ---------------
    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'attribute_id');
    }

    public function variants()
    {
        return $this->belongsToMany(
            ProductVariant::class,
            'su_product_variant_attributes',
            'attribute_value_id',
            'variant_id'
        );
    }
}
