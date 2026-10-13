<?php

namespace App\Models\Manage\Payments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'su_transactions';

    protected $guarded = [];
}