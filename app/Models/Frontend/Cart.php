<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'su_carts';

    protected $guarded = [];

    // ---------------
    // Relationships
    // ---------------
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
