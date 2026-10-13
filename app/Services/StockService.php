<?php

/* -------------------
   Stock service. Deducts inventory once per order (guarded by the
   stock_deducted flag), restores it when an order is cancelled, and
   raises low stock alerts in su_low_stock_alerts with email and SMS
   notifications to super admins.
------------------- */

namespace App\Services;

use App\Models\Manage\Products\LowStockAlert;
use App\Models\Manage\Products\Product;
use App\Models\Manage\Products\ProductVariant;
use App\Services\Sms\SmsService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockService
{
    // ---------------
    // Deduct stock for every item on an order. Idempotent: exits when
    // the order is already marked stock_deducted. Accepts any order
    // model that exposes id and items (product_id, variant_id, quantity).
    // ---------------
    public function deductForOrder($order): void
    {
        try {
            $deducted = DB::transaction(function () use ($order) {
                $row = DB::table('su_orders')->where('id', $order->id)->lockForUpdate()->first();
                if (! $row || (int) $row->stock_deducted === 1) {
                    return false;
                }

                $order->loadMissing('items');

                foreach ($order->items as $item) {
                    if ($item->variant_id) {
                        DB::table('su_product_variants')
                            ->where('id', $item->variant_id)
                            ->update(['stock_quantity' => DB::raw('GREATEST(stock_quantity - ' . (int) $item->quantity . ', 0)')]);
                    } elseif ($item->product_id) {
                        DB::table('su_products')
                            ->where('id', $item->product_id)
                            ->update(['stock_quantity' => DB::raw('GREATEST(stock_quantity - ' . (int) $item->quantity . ', 0)')]);
                    }
                }

                DB::table('su_orders')->where('id', $order->id)->update(['stock_deducted' => 1]);

                return true;
            });

            if ($deducted) {
                $this->checkLowStockForOrder($order);
            }
        } catch (\Throwable $e) {
            Log::error('StockService: deductForOrder failed', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    // ---------------
    // Restore stock for a cancelled or refunded order. Idempotent via
    // the same stock_deducted flag.
    // ---------------
    public function restoreForOrder($order): void
    {
        try {
            DB::transaction(function () use ($order) {
                $row = DB::table('su_orders')->where('id', $order->id)->lockForUpdate()->first();
                if (! $row || (int) $row->stock_deducted !== 1) {
                    return;
                }

                $order->loadMissing('items');

                foreach ($order->items as $item) {
                    if ($item->variant_id) {
                        DB::table('su_product_variants')
                            ->where('id', $item->variant_id)
                            ->increment('stock_quantity', (int) $item->quantity);
                    } elseif ($item->product_id) {
                        DB::table('su_products')
                            ->where('id', $item->product_id)
                            ->increment('stock_quantity', (int) $item->quantity);
                    }
                }

                DB::table('su_orders')->where('id', $order->id)->update(['stock_deducted' => 0]);
            });
        } catch (\Throwable $e) {
            Log::error('StockService: restoreForOrder failed', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    // ---------------
    // Check every product on an order against its low stock threshold
    // and raise alerts for any that fell to or below it.
    // ---------------
    public function checkLowStockForOrder($order): void
    {
        $order->loadMissing('items');

        $productIds = $order->items->pluck('product_id')->filter()->unique();

        foreach ($productIds as $productId) {
            $product = Product::with('variants')->find($productId);
            if (! $product) {
                continue;
            }
            $this->checkProduct($product);
        }
    }

    // ---------------
    // Raise an alert for a single product when its effective stock is at
    // or below low_stock_threshold and no unresolved alert exists yet.
    // Resolves open alerts automatically once stock recovers.
    // ---------------
    public function checkProduct(Product $product): void
    {
        $threshold = (int) ($product->low_stock_threshold ?? 5);
        $stock     = $product->is_variant && $product->variants->isNotEmpty()
            ? (int) $product->variants->sum('stock_quantity')
            : (int) $product->stock_quantity;

        $openAlert = LowStockAlert::where('product_id', $product->id)
            ->whereNull('resolved_at')
            ->first();

        if ($stock > $threshold) {
            if ($openAlert) {
                $openAlert->update(['resolved_at' => now()]);
            }
            return;
        }

        if ($openAlert) {
            return;
        }

        $alert = LowStockAlert::create([
            'product_id'     => $product->id,
            'variant_id'     => null,
            'stock_quantity' => $stock,
            'threshold'      => $threshold,
            'notified_email' => false,
            'notified_sms'   => false,
            'created_at'     => now(),
        ]);

        $this->notifyAdmins($product, $alert, $stock, $threshold);
    }

    // ---------------
    // Notify super admins by email (and SMS when configured)
    // ---------------
    protected function notifyAdmins(Product $product, LowStockAlert $alert, int $stock, int $threshold): void
    {
        $admins = DB::table('su_users as u')
            ->join('su_user_roles as ur', 'ur.user_id', '=', 'u.id')
            ->join('su_roles as r', 'r.id', '=', 'ur.role_id')
            ->where('r.slug', 'super_admin')
            ->whereNull('u.deleted_at')
            ->get(['u.id', 'u.first_name', 'u.last_name', 'u.email', 'u.phone']);

        if ($admins->isEmpty()) {
            return;
        }

        $emailSent = false;
        $smsSent   = false;

        try {
            $emailService = app(StockEmailService::class);
            foreach ($admins as $admin) {
                if ($admin->email) {
                    $emailService->sendLowStockAlert(
                        $admin->email,
                        trim($admin->first_name . ' ' . $admin->last_name),
                        $product,
                        $stock,
                        $threshold
                    );
                    $emailSent = true;
                }
            }
        } catch (\Throwable $e) {
            Log::warning('StockService: low stock email failed', [
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
            ]);
        }

        try {
            $sms = app(SmsService::class);
            if ($sms->isActive()) {
                foreach ($admins as $admin) {
                    if ($admin->phone) {
                        $smsSent = $sms->sendLowStockAlert($admin->phone, $product->name, $stock) || $smsSent;
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::warning('StockService: low stock SMS failed', [
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
            ]);
        }

        $alert->update([
            'notified_email' => $emailSent,
            'notified_sms'   => $smsSent,
        ]);
    }
}
