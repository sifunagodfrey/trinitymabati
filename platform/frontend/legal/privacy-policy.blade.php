@extends('frontend.layouts.app')

@section('content')
    <!-- frontend/legal/privacy-policy.blade.php -->

    {{-- -------------------
    -- Privacy Policy Page
    -- ------------------- --}}
    <section class="relative py-20 border-b border-border overflow-hidden">

        <div class="absolute inset-0 bg-cover bg-center opacity-[0.15]"
            style="background-image: url('{{ url('public/images/trinity-mabati-factory-online-shopping-card.jpg') }}');">
        </div>

        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-secondary"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white">

            <h1 class="text-3xl md:text-4xl font-bold mb-4">Privacy Policy</h1>

        </div>
    </section>
    <section class="py-16 bg-gray-50">

        <div class="max-w-4xl mx-auto px-6">

            <div class="bg-white border border-border rounded-[12px] p-8 md:p-10 shadow-sm">

                <p class="text-gray-500 mb-8">
                    Effective Date: 30 April 2026
                </p>

                {{-- 1. Introduction --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3">1. Introduction</h2>
                    <p class="text-gray-700 leading-relaxed">
                        Welcome to Trinity Mabati Factory. Your privacy is important to us. This Privacy Policy explains how we collect,
                        use, store, and protect your personal information when you use our mobile application, website,
                        and related services.
                    </p>
                    <p class="text-gray-700 leading-relaxed mt-3">
                        By accessing or using Trinity Mabati Factory, you agree to the practices described in this Privacy Policy.
                        If you do not agree, please discontinue use of the platform.
                    </p>
                </div>

                {{-- 2. Information We Collect --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3">2. Information We Collect</h2>

                    <h3 class="font-semibold mt-4">a) Information You Provide</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2 space-y-1">
                        <li>Name, email address, phone number</li>
                        <li>Account login credentials</li>
                        <li>Profile information</li>
                        <li>Order, payment, and transaction details</li>
                        <li>Messages or support inquiries</li>
                    </ul>

                    <h3 class="font-semibold mt-5">b) Automatically Collected Information</h3>
                    <ul class="list-disc list-inside text-gray-700 mt-2 space-y-1">
                        <li>Device information (model, OS version)</li>
                        <li>IP address and approximate location</li>
                        <li>App usage data and interaction logs</li>
                        <li>Cookies and similar technologies (website)</li>
                    </ul>
                </div>

                {{-- 3. How We Use --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3">3. How We Use Your Information</h2>

                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Create and manage user accounts</li>
                        <li>Facilitate buying and selling of products</li>
                        <li>Process orders and payments</li>
                        <li>Provide customer support</li>
                        <li>Improve app performance and user experience</li>
                        <li>Send service-related notifications</li>
                        <li>Detect fraud and ensure platform security</li>
                    </ul>
                </div>

                {{-- 4. Analytics --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3">4. Analytics & Performance Monitoring</h2>
                    <p class="text-gray-700 leading-relaxed">
                        Trinity Mabati Factory may use analytics tools (such as Google Analytics or Firebase) to understand user behavior,
                        diagnose technical issues, and improve performance. These tools collect aggregated and anonymized
                        usage data.
                    </p>
                </div>

                {{-- 5. Sharing --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3">5. Data Sharing & Disclosure</h2>

                    <p class="text-gray-700 mb-3">
                        We do not sell your personal data. Information may only be shared:
                    </p>

                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>With trusted service providers (payment processors, hosting providers)</li>
                        <li>To comply with legal obligations or law enforcement requests</li>
                        <li>To protect Trinity Mabati Factory's legal rights and platform integrity</li>
                    </ul>
                </div>

                {{-- 6. Security --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3">6. Data Security</h2>
                    <p class="text-gray-700 leading-relaxed">
                        We implement reasonable technical and organizational measures to protect your data against
                        unauthorized access,
                        loss, or misuse. All data transmissions are encrypted where applicable.
                    </p>
                </div>

                {{-- 7. Retention --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3">7. Data Retention</h2>
                    <p class="text-gray-700 leading-relaxed">
                        We retain personal information only for as long as necessary to provide our services, comply with
                        legal obligations,
                        resolve disputes, and enforce agreements.
                    </p>
                </div>

                {{-- 8. Rights --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3">8. User Rights</h2>

                    <ul class="list-disc list-inside text-gray-700 space-y-2">
                        <li>Access and update your personal information</li>
                        <li>Request deletion of your account and data</li>
                        <li>Withdraw consent where applicable</li>
                        <li>Object to unlawful data processing</li>
                    </ul>

                    <p class="text-gray-700 mt-3">
                        Requests can be made by contacting our support team.
                    </p>
                </div>

                {{-- 9. Children --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3">9. Children’s Privacy</h2>
                    <p class="text-gray-700 leading-relaxed">
                        Trinity Mabati Factory is not intended for children under the age of 18. We do not knowingly collect personal data
                        from minors.
                        If such data is discovered, it will be deleted promptly.
                    </p>
                </div>

                {{-- 10. Third Party --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3">10. Third-Party Services</h2>
                    <p class="text-gray-700 leading-relaxed">
                        Our platform may contain links or integrations with third-party services. We are not responsible for
                        their privacy practices.
                        Users are encouraged to review their respective privacy policies.
                    </p>
                </div>

                {{-- 11. Updates --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3">11. Policy Updates</h2>
                    <p class="text-gray-700 leading-relaxed">
                        We may update this Privacy Policy from time to time. Changes will be posted on this page with a
                        revised effective date.
                        Continued use of Trinity Mabati Factory constitutes acceptance of the updated policy.
                    </p>
                </div>

                {{-- 12. Law --}}
                <div class="mb-8">
                    <h2 class="text-xl font-semibold mb-3">12. Governing Law</h2>
                    <p class="text-gray-700 leading-relaxed">
                        This Privacy Policy is governed by the laws of the Republic of Kenya.
                    </p>
                </div>

                {{-- 13. Contact --}}
                <div>
                    <h2 class="text-xl font-semibold mb-3">13. Contact Us</h2>

                    <p class="text-gray-700 mb-2">
                        Trinity Mabati Factory Support Team
                    </p>

                    <p class="text-gray-700">
                        Fahari Gardens, Ruiru, Kenya
                    </p>

                    <p class="text-gray-700 mt-2">
                        Phone: +254 758 821800 / +254 790 519791
                    </p>

                    <p class="text-gray-700">
                        Email: support@haromienergy.com
                    </p>
                </div>

            </div>

        </div>

    </section>
@endsection
