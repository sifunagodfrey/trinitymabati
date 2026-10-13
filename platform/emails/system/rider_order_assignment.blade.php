<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Delivery Assignment</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7f6;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);max-width:600px;">

                    {{-- ---------------
                    -- Header
                    -- --------------- --}}
                    <tr>
                        <td style="background-color:#AAC527;padding:28px 32px;text-align:center;">
                            <h1 style="color:#ffffff;margin:0;font-size:22px;font-weight:700;letter-spacing:-0.3px;">Trinity Mabati Factory</h1>
                            <p style="color:black;margin:6px 0 0;font-size:13px;">Rider Dispatch Notifications</p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Status Banner
                    -- --------------- --}}
                    <tr>
                        <td style="background-color:#fff7ed;border-bottom:1px solid #fed7aa;padding:14px 32px;text-align:center;">
                            <p style="margin:0;font-size:13px;color:#c2410c;font-weight:700;">New Delivery Assignment, Action Required</p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Body
                    -- --------------- --}}
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#1e3a5f;font-size:20px;margin:0 0 16px;font-weight:700;">Hi {{ $rider->user->first_name }}, you have a new delivery!</h2>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                The Trinity Mabati Factory admin team has assigned you a new delivery order. Please review the details below and proceed to pick up the items as soon as possible.
                            </p>

                            {{-- ---------------
                            -- Order & Earning Reference Box
                            -- --------------- --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#fff7ed;border:1px solid #fed7aa;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px 24px;">
                                        <p style="margin:0 0 14px;font-size:12px;color:#c2410c;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Assignment Details</p>
                                        <table width="100%" cellpadding="5" cellspacing="0">
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;width:160px;vertical-align:top;">Order Code</td>
                                                <td style="font-size:14px;color:#c2410c;font-weight:700;font-family:monospace;">{{ $order->order_code }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Assigned At</td>
                                                <td style="font-size:14px;color:#111827;">{{ $assignment->assigned_at ? \Carbon\Carbon::parse($assignment->assigned_at)->format('d M Y, h:i A') : now()->format('d M Y, h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Order Value</td>
                                                <td style="font-size:14px;color:#111827;">KES {{ number_format((float) $order->total, 2) }}</td>
                                            </tr>
                                            @if($earning)
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Your Earning</td>
                                                <td style="font-size:15px;color:#16a34a;font-weight:700;">KES {{ number_format((float) $earning, 2) }}</td>
                                            </tr>
                                            @endif
                                            @if($order->expected_delivery)
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Expected By</td>
                                                <td style="font-size:14px;color:#111827;">{{ \Carbon\Carbon::parse($order->expected_delivery)->format('d M Y') }}</td>
                                            </tr>
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- ---------------
                            -- Pickup & Delivery Locations
                            -- --------------- --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:8px;margin-bottom:24px;overflow:hidden;">
                                <tr>
                                    <td style="background-color:#f8fafc;padding:12px 16px;border-bottom:1px solid #e5e7eb;">
                                        <p style="margin:0;font-size:12px;color:#374151;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Pickup &amp; Delivery Information</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:20px 20px 8px;">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:20px;vertical-align:top;padding-top:2px;">
                                                    <span style="display:inline-block;width:12px;height:12px;background-color:#16a34a;border-radius:50%;"></span>
                                                </td>
                                                <td style="padding-left:10px;padding-bottom:16px;">
                                                    <p style="margin:0 0 4px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Pickup Location</p>
                                                    <p style="margin:0;font-size:14px;color:#111827;line-height:1.5;">{{ $assignment->pickup_location ?: 'As communicated by the admin.' }}</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="padding-left:6px;padding-bottom:16px;border-left:2px dashed #d1d5db;height:16px;width:2px;"></td>
                                            </tr>
                                            <tr>
                                                <td style="width:20px;vertical-align:top;padding-top:2px;">
                                                    <span style="display:inline-block;width:12px;height:12px;background-color:#c2410c;border-radius:50%;"></span>
                                                </td>
                                                <td style="padding-left:10px;padding-bottom:16px;">
                                                    <p style="margin:0 0 4px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Delivery Location</p>
                                                    <p style="margin:0;font-size:14px;color:#111827;line-height:1.5;">{{ $assignment->delivery_location ?: 'As communicated by the admin.' }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @if($assignment->rider_note)
                                <tr>
                                    <td style="padding:0 20px 20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#fffbeb;border:1px solid #fde68a;border-radius:6px;">
                                            <tr>
                                                <td style="padding:12px 16px;">
                                                    <p style="margin:0 0 4px;font-size:12px;color:#92400e;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;">Admin Note</p>
                                                    <p style="margin:0;font-size:14px;color:#78350f;line-height:1.6;">{{ $assignment->rider_note }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endif
                            </table>

                            {{-- ---------------
                            -- What to do next
                            -- --------------- --}}
                            <p style="color:#111827;font-size:14px;font-weight:700;margin:0 0 10px;">What to do next:</p>
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                <tr>
                                    <td style="padding:6px 0;">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:24px;font-size:14px;color:#c2410c;font-weight:700;vertical-align:top;">1.</td>
                                                <td style="font-size:14px;color:#374151;line-height:1.6;">Head to the <strong>pickup location</strong> listed above to collect the items from the seller.</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:24px;font-size:14px;color:#c2410c;font-weight:700;vertical-align:top;">2.</td>
                                                <td style="font-size:14px;color:#374151;line-height:1.6;">Deliver the package to the <strong>delivery location</strong> and confirm receipt with the customer.</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:6px 0;">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="width:24px;font-size:14px;color:#c2410c;font-weight:700;vertical-align:top;">3.</td>
                                                <td style="font-size:14px;color:#374151;line-height:1.6;">Update the delivery status in your rider portal once the order has been delivered.</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- ---------------
                            -- Security / Info Notice
                            -- --------------- --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0fdf4;border:1px solid #bbf7d0;border-radius:6px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:14px 18px;">
                                        <p style="margin:0;font-size:13px;color:#166534;line-height:1.6;">
                                            <strong>Your earnings</strong> for this delivery will be credited to your rider wallet once the order is confirmed as delivered by the customer.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 24px;">
                                For any issues with this assignment, please contact Trinity Mabati Factory support at <a href="mailto:support@haromienergy.com" style="color:#c2410c;text-decoration:none;font-weight:600;">support@haromienergy.com</a>.
                            </p>

                            <p style="color:#374151;font-size:14px;margin:0;">
                                Safe riding,<br>
                                <strong>The Trinity Mabati Factory Team</strong>
                            </p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Footer
                    -- --------------- --}}
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
