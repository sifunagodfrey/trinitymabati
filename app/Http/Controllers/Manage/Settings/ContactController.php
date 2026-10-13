<?php

/* -------------------
   Admin contact and social settings - manage the public email, phone,
   WhatsApp number, location and social media links shown in the site
   header, footer and contact page.
------------------- */

namespace App\Http\Controllers\Manage\Settings;

use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class ContactController extends Controller
{
    // ---------------
    // The managed keys with their form labels and help text
    // ---------------
    private const FIELDS = [
        'contact_email'    => ['label' => 'Support Email',     'help' => 'Shown in the top bar, footer and contact page.'],
        'contact_phone'    => ['label' => 'Phone Number',      'help' => 'Shown in the top bar, footer and contact page.'],
        'contact_whatsapp' => ['label' => 'WhatsApp Number',   'help' => 'International format without plus, e.g. 254758821800. Used for wa.me chat links.'],
        'contact_address'  => ['label' => 'Location / Address','help' => 'Physical location shown in the footer and contact page.'],
        'social_facebook'  => ['label' => 'Facebook URL',      'help' => 'Full page URL. Leave blank to hide the icon.'],
        'social_instagram' => ['label' => 'Instagram URL',     'help' => 'Full profile URL. Leave blank to hide the icon.'],
        'social_twitter'   => ['label' => 'X (Twitter) URL',   'help' => 'Full profile URL. Leave blank to hide the icon.'],
        'social_tiktok'    => ['label' => 'TikTok URL',        'help' => 'Full profile URL. Leave blank to hide the icon.'],
        'social_youtube'   => ['label' => 'YouTube URL',       'help' => 'Full channel URL. Leave blank to hide the icon.'],
        'social_linkedin'  => ['label' => 'LinkedIn URL',      'help' => 'Full page URL. Leave blank to hide the icon.'],
    ];

    // ---------------
    // Settings form
    // ---------------
    public function index(): View
    {
        $stored = Setting::whereIn('setting_key', array_keys(self::FIELDS))
            ->pluck('setting_value', 'setting_key')
            ->toArray();

        $fields = [];
        foreach (self::FIELDS as $key => $meta) {
            $fields[$key] = $meta + ['value' => $stored[$key] ?? ''];
        }

        return view('manage.settings.contact.index', compact('fields'));
    }

    // ---------------
    // Persist settings
    // ---------------
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'contact_email'    => 'nullable|email|max:150',
            'contact_phone'    => 'nullable|string|max:30',
            'contact_whatsapp' => 'nullable|string|max:20|regex:/^[0-9 +]*$/',
            'contact_address'  => 'nullable|string|max:255',
            'social_facebook'  => 'nullable|url|max:255',
            'social_instagram' => 'nullable|url|max:255',
            'social_twitter'   => 'nullable|url|max:255',
            'social_tiktok'    => 'nullable|url|max:255',
            'social_youtube'   => 'nullable|url|max:255',
            'social_linkedin'  => 'nullable|url|max:255',
        ]);

        foreach (array_keys(self::FIELDS) as $key) {
            Setting::updateOrCreate(
                ['setting_key' => $key],
                ['setting_value' => trim((string) $request->input($key, ''))]
            );
        }

        Cache::forget('site_settings_all');

        return redirect()->route('manage.settings.contact.index')
            ->with('success', 'Contact and social settings saved.');
    }
}
