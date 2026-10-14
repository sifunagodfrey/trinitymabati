<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Trinity Mabati Factory Account</title>
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
                        <td style="background-color:#eef2ff;border-bottom:1px solid #c7d2fe;padding:14px 32px;text-align:center;">
                            <p style="margin:0;font-size:13px;color:#3730a3;font-weight:600;">One step away! Verify your email to activate your account</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#1e1b4b;font-size:20px;margin:0 0 16px;font-weight:700;">Welcome to Trinity Mabati Factory!</h2>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 16px;">
                                Hi <strong>{{ $firstName }}</strong>,
                            </p>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                Thank you for registering on <strong>Trinity Mabati Factory</strong>. Enter the verification code below on the confirmation page to activate your account.
                            </p>

                            <!-- OTP Box -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f3ff;border:1px solid #e0e7ff;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:28px 24px;text-align:center;">
                                        <p style="margin:0 0 10px;font-size:12px;color:#7c3aed;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Your Verification Code</p>
                                        <p style="margin:0;font-size:40px;font-weight:700;color:#4f46e5;letter-spacing:12px;font-family:monospace;">{{ $otp }}</p>
                                        <p style="margin:14px 0 0;font-size:13px;color:#6b7280;">This code expires in <strong>15 minutes</strong>.</p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Notice -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#fffbeb;border:1px solid #fde68a;border-radius:6px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:14px 18px;">
                                        <p style="margin:0;font-size:13px;color:#92400e;line-height:1.6;">
                                            <strong>Security tip:</strong> Never share this code with anyone. Trinity Mabati Factory will never ask for your OTP by phone or chat.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 24px;">
                                If you did not create an account, you can safely ignore this email. No account will be created without verification.
                            </p>

                            <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 24px;">
                                Questions? Contact us at <a href="mailto:support@haromienergy.com" style="color:#4f46e5;text-decoration:none;font-weight:600;">support@haromienergy.com</a>.
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
