<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Manage\SystemMessage;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    // ---------------
    // List messages with search, filters, pagination
    // ---------------
    public function index(Request $request)
    {
        $adminId = auth()->id();

        $query = SystemMessage::forAdmin($adminId)
            ->with('sender:id,first_name,last_name');

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhereHas('sender', function ($sq) use ($search) {
                      $sq->where('first_name', 'like', "%{$search}%")
                         ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        // Date filters
        if ($from = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $from);
        }
        if ($to = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $to);
        }

        $messages = $query->orderByDesc('created_at')->paginate(20);

        // Unread count for badge
        $unreadCount = SystemMessage::forAdmin($adminId)->unread()->count();

        return view('manage.messages.index', compact('messages', 'unreadCount'));
    }

    // ---------------
    // Show a single message and mark as read
    // ---------------
    public function show($id)
    {
        $adminId = auth()->id();
        $message = SystemMessage::forAdmin($adminId)
            ->with('sender:id,first_name,last_name')
            ->findOrFail($id);

        // Mark as read if not already (also handles broadcasts where recipient_id is null)
        if (!$message->is_read && ($message->recipient_id === $adminId || is_null($message->recipient_id))) {
            $message->update(['is_read' => true]);
        }

        return view('manage.messages.show', compact('message'));
    }

    // ---------------
    // Bulk actions: mark read/unread, delete
    // ---------------
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:mark_read,mark_unread,delete',
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:su_system_messages,id',
        ]);

        $ids = $request->message_ids;
        $adminId = auth()->id();

        // Ensure admin only acts on messages they have access to
        $query = SystemMessage::forAdmin($adminId)->whereIn('id', $ids);

        switch ($request->action) {
            case 'mark_read':
                $query->update(['is_read' => true]);
                break;
            case 'mark_unread':
                $query->update(['is_read' => false]);
                break;
            case 'delete':
                $query->delete();
                break;
        }

        return redirect()->route('manage.messages.index')
            ->with('success', 'Bulk action completed.');
    }

    // ---------------
    // Mark all messages as read for this admin
    // ---------------
    public function markAllRead()
    {
        $adminId = auth()->id();
        SystemMessage::forAdmin($adminId)->unread()->update(['is_read' => true]);

        return redirect()->route('manage.messages.index')
            ->with('success', 'All messages marked as read.');
    }
}