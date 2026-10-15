<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $table = 'su_partners';

    protected $fillable = ['name', 'image', 'is_published', 'sort_order'];

    protected function casts(): array
    {
        return ['is_published' => 'boolean', 'sort_order' => 'integer'];
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
