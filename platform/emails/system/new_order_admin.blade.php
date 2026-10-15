<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Order</title>
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
                            <p style="color:#ffffff;margin:6px 0 0;font-size:13px;">New Order Received</p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Body
                    -- --------------- --}}
                    <tr>
                        <td style="padding:32px;">
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 20px;">
                                A new order <strong>{{ $order->order_code }}</strong> was placed on the website.
                            </p>

                            <table width="100%" cellpadding="5" cellspacing="0" style="background-color:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;margin-bottom:20px;">
                                <tr>
                                    <td style="font-size:14px;color:#6b7280;width:110px;">Customer</td>
                                    <td style="font-size:14px;color:#111827;font-weight:600;">{{ trim(($order->user->first_name ?? '') . ' ' . ($order->user->last_name ?? '')) ?: 'Guest' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;color:#6b7280;">Email</td>
                                    <td style="font-size:14px;color:#111827;">{{ $order->user->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;color:#6b7280;">Phone</td>
                                    <td style="font-size:14px;color:#111827;">{{ $order->phone ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;color:#6b7280;">Ship To</td>
                                    <td style="font-size:14px;color:#111827;">{{ $locationName }}, {{ $countyName }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size:14px;color:#6b7280;">Placed</td>
                                    <td style="font-size:14px;color:#111827;">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                </tr>
                            </table>

                            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-collapse:collapse;margin-bottom:16px;">
                                <thead>
                                    <tr style="background-color:#f9fafb;">
                                        <th style="padding:10px 14px;text-align:left;font-size:12px;color:#6b7280;border-bottom:1px solid #e5e7eb;">Product</th>
                                        <th style="padding:10px 14px;text-align:right;font-size:12px;color:#6b7280;border-bottom:1px solid #e5e7eb;">Qty</th>
                                        <th style="padding:10px 14px;text-align:right;font-size:12px;color:#6b7280;border-bottom:1px solid #e5e7eb;">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td style="padding:10px 14px;font-size:14px;color:#111827;border-bottom:1px solid #f3f4f6;">
                                                {{ $item->product_name }}
                                                @if ($item->variant_label)
                                                    <br><span style="font-size:12px;color:#6b7280;">{{ $item->variant_label }}</span>
                                                @endif
                                            </td>
                                            <td style="padding:10px 14px;font-size:14px;color:#374151;text-align:right;border-bottom:1px solid #f3f4f6;">{{ $item->quantity }}</td>
                                            <td style="padding:10px 14px;font-size:14px;color:#374151;text-align:right;border-bottom:1px solid #f3f4f6;">KES {{ number_format((float) $item->price, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <p style="color:#111827;font-size:16px;font-weight:700;text-align:right;margin:0 0 24px;">
                                Total: KES {{ number_format((float) $order->total, 2) }}
                            </p>

                            <p style="margin:0;text-align:center;">
                                <a href="{{ route('manage.ecommerce.orders.show', $order->id) }}"
                                   style="display:inline-block;background-color:#aa1f25;color:#ffffff;font-weight:700;font-size:14px;text-decoration:none;padding:12px 24px;border-radius:8px;">
                                    View Order
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