<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Tier {{ $isUpgrade ? 'Upgrade' : 'Update' }}</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7f6;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);max-width:600px;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#AAC527;padding:28px 32px;text-align:center;">
                            <h1 style="color:#ffffff;margin:0;font-size:22px;font-weight:700;letter-spacing:-0.3px;">Trinity Mabati Factory</h1>
                            <p style="color:black;margin:6px 0 0;font-size:13px;">Loyalty Rewards Programme</p>
                        </td>
                    </tr>

                    <!-- Status Banner -->
                    <tr>
                        <td style="background-color:{{ $isUpgrade ? '#ecfdf5' : '#fefce8' }};border-bottom:1px solid {{ $isUpgrade ? '#a7f3d0' : '#fde68a' }};padding:14px 32px;text-align:center;">
                            <p style="margin:0;font-size:13px;color:{{ $isUpgrade ? '#065f46' : '#92400e' }};font-weight:700;">
                                @if($isUpgrade)
                                    &#127881; Congratulations &mdash; you've been upgraded to <strong>{{ $newTier->name }}</strong>!
                                @else
                                    &#8505; Your loyalty tier has been updated to <strong>{{ $newTier->name }}</strong>
                                @endif
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#111827;font-size:20px;margin:0 0 16px;font-weight:700;">Hi {{ $user->first_name }},</h2>

                            @if($isUpgrade)
                                <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                    Your loyalty and dedication have paid off! You've been promoted to the
                                    <strong>{{ $newTier->name }}</strong> tier on Trinity Mabati Factory.
                                    Enjoy your enhanced rewards and benefits.
                                </p>
                            @else
                                <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                    Your loyalty tier has been updated. Your current tier is now
                                    <strong>{{ $newTier->name }}</strong>. Continue earning points to unlock higher tiers.
                                </p>
                            @endif

                            <!-- Tier Comparison -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                <tr>
                                    <!-- Old Tier -->
                                    <td width="48%" style="background-color:#f3f4f6;border-radius:8px;padding:16px 20px;text-align:center;vertical-align:top;">
                                        <p style="margin:0 0 6px;font-size:11px;color:#9ca3af;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Previous Tier</p>
                                        <p style="margin:0;font-size:20px;font-weight:700;color:#6b7280;">{{ $oldTier->name }}</p>
                                        <p style="margin:4px 0 0;font-size:12px;color:#9ca3af;">{{ number_format($oldTier->discount_percent, 1) }}% discount</p>
                                    </td>
                                    <!-- Arrow -->
                                    <td width="4%" style="text-align:center;vertical-align:middle;font-size:20px;color:#AAC527;">&#8594;</td>
                                    <!-- New Tier -->
                                    <td width="48%" style="background-color:{{ $isUpgrade ? '#ecfdf5' : '#fefce8' }};border:2px solid {{ $isUpgrade ? '#6ee7b7' : '#fde68a' }};border-radius:8px;padding:16px 20px;text-align:center;vertical-align:top;">
                                        <p style="margin:0 0 6px;font-size:11px;color:{{ $isUpgrade ? '#059669' : '#b45309' }};font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">New Tier</p>
                                        <p style="margin:0;font-size:20px;font-weight:700;color:{{ $isUpgrade ? '#059669' : '#b45309' }};">{{ $newTier->name }}</p>
                                        <p style="margin:4px 0 0;font-size:12px;color:{{ $isUpgrade ? '#059669' : '#b45309' }};">{{ number_format($newTier->discount_percent, 1) }}% discount</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Benefits Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <p style="margin:0 0 10px;font-size:12px;color:#374151;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">{{ $newTier->name }} Benefits</p>
                                        <table width="100%" cellpadding="4" cellspacing="0">
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;width:160px;">Discount at Checkout</td>
                                                <td style="font-size:14px;color:#111827;font-weight:600;">{{ number_format($newTier->discount_percent, 1) }}%</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;">Points Multiplier</td>
                                                <td style="font-size:14px;color:#111827;font-weight:600;">{{ number_format($newTier->points_multiplier, 1) }}×</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/account/loyalty') }}"
                                           style="display:inline-block;background-color:#AAC527;color:#ffffff;padding:13px 32px;border-radius:6px;text-decoration:none;font-size:15px;font-weight:700;">
                                            View My Loyalty Dashboard
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#374151;font-size:14px;margin:0;">
                                Warm regards,<br><strong>The Trinity Mabati Factory Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f9fafb;border-top:1px solid #e5e7eb;padding:16px 32px;text-align:center;">
                            <p style="color:#9ca3af;font-size:12px;margin:0;line-height:1.6;">
                                This is an automated message &mdash; please do not reply to this email.<br>
                                &copy; {{ date('Y') }} Trinity Mabati Factory. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
