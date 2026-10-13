<?php

namespace App\Models\Client;

use App\Models\Manage\Products\ProductVariant;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // ---------------
    // Table
    // ---------------
    protected $table = 'su_order_items';

    public $timestamps = false;

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
