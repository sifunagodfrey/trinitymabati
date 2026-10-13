<?php

namespace App\Models\Manage\System;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    protected $table = 'su_email_settings';

    // ---------------
    // su_email_settings has no created_at column
    // ---------------
    public const CREATED_AT = null;

    protected $fillable = [
        'mail_driver',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
    ];

    // ---------------
    // Exclude password from serialisation
    // ---------------
    protected $hidden = ['mail_password'];
}
