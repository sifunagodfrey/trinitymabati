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
        'contact_phone'    => ['label' => 'Call Center Phone (Primary)', 'help' => 'Main company number shown in the top bar, Contact Us and footer. Branch numbers remain separate.'],
        'contact_whatsapp' => ['label' => 'WhatsApp Number',   'help' => 'International format without plus, e.g. 254758821800. Used for wa.me chat links.'],
        'contact_address'  => ['label' => 'Location / Address','help' => 'Physical location shown in the footer and contact page.'],
        'branch_nairobi_name' => ['label' => 'Nairobi Branch Name', 'help' => 'Shown on Contact Us.'],
        'branch_nairobi_address' => ['label' => 'Nairobi Branch Address', 'help' => 'Address shown under the Nairobi outlet on Contact Us.'],
        'branch_nairobi_phone' => ['label' => 'Nairobi Branch Phone', 'help' => 'Shown on Contact Us and linked to the phone dialler.'],
        'branch_corporate_name' => ['label' => 'Corporate Office Name', 'help' => 'Shown on Contact Us, About Us and in the footer.'],
        'branch_corporate_address' => ['label' => 'Corporate Office Address', 'help' => 'Full corporate office location.'],
        'branch_corporate_phone' => ['label' => 'Corporate Office Phone (optional)', 'help' => 'Leave blank if this office uses the main call center.'],
        'branch_migori_name' => ['label' => 'Migori Branch Name', 'help' => 'Shown on Contact Us.'],
        'branch_migori_address' => ['label' => 'Migori Branch Address', 'help' => 'Address shown under the Migori outlet on Contact Us.'],
        'branch_migori_phone' => ['label' => 'Migori Branch Phone', 'help' => 'Shown on Contact Us and linked to the phone dialler.'],
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

        $defaults = [
            'branch_nairobi_name' => 'Nairobi Branch',
            'branch_nairobi_address' => 'GM, Enterprise Road B, Nairobi.',
            'branch_nairobi_phone' => '+254 740 550 105',
            'branch_corporate_name' => 'Corporate Office',
            'branch_corporate_address' => 'Pili Trade Center, opposite Hilton Hotel, Mombasa Road, Nairobi.',
            'branch_corporate_phone' => '',
            'branch_migori_name' => 'Migori Branch',
            'branch_migori_address' => 'Next to Dolion Hotel, Migori.',
            'branch_migori_phone' => '+254 796 593 842',
        ];
        foreach ($defaults as $key => $default) {
            if (!array_key_exists($key, $stored)) {
                $fields[$key]['value'] = $default;
            }
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
            'contact_phone'    => ['nullable', 'string', 'max:30', 'regex:/^\+?[0-9][0-9() .-]*$/', 'regex:/[0-9].*[0-9]/'],
            'contact_whatsapp' => 'nullable|string|max:20|regex:/^[0-9 +]*$/',
            'contact_address'  => 'nullable|string|max:255',
            'branch_nairobi_name' => 'required|string|max:100',
            'branch_nairobi_address' => 'required|string|max:255',
            'branch_nairobi_phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+() .-]+$/'],
            'branch_corporate_name' => 'required|string|max:100',
            'branch_corporate_address' => 'required|string|max:255',
            'branch_corporate_phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+() .-]+$/'],
            'branch_migori_name' => 'required|string|max:100',
            'branch_migori_address' => 'required|string|max:255',
            'branch_migori_phone' => ['required', 'string', 'max:30', 'regex:/^[0-9+() .-]+$/'],
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
