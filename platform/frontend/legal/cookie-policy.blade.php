{{-- ---------------
-- Cookie Policy Page
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', 'Cookie Policy | Trinity Mabati Factory')
@section('meta_description', 'Learn how Trinity Mabati Factory uses cookies to enhance your shopping experience. Read our cookie usage, types, and control settings.')
@section('meta_keywords', 'Trinity Mabati Factory cookie policy, cookies Trinity Mabati Factory, tracking cookies Kenya marketplace')
@section('og_title', 'Cookie Policy | Trinity Mabati Factory')
@section('og_description', 'Learn how Trinity Mabati Factory uses cookies to enhance your shopping experience.')

@section('content')

    {{-- ---------------
    -- Hero Section
    -- --------------- --}}
    <section class="relative py-20 border-b border-border overflow-hidden">

        <div class="absolute inset-0 bg-cover bg-center opacity-[0.15]"
            style="background-image: url('{{ url('public/images/trinity-mabati-factory-online-shopping-card.jpg') }}');">
        </div>

        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-secondary"></div>

        <div class="relative max-w-7xl mx-auto px-6 text-center text-white">

            <h1 class="text-3xl md:text-4xl font-bold mb-4">Cookie Policy</h1>

            <p class="max-w-2xl mx-auto text-white/90">
                How we use cookies to enhance your experience on Trinity Mabati Factory.
            </p>

        </div>
    </section>

    {{-- ---------------
    -- Cookie Policy Content
    -- --------------- --}}
    <section class="py-16 bg-white">

        <div class="max-w-4xl mx-auto px-6">

            <p class="text-gray-500 mb-8">Effective Date: <strong>30 May 2025</strong></p>

            {{-- Section 1 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">1. Introduction</h3>
            <p class="text-gray-600 leading-relaxed mb-3">
                This Cookie Policy explains how <strong>Trinity Mabati Factory</strong> ("we", "our", or "us") uses cookies and similar
                tracking technologies to enhance your experience on our website, improve performance, personalize content,
                and deliver relevant advertising.
            </p>
            <p class="text-gray-600 leading-relaxed">
                By continuing to use our website, you agree to our use of cookies in accordance with this policy.
            </p>

            {{-- Section 2 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">2. What Are Cookies?</h3>
            <p class="text-gray-600 leading-relaxed">
                Cookies are small text files stored on your device (computer, tablet, smartphone) by websites you visit.
                They help websites recognize your device, remember your preferences, and improve functionality.
            </p>

            {{-- Section 3 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">3. Types of Cookies We Use</h3>
            <ul class="list-disc list-inside space-y-3 text-gray-600">
                <li>
                    <strong>Essential Cookies:</strong> Required for website functionality (e.g., shopping cart, secure
                    login, account access).
                </li>
                <li>
                    <strong>Performance & Analytics Cookies:</strong> Help us understand how users interact with our site
                    (e.g., page speed, errors, traffic sources).
                </li>
                <li>
                    <strong>Functionality Cookies:</strong> Remember user preferences like language, region, or currency
                    for a personalized experience.
                </li>
                <li>
                    <strong>Advertising & Targeting Cookies:</strong> Deliver ads relevant to your interests, reduce ad
                    repetition, and track campaign effectiveness.
                </li>
            </ul>

            {{-- Section 4 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">4. Third-Party Cookies</h3>
            <p class="text-gray-600 leading-relaxed mb-3">
                We may allow trusted third-party services to place cookies on your device to analyze site usage, enable
                social sharing, or deliver targeted ads. These include tools such as:
            </p>
            <ul class="list-disc list-inside space-y-2 text-gray-600 mb-3">
                <li>Google Analytics</li>
                <li>Facebook Pixel</li>
                <li>Meta Ads, Google Ads, and similar platforms</li>
            </ul>
            <p class="text-gray-600 leading-relaxed">
                These third parties have their own cookie and privacy policies which you can review on their respective
                websites.
            </p>

            {{-- Section 5 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">5. How to Control Cookies</h3>
            <p class="text-gray-600 leading-relaxed mb-3">
                You can manage or delete cookies anytime via your browser settings. Below are instructions for common
                browsers:
            </p>
            <ul class="list-disc list-inside space-y-2 text-gray-600 mb-3">
                <li><strong>Chrome:</strong> Settings &gt; Privacy and security &gt; Cookies and other site data</li>
                <li><strong>Firefox:</strong> Options &gt; Privacy & Security &gt; Cookies and Site Data</li>
                <li><strong>Safari:</strong> Preferences &gt; Privacy &gt; Manage Website Data</li>
                <li><strong>Microsoft Edge:</strong> Settings &gt; Site permissions &gt; Cookies and site data</li>
            </ul>
            <p class="text-gray-600 leading-relaxed italic">
                Note: Disabling cookies may affect functionality and limit your shopping experience on Trinity Mabati Factory.
            </p>

            {{-- Section 6 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">6. Policy Updates</h3>
            <p class="text-gray-600 leading-relaxed">
                We may update this Cookie Policy from time to time to reflect changes in law, technology, or business
                practices. Updates will be posted here with the new effective date.
            </p>

            {{-- Section 7 --}}
            <h3 class="text-lg font-bold mt-8 mb-3">7. Contact Us</h3>
            <p class="text-gray-600 leading-relaxed mb-3">
                If you have questions about this Cookie Policy or how we use cookies, please contact us:
            </p>
            <address class="not-italic text-gray-600 leading-relaxed">
                <strong>Trinity Mabati Factory Headquarters</strong><br>
                Fahari Gardens, Ruiru<br>
                Phone: +254 758 821800<br>
                Secondary: +254 790 519791<br>
                Email: <a href="mailto:support@haromienergy.com" class="text-primary hover:underline">support@haromienergy.com</a>
            </address>

        </div>
    </section>

@endsection
