<?php

namespace App\Models\Manage;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SystemMessage extends Model
{
    protected $table = 'su_system_messages';

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'subject',
        'message',
        'is_read',
        'user_role',  
    ];

    public $timestamps = false;
    
    protected $casts = [
        'is_read'     => 'boolean',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    // ---------------
    // Relationships
    // ---------------
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    // ---------------
    // Scopes
    // ---------------
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeForAdmin($query, $adminId)
    {
        return $query->where(function ($q) use ($adminId) {
            $q->where('recipient_id', $adminId)
              ->orWhere('sender_id', $adminId)
              ->orWhereNull('recipient_id'); // broadcast - visible to all admins
        });
    }
}