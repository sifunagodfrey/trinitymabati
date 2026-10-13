<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Users\UserRole;
use App\Models\Users\UserRoleAssignment;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    // -------------------
    // Custom Table Mapping
    // -------------------
    protected $table = 'su_users';

    // -------------------
    // Primary Key Mapping
    // -------------------
    protected $primaryKey = 'id';

    // -------------------
    // Mass Assignable Fields
    // -------------------
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'status',
        'last_login_at',
        'last_activity_at',
        'login_ip',
        'device_name',
        'remember_token',
    ];

    // -------------------
    // Hidden Fields
    // -------------------
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // -------------------
    // Attribute Casting
    // -------------------
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at'     => 'datetime',
            'last_activity_at'  => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // -------------------
    // Accessor: Full Name
    // -------------------
    public function getNameAttribute(): string
    {
        return trim(($this->first_name ?? '') . ' ' . ($this->last_name ?? ''));
    }

    // -------------------
    // Relationship: Roles (many-to-many via su_user_roles)
    // -------------------
    public function roles()
    {
        return $this->belongsToMany(
            UserRole::class,
            'su_user_roles',
            'user_id',
            'role_id'
        );
    }

    // -------------------
    // Relationship: Primary Role
    // Resolves through su_user_roles so existing $user->role
    // and $user->role?->slug reads keep working.
    // -------------------
    public function role()
    {
        return $this->hasOneThrough(
            UserRole::class,
            UserRoleAssignment::class,
            'user_id',  // FK on su_user_roles referencing users
            'id',       // PK on su_roles
            'id',       // local key on su_users
            'role_id'   // FK on su_user_roles referencing roles
        );
    }

    // -------------------
    // Accessor: role_id (primary role id via the pivot)
    // -------------------
    public function getRoleIdAttribute(): ?int
    {
        return $this->role?->id;
    }

    // -------------------
    // Role check by slug
    // -------------------
    public function hasRole(string $slug): bool
    {
        return $this->roles()->where('slug', $slug)->exists();
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super_admin');
    }

    // ---------------
    // Relationship: User Profile (su_user_profiles)
    // ---------------
    public function profile()
    {
        return $this->hasOne(\App\Models\Users\UserProfile::class, 'user_id');
    }

    // ---------------
    // Relationship: Orders placed by this user
    // ---------------
    public function orders()
    {
        return $this->hasMany(\App\Models\Manage\Ecommerce\Order::class, 'user_id');
    }

    // ---------------
    // Relationship: Referral codes owned by this user
    // ---------------
    public function referralCodes()
    {
        return $this->hasMany(\App\Models\Client\ReferralCode::class, 'user_id');
    }

    // Cache for permissions loaded once per request
    protected $cachedPermissions = null;

    /**
     * Check if the user has a specific permission (by slug).
     * Super Administrators always return true.
     */
    public function hasPermission(string $slug): bool
    {
        // Super Admin bypass
        if ($this->isSuperAdmin()) {
            return true;
        }

        // Load the union of permissions across all assigned roles once per request
        if ($this->cachedPermissions === null) {
            $this->cachedPermissions = $this->roles()
                ->with('permissions')
                ->get()
                ->flatMap(fn ($role) => $role->permissions->pluck('slug'))
                ->unique()
                ->values()
                ->toArray();
        }

        return in_array($slug, $this->cachedPermissions);
    }

    /**
     * Check if the user has any of the given permissions.
     */
    public function hasAnyPermission(array $slugs): bool
    {
        foreach ($slugs as $slug) {
            if ($this->hasPermission($slug)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if the user has all of the given permissions.
     */
    public function hasAllPermissions(array $slugs): bool
    {
        foreach ($slugs as $slug) {
            if (!$this->hasPermission($slug)) {
                return false;
            }
        }
        return true;
    }
}
