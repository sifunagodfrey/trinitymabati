<?php

namespace App\Models\Manage\Ecommerce;

use App\Models\Manage\Products\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AbandonedCartLog extends Model
{
    protected $table = 'su_abandoned_cart_logs';

    // ---------------
    // su_abandoned_cart_logs has no created_at / updated_at columns
    // ---------------
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    // ---------------
    // Relationships
    // ---------------
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
