<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreReplyRequest;
use App\Http\Requests\Client\StoreTicketRequest;
use App\Models\Manage\System\SupportTicket;
use App\Models\Manage\System\SupportTicketReply;
use App\Services\TicketEmailService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    // ---------------
    // My Tickets List
    // ---------------
    public function index()
    {
        $userId  = Auth::id();
        $tickets = SupportTicket::where('user_id', $userId)
            ->with('lastReply')
            ->orderByDesc('created_at')
            ->paginate(15);

        $ticketIds    = $tickets->pluck('id')->toArray();
        $unreadCounts = [];

        if ($ticketIds) {
            $rows = DB::table('su_support_ticket_replies as r')
                ->join('su_users as u', 'u.id', '=', 'r.sender_id')
                ->join('su_user_roles as ur', 'ur.user_id', '=', 'u.id')
                ->whereIn('r.ticket_id', $ticketIds)
                ->where('ur.role_id', 1)
                ->where('r.is_read_by_user', 0)
                ->selectRaw('r.ticket_id, COUNT(*) as cnt')
                ->groupBy('r.ticket_id')
                ->get();

            foreach ($rows as $row) {
                $unreadCounts[$row->ticket_id] = $row->cnt;
            }
        }

        return view('client.tickets.index', compact('tickets', 'unreadCounts'));
    }

    // ---------------
    // Create Ticket Form
    // ---------------
    public function create()
    {
        return view('client.tickets.create');
    }

    // ---------------
    // Store New Ticket
    // ---------------
    public function store(StoreTicketRequest $request)
    {
        $userId         = Auth::id();
        $attachmentPath = $this->handleAttachment($request);

        $ticket = SupportTicket::create([
            'user_id'           => $userId,
            'subject'           => $request->subject,
            'message'           => $request->message,
            'department'        => $request->department,
            'urgency'           => $request->urgency,
            'status'            => 'open',
            'assigned_admin_id' => null,
            'last_reply_at'     => now(),
        ]);

        if ($attachmentPath) {
            SupportTicketReply::create([
                'ticket_id'        => $ticket->id,
                'sender_id'        => $userId,
                'message'          => $request->message,
                'attachment_path'  => $attachmentPath,
                'is_read_by_admin' => 0,
                'is_read_by_user'  => 1,
            ]);
        }

        $this->logSystemEvent($userId, "Customer (ID: {$userId}) created Ticket #{$ticket->id}.");
        $this->createSystemMessage(
            $userId,
            'New Ticket Created',
            "Customer created Ticket #{$ticket->id}.",
            route('manage.tickets.show', $ticket->id)
        );

        // ---------------
        // Notify the client their ticket has been received.
        // ---------------
        try {
            app(TicketEmailService::class)->sendTicketCreated($ticket);
        } catch (\Throwable $e) {
            Log::warning('Ticket created email failed', [
                'ticket_id' => $ticket->id,
                'error'     => $e->getMessage(),
            ]);
        }

        return redirect()->route('client.tickets.index')
            ->with('success', 'Your support ticket has been submitted successfully.');
    }

    // ---------------
    // View Ticket + Replies
    // ---------------
    public function show(int $id)
    {
        $ticket = SupportTicket::where('user_id', Auth::id())->findOrFail($id);

        // Mark admin replies as read
        SupportTicketReply::where('ticket_id', $id)
            ->where('is_read_by_user', 0)
            ->whereExists(function ($q) {
                $q->select(DB::raw(1))
                  ->from('su_user_roles')
                  ->whereColumn('su_user_roles.user_id', 'su_support_ticket_replies.sender_id')
                  ->where('su_user_roles.role_id', 1);
            })
            ->update(['is_read_by_user' => 1]);

        $replies = SupportTicketReply::where('ticket_id', $id)
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        return view('client.tickets.show', compact('ticket', 'replies'));
    }

    // ---------------
    // Store Reply
    // ---------------
    public function storeReply(StoreReplyRequest $request, int $id)
    {
        $userId = Auth::id();
        $ticket = SupportTicket::where('user_id', $userId)->findOrFail($id);

        $attachmentPath = $this->handleAttachment($request);

        SupportTicketReply::create([
            'ticket_id'        => $ticket->id,
            'sender_id'        => $userId,
            'message'          => $request->reply_message,
            'attachment_path'  => $attachmentPath,
            'is_read_by_admin' => 0,
            'is_read_by_user'  => 1,
        ]);

        $ticket->update([
            'last_reply_at' => now(),
            'status'        => 'open',
        ]);

        $user     = Auth::user();
        $userName = $user->first_name . ' ' . $user->last_name;
        $this->logSystemEvent($userId, "Customer (ID: {$userId}, Name: {$userName}) replied to Ticket #{$id}.");
        $this->createSystemMessage(
            $userId,
            'Ticket Reply',
            "{$userName} replied to Ticket #{$id}.",
            route('manage.tickets.show', $id)
        );

        $settings = DB::table('su_email_settings')->orderByDesc('id')->first();
        if ($settings) {
            $this->sendNotificationEmail(
                $settings->mail_from_address ?: $settings->mail_username,
                'Trinity Mabati Factory Support',
                "New Customer Reply on Ticket #{$id}",
                "A customer has replied to Ticket <strong>#{$id}</strong>.<br><br>
                 <strong>Customer:</strong> {$userName}<br>
                 <strong>Subject:</strong> {$ticket->subject}<br><br>
                 <strong>Reply:</strong><br>{$request->reply_message}"
            );
        }

        return redirect()->route('client.tickets.show', $id)
            ->with('success', 'Your reply has been sent.');
    }

    // ---------------
    // Handle file attachment
    // ---------------
    private function handleAttachment($request, string $field = 'attachment'): ?string
    {
        if (!$request->hasFile($field)) {
            return null;
        }

        $file     = $request->file($field);
        $safeName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = $safeName . '_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();

        $file->storeAs('tickets', $filename, 'public');

        return 'tickets/' . $filename;
    }

    // ---------------
    // Log system event
    // ---------------
    private function logSystemEvent(int $userId, string $description): void
    {
        DB::table('su_system_logs')->insert([
            'user_id'     => $userId,
            'description' => $description,
            'ip_address'  => request()->ip(),
            'user_agent'  => request()->userAgent(),
            'created_at'  => now(),
        ]);
    }

    // ---------------
    // Create system message
    // ---------------
    private function createSystemMessage(int $senderId, string $subject, string $message, string $relatedUrl = null): void
    {
        DB::table('su_system_messages')->insert([
            'sender_id'    => $senderId,
            'recipient_id' => null,
            'subject'      => $subject,
            'message'      => $message,
            'related_url'  => $relatedUrl,
            'is_read'      => 0,
            'is_user_read' => 0,
            'created_at'   => now(),
        ]);
    }

    // ---------------
    // Send a raw HTML notification email via SMTP
    // ---------------
    private function sendNotificationEmail(string $toEmail, string $toName, string $subject, string $html): void
    {
        try {
            $settings = DB::table('su_email_settings')->orderByDesc('id')->first();
            if (!$settings) {
                return;
            }

            config([
                'mail.mailers.platform' => [
                    'transport'  => $settings->mail_driver ?: 'smtp',
                    'host'       => $settings->mail_host,
                    'port'       => $settings->mail_port,
                    'encryption' => $settings->mail_encryption ?: null,
                    'username'   => $settings->mail_username,
                    'password'   => $settings->mail_password,
                    'timeout'    => null,
                ],
            ]);

            Mail::mailer('platform')->html($html, function ($message) use ($toEmail, $toName, $subject, $settings) {
                $message->to($toEmail, $toName)
                    ->subject($subject)
                    ->from(
                        $settings->mail_from_address ?: $settings->mail_username,
                        $settings->mail_from_name ?: null
                    );
            });
        } catch (\Throwable $e) {
            DB::table('su_system_logs')->insert([
                'user_id'     => Auth::id(),
                'description' => 'Notification email failed: ' . $e->getMessage(),
                'ip_address'  => request()->ip(),
                'user_agent'  => request()->userAgent(),
                'created_at'  => now(),
            ]);
        }
    }
}
