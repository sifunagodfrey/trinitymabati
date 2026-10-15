<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>Order Confirmed</title></head>
<body style="margin:0;padding:0;background-color:#f4f7f6;font-family:Arial,Helvetica,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f7f6;padding:30px 0;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:8px;overflow:hidden;max-width:600px;">
    <tr>
        <td style="background-color:#aa1f25;padding:28px 32px;text-align:center;">
            <h1 style="color:#ffffff;margin:0;font-size:22px;">Trinity Mabati Factory</h1>
            <p style="color:#ffffff;margin:6px 0 0;font-size:13px;">Order Confirmed</p>
        </td>
    </tr>
    <tr>
        <td style="padding:32px;">
            <h2 style="color:#111827;font-size:20px;margin:0 0 16px;">Thank you, {{ $order->user->first_name }}!</h2>
            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 20px;">
                Your order <strong>{{ $order->order_code }}</strong> is confirmed and your stock is reserved.
                Please pay <strong>KES {{ number_format((float) $order->total, 2) }}</strong> in cash when it is delivered.
            </p>
            <table width="100%" cellpadding="5" cellspacing="0" style="background-color:#f8fafc;border:1px solid #e2e8f0;margin-bottom:20px;">
                <tr><td style="font-size:14px;color:#6b7280;width:130px;">Ship To</td><td style="font-size:14px;color:#111827;">{{ $locationName }}, {{ $countyName }}</td></tr>
                <tr><td style="font-size:14px;color:#6b7280;">Payment</td><td style="font-size:14px;color:#d97706;font-weight:700;">Cash on delivery</td></tr>
                <tr><td style="font-size:14px;color:#6b7280;">Placed</td><td style="font-size:14px;color:#111827;">{{ $order->created_at->format('d M Y, h:i A') }}</td></tr>
            </table>
            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-collapse:collapse;margin-bottom:16px;">
                <tr style="background-color:#f9fafb;">
                    <th style="padding:10px 14px;text-align:left;font-size:12px;color:#6b7280;">Product</th>
                    <th style="padding:10px 14px;text-align:right;font-size:12px;color:#6b7280;">Qty</th>
                    <th style="padding:10px 14px;text-align:right;font-size:12px;color:#6b7280;">Subtotal</th>
                </tr>
                @foreach ($order->items as $item)
                <tr>
                    <td style="padding:10px 14px;font-size:14px;color:#111827;border-top:1px solid #f3f4f6;">
                        {{ $item->product_name }}
                        @if ($item->variant_label)<br><span style="font-size:12px;color:#6b7280;">{{ $item->variant_label }}</span>@endif
                    </td>
                    <td style="padding:10px 14px;font-size:14px;text-align:right;border-top:1px solid #f3f4f6;">{{ $item->quantity }}</td>
                    <td style="padding:10px 14px;font-size:14px;text-align:right;border-top:1px solid #f3f4f6;">KES {{ number_format((float) $item->price * (int) $item->quantity, 2) }}</td>
                </tr>
                @endforeach
            </table>
            <p style="color:#111827;font-size:16px;font-weight:700;text-align:right;margin:0 0 24px;">Total to pay on delivery: KES {{ number_format((float) $order->total, 2) }}</p>
            <p style="margin:0;text-align:center;">
                <a href="{{ route('client.orders.show', $order->id) }}" style="display:inline-block;background-color:#aa1f25;color:#ffffff;font-weight:700;font-size:14px;text-decoration:none;padding:12px 24px;border-radius:8px;">View My Order</a>
            </p>
        </td>
    </tr>
</table>
</td></tr>
</table>
</body>
</html>