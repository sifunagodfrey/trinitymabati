<?php

namespace App\Models\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    // ---------------
    // Table name
    // ---------------
    protected $table = 'su_user_profiles';

    // ---------------
    // Primary key
    // ---------------
    protected $primaryKey = 'id';

    // ---------------
    // Mass assignable fields
    // ---------------
    protected $fillable = [
        'user_id',
        'gender',
        'date_of_birth',
        'profile_photo',
        'social_links',
    ];

    // ---------------
    // Casts
    // ---------------
    protected $casts = [
        'date_of_birth' => 'date',
        'social_links'  => 'array',
    ];

    // ---------------
    // Relationship back to User
    // ---------------
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ---------------
    // Accessor: Profile Photo URL
    // ---------------
    public function getProfilePhotoUrlAttribute(): ?string
    {
        if (!$this->profile_photo) {
            return null;
        }
        return asset('uploads/users/' . $this->profile_photo);
    }
}