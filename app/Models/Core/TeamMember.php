<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $table = 'su_team_members';

    protected $fillable = ['first_name', 'last_name', 'title', 'bio', 'photo', 'is_published', 'sort_order'];

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

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
