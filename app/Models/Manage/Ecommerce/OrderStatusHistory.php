<?php

/* -------------------
   Order status history model mapped to su_order_status_history.
   One row per status change forming the order timeline shown to
   customers and admins. Includes a static record() helper.
------------------- */

namespace App\Models\Manage\Ecommerce;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    protected $table = 'su_order_status_history';

    public $timestamps = false;

    protected $guarded = [];

    // --------------- Attribute Casting ---------------
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    // --------------- Relationships ---------------
    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    // ---------------
    // Record a status change on an order timeline.
    // Safe to call anywhere: failures are swallowed so the timeline
    // never breaks a payment or checkout flow.
    // ---------------
    public static function record(int $orderId, string $status, ?string $note = null, ?int $changedBy = null): void
    {
        try {
            static::create([
                'order_id'   => $orderId,
                'status'     => $status,
                'note'       => $note,
                'changed_by' => $changedBy,
                'created_at' => now(),
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('OrderStatusHistory::record failed', [
                'order_id' => $orderId,
                'status'   => $status,
                'error'    => $e->getMessage(),
            ]);
        }
    }
}
