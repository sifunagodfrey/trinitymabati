<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'su_partners';

    protected $fillable = ['name', 'image', 'is_published', 'is_association', 'sort_order'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean', 'is_association' => 'boolean', 'sort_order' => 'integer'];
    }

    // ---------------
    // Filter: associations (true) or regular partners (false)
    // ---------------
    public function scopeAssociation($query, bool $value = true)
    {
        return $query->where('is_association', $value);
    }
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeDisplayOrder($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

}
