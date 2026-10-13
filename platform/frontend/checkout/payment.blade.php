@extends('frontend.layouts.app')

@section('title', $mode === 'confirmation' ? 'Order Confirmed - Trinity Mabati Factory' : 'Payment - Trinity Mabati Factory')

@section('content')

    <section class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-6">

            {{-- Flash Messages --}}
            @if (session('success'))
                <div
                    class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-[8px] px-5 py-4 text-sm flex items-center gap-2">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-[8px] px-5 py-4 text-sm flex items-center gap-2">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if (session('info'))
                <div
                    class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 rounded-[8px] px-5 py-4 text-sm flex items-center gap-2">
                    <i class="fas fa-info-circle"></i> {{ session('info') }}
                </div>
            @endif

            @if ($mode === 'confirmation')
                {{-- Confirmation mode with order summary --}}
                <div class="mb-6 text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-[12px] flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-check text-2xl text-green-600"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">Order Placed!</h1>
                    <p class="text-gray-500 text-sm mt-1">
                        Order reference: <span class="font-semibold text-primary">{{ $order->order_code }}</span>
                    </p>
                </div>

                <div class="bg-white border border-gray-200 rounded-[8px] p-6 mb-6">
                    <h2 class="font-bold text-gray-900 text-lg mb-4">
                        <i class="fas fa-receipt text-primary mr-2"></i> Order Summary
                    </h2>
                    <div class="space-y-1">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-4 py-3 border-b border-gray-100 last:border-0">
                                <div class="w-12 h-12 bg-gray-100 rounded-[8px] overflow-hidden flex-shrink-0">
                                    <img src="{{ asset($item->product->thumbnail ? (str_starts_with($item->product->thumbnail, 'uploads/') ? $item->product->thumbnail : 'uploads/products/images/' . $item->product->thumbnail) : 'images/placeholder.png') }}"
                                        alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <p class="font-semibold text-gray-900 text-sm">{{ $item->product_name }}</p>
                                    <p class="text-xs text-gray-400">Qty: {{ $item->quantity }}</p>
                                </div>
                                <p class="font-bold text-primary text-sm whitespace-nowrap">
                                    KSh {{ number_format($item->price * $item->quantity) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-100 pt-4 mt-2 space-y-2 text-sm">
                        <div class="flex justify-between text-gray-600">
                            <span>Shipping</span>
                            <span class="font-semibold">KSh {{ number_format($order->shipping_cost) }}</span>
                        </div>
                        <div class="flex justify-between text-gray-900 font-bold text-base">
                            <span>Total</span>
                            <span class="text-primary">KSh {{ number_format($order->total) }}</span>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('frontend.products') }}"
                        class="inline-block px-8 py-3 bg-primary text-white font-bold rounded-[12px] hover:opacity-90 transition text-sm">
                        <i class="fas fa-shopping-bag mr-2"></i> Continue Shopping
                    </a>
                </div>

            @else
                {{-- Payment Mode (unchanged) --}}
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">Select Payment Method</h1>
                    <p class="text-gray-500 text-sm mt-1">Review your order and choose how you'd like to pay.</p>
                </div>

                <div x-data="{
                    get adjustedTotal() { return {{ $total }}; },
                    method: {{ optional($paymentMethods->firstWhere('is_default', true))->id ?? ($paymentMethods->isNotEmpty() ? $paymentMethods->first()->id : 'null') }},

                    mpesaModal: false,
                    mpesaStatus: 'pending',
                    mpesaReason: '',
                    mpesaError: '',
                    mpesaOrderCode: '',
                    mpesaCid: '',
                    mpesaElapsed: 0,
                    mpesaPollInterval: null,
                    mpesaTickTimer: null,

                    initiateMpesa(form) {
                        this.mpesaModal = true;
                        this.mpesaStatus = 'pending';
                        this.mpesaReason = '';
                        this.mpesaError = '';
                        this.mpesaElapsed = 0;
                        axios.post('{{ route('frontend.checkout.payment.store') }}', new FormData(form), {
                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                            })
                            .then(res => {
                                if (res.data.success) {
                                    this.mpesaOrderCode = res.data.order_code;
                                    this.mpesaCid = res.data.cid;
                                    this.startMpesaPolling();
                                } else {
                                    this.mpesaModal = false;
                                    this.mpesaError = res.data.message || 'Could not initiate M-Pesa. Please try again.';
                                }
                            })
                            .catch(e => {
                                const errs = e.response?.data?.errors;
                                const first = errs ? Object.values(errs)[0][0] : null;
                                this.mpesaModal = false;
                                this.mpesaError = first || e.response?.data?.message || 'An error occurred. Please try again.';
                            });
                    },

                    startMpesaPolling() {
                        this.mpesaTickTimer = setInterval(() => { this.mpesaElapsed++; }, 1000);
                        setTimeout(() => this.checkMpesaStatus(), 4000);
                        this.mpesaPollInterval = setInterval(() => {
                            if (this.mpesaElapsed >= 40) {
                                clearInterval(this.mpesaPollInterval);
                                clearInterval(this.mpesaTickTimer);
                                this.notifyMpesaTimeout();
                                return;
                            }
                            this.checkMpesaStatus();
                        }, 5000);
                    },

                    checkMpesaStatus() {
                        axios.get('{{ route('frontend.checkout.mpesa.status') }}', { params: { cid: this.mpesaCid } })
                            .then(res => {
                                if (res.data.status === 'successful') {
                                    clearInterval(this.mpesaPollInterval);
                                    clearInterval(this.mpesaTickTimer);
                                    this.mpesaStatus = 'successful';
                                    setTimeout(() => {
                                        window.location.href = '{{ route('frontend.checkout.payment') }}?order=' + this.mpesaOrderCode;
                                    }, 2000);
                                } else if (res.data.status === 'failed') {
                                    clearInterval(this.mpesaPollInterval);
                                    clearInterval(this.mpesaTickTimer);
                                    this.mpesaReason = res.data.reason || 'Payment was not completed.';
                                    this.mpesaStatus = 'failed';
                                }
                            })
                            .catch(() => {});
                    },

                    notifyMpesaTimeout() {
                        axios.post('{{ route('frontend.checkout.mpesa.timeout') }}', {
                            cid: this.mpesaCid,
                            _token: '{{ csrf_token() }}'
                        }).finally(() => {
                            this.mpesaReason = 'No payment confirmation received.';
                            this.mpesaStatus = 'failed';
                        });
                    },

                    {{--  
                    coopSub: '',
                    coopModal: false,
                    coopStatus: 'pending',
                    coopReason: '',
                    coopError: '',
                    coopOrderCode: '',
                    coopCid: '',
                    coopElapsed: 0,
                    coopPollInt: null,
                    coopTickTimer: null,
                    coopBankDetails: {},

                    initiateCoopBank(form) {
                        this.coopError = '';
                        if (!this.coopSub) {
                            this.coopError = 'Please choose how you would like to pay.';
                            return;
                        }
                        if (this.coopSub === 'card') {
                            this.coopError = 'Card payment (Chapa Pay) is not yet enabled. Please use Send Money or Bank Transfer.';
                            return;
                        }
                        axios.post('{{ route('frontend.checkout.payment.store') }}', new FormData(form), {
                                headers: { 'X-Requested-With': 'XMLHttpRequest' }
                            })
                            .then(res => {
                                if (!res.data.success) {
                                    this.coopError = res.data.message || 'Could not create order. Please try again.';
                                    return;
                                }
                                this.coopOrderCode = res.data.order_code;
                                const orderId = res.data.order_id;
                                if (this.coopSub === 'send_money') {
                                    this.doCoopStkPush(orderId, form);
                                } else {
                                    this.doCoopBankTransfer(orderId);
                                }
                            })
                            .catch(e => {
                                const errs = e.response?.data?.errors;
                                const first = errs ? Object.values(errs)[0][0] : null;
                                this.coopError = first || e.response?.data?.message || 'An error occurred. Please try again.';
                            });
                    },

                    doCoopStkPush(orderId, form) {
                        const phone = form.querySelector('[name=coop_phone]')?.value?.trim();
                        if (!phone) {
                            this.coopError = 'Please enter your phone number.';
                            return;
                        }
                        this.coopModal = true;
                        this.coopStatus = 'pending';
                        this.coopElapsed = 0;
                        axios.post('{{ route('frontend.checkout.coopbank.sendmoney') }}', {
                                order_id: orderId,
                                phone: phone,
                                _token: '{{ csrf_token() }}'
                            })
                            .then(res => {
                                if (res.data.success) {
                                    this.coopCid = res.data.cid;
                                    this.startCoopPolling();
                                } else {
                                    this.coopModal = false;
                                    this.coopError = res.data.message || 'Could not send payment prompt.';
                                }
                            })
                            .catch(e => {
                                this.coopModal = false;
                                this.coopError = e.response?.data?.message || 'Payment request failed. Please try again.';
                            });
                    },

                    doCoopBankTransfer(orderId) {
                        axios.post('{{ route('frontend.checkout.coopbank.banktransfer') }}', {
                                order_id: orderId,
                                _token: '{{ csrf_token() }}'
                            })
                            .then(res => {
                                if (res.data.success) {
                                    this.coopBankDetails = res.data.bank_details || {};
                                    this.coopModal = true;
                                    this.coopStatus = 'bank_saved';
                                } else {
                                    this.coopError = res.data.message || 'Could not save bank transfer request.';
                                }
                            })
                            .catch(e => {
                                this.coopError = e.response?.data?.message || 'An error occurred. Please try again.';
                            });
                    },

                    startCoopPolling() {
                        this.coopTickTimer = setInterval(() => { this.coopElapsed++; }, 1000);
                        setTimeout(() => this.checkCoopStatus(), 5000);
                        this.coopPollInt = setInterval(() => {
                            if (this.coopElapsed >= 90) {
                                clearInterval(this.coopPollInt);
                                clearInterval(this.coopTickTimer);
                                this.notifyCoopTimeout();
                                return;
                            }
                            this.checkCoopStatus();
                        }, 5000);
                    },

                    checkCoopStatus() {
                        axios.get('{{ route('frontend.checkout.coopbank.status') }}', { params: { cid: this.coopCid } })
                            .then(res => {
                                if (res.data.status === 'successful') {
                                    clearInterval(this.coopPollInt);
                                    clearInterval(this.coopTickTimer);
                                    this.coopStatus = 'successful';
                                    setTimeout(() => {
                                        window.location.href = '{{ route('frontend.checkout.payment') }}?order=' + this.coopOrderCode;
                                    }, 2000);
                                } else if (res.data.status === 'failed') {
                                    clearInterval(this.coopPollInt);
                                    clearInterval(this.coopTickTimer);
                                    this.coopReason = res.data.reason || 'Payment was not completed.';
                                    this.coopStatus = 'failed';
                                }
                            })
                            .catch(() => {});
                    },

                    notifyCoopTimeout() {
                        axios.post('{{ route('frontend.checkout.coopbank.timeout') }}', {
                            cid: this.coopCid,
                            _token: '{{ csrf_token() }}'
                        }).finally(() => {
                            this.coopReason = 'No payment confirmation received within 90 seconds.';
                            this.coopStatus = 'failed';
                        });
                    }
                    --}}
                }">

                    {{-- Order Summary --}}
                    <div class="bg-white border border-gray-200 rounded-[8px] p-6 mb-6">
                        <h2 class="font-bold text-gray-900 text-lg mb-4">
                            <i class="fas fa-receipt text-primary mr-2"></i> Order Summary
                        </h2>
                        <div class="space-y-1">
                            @foreach ($items as $item)
                                <div class="flex items-center gap-4 py-3 border-b border-gray-100 last:border-0">
                                    <div class="w-12 h-12 bg-gray-100 rounded-[8px] overflow-hidden flex-shrink-0">
                                        <img src="{{ asset($item->product->thumbnail ? (str_starts_with($item->product->thumbnail, 'uploads/') ? $item->product->thumbnail : 'uploads/products/images/' . $item->product->thumbnail) : 'images/placeholder.png') }}"
                                            alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 text-sm">{{ $item->product->name }}</p>
                                        @if ($item->variant)
                                            <p class="text-xs text-gray-400">{{ $item->variant->variant_code }}</p>
                                        @endif
                                        <p class="text-xs text-gray-400">
                                            <i class="fas fa-store mr-1"></i>{{ $item->product->vendor?->store_id ?? 'Trinity Mabati Factory' }}
                                            &nbsp;·&nbsp; Qty: {{ $item->quantity }}
                                        </p>
                                    </div>
                                    <p class="font-bold text-primary text-sm whitespace-nowrap">
                                        KSh {{ number_format($item->price_at_time * $item->quantity) }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                        <div class="border-t border-gray-100 pt-4 mt-2 space-y-2 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Subtotal</span>
                                <span class="font-semibold">KSh {{ number_format($subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Shipping</span>
                                <span class="font-semibold">KSh {{ number_format($shipping) }}</span>
                            </div>
                            <div class="flex justify-between text-gray-900 font-bold text-base pt-1 border-t border-gray-100">
                                <span>Total</span>
                                <span class="text-primary">KSh {{ number_format($total) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Methods --}}
                    <div class="bg-white border border-gray-200 rounded-[8px] p-6 mb-6">
                        <h2 class="font-bold text-gray-900 text-lg mb-4">
                            <i class="fas fa-credit-card text-primary mr-2"></i> Choose Payment Method
                        </h2>

                        <div x-show="mpesaError" x-cloak class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r-lg" x-text="mpesaError"></div>
                        <div x-show="coopError" x-cloak class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-sm rounded-r-lg" x-text="coopError"></div>

                        <div class="grid grid-cols-1 sm:grid-cols-{{ min($paymentMethods->count(), 4) }} gap-3 mb-6">
                            @foreach ($paymentMethods as $method)
                                @php $methodImg = $method->thumbnail ? 'images/' . basename($method->thumbnail) : null; @endphp
                                <button type="button" @click="method = {{ $method->id }}"
                                    :class="method === {{ $method->id }} ?
                                        'border-primary bg-primary/5 text-primary' :
                                        'border-gray-200 text-gray-500 hover:border-gray-300'"
                                    class="border-2 rounded-[8px] p-3 text-center transition">
                                    @if ($methodImg)
                                        <img src="{{ asset($methodImg) }}" alt="{{ $method->name }}"
                                            class="h-8 mx-auto mb-1 object-contain">
                                    @else
                                        <i class="fas fa-credit-card text-lg mb-1"></i>
                                    @endif
                                    <p class="font-bold text-sm">{{ $method->name }}</p>
                                    @if ($method->description)
                                        <p class="text-xs mt-0.5 opacity-70">{{ Str::limit($method->description, 40) }}</p>
                                    @endif
                                </button>
                            @endforeach
                        </div>

                        {{-- Method Forms (only for methods that were actually shown) --}}
                        @foreach ($paymentMethods as $method)
                            <div x-show="method === {{ $method->id }}" x-cloak>
                                <form action="{{ route('frontend.checkout.payment.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="payment_method_id" value="{{ $method->id }}">

                                    @if ($method->slug === 'mpesa')
                                        <div class="mb-4">
                                            <label for="phone_{{ $method->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                                {{ $method->user_input_label ?? 'M-Pesa Phone Number' }} <span class="text-red-500">*</span>
                                            </label>
                                            <input type="tel" id="phone_{{ $method->id }}" name="phone" required
                                                class="w-full border border-gray-200 rounded-[8px] px-3 py-2.5 text-sm focus:outline-none focus:border-primary"
                                                placeholder="07XXXXXXXX">
                                            <p class="text-xs text-gray-400 mt-1">{{ $method->user_input_description ?? 'An STK push will be sent to this number.' }}</p>
                                        </div>
                                    @elseif ($method->slug === 'cash_on_delivery')
                                        <div class="bg-amber-50 border border-amber-200 rounded-[8px] p-4 mb-4 text-sm text-amber-800">
                                            <i class="fas fa-info-circle mr-1"></i> {{ $method->description ?? 'Your order will be dispatched and payment collected upon delivery.' }}
                                            <span class="font-bold" x-text="' KSh ' + adjustedTotal.toLocaleString('en-US', {maximumFractionDigits: 0})"></span>
                                        </div>
                                    @elseif ($method->slug === 'coopbank')
                                        <div class="grid grid-cols-3 gap-2 mb-5">
                                            <button type="button" @click="coopSub = 'send_money'; coopError = ''"
                                                :class="coopSub === 'send_money' ? 'border-green-500 bg-green-50 text-green-700' : 'border-gray-200 text-gray-500 hover:border-gray-300'"
                                                class="border-2 rounded-[8px] py-3 px-2 text-center transition">
                                                <i class="fas fa-mobile-alt text-xl mb-1 block"></i>
                                                <span class="text-xs font-bold leading-tight block">Send<br>Money</span>
                                            </button>
                                            <button type="button" @click="coopSub = 'bank_transfer'; coopError = ''"
                                                :class="coopSub === 'bank_transfer' ? 'border-green-500 bg-green-50 text-green-700' : 'border-gray-200 text-gray-500 hover:border-gray-300'"
                                                class="border-2 rounded-[8px] py-3 px-2 text-center transition">
                                                <i class="fas fa-university text-xl mb-1 block"></i>
                                                <span class="text-xs font-bold leading-tight block">Bank<br>Transfer</span>
                                            </button>
                                            <button type="button"
                                                @click="coopSub = 'card'; coopError = 'Card payment via Chapa Pay is not yet enabled. Please use Send Money or Bank Transfer.'"
                                                :class="coopSub === 'card' ? 'border-gray-300 bg-gray-50 text-gray-400' : 'border-gray-100 text-gray-300'"
                                                class="border-2 rounded-[8px] py-3 px-2 text-center transition relative">
                                                <i class="fas fa-credit-card text-xl mb-1 block"></i>
                                                <span class="text-xs font-bold leading-tight block">Card</span>
                                                <span class="absolute -top-1.5 -right-1.5 text-[9px] bg-amber-400 text-white font-bold px-1.5 py-0.5 rounded-[12px]">Soon</span>
                                            </button>
                                        </div>
                                        <div x-show="coopSub === 'send_money'" x-cloak class="mb-4 space-y-3">
                                            <div class="p-3 bg-green-50 border border-green-100 rounded-[8px] text-xs text-green-800">
                                                <i class="fas fa-info-circle mr-1"></i> You will receive a payment prompt on your phone. Enter your PIN to authorise the payment.
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-red-500">*</span></label>
                                                <input type="tel" name="coop_phone" class="w-full border border-gray-200 rounded-[8px] px-3 py-2.5 text-sm focus:outline-none focus:border-primary" placeholder="07XXXXXXXX">
                                                <p class="text-xs text-gray-400 mt-1">Enter the phone number you want to receive the payment prompt on.</p>
                                            </div>
                                        </div>
                                        <div x-show="coopSub === 'bank_transfer'" x-cloak class="mb-4">
                                            <div class="p-3 bg-blue-50 border border-blue-100 rounded-[8px] text-xs text-blue-800 mb-3">
                                                <i class="fas fa-info-circle mr-1"></i> Transfer the exact amount from your banking app using the details below. Your order will be confirmed after payment is verified (usually within 2 hours).
                                            </div>
                                            <div class="bg-white border border-gray-200 rounded-[8px] divide-y divide-gray-100 text-sm">
                                                <div class="flex justify-between px-4 py-2.5"><span class="text-gray-500">Bank</span><span class="font-semibold text-gray-900">Co-operative Bank of Kenya</span></div>
                                                <div class="flex justify-between px-4 py-2.5"><span class="text-gray-500">Account Name</span><span class="font-semibold text-gray-900">HAROMI ENERGY LIMITED</span></div>
                                                <div class="flex justify-between px-4 py-2.5"><span class="text-gray-500">Account No.</span><span class="font-bold text-primary font-mono">01102751338001</span></div>
                                                <div class="flex justify-between px-4 py-2.5"><span class="text-gray-500">Bank Code</span><span class="font-semibold text-gray-900">011</span></div>
                                                <div class="flex justify-between px-4 py-2.5"><span class="text-gray-500">Reference</span><span class="text-xs text-gray-500">Use your order number as reference</span></div>
                                            </div>
                                        </div>
                                    @else
                                        @if ($method->description)
                                            <p class="text-sm text-gray-600 mb-4">{{ $method->description }}</p>
                                        @endif
                                        @if ($method->user_input_label)
                                            <div class="mb-4">
                                                <label for="input_{{ $method->id }}" class="block text-sm font-medium text-gray-700 mb-1">
                                                    {{ $method->user_input_label }}
                                                    @if ($method->slug === 'paystack') <span class="text-red-500">*</span> @endif
                                                </label>
                                                <input type="text" id="input_{{ $method->id }}" name="payment_input"
                                                    class="w-full border border-gray-200 rounded-[8px] px-3 py-2.5 text-sm focus:outline-none focus:border-primary"
                                                    placeholder="{{ $method->user_input_description ?? 'Enter required details' }}"
                                                    {{ $method->slug === 'paystack' ? 'required' : '' }}>
                                            </div>
                                        @endif
                                    @endif

                                    @if ($method->slug === 'mpesa')
                                        <button type="button" @click="initiateMpesa($el.closest('form'))"
                                            class="w-full px-6 py-3 rounded-[12px] font-bold bg-green-600 hover:bg-green-700 text-white transition">
                                            <i class="fas fa-mobile-alt mr-2"></i> Pay with {{ $method->name }}
                                        </button>
                                    @elseif ($method->slug === 'coopbank')
                                        <button type="button" @click="initiateCoopBank($el.closest('form'))"
                                            :disabled="!coopSub || coopSub === 'card'"
                                            :class="(!coopSub || coopSub === 'card') ? 'opacity-40 cursor-not-allowed' : 'hover:bg-green-800 cursor-pointer'"
                                            class="w-full px-6 py-3 rounded-[12px] font-bold bg-green-700 text-white transition flex items-center justify-center gap-2">
                                            <i class="fas" :class="{
                                                'fa-mobile-alt': coopSub === 'send_money',
                                                'fa-university': coopSub === 'bank_transfer',
                                                'fa-credit-card': coopSub === 'card',
                                                'fa-lock': !coopSub
                                            }"></i>
                                            <span x-text="coopSub === 'send_money' ? 'Send Money' : (coopSub === 'bank_transfer' ? 'Confirm Bank Transfer Order' : 'Select a payment option above')"></span>
                                        </button>
                                    @else
                                        <button type="submit"
                                            class="w-full px-6 py-3 rounded-[12px] font-bold transition
                                                @if ($method->slug === 'cash_on_delivery') bg-gray-800 hover:bg-gray-900
                                                @else bg-purple-600 hover:bg-purple-700 @endif text-white">
                                            <i class="fas @if ($method->slug === 'cash_on_delivery') fa-hand-holding-usd @else fa-bolt @endif mr-2"></i>
                                            Pay with {{ $method->name }}
                                        </button>
                                    @endif
                                </form>
                            </div>
                        @endforeach

                        {{-- M-Pesa Modal --}}
                        <div x-show="mpesaModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display:none">
                            <div class="bg-white rounded-[12px] shadow-xl w-full max-w-sm text-center overflow-hidden">
                                <div x-show="mpesaStatus === 'pending'" class="p-8">
                                    <div class="flex justify-center mb-5"><svg class="animate-spin h-14 w-14 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg></div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Waiting for M-Pesa...</h3>
                                    <p class="text-sm text-gray-500 mb-1">Enter your <strong>M-Pesa PIN</strong> on your phone to complete the payment.</p>
                                    <p class="text-xs text-gray-400 mt-3" x-text="'Checking… ' + mpesaElapsed + 's'"></p>
                                    <div class="mt-4 bg-green-50 border border-green-200 rounded-[8px] px-4 py-2 text-xs text-green-700"><i class="fas fa-shield-alt mr-1"></i> Do not close this window until confirmed.</div>
                                </div>
                                <div x-show="mpesaStatus === 'successful'" class="p-8">
                                    <div class="w-16 h-16 bg-green-100 rounded-[12px] flex items-center justify-center mx-auto mb-4"><i class="fas fa-check-circle text-3xl text-green-600"></i></div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Payment Successful!</h3>
                                    <p class="text-sm text-gray-500">Your M-Pesa payment has been confirmed. Redirecting…</p>
                                    <div class="mt-4 w-full bg-gray-100 rounded-[12px] h-1.5 overflow-hidden"><div class="bg-green-500 h-1.5 rounded-[12px] animate-pulse w-full"></div></div>
                                </div>
                                <div x-show="mpesaStatus === 'failed'" class="p-8">
                                    <div class="w-16 h-16 bg-red-100 rounded-[12px] flex items-center justify-center mx-auto mb-4"><i class="fas fa-times-circle text-3xl text-red-500"></i></div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Payment Failed</h3>
                                    <p class="text-sm text-red-600 font-medium mb-3" x-text="mpesaReason"></p>
                                    <p class="text-xs text-gray-400 mb-5">Your order has been recorded.</p>
                                    <a href="{{ route('client.orders.index') }}" class="inline-block px-5 py-2.5 bg-primary text-white font-bold rounded-[12px] hover:opacity-90 transition text-sm"><i class="fas fa-box mr-1"></i> View My Orders</a>
                                </div>
                            </div>
                        </div>

                        {{-- Co-op Bank Modal --}}
                        <div x-show="coopModal" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4" style="display:none">
                            <div class="bg-white rounded-[12px] shadow-xl w-full max-w-sm overflow-hidden">
                                <div x-show="coopStatus === 'pending'" class="p-8 text-center">
                                    <div class="flex justify-center mb-5"><svg class="animate-spin h-14 w-14 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg></div>
                                    <img src="{{ asset('images/coopbank-logo.png') }}" alt="Co-op Bank" class="h-7 mx-auto mb-3 object-contain" onerror="this.style.display='none'">
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Waiting for payment confirmation...</h3>
                                    <p class="text-sm text-gray-500 mb-1">Check your phone and enter your PIN to authorise the payment.</p>
                                    <p class="text-xs text-gray-400 mt-3" x-text="'Checking... ' + coopElapsed + 's'"></p>
                                    <div class="mt-4 bg-green-50 border border-green-200 rounded-[8px] px-4 py-2 text-xs text-green-700"><i class="fas fa-shield-alt mr-1"></i> Secured by Co-operative Bank of Kenya. Do not close this window.</div>
                                </div>
                                <div x-show="coopStatus === 'successful'" class="p-8 text-center">
                                    <div class="w-16 h-16 bg-green-100 rounded-[12px] flex items-center justify-center mx-auto mb-4"><i class="fas fa-check-circle text-3xl text-green-600"></i></div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Payment Confirmed!</h3>
                                    <p class="text-sm text-gray-500">Your Co-op Bank payment was received. Redirecting...</p>
                                    <div class="mt-4 w-full bg-gray-100 rounded-[12px] h-1.5 overflow-hidden"><div class="bg-green-500 h-1.5 rounded-[12px] animate-pulse w-full"></div></div>
                                </div>
                                <div x-show="coopStatus === 'failed'" class="p-8 text-center">
                                    <div class="w-16 h-16 bg-red-100 rounded-[12px] flex items-center justify-center mx-auto mb-4"><i class="fas fa-times-circle text-3xl text-red-500"></i></div>
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Payment Failed</h3>
                                    <p class="text-sm text-red-600 font-medium mb-3" x-text="coopReason"></p>
                                    <p class="text-xs text-gray-400 mb-5">Your order has been recorded. Retry payment from your orders page.</p>
                                    <a href="{{ route('client.orders.index') }}" class="inline-block px-5 py-2.5 bg-primary text-white font-bold rounded-[12px] hover:opacity-90 transition text-sm"><i class="fas fa-box mr-1"></i> View My Orders</a>
                                </div>
                                <div x-show="coopStatus === 'bank_saved'" class="p-6">
                                    <div class="text-center mb-4">
                                        <div class="w-14 h-14 bg-blue-100 rounded-[12px] flex items-center justify-center mx-auto mb-3"><i class="fas fa-university text-2xl text-blue-600"></i></div>
                                        <h3 class="text-lg font-bold text-gray-900">Order Saved!</h3>
                                        <p class="text-sm text-gray-500 mt-1">Transfer the exact amount using the details below and include your order number as reference.</p>
                                    </div>
                                    <div class="bg-gray-50 border border-gray-200 rounded-[8px] divide-y divide-gray-100 text-sm mb-4">
                                        <div class="flex justify-between px-4 py-2.5"><span class="text-gray-500">Bank</span><span class="font-semibold text-gray-900" x-text="coopBankDetails.bank_name || 'Co-operative Bank of Kenya'"></span></div>
                                        <div class="flex justify-between px-4 py-2.5"><span class="text-gray-500">Account Name</span><span class="font-semibold text-gray-900" x-text="coopBankDetails.account_name || 'HAROMI ENERGY LIMITED'"></span></div>
                                        <div class="flex justify-between px-4 py-2.5"><span class="text-gray-500">Account No.</span><span class="font-bold text-primary font-mono" x-text="coopBankDetails.account_number || '01102751338001'"></span></div>
                                        <div class="flex justify-between px-4 py-2.5"><span class="text-gray-500">Reference</span><span class="font-semibold text-green-700" x-text="coopOrderCode"></span></div>
                                    </div>
                                    <p class="text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-[8px] px-3 py-2 mb-4"><i class="fas fa-clock mr-1"></i> Your order will be confirmed within 2 hours once payment is verified.</p>
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('client.orders.index') }}" class="block text-center px-4 py-2.5 bg-primary text-white font-bold rounded-[12px] hover:opacity-90 transition text-sm"><i class="fas fa-box mr-1"></i> View My Orders</a>
                                        <a href="{{ route('frontend.products') }}" class="block text-center px-4 py-2 border border-gray-200 text-gray-600 font-semibold rounded-[12px] hover:border-gray-300 transition text-sm">Continue Shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="text-center">
                    <a href="{{ route('frontend.checkout') }}" class="text-sm text-gray-400 hover:text-primary transition">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Shipping Details
                    </a>
                </div>

            @endif

        </div>
    </section>

@endsection