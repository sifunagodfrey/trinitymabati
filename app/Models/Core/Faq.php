<?php

/* -------------------
   FAQ model mapped to su_faqs. Stores the frequently asked questions
   shown on the public FAQ page, ordered by position.
------------------- */

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'su_faqs';

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'position'   => 'integer',
            'is_active'  => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // --------------- Scope: active questions in display order ---------------
    public function scopeActiveOrdered($query)
    {
        return $query->where('is_active', true)->orderBy('position')->orderBy('id');
    }
}
