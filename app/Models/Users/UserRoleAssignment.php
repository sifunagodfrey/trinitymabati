<?php

/* -------------------
   Pivot model mapped to su_user_roles. Links users to their roles and
   backs the role relationships on the User model.
------------------- */

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

// -------------------
// User Role Assignment Model
// -------------------
// Maps users to roles (su_user_roles)
// -------------------
class UserRoleAssignment extends Model
{
    protected $table = 'su_user_roles';

    public $timestamps = false;

    protected $fillable = ['user_id', 'role_id', 'created_at'];

    // ---------------
    // Relationship: Role
    // ---------------
    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }

    // ---------------
    // Relationship: User
    // ---------------
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
