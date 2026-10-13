<?php

/* -------------------
   Banner model mapped to su_banners. Stores the homepage hero slides:
   image, optional link, display order and active state.
------------------- */

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'su_banners';

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

    // --------------- Scope: active slides in display order ---------------
    public function scopeActiveOrdered($query)
    {
        return $query->where('is_active', true)->orderBy('position')->orderBy('id');
    }

    // --------------- Resolved public image URL ---------------
    public function getImageUrlAttribute(): string
    {
        $img = (string) $this->image;

        if (str_starts_with($img, 'uploads/') || str_starts_with($img, 'storage/')) {
            return asset($img);
        }

        return url('public/images/' . $img);
    }
}
