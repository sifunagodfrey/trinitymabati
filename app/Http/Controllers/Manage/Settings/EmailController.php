<?php

namespace App\Http\Controllers\Manage\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Settings\UpdateEmailSettingsRequest;
use App\Models\Manage\System\EmailSetting;

class EmailController extends Controller
{
    // ---------------
    // Show Email Settings Form
    // ---------------
    public function index()
    {
        $emailSettings = EmailSetting::first();

        return view('manage.settings.email.index', compact('emailSettings'));
    }

    // ---------------
    // Save Email Settings
    // ---------------
    public function update(UpdateEmailSettingsRequest $request)
    {
        $data = [
            'mail_driver'       => $request->mail_driver,
            'mail_host'         => $request->smtp_host,
            'mail_port'         => $request->smtp_port,
            'mail_username'     => $request->smtp_user,
            'mail_encryption'   => $request->smtp_encrypt,
            'mail_from_address' => $request->mail_from,
            'mail_from_name'    => $request->mail_name,
        ];

        // ---------------
        // Only overwrite password when a new one is provided
        // ---------------
        if (filled($request->smtp_pass)) {
            $data['mail_password'] = $request->smtp_pass;
        }

        $existing = EmailSetting::first();
        if ($existing) {
            $existing->update($data);
        } else {
            EmailSetting::create($data);
        }

        return redirect()->route('manage.settings.email.index')
            ->with('success', 'Email settings updated successfully.');
    }
}
