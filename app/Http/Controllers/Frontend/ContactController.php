<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Manage\System\ContactMessage;
use App\Models\Manage\SystemMessage;
use App\Services\ContactEmailService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContactController extends Controller
{
    // ---------------
    // Contact page view
    // ---------------
    public function index(): View
    {
        return view('frontend.contact.index');
    }

    // ---------------
    // Save the contact message and send a confirmation email to the sender.
    // Captcha answer: 4 + 7 = 11
    // ---------------
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'message' => 'required|string|max:3000',
            'captcha' => 'required|integer|in:11',
        ], [
            'captcha.in' => 'Incorrect answer to the spam check. Please try again.',
        ]);

        $contactMessage = ContactMessage::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'subject'     => 'Website Contact Form',
            'message'     => $request->message,
            'is_read'     => 0,
            'received_at' => now(),
        ]);

        // ---------------
        // Push to admin system inbox so it appears in manage/messages
        // ---------------
        SystemMessage::create([
            'sender_id'    => null,
            'recipient_id' => null,
            'subject'      => 'Contact Form: ' . $contactMessage->name,
            'message'      => implode("\n", [
                'Name:  ' . $contactMessage->name,
                'Email: ' . $contactMessage->email,
                '',
                $contactMessage->message,
                '',
                'View full message: ' . route('manage.contact.show', $contactMessage->id),
            ]),
            'is_read' => false,
        ]);

        // ---------------
        // Confirm to the sender their message has been received.
        // ---------------
        try {
            app(ContactEmailService::class)->sendConfirmation($contactMessage);
        } catch (\Throwable $e) {
            Log::warning('Contact form confirmation email failed', [
                'contact_id' => $contactMessage->id,
                'error'      => $e->getMessage(),
            ]);
        }

        return redirect()->back()->with('success', 'Your message has been sent! We\'ll get back to you within 1–2 business days.');
    }
}
