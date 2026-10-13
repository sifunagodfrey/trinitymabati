<?php

namespace App\Http\Controllers\Manage\System;

use App\Http\Controllers\Controller;
use App\Models\Manage\System\ContactMessage;
use App\Services\ContactEmailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContactController extends Controller
{
    // ---------------
    // Paginated list of all contact form submissions
    // ---------------
    public function index(Request $request): View
    {
        $search = trim($request->input('search', ''));
        $filter = $request->input('filter', '');

        $query = ContactMessage::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%")
                       ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->when($filter === 'unread', fn ($q) => $q->where('is_read', 0))
            ->when($filter === 'read',   fn ($q) => $q->where('is_read', 1))
            ->orderByDesc('received_at');

        $messages = $query->paginate(20)->withQueryString();

        return view('manage.contact.index', compact('messages', 'search', 'filter'));
    }

    // ---------------
    // View a single contact message and mark it as read
    // ---------------
    public function show(string $id): View
    {
        $contactMessage = ContactMessage::findOrFail($id);

        if (! $contactMessage->is_read) {
            $contactMessage->update(['is_read' => 1]);
        }

        return view('manage.contact.show', compact('contactMessage'));
    }

    // ---------------
    // Send an admin reply to the contact message sender.
    // If the sender has an active account, also delivers to their inbox.
    // ---------------
    public function reply(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'reply_message' => 'required|string|max:5000',
        ]);

        $contactMessage = ContactMessage::findOrFail($id);

        try {
            app(ContactEmailService::class)->sendReply($contactMessage, $request->reply_message);
        } catch (\Throwable $e) {
            Log::warning('Contact reply email failed', [
                'contact_id' => $contactMessage->id,
                'error'      => $e->getMessage(),
            ]);
            return redirect()->back()->with('error', 'Reply could not be sent: ' . $e->getMessage());
        }

        $contactMessage->update(['is_read' => 1]);

        return redirect()->route('manage.contact.show', $id)
            ->with('success', 'Reply sent to ' . $contactMessage->email . '.');
    }
}
