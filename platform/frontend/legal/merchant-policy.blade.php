{{-- ---------------
-- Merchant Policy Page
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', 'Merchant Return Policy | Trinity Mabati Factory')
@section('meta_description', 'Understand Trinity Mabati Factory\'s return, refund, and dispute process for vendors. Ensure compliance with platform rules and expectations.')
@section('meta_keywords', 'Trinity Mabati Factory merchant policy, vendor return policy Kenya, seller refund policy Trinity Mabati Factory')
@section('og_title', 'Merchant Return Policy | Trinity Mabati Factory')
@section('og_description', 'Understand Trinity Mabati Factory\'s return, refund, and dispute process for vendors.')

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

            <h1 class="text-3xl md:text-4xl font-bold mb-4">Merchant Return Policy</h1>

            <p class="max-w-2xl mx-auto text-white/90">
                Rules and expectations for vendors regarding returns, exchanges, and customer disputes.
            </p>

        </div>
    </section>

    {{-- ---------------
    -- Merchant Policy Content
    -- --------------- --}}
    <section class="py-16 bg-white">

        <div class="max-w-4xl mx-auto px-6">

            <p class="text-gray-600 leading-relaxed mb-8">
                At <strong>Trinity Mabati Factory</strong>, we are committed to ensuring a smooth and fair experience for both buyers and
                sellers. This Merchant Return Policy outlines the rules and expectations for vendors regarding returns,
                exchanges, and customer disputes.
            </p>

            {{-- Section 1 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">1. Merchant Responsibilities</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Clearly describe products with accurate titles, images, and specifications.</li>
                <li>Ensure all items are of acceptable quality and in sellable condition.</li>
                <li>Accept returns and process refunds in accordance with Trinity Mabati Factory's platform guidelines.</li>
            </ul>

            {{-- Section 2 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">2. Return Eligibility</h3>
            <p class="text-gray-600 leading-relaxed mb-3">A customer may return a product if:</p>
            <ul class="list-disc list-inside space-y-2 text-gray-600 mb-3">
                <li>The item is defective, damaged, or broken upon delivery.</li>
                <li>The wrong item was shipped.</li>
                <li>The item is significantly different from the listing description.</li>
            </ul>
            <p class="text-gray-600 leading-relaxed italic">
                Note: Returns due to change of mind are optional and handled at the merchant's discretion.
            </p>

            {{-- Section 3 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">3. Return Window</h3>
            <p class="text-gray-600 leading-relaxed">
                Merchants must honor return requests submitted within <strong>7 days</strong> of product delivery.
                Products must be returned in original condition, including packaging and accessories.
            </p>

            {{-- Section 4 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">4. Return Process</h3>
            <ol class="list-decimal list-inside space-y-2 text-gray-600">
                <li>The merchant is notified via their dashboard or email.</li>
                <li>The merchant must respond within <strong>2 business days</strong>.</li>
                <li>If approved, the buyer receives return instructions.</li>
                <li>Failure to respond may lead to automatic approval and platform penalties.</li>
            </ol>

            {{-- Section 5 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">5. Shipping & Refunds</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>If the return is due to merchant error, the merchant bears return shipping costs.</li>
                <li>Refunds must be processed within <strong>5 business days</strong> of item receipt.</li>
                <li>Refunds are issued to the buyer's original payment method via Trinity Mabati Factory's system.</li>
            </ul>

            {{-- Section 6 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">6. Dispute Resolution</h3>
            <p class="text-gray-600 leading-relaxed">
                Merchants can file a dispute within <strong>48 hours</strong> of a return request. Trinity Mabati Factory's support
                team will mediate and make the final decision based on platform rules and evidence provided.
            </p>

            {{-- Section 7 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">7. Non-Compliance Consequences</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Order cancellation and forced refunds.</li>
                <li>Account suspension or permanent removal.</li>
                <li>Loss of seller privileges and negative store rating impact.</li>
            </ul>

            {{-- Section 8 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">8. Best Practices for Merchants</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Package items securely to prevent shipping damage.</li>
                <li>Use accurate product descriptions and high-quality images.</li>
                <li>Respond quickly to return and refund requests.</li>
                <li>Maintain excellent customer service to reduce disputes.</li>
            </ul>

            {{-- Section 9 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">9. Contact Support</h3>
            <p class="text-gray-600 leading-relaxed mb-3">For questions or help regarding return requests, contact:</p>
            <address class="not-italic text-gray-600 leading-relaxed">
                <strong>Trinity Mabati Factory Merchant Support</strong><br>
                Fahari Gardens, Ruiru, Kenya<br>
                Phone: +254 758 821800 / +254 790 519791<br>
                Email: <a href="mailto:support@haromienergy.com" class="text-primary hover:underline">support@haromienergy.com</a>
            </address>

        </div>
    </section>

@endsection
