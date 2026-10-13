<?php

namespace App\Models\Manage\System;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SupportTicket extends Model
{
    use HasFactory;

    protected $table = 'su_support_tickets';

    protected $guarded = [];

    protected $casts = [
        'last_reply_at' => 'datetime',
    ];

    // ---------------
    // Relationships
    // ---------------
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(SupportTicketReply::class, 'ticket_id');
    }

    public function lastReply(): HasOne
    {
        return $this->hasOne(SupportTicketReply::class, 'ticket_id')->latestOfMany();
    }

    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_admin_id');
    }
}