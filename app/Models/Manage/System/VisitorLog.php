<?php

namespace App\Models\Manage\System;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VisitorLog extends Model
{
    use HasFactory;

    protected $table = 'su_visitors_logs';

    // ---------------
    // Table uses visit_time, not created_at/updated_at
    // ---------------
    public $timestamps = false;

    protected $guarded = [];

    // ---------------
    // Relationships
    // ---------------
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}