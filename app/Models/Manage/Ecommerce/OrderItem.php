<?php

namespace App\Models\Manage\Ecommerce;

use App\Models\Manage\Products\Product;
use App\Models\Manage\Products\ProductVariant;
use Illuminate\Database\Eloquent\Model;


class OrderItem extends Model
{
    protected $table = 'su_order_items';

    protected $guarded = [];

    // ---------------
    // su_order_items has only created_at, not updated_at
    // ---------------
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    // ---------------
    // Return stored label, or compute it from the loaded variant relation so that
    // historical orders (where variant_label was never saved) still show the variant.
    // ---------------
    public function getVariantLabelAttribute($value): ?string
    {
        if ($value) {
            return $value;
        }

        if (!$this->variant_id || !$this->relationLoaded('variant') || !$this->variant) {
            return null;
        }

        $parts = $this->variant->variantAttributes
            ->map(fn ($va) => optional($va->attributeValue)->value)
            ->filter()
            ->values();

        return $parts->isNotEmpty()
            ? $parts->implode(' / ')
            : ($this->variant->variant_code ?: null);
    }
}
