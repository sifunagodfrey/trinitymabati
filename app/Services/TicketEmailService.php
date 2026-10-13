<?php

/*
 * Support ticket emails: confirmation on creation, admin reply
 * notifications, and closure notice sent to the client.
 */

namespace App\Services;

use App\Models\Manage\System\SupportTicket;
use App\Models\Manage\System\SupportTicketReply;
use App\Services\Concerns\SendsPlatformEmail;
use Illuminate\Support\Facades\Log;

class TicketEmailService
{
    use SendsPlatformEmail;

    // ---------------
    // Ticket created: confirmation email to the client.
    // Call immediately after the ticket record is saved.
    // ---------------
    public function sendTicketCreated(SupportTicket $ticket): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('TicketEmailService: no email settings found in su_email_settings.');
            return;
        }

        $ticket->loadMissing('user');
        $user = $ticket->user;
        if (! $user) return;

        $this->send(
            $settings,
            $user->email,
            trim($user->first_name . ' ' . $user->last_name),
            "Support Ticket #{$ticket->id} Created",
            'emails.client.new_ticket',
            ['ticket' => $ticket, 'user' => $user]
        );
    }

    // ---------------
    // Admin replied: notify the client that a reply has been posted.
    // Pass the freshly-created SupportTicketReply record.
    // ---------------
    public function sendAdminReply(SupportTicket $ticket, SupportTicketReply $reply): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('TicketEmailService: no email settings found in su_email_settings.');
            return;
        }

        $ticket->loadMissing('user');
        $user = $ticket->user;
        if (! $user) return;

        $this->send(
            $settings,
            $user->email,
            trim($user->first_name . ' ' . $user->last_name),
            "New Reply on Your Support Ticket #{$ticket->id}",
            'emails.client.ticket_reply',
            ['ticket' => $ticket, 'reply' => $reply, 'user' => $user]
        );
    }

    // ---------------
    // Ticket closed by admin: notify the client the ticket is resolved.
    // ---------------
    public function sendTicketClosed(SupportTicket $ticket): void
    {
        $settings = $this->emailSettings();

        if (! $settings?->mail_host) {
            Log::warning('TicketEmailService: no email settings found in su_email_settings.');
            return;
        }

        $ticket->loadMissing('user');
        $user = $ticket->user;
        if (! $user) return;

        $this->send(
            $settings,
            $user->email,
            trim($user->first_name . ' ' . $user->last_name),
            "Support Ticket #{$ticket->id} Closed",
            'emails.client.ticket_closed',
            ['ticket' => $ticket, 'user' => $user]
        );
    }
}
