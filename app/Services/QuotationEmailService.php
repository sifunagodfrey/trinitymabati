<?php

/*
 * Quotation emails: request received (client), new request alert (staff),
 * quotation sent to client, and quotation status update notices.
 */

namespace App\Services;

use App\Models\Manage\Quotations\Quotation;
use App\Services\Concerns\SendsPlatformEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuotationEmailService
{
    use SendsPlatformEmail;

    // ---------------
    // Copy for each client status email
    // ---------------
    private const STATUS_COPY = [
        'accepted' => [
            'subject'    => 'Quotation Accepted',
            'headline'   => 'Your quotation has been accepted',
            'intro'      => 'Thank you for choosing us. Our team will contact you shortly to confirm the next steps for your order.',
            'show_items' => false,
        ],
        'rejected' => [
            'subject'    => 'Quotation Update',
            'headline'   => 'Your quotation has been marked as declined',
            'intro'      => 'If this is unexpected, or you would like a revised quotation, please get in touch and we will be happy to help.',
            'show_items' => false,
        ],
        'expired' => [
            'subject'    => 'Quotation Expired',
            'headline'   => 'Your quotation has expired',
            'intro'      => 'Prices and availability may have changed since this quotation was issued. Contact us and we will prepare a fresh one for you.',
            'show_items' => false,
        ],
    ];

    // ---------------
    // Customer email: quotation's own email first, then the linked account
    // ---------------
    public function customerEmail(Quotation $quotation): ?string
    {
        $email = $quotation->customer_email ?: $quotation->customer?->email;

        return $email ? trim($email) : null;
    }

    // ---------------
    // Customer name: quotation's own fields first, then the linked account
    // ---------------
    protected function customerName(Quotation $quotation): string
    {
        $first = $quotation->customer_first_name ?: ($quotation->customer?->first_name ?? '');
        $last  = $quotation->customer_last_name ?: ($quotation->customer?->last_name ?? '');

        return trim($first . ' ' . $last) ?: 'Customer';
    }

    // ---------------
    // Request received: receipt to the customer.
    // Never throws, so it cannot break the public request.
    // ---------------
    public function sendRequestReceivedToClient(Quotation $quotation): void
    {
        try {
            $settings = $this->emailSettings();
            $email    = $this->customerEmail($quotation);

            if (! $settings?->mail_host || ! $email) {
                return;
            }

            $quotation->load(['customer', 'items']);

            $this->send(
                $settings,
                $email,
                $this->customerName($quotation),
                'Quotation Request Received - ' . $quotation->quotation_code,
                'emails.client.quotation_update',
                [
                    'quotation'    => $quotation,
                    'customerName' => $this->customerName($quotation),
                    'headline'     => 'We have received your quotation request',
                    'intro'        => 'Thank you for your request. Our team will review it and send you a confirmed quotation shortly. Prices below are estimates and are subject to confirmation.',
                    'showItems'    => true,
                ]
            );
        } catch (\Throwable $e) {
            Log::warning('QuotationEmailService: request received email failed', [
                'quotation' => $quotation->quotation_code,
                'error'     => $e->getMessage(),
            ]);
        }
    }

    // ---------------
    // New request: alert every super admin.
    // Never throws, one failed recipient does not block the others.
    // ---------------
    public function sendNewRequestToStaff(Quotation $quotation): void
    {
        try {
            $settings = $this->emailSettings();

            if (! $settings?->mail_host) {
                return;
            }

            $admins = DB::table('su_users as u')
                ->join('su_user_roles as ur', 'ur.user_id', '=', 'u.id')
                ->join('su_roles as r', 'r.id', '=', 'ur.role_id')
                ->where('r.slug', 'super_admin')
                ->whereNull('u.deleted_at')
                ->get(['u.first_name', 'u.last_name', 'u.email'])
                ->unique('email');

            $quotation->load(['customer', 'items']);

            foreach ($admins as $admin) {
                if (! $admin->email) {
                    continue;
                }

                try {
                    $this->send(
                        $settings,
                        $admin->email,
                        trim($admin->first_name . ' ' . $admin->last_name),
                        'New Quotation Request - ' . $quotation->quotation_code,
                        'emails.system.quotation_request_admin',
                        [
                            'quotation'    => $quotation,
                            'customerName' => $this->customerName($quotation),
                            'customerEmail' => $this->customerEmail($quotation),
                        ]
                    );
                } catch (\Throwable $e) {
                    Log::warning('QuotationEmailService: staff alert failed', [
                        'to'    => $admin->email,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::warning('QuotationEmailService: staff alert failed', ['error' => $e->getMessage()]);
        }
    }

    // ---------------
    // Quotation sent: full quotation with line items to the customer.
    // Returns false when email settings or customer email are missing.
    // Throws on SMTP failure so the caller can decide what to do.
    // ---------------
    public function sendQuotationToClient(Quotation $quotation): bool
    {
        $settings = $this->emailSettings();
        $email    = $this->customerEmail($quotation);

        if (! $settings?->mail_host || ! $email) {
            return false;
        }

        $quotation->loadMissing(['customer', 'items']);

        $this->send(
            $settings,
            $email,
            $this->customerName($quotation),
            'Your Quotation - ' . $quotation->quotation_code,
            'emails.client.quotation_update',
            [
                'quotation'    => $quotation,
                'customerName' => $this->customerName($quotation),
                'headline'     => 'Your quotation is ready',
                'intro'        => 'Thank you for your interest. Please find your quotation below. Reply to this email or contact us to accept it or to ask for any changes.',
                'showItems'    => true,
            ]
        );

        return true;
    }

    // ---------------
    // Status changed to accepted, rejected or expired: notice to the customer.
    // Returns false when nothing was sent. Throws on SMTP failure.
    // ---------------
    public function sendStatusUpdateToClient(Quotation $quotation, string $status): bool
    {
        $copy     = self::STATUS_COPY[$status] ?? null;
        $settings = $this->emailSettings();
        $email    = $this->customerEmail($quotation);

        if (! $copy || ! $settings?->mail_host || ! $email) {
            return false;
        }

        $quotation->loadMissing(['customer', 'items']);

        $this->send(
            $settings,
            $email,
            $this->customerName($quotation),
            $copy['subject'] . ' - ' . $quotation->quotation_code,
            'emails.client.quotation_update',
            [
                'quotation'    => $quotation,
                'customerName' => $this->customerName($quotation),
                'headline'     => $copy['headline'],
                'intro'        => $copy['intro'],
                'showItems'    => $copy['show_items'],
            ]
        );

        return true;
    }

    // ---------------
    // Quotation converted to an order: notice to the customer.
    // Returns false when nothing was sent. Throws on SMTP failure.
    // ---------------
    public function sendConvertedToClient(Quotation $quotation, string $orderCode): bool
    {
        $settings = $this->emailSettings();
        $email    = $this->customerEmail($quotation);

        if (! $settings?->mail_host || ! $email) {
            return false;
        }

        $quotation->loadMissing(['customer', 'items']);

        $this->send(
            $settings,
            $email,
            $this->customerName($quotation),
            'Quotation Converted to Order - ' . $quotation->quotation_code,
            'emails.client.quotation_update',
            [
                'quotation'    => $quotation,
                'customerName' => $this->customerName($quotation),
                'headline'     => 'Your quotation is now an order',
                'intro'        => 'Your quotation has been converted to order ' . $orderCode . '. Our team will be in touch to confirm payment and delivery details.',
                'showItems'    => true,
            ]
        );

        return true;
    }
}