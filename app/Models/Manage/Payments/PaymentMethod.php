<?php

namespace App\Models\Manage\Payments;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'su_payment_methods';
    public $timestamps = false;

    protected $fillable = [
        'name', 'slug', 'description', 'is_active', 'is_default', 'config',
        'user_input_label', 'user_input_description', 'thumbnail',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'is_default' => 'boolean',
        'config'     => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function transactions()
    {
        return $this->hasMany(\App\Models\Payment\PaymentTransaction::class, 'method_id');
    }
}