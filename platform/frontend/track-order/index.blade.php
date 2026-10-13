{{-- -------------------
     Track My Order
     Public order tracking: enter order number and the email used at
     checkout. The lookup is AJAX, so results, errors and not-found
     states appear in place without a page reload. Falls back to a
     normal submit when JavaScript is unavailable.
------------------- --}}
@extends('frontend.layouts.app')

@section('title', 'Track My Order | Trinity Mabati Factory')
@section('meta_description',
    'Easily track your Trinity Mabati Factory orders by entering your order number and the email address
    used at checkout.')
@section('meta_keywords', 'Trinity Mabati Factory track order, order tracking Kenya, check order status Trinity Mabati Factory')
@section('og_title', 'Track My Order | Trinity Mabati Factory')
@section('og_description', 'Easily track your Trinity Mabati Factory orders by entering your order number and email address.')

@section('content')

    {{-- ---------------
    -- Hero
    -- --------------- --}}
    <section class="relative py-16 md:py-20 border-b border-border overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-[0.10]"
            style="background-image: url('{{ url('public/images/trinity-mabati-factory-aboout.jpg') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-secondary"></div>

        <div class="relative max-w-7xl mx-auto px-6 text-center text-white">
            <div class="flex justify-center mb-4">
                <div class="w-14 h-14 flex items-center justify-center rounded-[12px] bg-white/10 border border-white/20">
                    <i class="fas fa-truck-fast text-xl"></i>
                </div>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold mb-3">Track My Order</h1>
            <p class="max-w-2xl mx-auto text-white/90">
                Enter your order number and the email used at checkout to see your order status.
            </p>
        </div>
    </section>

    {{-- ---------------
    -- Form + Results
    -- --------------- --}}
    <section class="py-12 md:py-16 bg-gray-50">
        <div class="max-w-xl mx-auto px-6" x-data="orderTracker({ url: '{{ route('frontend.track-order.track') }}' })">

            <form @submit.prevent="track" action="{{ route('frontend.track-order.track') }}" method="POST"
                class="bg-white border border-border rounded-[12px] p-6 md:p-8 space-y-5 shadow-sm">
                @csrf

                <div>
                    <label for="order_code" class="block text-sm font-medium text-gray-700 mb-1">Order Number *</label>
                    <input type="text" name="order_code" id="order_code" x-model="orderCode"
                        placeholder="E.g. HAR123456789" required
                        class="w-full border border-border rounded-[8px] px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address Used *</label>
                    <input type="email" name="email" id="email" x-model="email" placeholder="E.g. your@email.com"
                        required
                        class="w-full border border-border rounded-[8px] px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-primary">
                </div>

                {{-- Validation error --}}
                <p x-show="error" x-cloak x-text="error" class="text-sm text-red-500"></p>

                <button type="submit" :disabled="loading"
                    :class="loading ? 'opacity-60 cursor-not-allowed' : 'hover:opacity-90'"
                    class="w-full flex items-center justify-center gap-2 px-6 py-3 bg-primary text-white rounded-[8px] font-semibold transition">
                    <i class="fas fa-spinner fa-spin" x-show="loading"></i>
                    <i class="fas fa-magnifying-glass" x-show="!loading"></i>
                    <span x-text="loading ? 'Tracking...' : 'Track Order'"></span>
                </button>
            </form>

            {{-- Results swap in here --}}
            <div id="track-result" class="mt-6">
                @include('frontend.track-order.partials.result', [
                    'order' => $order,
                    'timeline' => $timeline,
                    'searched' => $searched,
                ])
            </div>

        </div>
    </section>

    @push('scripts')
        <script>
            function orderTracker(config) {
                return {
                    url: config.url,
                    orderCode: '{{ $old['order_code'] ?? '' }}',
                    email: '{{ $old['email'] ?? '' }}',
                    loading: false,
                    error: '',

                    track() {
                        this.error = '';
                        if (!this.orderCode.trim() || !this.email.trim()) {
                            this.error = 'Please enter both your order number and email.';
                            return;
                        }
                        this.loading = true;

                        var body = new FormData();
                        body.append('order_code', this.orderCode);
                        body.append('email', this.email);
                        body.append('ajax', '1');
                        body.append('_token', document.querySelector('meta[name=csrf-token]').content);

                        fetch(this.url, {
                                method: 'POST',
                                headers: {
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'Accept': 'text/html'
                                },
                                body: body
                            })
                            .then((r) => {
                                if (r.status === 422) {
                                    return r.json().then((d) => {
                                        var msgs = d.errors ? Object.values(d.errors).flat() : [
                                            'Please check your details.'
                                        ];
                                        this.error = msgs[0];
                                        return null;
                                    });
                                }
                                return r.text();
                            })
                            .then((html) => {
                                if (html === null) return;
                                document.getElementById('track-result').innerHTML = html;
                            })
                            .catch(() => {
                                this.error = 'Something went wrong. Please try again.';
                            })
                            .finally(() => {
                                this.loading = false;
                            });
                    }
                };
            }
        </script>
    @endpush

@endsection
