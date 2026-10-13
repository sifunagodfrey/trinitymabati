<?php

namespace App\Models\Manage\Ecommerce;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbandonedCart extends Model
{
    use HasFactory;

    protected $table = 'su_abandoned_carts';

    // ---------------
    // su_abandoned_carts uses last_updated instead of updated_at
    // ---------------
    public const UPDATED_AT = 'last_updated';

    protected $guarded = [];

    protected $casts = [
        'cart_data'     => 'array',
        'recovered'     => 'boolean',
        'reminder_sent' => 'boolean',
        'last_updated'  => 'datetime',
    ];

    // ---------------
    // Relationships
    // ---------------
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(AbandonedCartLog::class, 'user_id', 'user_id');
    }
}