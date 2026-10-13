<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'su_payment_methods';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'config',
        'user_input_label',
        'user_input_description',
        'thumbnail',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'config'    => 'array',
    ];

    public $timestamps = true;

    // ---------------
    // Scope: only active methods
    // ---------------
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}