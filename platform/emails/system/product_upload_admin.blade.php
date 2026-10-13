<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Product Awaiting Review</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7f6;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);max-width:600px;">

                    <!-- Header -->
                    <tr>
                        <td style="background-color:#AAC527;padding:28px 32px;text-align:center;">
                            <h1 style="color:#ffffff;margin:0;font-size:20px;font-weight:700;">Trinity Mabati Factory Admin Panel</h1>
                            <p style="color:black;margin:6px 0 0;font-size:13px;">Product Management Notification</p>
                        </td>
                    </tr>

                    <!-- Alert Banner -->
                    <tr>
                        <td style="background-color:#eff6ff;border-bottom:1px solid #bfdbfe;padding:14px 32px;text-align:center;">
                            <p style="margin:0;font-size:13px;color:#1e40af;font-weight:600;">Action Required, New Product Awaiting Review</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#1e1b4b;font-size:18px;margin:0 0 8px;font-weight:700;">New Product Uploaded</h2>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                A seller has uploaded a new product on Trinity Mabati Factory. Please review it and update the approval status.
                            </p>

                            <!-- Product Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;margin-bottom:20px;">
                                <tr>
                                    <td style="padding:20px 24px;">
                                        <p style="margin:0 0 14px;font-size:12px;color:#1e40af;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Product Details</p>
                                        <table width="100%" cellpadding="6" cellspacing="0">
                                            <tr style="border-bottom:1px solid #e5e7eb;">
                                                <td style="font-size:14px;color:#6b7280;width:150px;padding-bottom:10px;">Product Name</td>
                                                <td style="font-size:14px;color:#111827;font-weight:700;padding-bottom:10px;">{{ $product->name }}</td>
                                            </tr>
                                            <tr style="border-bottom:1px solid #e5e7eb;">
                                                <td style="font-size:14px;color:#6b7280;padding:10px 0;">SKU</td>
                                                <td style="font-size:14px;color:#111827;font-family:monospace;padding:10px 0;">{{ $product->sku ?? '&mdash;' }}</td>
                                            </tr>
                                            <tr style="border-bottom:1px solid #e5e7eb;">
                                                <td style="font-size:14px;color:#6b7280;padding:10px 0;">Price</td>
                                                <td style="font-size:14px;color:#111827;font-weight:600;padding:10px 0;">{{ $product->currency ?? 'KES' }} {{ number_format((float) $product->price, 2) }}</td>
                                            </tr>
                                            <tr style="border-bottom:1px solid #e5e7eb;">
                                                <td style="font-size:14px;color:#6b7280;padding:10px 0;">Category</td>
                                                <td style="font-size:14px;color:#111827;padding:10px 0;">{{ optional($product->category)->name ?? '&mdash;' }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;padding:10px 0 0;">Stock</td>
                                                <td style="font-size:14px;color:#111827;padding:10px 0 0;">{{ $product->stock_quantity }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Seller Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px 24px;">
                                        <p style="margin:0 0 14px;font-size:12px;color:#1e40af;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Seller Details</p>
                                        <table width="100%" cellpadding="6" cellspacing="0">
                                            <tr style="border-bottom:1px solid #e5e7eb;">
                                                <td style="font-size:14px;color:#6b7280;width:150px;padding-bottom:10px;">Business Name</td>
                                                <td style="font-size:14px;color:#111827;font-weight:700;padding-bottom:10px;">{{ $vendor->business_name }}</td>
                                            </tr>
                                            <tr style="border-bottom:1px solid #e5e7eb;">
                                                <td style="font-size:14px;color:#6b7280;padding:10px 0;">Owner</td>
                                                <td style="font-size:14px;color:#111827;padding:10px 0;">{{ $vendor->first_name }} {{ $vendor->last_name }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;padding:10px 0 0;">Email</td>
                                                <td style="font-size:14px;color:#111827;padding:10px 0 0;">{{ $vendor->email }}</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('manage.products.all.index') }}"
                                           style="display:inline-block;background-color:#4f46e5;color:#ffffff;padding:12px 28px;border-radius:6px;text-decoration:none;font-size:14px;font-weight:700;letter-spacing:0.3px;">
                                            Review Product
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#374151;font-size:14px;margin:0;">
                                Logged in as admin on the Trinity Mabati Factory Admin Panel.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color:#f9fafb;border-top:1px solid #e5e7eb;padding:16px 32px;text-align:center;">
                            <p style="color:#9ca3af;font-size:12px;margin:0;line-height:1.6;">
                                This is an automated admin notification from Trinity Mabati Factory.<br>
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
