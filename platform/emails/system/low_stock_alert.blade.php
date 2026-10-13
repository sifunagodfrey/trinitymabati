{{-- -------------------
     Low Stock Alert Email
     Sent to administrators when a product falls to or below its threshold
------------------- --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Low Stock Alert</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7f6;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);max-width:600px;">
                    <tr>
                        <td style="background-color:#3E4FD2;padding:22px 32px;">
                            <span style="color:#ffffff;font-size:20px;font-weight:bold;">{{ config('app.name', 'Trinity Mabati Factory') }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px;font-size:15px;color:#111827;">Hi {{ $adminName }},</p>
                            <p style="margin:0 0 20px;font-size:14px;color:#374151;line-height:1.6;">
                                The product below has reached its low stock threshold and may need restocking soon.
                            </p>
                            <table width="100%" cellpadding="8" cellspacing="0" style="background-color:#fff7ed;border:1px solid #fed7aa;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="font-size:13px;color:#6b7280;width:140px;">Product</td>
                                    <td style="font-size:13px;color:#111827;font-weight:bold;">{{ $product->name }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:13px;color:#6b7280;">SKU</td>
                                    <td style="font-size:13px;color:#111827;">{{ $product->sku }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:13px;color:#6b7280;">Stock remaining</td>
                                    <td style="font-size:13px;color:#b45309;font-weight:bold;">{{ $stock }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:13px;color:#6b7280;">Alert threshold</td>
                                    <td style="font-size:13px;color:#111827;">{{ $threshold }}</td>
                                </tr>
                            </table>
                            <p style="margin:0 0 8px;font-size:14px;color:#374151;line-height:1.6;">
                                Open the admin panel to review and restock this product.
                            </p>
                            <p style="margin:24px 0 0;font-size:13px;color:#9ca3af;">This is an automated stock notification.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#f9fafb;padding:18px 32px;border-top:1px solid #e5e7eb;">
                            <p style="margin:0;font-size:12px;color:#9ca3af;">{{ config('app.name', 'Trinity Mabati Factory') }} - Inventory Notifications</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
