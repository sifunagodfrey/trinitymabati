{{-- ---------------
-- Login 2FA Verification Page
-- --------------- --}}
@extends('frontend.layouts.app')

{{-- ---------------
-- Title
-- --------------- --}}
@section('title', 'Verify Your Identity - ' . config('app.name'))

@section('content')

    <div class="min-h-[70vh] flex items-center justify-center px-6 py-12">

        <div class="w-full max-w-md bg-white border border-border rounded-[8px] p-8 shadow-sm">

            {{-- ---------------
            -- Header
            -- --------------- --}}
            <div class="text-center mb-6">
                <div class="w-16 h-16 rounded-[12px] bg-primary/10 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-primary text-2xl"></i>
                </div>
                <h2 class="text-2xl font-bold mb-1">Two-Factor Verification</h2>
                <p class="text-gray-500 text-sm">
                    A 6-digit verification code has been sent to you.<br>
                    Enter it below to complete your login.
                </p>
            </div>

            {{-- ---------------
            -- Success Alert
            -- --------------- --}}
            @if (session('success'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-[8px] text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ---------------
            -- Error Alert
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
            <form method="POST"
                  action="{{ route('login.verify2fa.submit') }}"
                  x-data="otpVerifyForm()"
                  @submit.prevent="submit">
                @csrf

                {{-- Hidden combined field submitted to the server --}}
                <input type="hidden" name="code" x-model="combined">

                {{-- OTP Digit Inputs --}}
                <div class="flex justify-center gap-3 mb-6">
                    <template x-for="(digit, i) in digits" :key="i">
                        <input type="text"
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
                    Verify &amp; Login
                </button>

                {{-- Back link --}}
                <p class="text-center text-sm text-gray-500 mt-5">
                    Wrong account?
                    <a href="{{ route('login') }}" class="text-primary font-medium hover:underline">Back to login</a>
                </p>

            </form>

            {{-- Expiry notice --}}
            <p class="text-center text-xs text-gray-400 mt-4">
                The code expires in 10 minutes. If it was emailed, also check your spam folder.
            </p>

        </div>
    </div>

@endsection

@push('scripts')
<script>
// ---------------
// Alpine.js OTP form component
// ---------------
function otpVerifyForm() {
    return {
        digits: ['', '', '', '', '', ''],

        get combined() {
            return this.digits.join('');
        },

        onInput(i) {
            this.digits[i] = this.digits[i].replace(/\D/g, '').slice(0, 1);
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
