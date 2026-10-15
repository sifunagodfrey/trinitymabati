<?php

namespace App\Models\Manage\Payments;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'su_payment_methods';
    public $timestamps = false;

    protected $fillable = [
        'name', 'slug', 'description', 'is_active', 'is_default', 'is_manual', 'config',
        'user_input_label', 'user_input_description', 'thumbnail',
    ];

    protected $casts = [
        'is_active'  => 'boolean',
        'is_manual'  => 'boolean',
        'is_default' => 'boolean',
        'config'     => 'array',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeManual($query)
    {
        return $query->where('is_manual', true);
    }

    public function scopeAvailableManual($query)
    {
        return $query->manual()->active()
            ->whereNotNull('config->paybill')->where('config->paybill', '!=', '')
            ->whereNotNull('config->account_number')->where('config->account_number', '!=', '')
            ->whereNotNull('config->account_name')->where('config->account_name', '!=', '');
    }

    public function isConfigured(): bool
    {
        foreach (['paybill', 'account_number', 'account_name'] as $key) {
            if (trim((string) ($this->config[$key] ?? '')) === '') return false;
        }
        return true;
    }

    public function transactions()
    {
        return $this->hasMany(\App\Models\Payment\PaymentTransaction::class, 'method_id');
    }
}