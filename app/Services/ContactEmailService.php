<?php

/*
 * Contact form emails: confirmation to the sender and admin replies,
 * plus an in-app notification when the sender has an active account.
 */

namespace App\Services;

use App\Models\Manage\System\ContactMessage;
use App\Services\Concerns\SendsPlatformEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContactEmailService
{
    use SendsPlatformEmail;

    // ---------------
    // Confirmation to the sender: message received, we'll be in touch.
    // Call immediately after the contact message is saved.
    // ---------------
    public function sendConfirmation(ContactMessage $message): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('ContactEmailService: no email settings found in su_email_settings.');
            return;
        }

        $this->send(
            $settings,
            $message->email,
            $message->name,
            'We received your message - Trinity Mabati Factory',
            'emails.system.contact_form_submission',
            ['message' => $message]
        );
    }

    // ---------------
    // Admin reply: send reply email and, if the sender has an active account,
    // also create an in-app notification in su_notifications.
    // ---------------
    public function sendReply(ContactMessage $message, string $replyText): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('ContactEmailService: no email settings found in su_email_settings.');
            return;
        }

        $this->send(
            $settings,
            $message->email,
            $message->name,
            'Re: Your message to Trinity Mabati Factory',
            'emails.system.contact_reply',
            ['message' => $message, 'replyText' => $replyText]
        );

        // ---------------
        // If the sender has an active account, push a notification to their inbox.
        // ---------------
        $user = DB::table('su_users')
            ->where('email', $message->email)
            ->where('status', 'active')
            ->first();

        if ($user) {
            DB::table('su_notifications')->insert([
                'user_id'    => $user->id,
                'title'      => 'Reply to your contact message',
                'message'    => $replyText,
                'type'       => 'system',
                'is_read'    => 0,
                'created_at' => now(),
            ]);
        }
    }
}
