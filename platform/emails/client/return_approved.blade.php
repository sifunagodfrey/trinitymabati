<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Request Approved</title>
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
                            <p style="color:black;margin:6px 0 0;font-size:13px;">Return Request Approved</p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Status Banner
                    -- --------------- --}}
                    <tr>
                        <td style="background-color:#f0fdf4;border-bottom:1px solid #bbf7d0;padding:14px 32px;text-align:center;">
                            <p style="margin:0;font-size:13px;color:#166534;font-weight:700;">Your return request has been approved</p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Body
                    -- --------------- --}}
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#1e3a8a;font-size:20px;margin:0 0 16px;font-weight:700;">Good news, {{ $user->first_name }}!</h2>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                Your return request for order <strong>{{ optional($order)->order_code ?? '-' }}</strong> has been
                                <strong style="color:#166534;">approved</strong>. Please follow any return shipping instructions
                                provided by our team. Your refund will be processed once we receive the returned item.
                            </p>

                            {{-- ---------------
                            -- Return Details Box
                            -- --------------- --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px 24px;">
                                        <p style="margin:0 0 14px;font-size:12px;color:#166534;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Return Details</p>
                                        <table width="100%" cellpadding="5" cellspacing="0">
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;width:160px;vertical-align:top;">Return Reference</td>
                                                <td style="font-size:14px;color:#166534;font-weight:700;">#{{ $return->id }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Order Code</td>
                                                <td style="font-size:14px;color:#111827;font-family:monospace;font-weight:600;">{{ optional($order)->order_code ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Product</td>
                                                <td style="font-size:14px;color:#111827;">{{ optional($product)->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Status</td>
                                                <td style="font-size:14px;color:#166534;font-weight:700;">Approved</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- ---------------
                            -- What Happens Next
                            -- --------------- --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc;border:1px solid #e5e7eb;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <p style="margin:0 0 10px;font-size:12px;color:#374151;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">What Happens Next</p>
                                        <ul style="margin:0;padding-left:18px;font-size:14px;color:#374151;line-height:1.8;">
                                            <li>Ship the item back using a trackable courier service.</li>
                                            <li>Once we receive and inspect the item, your refund will be initiated.</li>
                                            <li>You will receive a confirmation email when your refund is processed.</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 24px;">
                                Questions? Reach us at <a href="mailto:support@haromienergy.com" style="color:#2563eb;text-decoration:none;font-weight:600;">support@haromienergy.com</a>.
                            </p>

                            <p style="color:#374151;font-size:14px;margin:0;">
                                Warm regards,<br>
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
