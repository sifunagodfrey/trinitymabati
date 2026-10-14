<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Contact Message</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7f6;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;max-width:600px;">

                    {{-- ---------------
                    -- Header
                    -- --------------- --}}
                    <tr>
                        <td style="background-color:#aa1f25;padding:28px 32px;text-align:center;">
                            <h1 style="color:#ffffff;margin:0;font-size:22px;font-weight:700;">Trinity Mabati Factory</h1>
                            <p style="color:black;margin:6px 0 0;font-size:13px;">New Contact Message</p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Body
                    -- --------------- --}}
                    <tr>
                        <td style="padding:32px;">
                            <table width="100%" cellpadding="5" cellspacing="0" style="background-color:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;margin-bottom:20px;">
                                <tr>
                                    <td style="font-size:14px;color:#6b7280;width:90px;">Name</td>
                                    <td style="font-size:14px;color:#111827;font-weight:600;">{{ $message->name }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;color:#6b7280;">Email</td>
                                    <td style="font-size:14px;color:#111827;">{{ $message->email }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;color:#6b7280;">Received</td>
                                    <td style="font-size:14px;color:#111827;">{{ \Carbon\Carbon::parse($message->received_at)->format('d M Y, H:i') }}</td>
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f0f9ff;border:1px solid #bae6fd;border-left:4px solid #2563eb;border-radius:6px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:18px 20px;">
                                        <p style="margin:0;font-size:14px;color:#374151;line-height:1.7;white-space:pre-line;">{{ $message->message }}</p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin:0;text-align:center;">
                                <a href="{{ route('manage.contact.show', $message->id) }}"
                                   style="display:inline-block;background-color:#AAC527;color:#000000;font-weight:700;font-size:14px;text-decoration:none;padding:12px 24px;border-radius:8px;">
                                    Read and Reply
                                </a>
                            </p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Footer
                    -- --------------- --}}
                    <tr>
                        <td style="background-color:#f9fafb;border-top:1px solid #e5e7eb;padding:16px 32px;text-align:center;">
                            <p style="color:#9ca3af;font-size:12px;margin:0;">&copy; {{ date('Y') }} Trinity Mabati Factory</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>