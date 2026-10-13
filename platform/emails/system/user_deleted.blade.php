<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Deleted – Trinity Mabati Factory Admin</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7f6;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);max-width:600px;">
                    <td style="background-color:#AAC527;padding:28px 32px;text-align:center;">
                        <h1 style="color:#ffffff;margin:0;font-size:22px;">Trinity Mabati Factory</h1>
                        <p style="color: black;margin:6px 0 0;font-size:13px;">Account Deletion Notice</p>
                    </td>
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#312e81;font-size:20px;margin:0 0 16px;">Dear {{ $user->first_name }},</h2>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 16px;">
                                Your system administrator account for the <strong>Trinity Mabati Factory Admin Panel</strong> has been <strong>deleted</strong>.
                            </p>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                You no longer have access to the admin panel. If you believe this was done in error, please contact the Trinity Mabati Factory support team.
                            </p>
                            <p style="color:#374151;font-size:14px;margin:0;">
                                Regards,<br>
                                <strong>The Trinity Mabati Factory Team</strong>
                            </p>
                        </td>
                    </tr>
                    <td style="background-color:#f9fafb;border-top:1px solid #e5e7eb;padding:16px 32px;text-align:center;">
                        <p style="color:#9ca3af;font-size:12px;margin:0;">© {{ date('Y') }} Trinity Mabati Factory. All rights reserved.</p>
                    </td>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>