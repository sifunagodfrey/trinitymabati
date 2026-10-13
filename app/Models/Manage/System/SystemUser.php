<?php

namespace App\Models\Manage\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SystemUser extends Model
{
    use HasFactory;

    protected $table = 'su_system_users';

    protected $guarded = [];
}