<?php

/* -------------------
   Setting model mapped to su_settings. Key-value store for site-wide
   configuration such as contact details, social media links and the
   referral program options. Includes cached helpers for reads.
------------------- */

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $table = 'su_settings';

    public $timestamps = false;

    protected $fillable = [
        'setting_key',
        'setting_value',
        'description',
    ];

    // ---------------
    // Read one setting value (cached)
    // ---------------
    public static function get(string $key, ?string $default = null): ?string
    {
        $all = static::allCached();

        return array_key_exists($key, $all) && $all[$key] !== '' ? $all[$key] : $default;
    }

    // ---------------
    // Write one setting value and refresh the cache
    // ---------------
    public static function put(string $key, ?string $value, ?string $description = null): void
    {
        static::updateOrCreate(
            ['setting_key' => $key],
            ['setting_value' => $value ?? ''] + ($description ? ['description' => $description] : [])
        );

        Cache::forget('site_settings_all');
    }

    // ---------------
    // All settings as [key => value], cached for 10 minutes
    // ---------------
    public static function allCached(): array
    {
        return Cache::remember('site_settings_all', 600, function () {
            return static::pluck('setting_value', 'setting_key')->toArray();
        });
    }

    // ---------------
    // Public site contact and social values with safe fallbacks,
    // shared with every frontend view by the view composer.
    // ---------------
    public static function siteContact(): array
    {
        $all = static::allCached();

        $value = fn (string $key) => isset($all[$key]) && trim((string) $all[$key]) !== ''
            ? trim((string) $all[$key])
            : null;

        $whatsappDigits = preg_replace('/\D+/', '', (string) ($value('contact_whatsapp') ?? ''));

        return [
            'email'        => $value('contact_email'),
            'phone'        => $value('contact_phone'),
            'phone_href'   => 'tel:' . preg_replace('/[^0-9+]/', '', (string) ($value('contact_phone') ?? '')),
            'whatsapp'     => $whatsappDigits ?: null,
            'whatsapp_url' => $whatsappDigits ? 'https://wa.me/' . $whatsappDigits : null,
            'address'      => $value('contact_address'),
            'branches' => [
                [
                    'name' => array_key_exists('branch_nairobi_name', $all) ? trim((string) $all['branch_nairobi_name']) : 'Nairobi Branch',
                    'address' => array_key_exists('branch_nairobi_address', $all) ? trim((string) $all['branch_nairobi_address']) : 'GM, Enterprise Road B, Nairobi.',
                    'phone' => array_key_exists('branch_nairobi_phone', $all) ? trim((string) $all['branch_nairobi_phone']) : '+254 740 550 105',
                ],
                [
                    'name' => array_key_exists('branch_corporate_name', $all) ? trim((string) $all['branch_corporate_name']) : 'Corporate Office',
                    'address' => array_key_exists('branch_corporate_address', $all) ? trim((string) $all['branch_corporate_address']) : 'Pili Trade Center, opposite Hilton Hotel, Mombasa Road, Nairobi.',
                    'phone' => array_key_exists('branch_corporate_phone', $all) ? trim((string) $all['branch_corporate_phone']) : '',
                ],
                [
                    'name' => array_key_exists('branch_migori_name', $all) ? trim((string) $all['branch_migori_name']) : 'Migori Branch',
                    'address' => array_key_exists('branch_migori_address', $all) ? trim((string) $all['branch_migori_address']) : 'Next to Dolion Hotel, Migori.',
                    'phone' => array_key_exists('branch_migori_phone', $all) ? trim((string) $all['branch_migori_phone']) : '+254 796 593 842',
                ],
            ],
            'socials'      => array_filter([
                'facebook'  => $value('social_facebook'),
                'instagram' => $value('social_instagram'),
                'twitter'   => $value('social_twitter'),
                'tiktok'    => $value('social_tiktok'),
                'youtube'   => $value('social_youtube'),
                'linkedin'  => $value('social_linkedin'),
            ]),
        ];
    }

    // ---------------
    // Site identity, uploaded artwork and theme colours.
    // Every layout receives this array as $branding.
    // ---------------
    public static function siteBranding(): array
    {
        $all = static::allCached();
        $value = fn (string $key, ?string $fallback = null) => isset($all[$key]) && trim((string) $all[$key]) !== ''
            ? trim((string) $all[$key])
            : $fallback;
        $assetUrl = fn (string $key, string $fallback) => url($value($key, $fallback));

        return [
            'site_name'         => $value('site_name', config('app.name')),
            'logo_main'         => $assetUrl('logo_main', 'public/images/suweka-logo.png'),
            'logo_white'        => $assetUrl('logo_white', 'public/images/suweka-logo.png'),
            'logo_dark'         => $assetUrl('logo_dark', 'public/images/suweka-logo.png'),
            'site_icon'         => $assetUrl('site_icon', 'public/images/suweka-icon.png'),
            'apple_touch_icon'  => $assetUrl('apple_touch_icon', 'public/images/suweka-icon.png'),
            'primary_color'     => $value('primary_color', '#713FCE'),
            'secondary_color'   => $value('secondary_color', '#AD70D4'),
            'tertiary_color'    => $value('tertiary_color', '#201436'),
        ];
    }
}
