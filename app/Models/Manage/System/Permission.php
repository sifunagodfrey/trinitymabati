<?php

namespace App\Models\Manage\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'su_permissions';

    protected $guarded = [];
}