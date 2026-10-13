<?php

/*
 * Stock email service. Sends low stock alert emails to administrators
 * via SMTP using the credentials stored in su_email_settings.
 */

namespace App\Services;

use App\Models\Manage\Products\Product;
use App\Services\Concerns\SendsPlatformEmail;
use Illuminate\Support\Facades\Log;

class StockEmailService
{
    use SendsPlatformEmail;

    // ---------------
    // Send a low stock alert email to one administrator
    // ---------------
    public function sendLowStockAlert(string $toEmail, string $toName, Product $product, int $stock, int $threshold): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('StockEmailService: no email settings found in su_email_settings.');
            return;
        }

        try {
            $this->send(
                $settings,
                $toEmail,
                $toName ?: $toEmail,
                'Low stock alert - ' . $product->name,
                'emails.system.low_stock_alert',
                [
                    'adminName' => $toName ?: 'Admin',
                    'product'   => $product,
                    'stock'     => $stock,
                    'threshold' => $threshold,
                ]
            );
        } catch (\Throwable $e) {
            Log::warning('StockEmailService: send failed', [
                'to'    => $toEmail,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
