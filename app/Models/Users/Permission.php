<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

// -------------------
// Permission Model
// -------------------
// Defines permissions (su_permissions)
// -------------------
class Permission extends Model
{
    protected $table = 'su_permissions';

    protected $fillable = ['name', 'slug', 'description'];
}