{{-- ---------------
-- Email Verification Page (Registration OTP)
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- SEO
-- --------------- --}}
@section('title', 'Verify Your Email | ' . config('app.name'))
@section('meta_description', 'Enter the verification code sent to your email or phone to activate your ' . config('app.name') . ' account.')

@section('content')

    {{-- ---------------
    -- Verification Form
    -- --------------- --}}
    <section class="py-16 bg-gray-50">

        <div class="max-w-lg mx-auto px-6">

            {{-- Header --}}
            <div class="text-center mb-8">

                <div class="w-16 h-16 rounded-[12px] bg-primary/10 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope-open-text text-primary text-2xl"></i>
                </div>

                <h1 class="text-2xl font-bold mb-2">Verify Your Email</h1>

                <p class="text-gray-500 text-sm">
                    We sent a 6-digit code to <strong class="text-gray-700">{{ $email }}</strong> and to your phone by SMS.<br>
                    Enter it below to activate your account.
                </p>

            </div>

            {{-- ---------------
            -- Error Summary
            -- --------------- --}}
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-[8px] text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- ---------------
            -- OTP Form
            -- --------------- --}}
            <form method="POST" action="{{ route('register.verify.submit') }}"
                class="bg-white border border-border rounded-[8px] p-8 shadow-sm"
                x-data="otpForm()"
                @submit.prevent="submit">
                @csrf

                {{-- Hidden combined code field --}}
                <input type="hidden" name="code" x-model="combined">

                {{-- OTP Digit Inputs --}}
                <div class="flex justify-center gap-3 mb-6">
                    <template x-for="(digit, i) in digits" :key="i">
                        <input
                            type="text"
                            inputmode="numeric"
                            maxlength="1"
                            x-model="digits[i]"
                            @input="onInput(i)"
                            @keydown.backspace="onBackspace(i, $event)"
                            @paste.prevent="onPaste($event)"
                            :id="'otp-' + i"
                            class="w-12 h-14 text-center text-xl font-bold border border-border rounded-[8px] focus:outline-none focus:ring-2 focus:ring-primary"
                            autocomplete="off">
                    </template>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="w-full px-6 py-3 bg-primary text-white rounded-[8px] font-semibold hover:opacity-90 transition">
                    Verify &amp; Activate Account
                </button>

                {{-- Back Link --}}
                <p class="text-center text-sm text-gray-500 mt-5">
                    Wrong email?
                    <a href="{{ route('register') }}" class="text-primary font-medium hover:underline">Start over</a>
                </p>

            </form>

            {{-- Expiry notice --}}
            <p class="text-center text-xs text-gray-400 mt-4">
                The code expires in 15 minutes. Check your SMS inbox or email spam folder if you don't see it.
            </p>

        </div>
    </section>

@endsection

@push('scripts')
<script>
// ---------------
// Alpine.js OTP form component
// ---------------
function otpForm() {
    return {
        digits: ['', '', '', '', '', ''],

        get combined() {
            return this.digits.join('');
        },

        onInput(i) {
            const val = this.digits[i];
            // Only keep first digit if multiple typed
            this.digits[i] = val.replace(/\D/g, '').slice(0, 1);
            if (this.digits[i] && i < 5) {
                this.$nextTick(() => document.getElementById('otp-' + (i + 1)).focus());
            }
        },

        onBackspace(i, e) {
            if (!this.digits[i] && i > 0) {
                e.preventDefault();
                this.digits[i - 1] = '';
                this.$nextTick(() => document.getElementById('otp-' + (i - 1)).focus());
            }
        },

        onPaste(e) {
            const text = (e.clipboardData || window.clipboardData)
                .getData('text')
                .replace(/\D/g, '')
                .slice(0, 6);
            text.split('').forEach((ch, i) => { this.digits[i] = ch; });
            const last = Math.min(text.length, 5);
            this.$nextTick(() => document.getElementById('otp-' + last).focus());
        },

        submit() {
            if (this.combined.length === 6) {
                this.$el.submit();
            }
        },
    };
}
</script>
@endpush
