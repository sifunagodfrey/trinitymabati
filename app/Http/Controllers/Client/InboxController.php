<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Core\Message;
use Illuminate\Http\Request;

class InboxController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $messages = Message::forReceiver($user->id)
            ->with('sender:id,first_name,last_name')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('client.inbox.index', compact('messages'));
    }

    public function show($id)
    {
        $user = auth()->user();

        $message = Message::forReceiver($user->id)
            ->where('id', $id)
            ->with('sender:id,first_name,last_name')
            ->firstOrFail();

        if (!$message->is_read) {
            $message->update(['is_read' => true, 'status' => 'read']);
        }

        return view('client.inbox.show', compact('message'));
    }
}