<?php

/* -------------------
   Page model mapped to su_pages. Stores editable site pages such as the
   refund policy, terms and conditions and privacy policy.
------------------- */

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'su_pages';

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'is_active'  => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    // --------------- Scope: active pages only ---------------
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
