<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Manage\System\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsletterController extends Controller
{
    // -------------------
    // SHOW - preferences form
    // -------------------
    public function index()
    {
        $user = Auth::user();

        // ---------------
        // Load or initialise the subscriber record for this user's email
        // ---------------
        $subscriber = NewsletterSubscriber::firstOrNew(['email' => $user->email]);

        return view('client.newsletter.index', compact('subscriber'));
    }

    // -------------------
    // UPDATE - save preferences via upsert
    // -------------------
    public function update(Request $request)
    {
        $user = Auth::user();

        // ---------------
        // Upsert subscriber record - create if not found, update if found
        // ---------------
        NewsletterSubscriber::updateOrCreate(
            ['email' => $user->email],
            [
                'is_verified'          => 1,
                'subscribed_at'        => now(),
                'receive_promotions'   => $request->boolean('receive_promotions'),
                'receive_suggestions'  => $request->boolean('receive_suggestions'),
                'receive_order_updates'=> $request->boolean('receive_order_updates'),
                'receive_news_updates' => $request->boolean('receive_news_updates'),
            ]
        );

        return redirect()
            ->route('client.newsletter.index')
            ->with('success', 'Your newsletter preferences have been updated.');
    }
}
