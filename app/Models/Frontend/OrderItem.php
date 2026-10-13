<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Manage\Products\Product;
use App\Models\Manage\Products\ProductVariant;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'su_order_items';

    protected $guarded = [];

    // ---------------
    // su_order_items has no updated_at column (total is a GENERATED column)
    // ---------------
    const UPDATED_AT = null;

    // ---------------
    // Relationships
    // ---------------
    public function order()
    {
        return $this->belongsTo(Order::class);
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
