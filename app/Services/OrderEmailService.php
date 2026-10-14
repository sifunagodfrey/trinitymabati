<?php

/*
 * Order lifecycle emails: new order confirmation, payment success
 * or failure, and order/payment/shipping status update notices.
 */

namespace App\Services;

use App\Models\Frontend\Order as FrontendOrder;
use App\Models\Manage\Ecommerce\Order as AdminOrder;
use App\Services\Concerns\SendsPlatformEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderEmailService
{
    use SendsPlatformEmail;

    // ---------------
    // Resolve county and location names for an order's shipping address.
    // Works with both Frontend\Order and Manage\Ecommerce\Order.
    // ---------------
    private function resolveShippingNames($order): array
    {
        $county   = DB::table('su_counties')->find($order->shipping_county_id);
        $location = DB::table('su_location_pricing')->find($order->shipping_location_id);

        return [
            'countyName'   => $county?->name ?? '-',
            'locationName' => $location?->location_name ?? '-',
        ];
    }

    // ---------------
    // New order placed: confirmation email to the client.
    // Accepts both Frontend\Order and Manage\Ecommerce\Order.
    // ---------------
    public function sendNewOrderToClient($order): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('OrderEmailService: no email settings found in su_email_settings.');
            return;
        }

        $order->loadMissing(['user', 'items']);

        $user = $order->user;
        if (! $user) return;

        $this->send(
            $settings,
            $user->email,
            trim($user->first_name . ' ' . $user->last_name),
            'Order Placed - ' . $order->order_code,
            'emails.client.new_order_placement',
            array_merge(
                ['order' => $order],
                $this->resolveShippingNames($order)
            )
        );
    }

    // ---------------
    // New order placed: alert every super admin.
    // Never throws, one failed recipient does not block the others.
    // ---------------
    public function sendNewOrderToStaff($order): void
    {
        try {
            $settings = $this->emailSettings();

            if (! $settings?->mail_host) {
                return;
            }

            $order->loadMissing(['user', 'items']);

            foreach ($this->superAdmins() as $admin) {
                try {
                    $this->send(
                        $settings,
                        $admin->email,
                        trim($admin->first_name . ' ' . $admin->last_name),
                        'New Order - ' . $order->order_code,
                        'emails.system.new_order_admin',
                        array_merge(
                            ['order' => $order],
                            $this->resolveShippingNames($order)
                        )
                    );
                } catch (\Throwable $e) {
                    Log::warning('OrderEmailService: staff order alert failed', [
                        'to'    => $admin->email,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('OrderEmailService: staff order alert failed', ['error' => $e->getMessage()]);
        }
    }
    // ---------------
    // Payment confirmed: success email to the client.
    // ---------------
    public function sendPaymentSuccessToClient($order): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('OrderEmailService: no email settings found in su_email_settings.');
            return;
        }

        $order->loadMissing(['user', 'items']);

        $user = $order->user;
        if (! $user) return;

        $this->send(
            $settings,
            $user->email,
            trim($user->first_name . ' ' . $user->last_name),
            'Payment Confirmed - Order ' . $order->order_code,
            'emails.client.order_payment_success',
            array_merge(
                ['order' => $order],
                $this->resolveShippingNames($order)
            )
        );
    }

    // ---------------
    // Payment failed: notification email to the client.
    // ---------------
    public function sendPaymentFailedToClient($order, string $reason = ''): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('OrderEmailService: no email settings found in su_email_settings.');
            return;
        }

        $order->loadMissing(['user', 'items']);

        $user = $order->user;
        if (! $user) return;

        $this->send(
            $settings,
            $user->email,
            trim($user->first_name . ' ' . $user->last_name),
            'Payment Failed - Order ' . $order->order_code,
            'emails.client.order_payment_failed',
            array_merge(
                [
                    'order'  => $order,
                    'reason' => $reason ?: 'The payment could not be completed.',
                ],
                $this->resolveShippingNames($order)
            )
        );
    }

    // ---------------
    // Order update notification: sent to the customer.
    // Triggered when admin or seller changes order, payment, or shipping status.
    // Accepts both Frontend\Order and Manage\Ecommerce\Order.
    // ---------------
    public function sendOrderUpdateEmails($order, array $oldStatuses, array $newStatuses, string $updatedBy = 'admin'): void
    {
        $settings = $this->emailSettings();
        if (! $settings?->mail_host) {
            Log::warning('OrderEmailService: no email settings, cannot send order update emails.');
            return;
        }

        // Compute only the fields that actually changed
        $changes = [];
        $fieldLabels = [
            'status'          => 'Order Status',
            'payment_status'  => 'Payment Status',
            'shipping_status' => 'Shipping Status',
        ];

        foreach ($fieldLabels as $field => $label) {
            $old = $oldStatuses[$field] ?? null;
            $new = $newStatuses[$field] ?? null;
            if ($old !== $new) {
                $changes[$label] = [
                    'old' => ucwords(str_replace('_', ' ', $old ?? '-')),
                    'new' => ucwords(str_replace('_', ' ', $new ?? '-')),
                ];
            }
        }

        if (empty($changes)) {
            return; // nothing changed
        }

        $order->loadMissing(['user', 'items']);

        // -------------------
        // 1. Email to customer
        // -------------------
        $customer = $order->user;
        if ($customer) {
            try {
                $this->send(
                    $settings,
                    $customer->email,
                    trim($customer->first_name . ' ' . $customer->last_name),
                    'Order Updated - ' . $order->order_code,
                    'emails.client.order_updated',
                    array_merge(
                        ['order' => $order, 'changes' => $changes, 'updatedBy' => $updatedBy],
                        $this->resolveShippingNames($order)
                    )
                );
            } catch (\Throwable $e) {
                Log::warning('Failed to send order update email to customer', [
                    'order_id' => $order->id,
                    'email'    => $customer->email,
                    'error'    => $e->getMessage(),
                ]);
            }
        }

    }
}
