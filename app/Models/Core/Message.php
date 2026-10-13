<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Message extends Model
{
    protected $table = 'su_user_messages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'user_id',      // nullable, for broadcast messages
        'subject',
        'message',
        'related_type',
        'related_id',
        'status',
        'is_read',
        'user_role',
    ];

    protected $casts = [
        'is_read'      => 'boolean',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    // Relationships
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function targetUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scope: messages intended for a specific receiver
    public function scopeForReceiver($query, $userId)
    {
        return $query->where('receiver_id', $userId)
            ->orWhereNull('receiver_id');
    }
}