{{-- ---------------
-- Admin 2FA Verification Page
-- --------------- --}}
@extends('manage.layouts.auth')

{{-- ---------------
-- Title
-- --------------- --}}
@section('title', 'Verify Identity - ' . config('app.name') . ' Admin')

@section('content')

    {{-- ---------------
    -- Centered Card
    -- --------------- --}}
    <div class="flex h-full justify-center overflow-y-auto p-4">
        <div class="w-full max-w-md">

            <div class="rounded-[8px] shadow-2xl p-5 sm:p-8"
                 style="background-color: rgba(255,255,255,0.88); backdrop-filter: blur(5px);">

                {{-- ---------------
                -- Header
                -- --------------- --}}
                <div class="text-center mb-6">
                    <img src="{{ url('public/images/trinity-mabati-factory-logo.png') }}"
                         alt="{{ config('app.name') }} Logo"
                         class="max-h-10 mx-auto mb-4">
                    <h5 class="text-lg font-semibold text-gray-800">Two-Factor Verification</h5>
                    <p class="text-sm text-gray-500 mt-1">
                        A 6-digit code has been sent to your email address.<br>
                        Enter it below to complete your login.
                    </p>
                </div>

                <hr class="mb-5 border-gray-200">

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
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-[8px] text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- ---------------
                -- 2FA Form
                -- --------------- --}}
                <form method="POST"
                      action="{{ route('manage.auth.verify2fa.submit') }}"
                      x-data="adminOtpForm()"
                      @submit.prevent="submit">
                    @csrf

                    {{-- Hidden combined field submitted to the server --}}
                    <input type="hidden" name="code" x-model="combined">

                    {{-- OTP Digit Inputs --}}
                    <div class="flex justify-center gap-2 mb-6">
                        <template x-for="(digit, i) in digits" :key="i">
                            <input type="text"
                                   inputmode="numeric"
                                   maxlength="1"
                                   x-model="digits[i]"
                                   @input="onInput(i)"
                                   @keydown.backspace="onBackspace(i, $event)"
                                   @paste.prevent="onPaste($event)"
                                   :id="'otp-' + i"
                                   class="w-10 h-12 sm:w-12 sm:h-14 text-center text-xl font-bold border border-gray-300 rounded-[8px] focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   autocomplete="off">
                        </template>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-[8px] transition text-sm">
                        Verify &amp; Login
                    </button>

                    {{-- Back link --}}
                    <p class="text-center text-sm text-gray-500 mt-4">
                        Wrong account?
                        <a href="{{ route('manage.auth.login') }}" class="text-blue-600 hover:underline">
                            Back to login
                        </a>
                    </p>

                </form>

                {{-- Expiry notice --}}
                <p class="text-center text-xs text-gray-400 mt-4">
                    The code expires in 10 minutes. Check your spam folder if you don't see the email.
                </p>

            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
// ---------------
// Alpine.js OTP form component
// ---------------
function adminOtpForm() {
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
