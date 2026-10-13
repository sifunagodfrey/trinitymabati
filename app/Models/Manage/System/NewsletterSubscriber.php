<?php

namespace App\Models\Manage\System;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    protected $table = 'su_newsletter_subscribers';

    // su_newsletter_subscribers has no created_at or updated_at columns
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'is_verified'          => 'boolean',
        'receive_promotions'   => 'boolean',
        'receive_suggestions'  => 'boolean',
        'receive_order_updates'=> 'boolean',
        'receive_news_updates' => 'boolean',
        'subscribed_at'        => 'datetime',
        'unsubscribed_at'      => 'datetime',
    ];
}
