<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Trinity Mabati Factory Admin Account</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7f6;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);max-width:600px;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#aa1f25;padding:28px 32px;text-align:center;">
                            <h1 style="color:#ffffff;margin:0;font-size:22px;font-weight:700;">Trinity Mabati Factory</h1>
                            <p style="color: black;margin:6px 0 0;font-size:13px;">System Account Notification</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#312e81;font-size:20px;margin:0 0 16px;">Hello {{ $user->first_name }},</h2>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 16px;">
                                An administrator has created a system account for you on the <strong>Trinity Mabati Factory Admin Panel</strong>.
                            </p>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 16px;">
                                Your login credentials are:
                            </p>
                            <table width="100%" cellpadding="8" cellspacing="0" style="background-color:#eef2ff;border:1px solid #c7d2fe;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="font-size:14px;color:#1f2937;"><strong>Email:</strong></td>
                                    <td style="font-size:14px;color:#1f2937;">{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;color:#1f2937;"><strong>Password:</strong></td>
                                    <td style="font-size:14px;color:#1f2937;font-family:monospace;">{{ $password }}</td>
                                </tr>
                            </table>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                Please log in at <a href="{{ url('/manage/login') }}" style="color:#4f46e5;">{{ url('/manage/login') }}</a> and change your password immediately.
                            </p>
                            <p style="color:#374151;font-size:14px;margin:0;">
                                Regards,<br>
                                <strong>The Trinity Mabati Factory Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f9fafb;border-top:1px solid #e5e7eb;padding:16px 32px;text-align:center;">
                            <p style="color:#9ca3af;font-size:12px;margin:0;">
                                This is an automated message &mdash; please do not reply.<br>
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