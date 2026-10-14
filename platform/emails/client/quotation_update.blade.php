<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $headline }}</title>
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
                        <td style="background-color:#AAC527;padding:28px 32px;text-align:center;">
                            <h1 style="color:#ffffff;margin:0;font-size:22px;font-weight:700;">Trinity Mabati Factory</h1>
                            <p style="color:black;margin:6px 0 0;font-size:13px;">Quotation {{ $quotation->quotation_code }}</p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Body
                    -- --------------- --}}
                    <tr>
                        <td style="padding:32px;">
                            <h2 style="color:#312e81;font-size:20px;margin:0 0 16px;">Hello {{ $customerName }},</h2>
                            <p style="color:#111827;font-size:16px;font-weight:700;margin:0 0 8px;">{{ $headline }}</p>
                            <p style="color:#374151;font-size:15px;line-height:1.7;margin:0 0 24px;">{{ $intro }}</p>

                            {{-- ---------------
                            -- Line items
                            -- --------------- --}}
                            @if ($showItems)
                                <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #e5e7eb;border-radius:8px;border-collapse:collapse;margin-bottom:16px;">
                                    <thead>
                                        <tr style="background-color:#f9fafb;">
                                            <th style="padding:10px 14px;text-align:left;font-size:12px;color:#6b7280;border-bottom:1px solid #e5e7eb;">Item</th>
                                            <th style="padding:10px 14px;text-align:right;font-size:12px;color:#6b7280;border-bottom:1px solid #e5e7eb;">Qty</th>
                                            <th style="padding:10px 14px;text-align:right;font-size:12px;color:#6b7280;border-bottom:1px solid #e5e7eb;">Unit Price</th>
                                            <th style="padding:10px 14px;text-align:right;font-size:12px;color:#6b7280;border-bottom:1px solid #e5e7eb;">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quotation->items as $item)
                                            <tr>
                                                <td style="padding:10px 14px;font-size:14px;color:#111827;border-bottom:1px solid #f3f4f6;">{{ $item->item_name }}</td>
                                                <td style="padding:10px 14px;font-size:14px;color:#374151;text-align:right;border-bottom:1px solid #f3f4f6;">{{ $item->quantity }}</td>
                                                <td style="padding:10px 14px;font-size:14px;color:#374151;text-align:right;border-bottom:1px solid #f3f4f6;">{{ number_format($item->unit_price, 2) }}</td>
                                                <td style="padding:10px 14px;font-size:14px;color:#111827;text-align:right;border-bottom:1px solid #f3f4f6;">{{ number_format($item->total ?? ($item->quantity * $item->unit_price), 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                            {{-- ---------------
                            -- Totals
                            -- --------------- --}}
                            <table width="100%" cellpadding="4" cellspacing="0" style="margin-bottom:24px;">
                                @if ($showItems)
                                    <tr>
                                        <td style="font-size:14px;color:#6b7280;">Subtotal</td>
                                        <td style="font-size:14px;color:#374151;text-align:right;">{{ $quotation->currency ?: 'KES' }} {{ number_format($quotation->subtotal, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:14px;color:#6b7280;">Tax</td>
                                        <td style="font-size:14px;color:#374151;text-align:right;">{{ $quotation->currency ?: 'KES' }} {{ number_format($quotation->tax, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size:14px;color:#6b7280;">Discount</td>
                                        <td style="font-size:14px;color:#374151;text-align:right;">- {{ $quotation->currency ?: 'KES' }} {{ number_format($quotation->discount, 2) }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="font-size:16px;color:#111827;font-weight:700;border-top:1px solid #e5e7eb;padding-top:10px;">Total</td>
                                    <td style="font-size:16px;color:#111827;font-weight:700;text-align:right;border-top:1px solid #e5e7eb;padding-top:10px;">{{ $quotation->currency ?: 'KES' }} {{ number_format($quotation->total, 2) }}</td>
                                </tr>
                                @if ($quotation->valid_until)
                                    <tr>
                                        <td colspan="2" style="font-size:13px;color:#6b7280;padding-top:10px;">Valid until {{ $quotation->valid_until->format('d M Y') }}</td>
                                    </tr>
                                @endif
                            </table>

                            @php
                                $contactPhone = \App\Models\Core\Setting::get('contact_phone', '');
                                $contactEmail = \App\Models\Core\Setting::get('contact_email', '');
                            @endphp
                            @if ($contactPhone || $contactEmail)
                                <p style="color:#374151;font-size:14px;line-height:1.7;margin:0 0 24px;">
                                    Questions? Contact us
                                    @if ($contactEmail) at <a href="mailto:{{ $contactEmail }}" style="color:#2563eb;text-decoration:none;font-weight:600;">{{ $contactEmail }}</a>@endif
                                    @if ($contactPhone) or call <strong>{{ $contactPhone }}</strong>@endif.
                                </p>
                            @endif

                            <p style="color:#374151;font-size:14px;margin:0;">
                                Regards,<br><strong>The Trinity Mabati Factory Team</strong>
                            </p>
                        </td>
                    </tr>

                    {{-- ---------------
                    -- Footer
                    -- --------------- --}}
                    <tr>
                        <td style="background-color:#f9fafb;border-top:1px solid #e5e7eb;padding:16px 32px;text-align:center;">
                            <p style="color:#9ca3af;font-size:12px;margin:0;">&copy; {{ date('Y') }} Trinity Mabati Factory. All rights reserved.</p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>