<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    // ============================================================
    // TABLE - uses su_ prefix as per project convention
    // ============================================================

    protected $table = 'su_products';

    // ============================================================
    // FILLABLE
    // ============================================================

    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'brand_id',
        'label_id',
        'sku',
        'price',
        'sale_price',
        'cost_price',
        'currency',
        'stock_quantity',
        'is_variant',
        'weight',
        'length',
        'width',
        'height',
        'is_active',
        'thumbnail',
        'views',
        'short_description',
        'detailed_description',
        'is_vat_exempt',
        'condition',
        'condition_notes',
        'original_price',
    ];

    // ============================================================
    // CASTS
    // ============================================================

    protected $casts = [
        'price'            => 'decimal:2',
        'sale_price'       => 'decimal:2',
        'cost_price'       => 'decimal:2',
        'original_price'   => 'decimal:2',
        'weight'           => 'decimal:2',
        'length'           => 'decimal:2',
        'width'            => 'decimal:2',
        'height'           => 'decimal:2',
        'is_variant'       => 'boolean',
        'is_active'        => 'boolean',
        'is_vat_exempt'    => 'boolean',
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
    ];

    // ============================================================
    // HELPERS
    // ============================================================

    /**
     * Selling price - sale_price if set, otherwise price.
     */
    public function effectivePrice(): float
    {
        return (float) ($this->sale_price ?? $this->price ?? 0);
    }

    /**
     * Full thumbnail URL.
     */
    public function thumbnailUrl(): string
    {
        if (! $this->thumbnail) {
            return asset('images/placeholder.png');
        }

        // If already a full URL, return as-is
        if (str_starts_with($this->thumbnail, 'http')) {
            return $this->thumbnail;
        }

        return asset('storage/products/' . $this->thumbnail);
    }
}