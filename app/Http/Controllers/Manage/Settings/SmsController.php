<?php

/* -------------------
   Admin SMS settings - configure the Africa's Talking credentials and
   sender id, switch SMS on or off, send a test message and review the
   recent delivery log.
------------------- */

namespace App\Http\Controllers\Manage\Settings;

use App\Http\Controllers\Controller;
use App\Models\Manage\System\SmsLog;
use App\Models\Manage\System\SmsSetting;
use App\Services\Sms\SmsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SmsController extends Controller
{
    // ---------------
    // Settings form with recent log
    // ---------------
    public function index(): View
    {
        $settings = SmsSetting::orderByDesc('id')->first()
            ?? new SmsSetting([
                'provider'    => 'africastalking',
                'environment' => 'sandbox',
                'is_active'   => true,
            ]);

        $logs = SmsLog::orderByDesc('id')->limit(25)->get();

        return view('manage.settings.sms.index', compact('settings', 'logs'));
    }

    // ---------------
    // Persist settings
    // ---------------
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username'    => 'required|string|max:100',
            'api_key'     => 'required|string|max:255',
            'sender_id'   => 'nullable|string|max:20',
            'environment' => 'required|in:sandbox,production',
            'is_active'   => 'required|boolean',
        ]);

        $settings = SmsSetting::orderByDesc('id')->first();

        if ($settings) {
            $settings->update($data + ['updated_at' => now()]);
        } else {
            SmsSetting::create($data + ['provider' => 'africastalking', 'updated_at' => now()]);
        }

        return redirect()->route('manage.settings.sms.index')
            ->with('success', 'SMS settings saved.');
    }

    // ---------------
    // Send a test message to confirm the configuration
    // ---------------
    public function test(Request $request): RedirectResponse
    {
        $request->validate([
            'test_phone' => 'required|string|max:15',
        ]);

        $sms = app(SmsService::class);

        if (! $sms->isActive()) {
            return back()->with('error', 'SMS is disabled or the credentials are not configured yet.');
        }

        $sent = $sms->send(
            $request->input('test_phone'),
            config('app.name', 'Trinity Mabati Factory') . ' test message: your SMS configuration works.',
            'test',
            auth()->id()
        );

        return back()->with(
            $sent ? 'success' : 'error',
            $sent ? 'Test message sent. Check the phone and the log below.'
                  : 'The test message failed. Check the log below for the provider error.'
        );
    }
}
