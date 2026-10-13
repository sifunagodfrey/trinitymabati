<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

// -------------------
// Role Permission Model
// -------------------
// Pivot: links su_roles to su_permissions (no timestamps, no auto-increment PK)
// -------------------
class RolePermission extends Model
{
    protected $table = 'su_role_permissions';

    public $timestamps = false;

    public $incrementing = false;

    protected $primaryKey = null;

    protected $fillable = ['role_id', 'permission_id'];
}