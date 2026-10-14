<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Order Has Been Updated</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7f6;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;max-width:600px;">
                    <td style="background-color:#aa1f25;padding:28px 32px;text-align:center;">
                        <h1 style="color:#ffffff;margin:0;font-size:22px;">Trinity Mabati Factory</h1>
                        <p style="color: black;margin:6px 0 0;font-size:13px;">Order Update Notification</p>
                    </td>
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#312e81;font-size:20px;margin:0 0 16px;">
                                Hello {{ $order->user->first_name }},
                            </h2>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 16px;">
                                Your order <strong>{{ $order->order_code }}</strong> has been updated by
                                {{ $updatedBy === 'admin' ? 'our support team' : 'the seller' }}.
                            </p>

                            @if(!empty($changes))
                                <h3 style="color:#312e81;font-size:16px;margin:0 0 12px;">Changes made:</h3>
                                <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#eef2ff;border:1px solid #c7d2fe;border-radius:8px;margin-bottom:24px;border-collapse:collapse;">
                                    <thead>
                                        <tr style="background-color:#c7d2fe;">
                                            <th style="padding:12px 16px; text-align:left; font-weight:600; color:#1e1b4b; border-bottom:1px solid #a5b4fc;">Field</th>
                                            <th style="padding:12px 16px; text-align:left; font-weight:600; color:#1e1b4b; border-bottom:1px solid #a5b4fc;">New Value</th>
                                            <th style="padding:12px 16px; text-align:left; font-weight:600; color:#1e1b4b; border-bottom:1px solid #a5b4fc;">Previous Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($changes as $field => $change)
                                            <tr style="border-bottom:1px solid #d9e2ef;">
                                                <td style="padding:12px 16px; vertical-align:top;"><strong>{{ $field }}</strong></td>
                                                <td style="padding:12px 16px; vertical-align:top;">{{ $change['new'] }}</td>
                                                <td style="padding:12px 16px; vertical-align:top;">{{ $change['old'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                You can track your order status from your account dashboard.
                            </p>

                            <p style="color:#374151;font-size:14px;margin:0;">
                                Regards,<br><strong>The Trinity Mabati Factory Team</strong>
                            </p>
                        </td>
                    </tr>
                    <td style="background-color:#f9fafb;border-top:1px solid #e5e7eb;padding:16px;text-align:center;">
                        <p style="color:#9ca3af;font-size:12px;">&copy; {{ date('Y') }} Trinity Mabati Factory</p>
                    </td>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>