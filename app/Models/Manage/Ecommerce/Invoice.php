<?php

namespace App\Models\Manage\Ecommerce;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'su_invoices';

    protected $guarded = [];

    // ---------------
    // Attribute Casting
    // ---------------
    protected function casts(): array
    {
        return [
            'amount'    => 'decimal:2',
            'issued_at' => 'datetime',
            'due_date'  => 'date',
        ];
    }

    // ---------------
    // Relationships
    // ---------------
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}