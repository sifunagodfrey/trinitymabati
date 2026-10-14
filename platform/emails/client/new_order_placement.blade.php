<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7f6;padding:30px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.08);max-width:600px;">

                    {{-- ---------------
                    -- Header
                    -- --------------- --}}
                    <tr>
                        <td style="background-color:#aa1f25;padding:28px 32px;text-align:center;">
                            <h1 style="color:#ffffff;margin:0;font-size:22px;font-weight:700;letter-spacing:-0.3px;">Trinity Mabati Factory</h1>
                            <p style="color:black;margin:6px 0 0;font-size:13px;">Order Confirmation</p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Status Banner
                    -- --------------- --}}
                    <tr>
                        <td style="background-color:#eff6ff;border-bottom:1px solid #bfdbfe;padding:14px 32px;text-align:center;">
                            <p style="margin:0;font-size:13px;color:#1e40af;font-weight:700;">Order Received! Awaiting Payment Confirmation</p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Body
                    -- --------------- --}}
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#1e3a8a;font-size:20px;margin:0 0 16px;font-weight:700;">Thank you for your order, {{ $order->user->first_name }}!</h2>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">
                                We have received your order on <strong>Trinity Mabati Factory</strong>. Your order details are shown below. You will receive another email once your payment has been confirmed.
                            </p>

                            {{-- ---------------
                            -- Order Summary Box
                            -- --------------- --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;margin-bottom:24px;">
                                <tr>
                                    <td style="padding:20px 24px;">
                                        <p style="margin:0 0 14px;font-size:12px;color:#1e40af;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Order Summary</p>
                                        <table width="100%" cellpadding="5" cellspacing="0">
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;width:150px;vertical-align:top;">Order Code</td>
                                                <td style="font-size:14px;color:#1e40af;font-weight:700;font-family:monospace;">{{ $order->order_code }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Date Placed</td>
                                                <td style="font-size:14px;color:#111827;">{{ $order->created_at->format('d M Y, h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Ship To</td>
                                                <td style="font-size:14px;color:#111827;">{{ $locationName }}, {{ $countyName }}</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Order Status</td>
                                                <td style="font-size:14px;color:#d97706;font-weight:700;">Pending</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:14px;color:#6b7280;vertical-align:top;">Payment Status</td>
                                                <td style="font-size:14px;color:#d97706;font-weight:700;">Awaiting Payment</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            {{-- ---------------
                            -- Items Table
                            -- --------------- --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:8px;margin-bottom:24px;overflow:hidden;">
                                <tr>
                                    <td style="background-color:#f8fafc;padding:12px 16px;border-bottom:1px solid #e5e7eb;">
                                        <p style="margin:0;font-size:12px;color:#374151;font-weight:700;text-transform:uppercase;letter-spacing:0.8px;">Items Ordered</p>
                                    </td>
                                </tr>
                                {{-- Header Row --}}
                                <tr style="background-color:#f1f5f9;">
                                    <td style="padding:10px 16px;font-size:12px;color:#6b7280;font-weight:700;text-transform:uppercase;letter-spacing:0.5px;width:50%;">Product</td>
                                    <td style="padding:10px 8px;font-size:12px;color:#6b7280;font-weight:700;text-align:center;width:15%;">Qty</td>
                                    <td style="padding:10px 8px;font-size:12px;color:#6b7280;font-weight:700;text-align:right;width:17%;">Unit Price</td>
                                    <td style="padding:10px 16px;font-size:12px;color:#6b7280;font-weight:700;text-align:right;width:18%;">Subtotal</td>
                                </tr>
                                {{-- Item Rows --}}
                                @foreach($order->items as $item)
                                <tr style="border-top:1px solid #f3f4f6;">
                                    <td style="padding:12px 16px;font-size:14px;color:#111827;vertical-align:top;">
                                        {{ $item->product_name }}
                                        @if($item->variant_label)
                                        <br><span style="font-size:12px;color:#6b7280;">{{ $item->variant_label }}</span>
                                        @endif
                                    </td>
                                    <td style="padding:12px 8px;font-size:14px;color:#374151;text-align:center;vertical-align:top;">{{ $item->quantity }}</td>
                                    <td style="padding:12px 8px;font-size:14px;color:#374151;text-align:right;vertical-align:top;">KES {{ number_format((float)$item->price, 2) }}</td>
                                    <td style="padding:12px 16px;font-size:14px;color:#111827;font-weight:600;text-align:right;vertical-align:top;">KES {{ number_format((float)$item->price * (int)$item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                                {{-- Totals --}}
                                @php
                                    $subtotal = $order->items->sum(fn($i) => $i->price * $i->quantity);
                                @endphp
                                <tr style="border-top:1px solid #e5e7eb;background-color:#f8fafc;">
                                    <td colspan="3" style="padding:10px 16px;font-size:14px;color:#374151;text-align:right;">Subtotal</td>
                                    <td style="padding:10px 16px;font-size:14px;color:#111827;font-weight:600;text-align:right;">KES {{ number_format((float)$subtotal, 2) }}</td>
                                </tr>
                                <tr style="background-color:#f8fafc;">
                                    <td colspan="3" style="padding:6px 16px;font-size:14px;color:#374151;text-align:right;">Shipping</td>
                                    <td style="padding:6px 16px;font-size:14px;color:#111827;font-weight:600;text-align:right;">KES {{ number_format((float)$order->shipping_cost, 2) }}</td>
                                </tr>
                                <tr style="border-top:2px solid #e5e7eb;background-color:#eff6ff;">
                                    <td colspan="3" style="padding:12px 16px;font-size:15px;color:#1e40af;font-weight:700;text-align:right;">Total</td>
                                    <td style="padding:12px 16px;font-size:15px;color:#1e40af;font-weight:700;text-align:right;">KES {{ number_format((float)$order->total, 2) }}</td>
                                </tr>
                            </table>

                            {{-- ---------------
                            -- CTA Button
                            -- --------------- --}}
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ url('/client/orders/' . $order->id) }}"
                                           style="display:inline-block;background-color:#2563eb;color:#ffffff;padding:13px 32px;border-radius:6px;text-decoration:none;font-size:15px;font-weight:700;">
                                            View Your Order
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 24px;">
                                Need help? Contact us at <a href="mailto:support@haromienergy.com" style="color:#2563eb;text-decoration:none;font-weight:600;">support@haromienergy.com</a>.
                            </p>

                            <p style="color:#374151;font-size:14px;margin:0;">
                                Warm regards,<br>
                                <strong>The Trinity Mabati Factory Team</strong>
                            </p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Footer
                    -- --------------- --}}
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
