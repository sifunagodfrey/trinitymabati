<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loyalty Points {{ isset($isAdjust) && $isAdjust ? 'Adjusted' : 'Earned' }}</title>
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
                    @php $isAdd = !isset($isAdjust) || !$isAdjust || (isset($isAdd) && $isAdd); @endphp
                    <tr>
                        <td style="background-color:{{ $isAdd ? '#fefce8' : '#fef2f2' }};border-bottom:1px solid {{ $isAdd ? '#fde68a' : '#fecaca' }};padding:14px 32px;text-align:center;">
                            <p style="margin:0;font-size:13px;color:{{ $isAdd ? '#92400e' : '#991b1b' }};font-weight:700;">
                                @if(isset($isAdjust) && $isAdjust)
                                    {{ $isAdd ? '&#11014; Points Added to Your Account' : '&#11015; Points Deducted from Your Account' }}
                                @else
                                    &#11088; Points earned from your purchase!
                                @endif
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#111827;font-size:20px;margin:0 0 16px;font-weight:700;">Hi {{ $user->first_name }},</h2>

                            @if(isset($isAdjust) && $isAdjust)
                                <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                    Your loyalty points balance has been {{ $isAdd ? 'credited' : 'debited' }} by an administrator.
                                    @if(!empty($description))
                                        <br><span style="font-size:13px;color:#6b7280;">Reason: {{ $description }}</span>
                                    @endif
                                </p>
                            @else
                                <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                    Great news &mdash; you've just earned loyalty points on your recent purchase.
                                    Keep shopping to unlock higher tiers and bigger rewards!
                                </p>
                            @endif

                            <!-- Points Summary -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#fefce8;border:1px solid #fde68a;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px 24px;">
                                        <p style="margin:0 0 14px;font-size:12px;color:#b45309;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Points Summary</p>
                                        <table width="100%" cellpadding="5" cellspacing="0">
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;width:160px;vertical-align:top;">
                                                    {{ (isset($isAdjust) && $isAdjust) ? ($isAdd ? 'Points Added' : 'Points Deducted') : 'Points Earned' }}
                                                </td>
                                                <td style="font-size:20px;color:#d97706;font-weight:700;">{{ number_format($points) }} pts</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">New Balance</td>
                                                <td style="font-size:16px;color:#111827;font-weight:700;">{{ number_format($newBalance) }} pts</td>
                                            </tr>
                                            @if(!isset($isAdjust) && $orderId)
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Order</td>
                                                <td style="font-size:14px;color:#374151;font-family:monospace;">#{{ $orderId }}</td>
                                            </tr>
                                            @endif
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Date</td>
                                                <td style="font-size:14px;color:#374151;">{{ now()->format('d M Y, h:i A') }}</td>
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
                                           style="display:inline-block;background-color:#d97706;color:#ffffff;padding:13px 32px;border-radius:6px;text-decoration:none;font-size:15px;font-weight:700;">
                                            View My Loyalty Points
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
