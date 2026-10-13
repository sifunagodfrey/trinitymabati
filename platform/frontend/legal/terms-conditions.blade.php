{{-- ---------------
-- Terms & Conditions Page
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', 'Terms & Conditions | Trinity Mabati Factory')
@section('meta_description', 'Read the terms and conditions governing your use of Trinity Mabati Factory\'s platform, products, and services.')
@section('meta_keywords', 'Trinity Mabati Factory terms and conditions, marketplace terms, user agreement Kenya')
@section('og_title', 'Terms & Conditions | Trinity Mabati Factory')
@section('og_description', 'Read the terms and conditions governing your use of Trinity Mabati Factory\'s platform.')

@section('content')

    {{-- ---------------
    -- Hero Section
    -- --------------- --}}
    <section class="relative py-20 border-b border-border overflow-hidden">

        <div class="absolute inset-0 bg-cover bg-center opacity-[0.15]"
            style="background-image: url('{{ url('public/images/trinity-mabati-factory-terms-and-conditions.jpg') }}');">
        </div>

        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-secondary"></div>

        <div class="relative max-w-7xl mx-auto px-6 text-center text-white">

            <h1 class="text-3xl md:text-4xl font-bold mb-4">Terms & Conditions</h1>

            <p class="max-w-2xl mx-auto text-white/90">
                Please read these terms carefully before using the Trinity Mabati Factory platform.
            </p>

        </div>
    </section>

    {{-- ---------------
    -- Terms Content
    -- --------------- --}}
    <section class="py-16 bg-white">

        <div class="max-w-4xl mx-auto px-6">

            <p class="text-gray-500 mb-8">Effective Date: <strong>30 June 2025</strong></p>

            {{-- Section 1 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">1. Introduction</h3>
            <p class="text-gray-600 leading-relaxed mb-3">
                Welcome to <strong>Trinity Mabati Factory</strong> - a digital marketplace connecting buyers and sellers across Africa.
                These Terms and Conditions ("Terms") govern your access and use of our website, services, and tools. By
                using our platform, you agree to be bound by these Terms. If you disagree, discontinue use immediately.
            </p>
            <p class="text-gray-600 leading-relaxed">
                These Terms work alongside our
                <a href="{{ route('frontend.cookie-policy') }}" class="text-primary hover:underline">Cookie Policy</a>,
                <a href="{{ route('frontend.refund-policy') }}" class="text-primary hover:underline">Refund Policy</a>,
                and other posted policies.
            </p>

            {{-- Section 2 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">2. Definitions</h3>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li><strong>"Trinity Mabati Factory":</strong> Refers to our platform, services, and operating company.</li>
                <li><strong>"User" or "You":</strong> Any individual accessing the site, including buyers and merchants.</li>
                <li><strong>"Merchant":</strong> A seller or vendor listing products on Trinity Mabati Factory.</li>
                <li><strong>"Content":</strong> Any data, images, listings, or materials posted to the site.</li>
            </ul>

            {{-- Section 3 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">3. Eligibility & Account Registration</h3>
            <p class="text-gray-600 leading-relaxed mb-3">To create an account or sell on Trinity Mabati Factory, you must:</p>
            <ul class="list-disc list-inside space-y-2 text-gray-600 mb-3">
                <li>Be at least 18 years old or have parental consent.</li>
                <li>Provide truthful and updated registration details.</li>
                <li>Keep your login credentials secure.</li>
            </ul>
            <p class="text-gray-600 leading-relaxed">
                You are responsible for all activity under your account. Trinity Mabati Factory reserves the right to suspend or
                terminate accounts that violate these Terms.
            </p>

            {{-- Section 4 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">4. Use of the Platform</h3>
            <p class="text-gray-600 leading-relaxed mb-3">You agree to use Trinity Mabati Factory lawfully and ethically. You may not:</p>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Post false, harmful, or illegal content.</li>
                <li>Upload viruses or attempt to breach site security.</li>
                <li>Misrepresent your identity or business.</li>
            </ul>

            {{-- Section 5 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">5. Product Listings & Transactions</h3>
            <p class="text-gray-600 font-medium mb-2">For Buyers:</p>
            <ul class="list-disc list-inside space-y-2 text-gray-600 mb-4">
                <li>Product availability and prices may change without notice.</li>
                <li>Review product details carefully before ordering.</li>
            </ul>
            <p class="text-gray-600 font-medium mb-2">For Merchants:</p>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Ensure listings are accurate and not misleading.</li>
                <li>Only list authentic, legally permitted products.</li>
                <li>Fulfill orders on time and handle disputes responsibly.</li>
            </ul>

            {{-- Section 6 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">6. Payments & Fees</h3>
            <p class="text-gray-600 leading-relaxed mb-3">
                Transactions are processed securely through Trinity Mabati Factory's systems. By using the platform, you agree to:
            </p>
            <ul class="list-disc list-inside space-y-2 text-gray-600 mb-3">
                <li>Pay all relevant fees, commissions, or service charges.</li>
                <li>Allow us to process payments on your behalf.</li>
            </ul>
            <p class="text-gray-600 leading-relaxed">
                Merchants may be charged platform service or commission fees as outlined in their onboarding agreement.
            </p>

            {{-- Section 7 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">7. Shipping & Delivery</h3>
            <p class="text-gray-600 leading-relaxed mb-3">
                Estimated delivery times depend on the product and merchant. Trinity Mabati Factory is not responsible for delays caused
                by third-party logistics providers.
            </p>
            <p class="text-gray-600 leading-relaxed">
                Buyers must ensure accurate delivery details to avoid failed deliveries.
            </p>

            {{-- Section 8 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">8. Returns, Refunds & Cancellations</h3>
            <p class="text-gray-600 leading-relaxed mb-3">Returns are allowed for:</p>
            <ul class="list-disc list-inside space-y-2 text-gray-600 mb-3">
                <li>Damaged or defective products</li>
                <li>Incorrect or mismatched items</li>
            </ul>
            <p class="text-gray-600 leading-relaxed">
                Return requests must be made within 7 days. Refunds must be processed within 5 business days after the
                returned product is received by the merchant.
            </p>

            {{-- Section 9 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">9. Intellectual Property</h3>
            <p class="text-gray-600 leading-relaxed">
                All content on Trinity Mabati Factory (including code, images, branding) is protected by copyright and may not be used
                without written permission.
            </p>

            {{-- Section 10 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">10. Third-Party Links</h3>
            <p class="text-gray-600 leading-relaxed">
                We may provide links to external sites. Trinity Mabati Factory is not responsible for the content, security, or terms
                of those sites.
            </p>

            {{-- Section 11 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">11. Limitation of Liability</h3>
            <p class="text-gray-600 leading-relaxed mb-3">
                Trinity Mabati Factory shall not be liable for indirect, incidental, or consequential damages arising from your use of
                the platform, including:
            </p>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Loss of profits or data</li>
                <li>Downtime or errors</li>
                <li>Issues with third-party providers</li>
            </ul>

            {{-- Section 12 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">12. Indemnification</h3>
            <p class="text-gray-600 leading-relaxed mb-3">
                You agree to indemnify and hold harmless Trinity Mabati Factory and its staff from any claims or damages arising from:
            </p>
            <ul class="list-disc list-inside space-y-2 text-gray-600">
                <li>Your breach of these Terms</li>
                <li>Your misuse of the platform</li>
                <li>Your violation of third-party rights</li>
            </ul>

            {{-- Section 13 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">13. Account Suspension or Termination</h3>
            <p class="text-gray-600 leading-relaxed">
                We may suspend or permanently remove accounts found to be fraudulent, abusive, or in violation of
                platform rules.
            </p>

            {{-- Section 14 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">14. Amendments</h3>
            <p class="text-gray-600 leading-relaxed">
                We reserve the right to update these Terms. All changes will be posted on this page. Continued use after
                updates implies your acceptance.
            </p>

            {{-- Section 15 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">15. Governing Law</h3>
            <p class="text-gray-600 leading-relaxed">
                These Terms are governed by the laws of Kenya. Disputes will be resolved in Kenyan courts of competent
                jurisdiction.
            </p>

            {{-- Section 16 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">16. Contact Us</h3>
            <p class="text-gray-600 leading-relaxed mb-3">
                If you have questions about these Terms or your rights, contact us:
            </p>
            <address class="not-italic text-gray-600 leading-relaxed">
                <strong>Trinity Mabati Factory Support Team</strong><br>
                Fahari Gardens, Ruiru, Kenya<br>
                Phone: +254 758 821800 / +254 790 519791<br>
                Email: <a href="mailto:support@haromienergy.com" class="text-primary hover:underline">support@haromienergy.com</a>
            </address>

        </div>
    </section>

@endsection
