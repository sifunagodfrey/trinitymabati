<?php

namespace App\Models\Manage\Quotations;

use App\Models\User;
use App\Models\Manage\Ecommerce\Order;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table = 'su_quotations';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'subtotal'    => 'decimal:2',
            'tax'         => 'decimal:2',
            'discount'    => 'decimal:2',
            'total'       => 'decimal:2',
            'valid_until' => 'date',
        ];
    }

    // --------------- Relationships ---------------
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function preparedBy()
    {
        return $this->belongsTo(User::class, 'prepared_by');
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id');
    }

    public function convertedOrder()
    {
        return $this->belongsTo(Order::class, 'converted_order_id');
    }

    // --------------- Helpers ---------------
    public static function generateCode(): string
    {
        do {
            $code = 'QUO-' . strtoupper(substr(uniqid(), -8));
        } while (static::where('quotation_code', $code)->exists());

        return $code;
    }
}
