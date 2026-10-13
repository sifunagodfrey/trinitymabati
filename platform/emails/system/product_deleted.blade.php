<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Removed from Marketplace</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7f6;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);max-width:600px;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#AAC527;padding:28px 32px;text-align:center;">
                            <h1 style="color:#ffffff;margin:0;font-size:22px;font-weight:700;letter-spacing:-0.3px;">Trinity Mabati Factory</h1>
                            <p style="color:black;margin:6px 0 0;font-size:13px;">Seller Notification</p>
                        </td>
                    </tr>

                    <!-- Status Banner -->
                    <tr>
                        <td style="background-color:#fef2f2;border-bottom:1px solid #fecaca;padding:14px 32px;text-align:center;">
                            <p style="margin:0;font-size:13px;color:#991b1b;font-weight:700;">
                                &#128683; Your product has been removed from the marketplace
                            </p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#111827;font-size:20px;margin:0 0 16px;font-weight:700;">Hi {{ $vendor->first_name }},</h2>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                We're writing to let you know that one of your product listings has been removed from Trinity Mabati Factory by our administration team.
                                If you believe this was done in error or would like further clarification, please contact our support team.
                            </p>

                            <!-- Product Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#fef2f2;border:1px solid #fecaca;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px 24px;">
                                        <p style="margin:0 0 14px;font-size:12px;color:#991b1b;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Removed Product Details</p>
                                        <table width="100%" cellpadding="5" cellspacing="0">
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;width:160px;vertical-align:top;">Product Name</td>
                                                <td style="font-size:14px;color:#111827;font-weight:700;">{{ $productName }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">SKU</td>
                                                <td style="font-size:14px;color:#374151;font-family:monospace;">{{ $productSku }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Date Removed</td>
                                                <td style="font-size:14px;color:#374151;">{{ now()->format('d M Y, h:i A') }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Info Note -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#fffbeb;border:1px solid #fde68a;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <p style="margin:0;font-size:13px;color:#92400e;line-height:1.6;">
                                            <strong>What this means:</strong> This product is no longer visible to buyers and has been permanently removed from your store. Any active orders containing this product will not be affected.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/seller/support') }}"
                                           style="display:inline-block;background-color:#AAC527;color:#ffffff;padding:13px 32px;border-radius:6px;text-decoration:none;font-size:15px;font-weight:700;">
                                            Contact Support
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#374151;font-size:14px;margin:0;">
                                Warm regards,<br><strong>The Trinity Mabati Factory Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
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
