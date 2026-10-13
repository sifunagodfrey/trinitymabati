<?php

namespace App\Models\Client;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    // ---------------
    // Table & Fillable
    // ---------------
    protected $table = 'su_orders';

    protected $fillable = ['status'];

    // ---------------
    // Relationships
    // ---------------
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }
}
