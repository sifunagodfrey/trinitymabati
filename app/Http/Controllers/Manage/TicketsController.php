<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Tickets\StoreReplyRequest;
use App\Http\Requests\Manage\Tickets\StoreTicketRequest;
use App\Models\Manage\System\SupportTicket;
use App\Models\Manage\System\SupportTicketReply;
use App\Services\TicketEmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TicketsController extends Controller
{
    // ---------------
    // All Tickets List
    // ---------------
    public function index(Request $request)
    {
        $search  = trim($request->get('search', ''));
        $status  = $request->get('status', '');
        $urgency = $request->get('urgency', '');

        $validStatuses  = ['open', 'in_progress', 'on_hold', 'resolved', 'closed'];
        $validUrgencies = ['low', 'medium', 'high', 'critical'];

        $query = SupportTicket::with('user')
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($sq) use ($search) {
                    $sq->where('subject', 'like', "%{$search}%")
                       ->orWhereHas('user', fn ($u) => $u->where('first_name', 'like', "%{$search}%")
                           ->orWhere('last_name', 'like', "%{$search}%")
                           ->orWhere('email', 'like', "%{$search}%"));
                });
            })
            ->when(in_array($status, $validStatuses), fn ($q) => $q->where('status', $status))
            ->when(in_array($urgency, $validUrgencies), fn ($q) => $q->where('urgency', $urgency))
            ->orderByDesc('created_at');

        $tickets = $query->paginate(15)->withQueryString();

        return view('manage.tickets.index', compact('tickets', 'search', 'status', 'urgency'));
    }

    // ---------------
    // Generate Ticket Form
    // ---------------
    public function create(Request $request)
    {
        $productFromUrl = null;

        $productId = (int) $request->get('product_id', 0);

        if ($productId > 0) {
            $productFromUrl = DB::table('su_products')
                ->where('id', $productId)
                ->select('id', 'name')
                ->first();
        }

        return view('manage.tickets.create', compact('productFromUrl'));
    }

    // ---------------
    // Store Generated Ticket
    // ---------------
    public function store(StoreTicketRequest $request)
    {
        $actorId        = Auth::id();
        $attachmentPath = $this->handleAttachment($request);

        $ticket = SupportTicket::create([
            'user_id'           => $request->user_id,
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
                'sender_id'        => $actorId,
                'message'          => $request->message,
                'attachment_path'  => $attachmentPath,
                'is_read_by_admin' => 1,
                'is_read_by_user'  => 0,
            ]);
        }

        $actorName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $this->logSystemEvent($actorId, "Admin ({$actorName}) created Ticket #{$ticket->id} for User ID {$request->user_id}.");
        $this->createSystemMessage(
            $actorId,
            'New Ticket Created',
            "Admin created Ticket #{$ticket->id} for User ID {$request->user_id}.",
            route('manage.tickets.show', $ticket->id)
        );

        // ---------------
        // Notify the user a ticket has been opened on their behalf.
        // ---------------
        try {
            app(TicketEmailService::class)->sendTicketCreated($ticket);
        } catch (\Throwable $e) {
            Log::warning('Ticket created email failed (admin store)', [
                'ticket_id' => $ticket->id,
                'error'     => $e->getMessage(),
            ]);
        }

        return redirect()->route('manage.tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    // ---------------
    // View Ticket
    // ---------------
    public function show(int $id)
    {
        $ticket = SupportTicket::with(['user', 'assignedAdmin'])->findOrFail($id);

        // Mark customer replies as read by admin
        SupportTicketReply::where('ticket_id', $id)
            ->where('is_read_by_admin', 0)
            ->whereExists(function ($q) {
                $q->select(DB::raw(1))
                  ->from('su_user_roles')
                  ->whereColumn('su_user_roles.user_id', 'su_support_ticket_replies.sender_id')
                  ->where('su_user_roles.role_id', '<>', 1);
            })
            ->update(['is_read_by_admin' => 1]);

        $replies = SupportTicketReply::where('ticket_id', $id)
            ->with('sender')
            ->orderBy('created_at')
            ->get();

        $admins = DB::table('su_users')
            ->join('su_user_roles', 'su_user_roles.user_id', '=', 'su_users.id')
            ->where('su_user_roles.role_id', 1)
            ->orderBy('first_name')
            ->select('su_users.id', 'first_name', 'last_name')
            ->get();

        return view('manage.tickets.show', compact('ticket', 'replies', 'admins'));
    }

    // ---------------
    // Store Admin Reply
    // ---------------
    public function storeReply(StoreReplyRequest $request, int $id)
    {
        $adminId  = Auth::id();
        $ticket   = SupportTicket::with('user')->findOrFail($id);
        $adminName = Auth::user()->first_name . ' ' . Auth::user()->last_name;

        $attachmentPath = $this->handleAttachment($request);

        $reply = SupportTicketReply::create([
            'ticket_id'        => $ticket->id,
            'sender_id'        => $adminId,
            'message'          => $request->reply_message,
            'attachment_path'  => $attachmentPath,
            'is_read_by_admin' => 1,
            'is_read_by_user'  => 0,
        ]);

        $ticket->update([
            'last_reply_at' => now(),
            'status'        => 'in_progress',
        ]);

        $this->logSystemEvent($adminId, "Admin ({$adminName}) replied to Ticket #{$id}.");

        // ---------------
        // Notify the client that the admin has posted a reply.
        // ---------------
        try {
            app(TicketEmailService::class)->sendAdminReply($ticket, $reply);
        } catch (\Throwable $e) {
            Log::warning('Ticket reply email failed', [
                'ticket_id' => $id,
                'error'     => $e->getMessage(),
            ]);
        }

        return redirect()->route('manage.tickets.show', $id)
            ->with('success', 'Reply sent successfully.');
    }

    // ---------------
    // Update Ticket Status
    // ---------------
    public function updateStatus(Request $request, int $id)
    {
        $status  = $request->input('status');
        $allowed = ['open', 'in_progress', 'on_hold', 'resolved', 'closed'];

        if (!in_array($status, $allowed)) {
            return redirect()->back()->with('error', 'Invalid status value.');
        }

        SupportTicket::findOrFail($id)->update(['status' => $status]);

        $actorId = Auth::id();
        $this->logSystemEvent($actorId, "Admin (ID: {$actorId}) updated Ticket #{$id} status to '{$status}'.");

        return redirect()->route('manage.tickets.show', $id)
            ->with('success', 'Ticket status updated.');
    }

    // ---------------
    // Assign Ticket to Admin
    // ---------------
    public function assign(Request $request, int $id)
    {
        $adminId = $request->input('assigned_admin_id') ?: null;

        SupportTicket::findOrFail($id)->update(['assigned_admin_id' => $adminId]);

        $actorId = Auth::id();
        $this->logSystemEvent($actorId, "Admin (ID: {$actorId}) assigned Ticket #{$id} to Admin ID {$adminId}.");

        return redirect()->route('manage.tickets.show', $id)
            ->with('success', 'Ticket assigned.');
    }

    // ---------------
    // Close Ticket
    // ---------------
    public function close(int $id)
    {
        $ticket  = SupportTicket::with('user')->findOrFail($id);
        $actorId = Auth::id();

        if ($ticket->status !== 'closed') {
            $ticket->update(['status' => 'closed']);

            $this->logSystemEvent($actorId, "Admin (ID: {$actorId}) closed Ticket #{$id}.");

            // ---------------
            // Notify the client their ticket has been resolved and closed.
            // ---------------
            try {
                app(TicketEmailService::class)->sendTicketClosed($ticket);
            } catch (\Throwable $e) {
                Log::warning('Ticket closed email failed', [
                    'ticket_id' => $id,
                    'error'     => $e->getMessage(),
                ]);
            }
        }

        return redirect()->route('manage.tickets.show', $id)
            ->with('success', 'Ticket closed.');
    }

    // ---------------
    // User Search (JSON for autocomplete)
    // ---------------
    public function searchUsers(Request $request)
    {
        $q = trim($request->get('q', ''));

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $users = DB::table('su_users')
            ->where(function ($query) use ($q) {
                $query->where('first_name', 'like', "%{$q}%")
                      ->orWhere('last_name', 'like', "%{$q}%")
                      ->orWhere('email', 'like', "%{$q}%");
            })
            ->select('id', 'first_name', 'last_name', 'email')
            ->limit(10)
            ->get();

        return response()->json($users);
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

}
