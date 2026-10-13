<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Manage\System\Permission;

// -------------------
// User Role Model
// -------------------
// Defines system roles (su_roles)
// -------------------
class UserRole extends Model
{
    protected $table = 'su_roles';

    protected $fillable = ['name', 'slug', 'description'];

    // ---------------
    // Relationship: Permissions (many-to-many via su_role_permissions)
    // ---------------
    public function permissions()
    {
        return $this->belongsToMany(
            Permission::class,
            'su_role_permissions',
            'role_id',
            'permission_id'
        );
    }
}