{{-- ---------------
-- Refund Policy Page
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', 'Refund Policy | Trinity Mabati Factory')
@section('meta_description', 'Understand the terms and conditions for refunds, returns, and exchanges on Trinity Mabati Factory.')
@section('meta_keywords', 'Trinity Mabati Factory refund policy, returns Kenya marketplace, order refund Trinity Mabati Factory')
@section('og_title', 'Refund Policy | Trinity Mabati Factory')
@section('og_description', 'Understand the terms and conditions for refunds, returns, and exchanges on Trinity Mabati Factory.')

@section('content')

    {{-- ---------------
    -- Hero Section
    -- --------------- --}}
    <section class="relative py-20 border-b border-border overflow-hidden">

        <div class="absolute inset-0 bg-cover bg-center opacity-[0.15]"
            style="background-image: url('{{ url('public/images/trinity-mabati-factory-online-shopping-card.jpg') }}');">
        </div>

        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-secondary"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">

            <h1 class="text-3xl md:text-4xl font-bold mb-4">Refund Policy</h1>

            <p class="max-w-2xl mx-auto text-white/90">
                Our commitment to customer satisfaction and fair refund processing.
            </p>

        </div>
    </section>

    {{-- ---------------
    -- Refund Policy Content
    -- --------------- --}}
    <section class="py-16 bg-white">

        <div class="max-w-4xl mx-auto px-6">

            <p class="text-gray-600 leading-relaxed mb-8">
                At Trinity Mabati Factory, we are committed to customer satisfaction. This Refund Policy outlines the conditions under
                which returns, exchanges, and refunds are accepted for purchases made on our platform.
            </p>

            {{-- Section 1 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">1. Eligibility for Refunds</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600 mb-3">
                <li>The product was damaged or defective upon delivery.</li>
                <li>You received the wrong item.</li>
                <li>The product does not match the description provided on the website.</li>
                <li>The item is returned within the specified return window (see Section 3).</li>
            </ul>
            <p class="text-gray-600 leading-relaxed">
                Refunds will only be issued to the original payment method used at the time of purchase.
            </p>

            {{-- Section 2 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">2. Non-Refundable Items</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Perishable or consumable goods.</li>
                <li>Downloadable digital products.</li>
                <li>Items marked as "Final Sale" or "Non-Returnable".</li>
                <li>Products damaged due to misuse, neglect, or alteration by the customer.</li>
            </ul>

            {{-- Section 3 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">3. Return Window</h3>
            <p class="text-gray-600 leading-relaxed">
                All return requests must be initiated within <strong>7 days</strong> of receiving the order. Items must
                be returned in their original condition, including packaging, tags, and accessories.
            </p>

            {{-- Section 4 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">4. How to Request a Refund</h3>
            <ol class="list-decimal list-inside space-y-2 text-gray-600">
                <li>
                    Contact our support team at
                    <a href="mailto:support@haromienergy.com" class="text-primary hover:underline">support@haromienergy.com</a>
                    or call us.
                </li>
                <li>Provide your order number, photos of the item (if damaged or incorrect), and a short explanation.</li>
                <li>Our team will review the request and notify you of approval or rejection within 2–4 business days.</li>
            </ol>

            {{-- Section 5 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">5. Return Shipping</h3>
            <p class="text-gray-600 leading-relaxed">
                If the return is due to an error on our part (e.g., wrong or defective item), we will cover the return
                shipping costs. If the return is for other reasons, the customer will be responsible for shipping charges.
            </p>

            {{-- Section 6 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">6. Refund Processing</h3>
            <p class="text-gray-600 leading-relaxed mb-3">Once your return is received and inspected:</p>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Approved refunds will be processed within <strong>7 business days</strong>.</li>
                <li>You will receive a confirmation email once the refund has been issued.</li>
                <li>Refund time may vary depending on your payment provider.</li>
            </ul>

            {{-- Section 7 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">7. Exchanges</h3>
            <p class="text-gray-600 leading-relaxed">
                If you prefer a replacement product instead of a refund, please indicate this in your request. Exchanges
                are subject to item availability.
            </p>

            {{-- Section 8 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">8. Late or Missing Refunds</h3>
            <p class="text-gray-600 leading-relaxed mb-3">If you haven't received a refund within the expected time:</p>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Check with your bank or payment provider.</li>
                <li>
                    Then contact us at
                    <a href="mailto:support@haromienergy.com" class="text-primary hover:underline">support@haromienergy.com</a>
                    for further assistance.
                </li>
            </ul>

            {{-- Section 9 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">9. Contact Us</h3>
            <address class="not-italic text-gray-600 leading-relaxed">
                <strong>Trinity Mabati Factory Customer Service</strong><br>
                Fahari Gardens, Ruiru, Kenya<br>
                Phone: +254 758 821800 / +254 790 519791<br>
                Email: <a href="mailto:support@haromienergy.com" class="text-primary hover:underline">support@haromienergy.com</a>
            </address>

        </div>
    </section>

@endsection
