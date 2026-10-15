@php
    $gaId = \App\Models\Core\Setting::get('ga4_measurement_id', '');
    $gaEnabled = app()->environment('production')
        && \App\Models\Core\Setting::get('ga4_enabled', '0') === '1'
        && preg_match('/^G-[A-Z0-9]+$/', $gaId);
    $analyticsEvents = [];
    if (session('analytics_lead')) $analyticsEvents[] = ['name' => 'generate_lead', 'params' => ['lead_type' => session('analytics_lead')]];
    if (session('analytics_cart')) $analyticsEvents[] = ['name' => 'add_to_cart', 'params' => session('analytics_cart')];
    if (request()->routeIs('frontend.products.show') && isset($product)) {
        $analyticsLength = $product->allow_custom_length ? (float) ($product->default_length_m ?? 1) : 1;
        $analyticsPrice = (float) ($variantMinPrice ?? $basePrice ?? 0) * $analyticsLength;
        $analyticsEvents[] = ['name' => 'view_item', 'params' => ['currency' => 'KES', 'value' => $analyticsPrice, 'items' => [[
            'item_id' => (string) $product->id, 'item_name' => $product->name, 'price' => $analyticsPrice, 'quantity' => 1,
        ]]]];
    }
    if (request()->routeIs('frontend.checkout') && isset($items)) {
        $analyticsEvents[] = ['name' => 'begin_checkout', 'params' => ['currency' => 'KES', 'value' => (float) $subtotal,
            'items' => $items->map(fn ($item) => ['item_id' => (string) $item->product_id, 'item_name' => $item->product?->name ?? 'Product',
                'price' => (float) $item->price_at_time, 'quantity' => (int) $item->quantity])->values()->all()]];
    }
    // Manual payments count as purchases only after approval, on the owner's order page.
    if (request()->routeIs('client.orders.show') && isset($order) && $order->payment_status === 'paid'
        && (int) $order->user_id === (int) auth()->id()) {
        $analyticsEvents[] = ['name' => 'purchase', 'params' => ['transaction_id' => $order->order_code, 'currency' => 'KES',
            'value' => $order->items->sum(fn ($item) => (float) $item->price * $item->quantity), 'shipping' => (float) $order->shipping_cost,
            'items' => $order->items->map(fn ($item) => ['item_id' => (string) $item->product_id, 'item_name' => $item->product_name,
                'price' => (float) $item->price, 'quantity' => (int) $item->quantity])->values()->all()]];
    }
@endphp
@if ($gaEnabled)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
    <script>
    (function () {
        if (window.trinityTrack) return;
        window.dataLayer = window.dataLayer || [];
        window.gtag = function () { window.dataLayer.push(arguments); };
        function cleanUrl(value) {
            try { const url = new URL(value); return url.origin + url.pathname; } catch (_) { return ''; }
        }
        gtag('js', new Date());
        gtag('config', @js($gaId), {
            send_page_view: false, allow_google_signals: false, allow_ad_personalization_signals: false,
            page_location: cleanUrl(location.href), page_referrer: cleanUrl(document.referrer)
        });
        // Names, phone numbers, email addresses and payment references are never event parameters.
        window.trinityTrack = function (name, params) {
            if (name === 'purchase' && params.transaction_id) {
                const key = 'trinity:ga4:purchase:' + params.transaction_id;
                try { if (localStorage.getItem(key)) return; localStorage.setItem(key, '1'); } catch (_) {}
            }
            gtag('event', name, params);
        };
        gtag('event', 'page_view', {page_location: cleanUrl(location.href), page_referrer: cleanUrl(document.referrer), page_title: document.title});
        @foreach ($analyticsEvents as $event)
            window.trinityTrack(@js($event['name']), @js($event['params']));
        @endforeach
        document.addEventListener('click', function (event) {
            const link = event.target.closest('a[href]');
            if (!link) return;
            if (link.protocol === 'tel:') window.trinityTrack('phone_click', {contact_method: 'phone'});
            if (link.hostname === 'wa.me' || link.hostname === 'api.whatsapp.com') window.trinityTrack('whatsapp_click', {contact_method: 'whatsapp'});
        });
    })();
    </script>
@endif
