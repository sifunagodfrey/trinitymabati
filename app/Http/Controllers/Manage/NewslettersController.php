<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Manage\System\Newsletter;
use App\Models\Manage\System\NewsletterSubscriber;
use App\Services\NewsletterEmailService;
use Illuminate\Http\Request;

class NewslettersController extends Controller
{
    // ---------------
    // Audience column map: audience slug → subscriber consent column
    // ---------------
    private array $audienceColumns = [
        'all'           => null,
        'promotions'    => 'receive_promotions',
        'suggestions'   => 'receive_suggestions',
        'order_updates' => 'receive_order_updates',
        'news_updates'  => 'receive_news_updates',
    ];

    // -------------------
    // INDEX - campaigns list + subscribers list
    // -------------------
    public function index(Request $request)
    {
        // ---------------
        // Campaigns (latest first)
        // ---------------
        $campaigns = Newsletter::latest('created_at')->paginate(20, ['*'], 'campaigns_page');

        // ---------------
        // Subscribers - filter by consent type
        // ---------------
        $filterConsent = $request->input('consent');

        $subscribersQuery = NewsletterSubscriber::where('is_verified', 1)
            ->latest('subscribed_at');

        if ($filterConsent && array_key_exists($filterConsent, $this->audienceColumns) && $this->audienceColumns[$filterConsent]) {
            $subscribersQuery->where($this->audienceColumns[$filterConsent], 1);
        }

        $subscribers = $subscribersQuery->paginate(50, ['*'], 'subscribers_page');

        return view('manage.newsletters.index', compact('campaigns', 'subscribers', 'filterConsent'));
    }

    // -------------------
    // STORE - create campaign and send
    // -------------------
    public function store(Request $request)
    {
        $request->validate([
            'subject'  => ['required', 'string', 'max:255'],
            'audience' => ['required', 'in:all,promotions,suggestions,order_updates,news_updates'],
            'message'  => ['required', 'string'],
        ]);

        // ---------------
        // Persist the campaign record first
        // ---------------
        $campaign = Newsletter::create([
            'subject'  => $request->subject,
            'audience' => $request->audience,
            'message'  => $request->message,
            'status'   => 'Sent',
        ]);

        // ---------------
        // Resolve eligible subscribers based on audience
        // ---------------
        $column = $this->audienceColumns[$request->audience] ?? null;

        $subscribersQuery = NewsletterSubscriber::where('is_verified', 1);

        if ($column) {
            $subscribersQuery->where($column, 1);
        }

        $subscribers = $subscribersQuery->get(['email']);

        // ---------------
        // Dispatch emails and count successes / failures
        // ---------------
        $service = new NewsletterEmailService();
        $total   = $subscribers->count();
        $sent    = 0;

        if ($total === 0) {
            return redirect()
                ->route('manage.newsletters.index')
                ->with('info', 'No verified subscribers matched the selected audience. Campaign saved but no emails were sent.');
        }

        foreach ($subscribers as $subscriber) {
            $ok = $service->sendCampaign(
                $subscriber->email,
                '',
                $request->subject,
                $request->message
            );
            if ($ok) {
                $sent++;
            }
        }

        $failed = $total - $sent;

        if ($sent === 0) {
            // ---------------
            // Surface the actual send error so the admin knows what to fix
            // ---------------
            $errorDetail = $service->lastError ? ' Error: ' . $service->lastError : ' Check email configuration and server logs.';
            return redirect()
                ->route('manage.newsletters.index')
                ->with('error', "Newsletter delivery failed for all {$total} subscriber(s).{$errorDetail}");
        }

        $successMessage = "Newsletter sent to {$sent} of {$total} subscriber(s).";
        if ($failed > 0) {
            $errorDetail = $service->lastError ? ' Last error: ' . $service->lastError : ' Check server logs for details.';
            $successMessage .= " {$failed} failed.{$errorDetail}";
        }

        return redirect()
            ->route('manage.newsletters.index')
            ->with('success', $successMessage);
    }

    // -------------------
    // DESTROY - delete a campaign record
    // -------------------
    public function destroy(int $id)
    {
        Newsletter::findOrFail($id)->delete();

        return back()->with('success', 'Newsletter campaign deleted.');
    }
}
