{{-- ---------------
-- Account Deletion Page
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', 'Account Deletion | Trinity Mabati Factory')
@section('meta_description', 'Request deletion of your Trinity Mabati Factory account and associated personal data.')
@section('meta_keywords', 'Trinity Mabati Factory account deletion, delete account, remove Trinity Mabati Factory account')
@section('og_title', 'Account Deletion | Trinity Mabati Factory')
@section('og_description', 'Request deletion of your Trinity Mabati Factory account and associated personal data.')

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

            <h1 class="text-3xl md:text-4xl font-bold mb-4">
                Trinity Mabati Factory Account Deletion
            </h1>

            <p class="text-white/90 max-w-3xl mx-auto">
                This page explains how users of Trinity Mabati Factory can request permanent deletion
                of their account and associated personal data.
            </p>

        </div>
    </section>

    {{-- ---------------
    -- Main Content
    -- --------------- --}}
    <section class="py-16 bg-gray-50">

        <div class="max-w-4xl mx-auto px-6">

            <div class="bg-white border border-border rounded-[12px] p-8 md:p-10 shadow-sm">

                {{-- Intro --}}
                <div class="mb-10">

                    <h2 class="text-2xl font-bold mb-4">
                        Request Account Deletion
                    </h2>

                    <p class="text-gray-700 leading-relaxed mb-4">
                        Users of the Trinity Mabati Factory mobile application may request permanent deletion
                        of their account and associated personal information at any time.
                    </p>

                    <p class="text-gray-700 leading-relaxed">
                        Once your deletion request is successfully processed, you will no longer be able
                        to access your account using the deleted credentials.
                    </p>

                </div>

                {{-- Steps --}}
                <div class="mb-10">

                    <h3 class="text-xl font-semibold mb-5">
                        Steps to Request Account Deletion
                    </h3>

                    <div class="space-y-5">

                        {{-- Step 1 --}}
                        <div class="border border-border rounded-[8px] p-5">

                            <div class="flex items-start gap-4">

                                <div
                                    class="w-10 h-10 rounded-[12px] bg-primary text-white flex items-center justify-center font-semibold shrink-0">
                                    1
                                </div>

                                <div>
                                    <h4 class="font-semibold mb-2">
                                        Send a Deletion Request
                                    </h4>

                                    <p class="text-gray-700 mb-3">
                                        Send an email to our support team requesting account deletion.
                                    </p>

                                    <a href="mailto:support@haromienergy.com"
                                        class="inline-flex items-center text-primary font-medium hover:underline">
                                        support@haromienergy.com
                                    </a>

                                </div>

                            </div>

                        </div>

                        {{-- Step 2 --}}
                        <div class="border border-border rounded-[8px] p-5">

                            <div class="flex items-start gap-4">

                                <div
                                    class="w-10 h-10 rounded-[12px] bg-primary text-white flex items-center justify-center font-semibold shrink-0">
                                    2
                                </div>

                                <div>
                                    <h4 class="font-semibold mb-2">
                                        Use Your Registered Email Address
                                    </h4>

                                    <p class="text-gray-700">
                                        Please send the deletion request using the email address associated
                                        with your Trinity Mabati Factory account for verification purposes.
                                    </p>
                                </div>

                            </div>

                        </div>

                        {{-- Step 3 --}}
                        <div class="border border-border rounded-[8px] p-5">

                            <div class="flex items-start gap-4">

                                <div
                                    class="w-10 h-10 rounded-[12px] bg-primary text-white flex items-center justify-center font-semibold shrink-0">
                                    3
                                </div>

                                <div>
                                    <h4 class="font-semibold mb-2">
                                        Verification & Processing
                                    </h4>

                                    <p class="text-gray-700">
                                        Our support team may contact you to verify ownership of the account
                                        before processing the deletion request.
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Deleted Data --}}
                <div class="mb-10">

                    <h3 class="text-xl font-semibold mb-5">
                        Data That Will Be Deleted
                    </h3>

                    <div class="bg-emerald-50 border border-emerald-200 rounded-[8px] p-6">

                        <ul class="space-y-3 text-gray-700 list-disc list-inside">

                            <li>
                                Your Trinity Mabati Factory account profile
                            </li>

                            <li>
                                Personal account information such as your name, phone number, and email address
                            </li>

                            <li>
                                Saved addresses and account preferences
                            </li>

                            <li>
                                Account authentication credentials associated with the account
                            </li>

                            <li>
                                Wishlist, favorites, and other account-related preferences
                            </li>

                        </ul>

                    </div>

                </div>

                {{-- Retained Data --}}
                <div class="mb-10">

                    <h3 class="text-xl font-semibold mb-5">
                        Data That May Be Retained
                    </h3>

                    <div class="bg-amber-50 border border-amber-200 rounded-[8px] p-6">

                        <p class="text-gray-700 mb-4">
                            Certain information may be retained for legal, regulatory, security,
                            fraud prevention, dispute resolution, and financial record-keeping purposes.
                        </p>

                        <ul class="space-y-3 text-gray-700 list-disc list-inside">

                            <li>
                                Transaction and payment records required for legal or tax obligations
                            </li>

                            <li>
                                Security logs and fraud prevention records
                            </li>

                            <li>
                                Information required to comply with applicable laws and regulations
                            </li>

                        </ul>

                    </div>

                </div>

                {{-- Retention Period --}}
                <div class="mb-10">

                    <h3 class="text-xl font-semibold mb-5">
                        Data Retention Period
                    </h3>

                    <div class="border border-border rounded-[8px] p-6">

                        <p class="text-gray-700 leading-relaxed">
                            Account deletion requests are typically processed within 7 business days.
                            Certain legally required records may be retained for up to 90 days or longer
                            where required by law or regulatory obligations.
                        </p>

                    </div>

                </div>

                {{-- Contact --}}
                <div>

                    <h3 class="text-xl font-semibold mb-5">
                        Need Help?
                    </h3>

                    <div class="border border-border rounded-[8px] p-6">

                        <p class="text-gray-700 mb-4">
                            If you need assistance regarding account deletion or your personal data,
                            please contact Trinity Mabati Factory support.
                        </p>

                        <div class="space-y-2">

                            <a href="mailto:support@haromienergy.com" class="block text-primary font-medium hover:underline">
                                support@haromienergy.com
                            </a>

                            <a href="{{ route('frontend.contact') }}"
                                class="block text-primary font-medium hover:underline">
                                Contact Support
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

@endsection
