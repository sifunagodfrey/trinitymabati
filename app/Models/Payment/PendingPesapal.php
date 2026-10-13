<?php

/* -------------------
   Pending Pesapal model mapped to su_pending_pesapal. Tracks Pesapal
   order submissions awaiting confirmation via callback or IPN.
------------------- */

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class PendingPesapal extends Model
{
    protected $table = 'su_pending_pesapal';

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'amount'     => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
