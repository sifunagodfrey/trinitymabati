<?php

namespace App\Models\Manage\Quotations;

use App\Models\Manage\Products\Product;
use App\Models\Manage\Products\ProductVariant;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    protected $table = 'su_quotation_items';

    public $timestamps = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'unit_price' => 'decimal:2',
            'total'      => 'decimal:2',
        ];
    }

    // --------------- Relationships ---------------
    public function quotation()
    {
        return $this->belongsTo(Quotation::class, 'quotation_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}
