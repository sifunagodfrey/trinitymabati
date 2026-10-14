<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trinity Mabati Factory Password Reset</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7f6;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);max-width:600px;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#aa1f25;padding:28px 32px;text-align:center;">
                            <h1 style="color:#ffffff;margin:0;font-size:22px;font-weight:700;letter-spacing:-0.3px;">Trinity Mabati Factory</h1>
                            <p style="color:black;margin:6px 0 0;font-size:13px;">Your Trusted Multi-Vendor Platform</p>
                        </td>
                    </tr>

                    <!-- Status Banner -->
                    <tr>
                        <td style="background-color:#fffbeb;border-bottom:1px solid #fde68a;padding:14px 32px;text-align:center;">
                            <p style="margin:0;font-size:13px;color:#92400e;font-weight:600;">Password Reset Requested</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#78350f;font-size:20px;margin:0 0 16px;font-weight:700;">Reset Your Password</h2>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 16px;">
                                Hi <strong>{{ $user->first_name }}</strong>,
                            </p>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                We received a request to reset the password for your Trinity Mabati Factory account. Use the code below to proceed with your password reset.
                            </p>

                            <!-- OTP Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#fffbeb;border:1px solid #fde68a;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:28px 24px;text-align:center;">
                                        <p style="margin:0 0 10px;font-size:12px;color:#b45309;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Your Password Reset Code</p>
                                        <p style="margin:0;font-size:38px;font-weight:700;color:#b45309;letter-spacing:10px;font-family:monospace;">{{ $otp }}</p>
                                        <p style="margin:14px 0 0;font-size:13px;color:#6b7280;">This code expires in <strong>15 minutes</strong>.</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Account Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <p style="margin:0 0 10px;font-size:12px;color:#64748b;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Account Details</p>
                                        <table width="100%" cellpadding="4" cellspacing="0">
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;width:120px;vertical-align:top;">Email</td>
                                                <td style="font-size:14px;color:#111827;font-weight:600;">{{ $user->email }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Requested</td>
                                                <td style="font-size:14px;color:#111827;">{{ now()->format('d M Y, h:i A') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Notice -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#fef2f2;border:1px solid #fecaca;border-radius:6px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:14px 18px;">
                                        <p style="margin:0;font-size:13px;color:#b91c1c;line-height:1.6;">
                                            <strong>Didn't request this?</strong> If you did not ask to reset your password, please ignore this email. Your account remains secure and no changes have been made.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 24px;">
                                Need help? Contact us at <a href="mailto:support@haromienergy.com" style="color:#b45309;text-decoration:none;font-weight:600;">support@haromienergy.com</a>.
                            </p>

                            <p style="color:#374151;font-size:14px;margin:0;">
                                Best regards,<br>
                                <strong>The Trinity Mabati Factory Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f9fafb;border-top:1px solid #e5e7eb;padding:16px 32px;text-align:center;">
                            <p style="color:#9ca3af;font-size:12px;margin:0;line-height:1.6;">
                                This is an automated message - please do not reply to this email.<br>
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
