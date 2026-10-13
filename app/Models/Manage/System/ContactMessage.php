<?php

namespace App\Models\Manage\System;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactMessage extends Model
{
    use HasFactory;

    protected $table = 'su_contact_messages';

    public $timestamps = false;

    protected $guarded = [];
}