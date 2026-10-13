{{--
    platform/frontend/checkout/coopbank-polling.blade.php
    Standalone fallback polling page. Mirrors mpesa-polling.blade.php.
    The modal in payment.blade.php handles the normal (AJAX) case;
    this page is only shown if the user lands here via a direct redirect.
--}}
@extends('frontend.layouts.app')

@section('title', 'Co-op Bank Payment - Trinity Mabati Factory')

@section('content')

    <section class="py-10 bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full px-6" x-data="{
            status: 'pending',
            reason: '',
            elapsed: 0,
            pollInt: null,
            tickTimer: null,
        
            init() {
                this.tickTimer = setInterval(() => { this.elapsed++; }, 1000);
                setTimeout(() => this.check(), 5000);
                this.pollInt = setInterval(() => {
                    if (this.elapsed >= 90) {
                        clearInterval(this.pollInt);
                        clearInterval(this.tickTimer);
                        this.timeout();
                        return;
                    }
                    this.check();
                }, 5000);
            },
        
            check() {
                axios.get('{{ route('frontend.checkout.coopbank.status') }}', {
                        params: { cid: '{{ $cid }}' }
                    })
                    .then(res => {
                        if (res.data.status === 'successful') {
                            clearInterval(this.pollInt);
                            clearInterval(this.tickTimer);
                            this.status = 'successful';
                            setTimeout(() => {
                                window.location.href = '{{ route('frontend.checkout.payment') }}?order={{ $orderCode }}';
                            }, 2000);
                        } else if (res.data.status === 'failed') {
                            clearInterval(this.pollInt);
                            clearInterval(this.tickTimer);
                            this.reason = res.data.reason || 'Payment was not completed.';
                            this.status = 'failed';
                        }
                    })
                    .catch(() => {});
            },
        
            timeout() {
                axios.post('{{ route('frontend.checkout.coopbank.timeout') }}', {
                    cid: '{{ $cid }}',
                    _token: '{{ csrf_token() }}'
                }).finally(() => {
                    this.reason = 'No payment confirmation received within 90 seconds. Please try again.';
                    this.status = 'failed';
                });
            }
        }" x-init="init()">

            {{-- Pending --}}
            <div x-show="status === 'pending'" class="bg-white rounded-[12px] shadow-sm border border-gray-100 p-8 text-center">
                <div class="flex justify-center mb-5">
                    <svg class="animate-spin h-14 w-14 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                </div>
                <img src="{{ asset('images/coopbank-logo.png') }}" alt="Co-op Bank" class="h-7 mx-auto mb-3 object-contain"
                    onerror="this.style.display='none'">
                <h3 class="text-lg font-bold text-gray-900 mb-1">Waiting for payment confirmation...</h3>
                <p class="text-sm text-gray-500 mb-4">Check your phone and enter your PIN to authorise the payment.</p>
                <p class="text-xs text-gray-400" x-text="'Checking... ' + elapsed + 's'"></p>
                <div class="mt-4 bg-green-50 border border-green-200 rounded-[8px] px-4 py-2 text-xs text-green-700">
                    <i class="fas fa-shield-alt mr-1"></i> Secured by Co-operative Bank of Kenya. Do not close this page.
                </div>
            </div>

            {{-- Successful --}}
            <div x-show="status === 'successful'" x-cloak
                class="bg-white rounded-[12px] shadow-sm border border-gray-100 p-8 text-center">
                <div class="w-16 h-16 bg-green-100 rounded-[12px] flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-check-circle text-3xl text-green-600"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-1">Payment Confirmed!</h3>
                <p class="text-sm text-gray-500">Your payment was received. Redirecting to your order...</p>
                <div class="mt-4 w-full bg-gray-100 rounded-[12px] h-1.5 overflow-hidden">
                    <div class="bg-green-500 h-1.5 rounded-[12px] animate-pulse w-full"></div>
                </div>
            </div>

            {{-- Failed --}}
            <div x-show="status === 'failed'" x-cloak
                class="bg-white rounded-[12px] shadow-sm border border-gray-100 p-8 text-center">
                <div class="w-16 h-16 bg-red-100 rounded-[12px] flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-times-circle text-3xl text-red-500"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Payment Failed</h3>
                <p class="text-sm text-red-600 font-medium mb-3" x-text="reason"></p>
                <p class="text-xs text-gray-400 mb-5">Your order is saved. Retry payment from your orders page.</p>
                <a href="{{ route('client.orders.index') }}"
                    class="inline-block px-5 py-2.5 bg-primary text-white font-bold rounded-[12px] hover:opacity-90 transition text-sm">
                    <i class="fas fa-box mr-1"></i> View My Orders
                </a>
            </div>

        </div>
    </section>

@endsection
