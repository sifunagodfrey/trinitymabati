<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Reply on Your Support Ticket</title>
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
                            <p style="color:black;margin:6px 0 0;font-size:13px;">Support Ticket Notification</p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Status Banner
                    -- --------------- --}}
                    <tr>
                        <td style="background-color:#eff6ff;border-bottom:1px solid #bfdbfe;padding:14px 32px;text-align:center;">
                            <p style="margin:0;font-size:13px;color:#1d4ed8;font-weight:700;">New Reply From Our Support Team</p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Body
                    -- --------------- --}}
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#1e3a8a;font-size:20px;margin:0 0 16px;font-weight:700;">We&rsquo;ve replied to your ticket, {{ $user->first_name }}</h2>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                Our support team has posted a new reply to your ticket <strong>#{{ $ticket->id }}: {{ $ticket->subject }}</strong>. You can view and respond from your ticket page.
                            </p>

                            {{-- ---------------
                            -- Reply Preview Box
                            -- --------------- --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0f9ff;border:1px solid #bae6fd;border-left:4px solid #2563eb;border-radius:6px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:18px 20px;">
                                        <p style="margin:0 0 8px;font-size:12px;color:#1d4ed8;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Support Reply</p>
                                        <p style="margin:0;font-size:14px;color:#374151;line-height:1.7;">{{ $reply->message }}</p>
                                    </td>
                                </tr>
                            </table>

                            {{-- ---------------
                            -- Ticket Reference Box
                            -- --------------- --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px 24px;">
                                        <p style="margin:0 0 14px;font-size:12px;color:#374151;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Ticket Reference</p>
                                        <table width="100%" cellpadding="5" cellspacing="0">
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;width:150px;vertical-align:top;">Ticket Number</td>
                                                <td style="font-size:14px;color:#111827;font-weight:700;font-family:monospace;">#{{ $ticket->id }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Subject</td>
                                                <td style="font-size:14px;color:#111827;font-weight:600;">{{ $ticket->subject }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Department</td>
                                                <td style="font-size:14px;color:#111827;">{{ ucfirst($ticket->department) }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Status</td>
                                                <td style="font-size:14px;color:#d97706;font-weight:700;">In Progress</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- ---------------
                            -- CTA Button
                            -- --------------- --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/client/tickets/' . $ticket->id) }}"
                                           style="display:inline-block;background-color:#2563eb;color:#ffffff;padding:13px 32px;border-radius:6px;text-decoration:none;font-size:15px;font-weight:700;">
                                            View Full Conversation
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 24px;">
                                You can reply directly from your ticket page. If you have questions, contact us at <a href="mailto:support@haromienergy.com" style="color:#2563eb;text-decoration:none;font-weight:600;">support@haromienergy.com</a>.
                            </p>

                            <p style="color:#374151;font-size:14px;margin:0;">
                                Regards,<br>
                                <strong>The Trinity Mabati Factory Support Team</strong>
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
