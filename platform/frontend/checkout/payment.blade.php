@extends('frontend.layouts.app')
@section('title', 'Payment | Trinity Mabati Factory')
@section('content')
@php
    $isConfirmation = $mode === 'confirmation';
    $displayTotal = $isConfirmation ? $order->total : $total;
    $canSubmit = !$isConfirmation || ($order->payment_status === 'failed' && $payment?->is_manual && !in_array($order->status, ['cancelled', 'refunded']));
@endphp
<section class="mx-auto max-w-3xl px-4 py-10 sm:px-6">
    @foreach(['success','error','info'] as $flash)
    @if(session($flash))
        <p role="status" class="mb-5 rounded-lg border border-gray-200 bg-white p-4 text-sm text-gray-700">{{ session($flash) }}</p>
    @endif
@endforeach
    @if($errors->any())<div role="alert" class="mb-5 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700"><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
    <header class="mb-6"><h1 class="text-2xl font-semibold text-primary">{{ $isConfirmation ? 'Your Order' : 'Choose Payment Method' }}</h1><p class="mt-2 text-sm text-gray-600">{{ $isConfirmation ? 'Order reference: ' . $order->order_code : 'Pay using one of the options below, then submit the payment for verification.' }}</p></header>
    <div class="mb-6 rounded-lg border border-gray-200 bg-white p-5">
        <h2 class="mb-4 font-semibold text-gray-900">Order Summary</h2>
        @foreach($isConfirmation ? $order->items : $items as $item)
            <div class="flex justify-between gap-4 border-b border-gray-100 py-3 text-sm"><span>{{ $isConfirmation ? $item->product_name : $item->product?->name }} <span class="text-gray-500">× {{ $item->quantity }}</span></span><span class="shrink-0">KSh {{ number_format(($isConfirmation ? $item->price : $item->price_at_time) * $item->quantity, 2) }}</span></div>
        @endforeach
        <div class="mt-4 flex justify-between gap-4 text-sm"><span class="text-gray-500">Shipping</span><span>KSh {{ number_format($isConfirmation ? $order->shipping_cost : $shipping, 2) }}</span></div>
        <div class="mt-3 flex justify-between gap-4 font-semibold"><span>Total</span><span class="text-primary">KSh {{ number_format($displayTotal, 2) }}</span></div>
    </div>
    @if($isConfirmation)
        <div class="mb-6 rounded-lg border border-gray-200 bg-white p-5">
            <h2 class="font-semibold text-primary">{{ $order->payment_status === 'paid' ? 'Payment approved' : ($order->payment_status === 'failed' ? 'Payment needs attention' : 'Awaiting payment verification') }}</h2>
            @if($payment)
                <p class="mt-3 text-sm text-gray-600">Payment option: {{ $payment->payment_details['method_name'] ?? $payment->method?->name }}</p>
                <p class="mt-2 text-sm text-gray-600">Your transaction reference: <strong>{{ $payment->reference ?: 'Not provided' }}</strong></p>
                @if($payment->is_manual && $payment->status === 'pending')<p class="mt-3 text-sm leading-relaxed text-gray-600">Your payment details have been submitted. Our team will verify the payment and confirm your order.</p>@endif
                @if($payment->status === 'failed' && $payment->review_notes)<p class="mt-3 text-sm text-red-700">{{ $payment->review_notes }}</p>@endif
                @if($payment->payment_details)<div class="mt-4 border-t pt-4">@include('frontend.checkout.manual-details', ['details' => $payment->payment_details])</div>@endif
            @endif
        </div>
    @endif
    @if($canSubmit)
        @if($paymentMethods->isEmpty())
            <div class="rounded-lg border border-gray-200 bg-white p-5 text-sm text-gray-600">Payment options are being configured. Please <a href="{{ route('frontend.contact') }}" class="font-semibold text-primary">contact us</a> to arrange payment.</div>
        @else
            <form method="POST" enctype="multipart/form-data" action="{{ $isConfirmation ? route('frontend.checkout.payment.resubmit', $order->order_code) : route('frontend.checkout.payment.store') }}" class="space-y-5 rounded-lg border border-gray-200 bg-white p-5" x-data="{ method: {{ (int) old('payment_method_id', $paymentMethods->first()->id) }}, submitting: false }" @submit="submitting=true">
                @csrf
                <fieldset><legend class="mb-3 font-semibold text-gray-900">{{ $isConfirmation ? 'Resubmit payment details' : 'Payment options' }}</legend><div class="grid gap-3 sm:grid-cols-3">
                    @foreach($paymentMethods as $method)
                        <label class="cursor-pointer rounded-lg border-2 p-4 text-sm transition" :class="Number(method) === {{ $method->id }} ? 'border-primary bg-primary/5' : 'border-gray-200'"><input type="radio" name="payment_method_id" value="{{ $method->id }}" x-model.number="method" required class="mr-2"><span class="font-semibold text-gray-900">{{ $method->name }}</span></label>
                    @endforeach
                </div></fieldset>
                @foreach($paymentMethods as $method)
                    <div x-show="Number(method) === {{ $method->id }}" x-cloak class="rounded-lg border border-gray-200 bg-gray-50 p-4"><h3 class="mb-4 font-semibold text-gray-900">{{ $method->name }}</h3>@include('frontend.checkout.manual-details', ['details' => $method->config ?? []])@if($method->description)<p class="mt-4 text-sm text-gray-600">{{ $method->description }}</p>@endif</div>
                @endforeach
                <div><label for="payment-reference" class="mb-2 block text-sm font-semibold text-gray-700">Payment transaction reference (optional)</label><input id="payment-reference" name="payment_reference" value="{{ old('payment_reference', $isConfirmation ? ($payment->reference ?? '') : '') }}" minlength="4" maxlength="100" autocomplete="off" class="w-full rounded-lg border border-gray-300 bg-white px-3 py-3 text-sm focus:border-primary"><p class="mt-2 text-xs text-gray-500">If available, enter the reference from your payment confirmation to help our team verify it.</p></div>
                <div><label for="payment-proof" class="mb-2 block text-sm font-semibold text-gray-700">Payment proof (optional)</label><input id="payment-proof" type="file" name="proof" accept="image/jpeg,image/png,image/webp,application/pdf" class="block w-full text-sm"><p class="mt-2 text-xs text-gray-500">Payment slip or screenshot: JPG, PNG, WebP or PDF, up to 5 MB.</p></div>
                <p class="text-sm text-gray-600">Payment is confirmed only after our team verifies receipt.</p>
                <button type="submit" :disabled="submitting" class="w-full rounded-lg bg-primary px-6 py-3 font-semibold text-white transition hover:opacity-90 disabled:opacity-50"><span x-text="submitting ? 'Submitting…' : '{{ $isConfirmation ? 'Resubmit for verification' : 'Submit payment for verification' }}'">Submit payment for verification</span></button>
            </form>
        @endif
    @endif
    <div class="mt-6 flex flex-wrap justify-center gap-4 text-sm"><a href="{{ route('frontend.categories') }}" class="font-semibold text-primary">Continue Shopping</a><a href="{{ route('frontend.contact') }}" class="text-primary">Contact Us</a></div>
</section>
@endsection
