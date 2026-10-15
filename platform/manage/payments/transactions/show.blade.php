@extends('manage.layouts.app')
@section('title', 'Review Payment')
@section('content')
<div class="mx-auto max-w-4xl space-y-5">
    <header class="flex flex-wrap items-center justify-between gap-3"><h1 class="text-2xl font-semibold">Review Payment</h1><a href="{{ route('manage.payments.transactions.index') }}" class="text-sm text-primary">Back to transactions</a></header>
    @if(session('success'))<p role="status" class="rounded-lg bg-green-50 p-4 text-sm text-green-800">{{ session('success') }}</p>@endif
    @if($errors->any())<div role="alert" class="rounded-lg bg-red-50 p-4 text-sm text-red-700">{{ $errors->first() }}</div>@endif
    <section class="rounded-lg border border-gray-200 bg-white p-5">
        <dl class="grid gap-5 text-sm sm:grid-cols-2">
            <div><dt class="text-gray-500">Order</dt><dd class="mt-1 font-semibold">{{ $transaction->order?->order_code ?? '—' }}</dd></div>
            <div><dt class="text-gray-500">Customer</dt><dd class="mt-1">{{ trim(($transaction->user?->first_name ?? '') . ' ' . ($transaction->user?->last_name ?? '')) }}<br>{{ $transaction->user?->email }}</dd></div>
            <div><dt class="text-gray-500">Payment option</dt><dd class="mt-1">{{ $transaction->payment_details['method_name'] ?? $transaction->method?->name }}</dd></div>
            <div><dt class="text-gray-500">Amount to verify</dt><dd class="mt-1 font-semibold text-primary">KSh {{ number_format($transaction->amount, 2) }}</dd></div>
            <div><dt class="text-gray-500">Customer transaction reference</dt><dd class="mt-1 break-all font-semibold">{{ $transaction->reference ?: 'Not provided' }}</dd></div>
            <div><dt class="text-gray-500">Status</dt><dd class="mt-1 font-semibold">{{ $transaction->status === 'successful' ? 'Approved' : ($transaction->status === 'failed' ? 'Rejected / failed' : ucfirst($transaction->status)) }}</dd></div>
        </dl>
        @if($transaction->payment_details)<div class="mt-5 border-t pt-5"><h2 class="mb-4 font-semibold">Payment details at submission</h2>@include('frontend.checkout.manual-details', ['details' => $transaction->payment_details])</div>@endif
        @if($transaction->proof_path)<a href="{{ route('manage.payments.transactions.proof', $transaction->id) }}" class="mt-5 inline-block rounded-lg border border-primary px-4 py-2 text-sm font-semibold text-primary">Download payment proof</a>@endif
        @if($transaction->reviewed_at)<p class="mt-5 text-sm text-gray-500">Reviewed {{ $transaction->reviewed_at->format('d M Y H:i') }}{{ $reviewer ? ' by ' . trim($reviewer->first_name . ' ' . $reviewer->last_name) : '' }}</p><p class="mt-2 whitespace-pre-line text-sm text-gray-600">{{ $transaction->review_notes }}</p>@endif
    </section>
    @if($transaction->is_manual && $transaction->status === 'pending')
        <form method="POST" action="{{ route('manage.payments.transactions.approve', $transaction->id) }}" class="space-y-4 rounded-lg border bg-white p-5">
            @csrf
            <p class="text-sm text-gray-600">Verify the reference and full amount in your bank or M-Pesa records before approving.</p>
            <div><label for="review-notes" class="mb-2 block text-sm font-semibold">Review note / rejection reason (shown to the customer)</label><textarea id="review-notes" name="review_notes" rows="3" maxlength="2000" class="w-full rounded-lg border px-3 py-2.5">{{ old('review_notes') }}</textarea></div>
            <div class="flex flex-wrap gap-3"><button type="submit" onclick="return confirm('Confirm the full payment has been received and approve it?')" class="rounded-lg bg-primary px-5 py-3 text-sm font-semibold text-white">Approve payment</button><button type="submit" formaction="{{ route('manage.payments.transactions.reject', $transaction->id) }}" class="rounded-lg border border-red-300 px-5 py-3 text-sm font-semibold text-red-700">Reject payment</button></div>
        </form>
    @endif
    <section class="rounded-lg border bg-white p-5"><h2 class="mb-4 font-semibold">Payment history</h2><div class="space-y-4">@forelse($transaction->logs->sortByDesc('id') as $entry)<div class="border-b pb-3 text-sm"><p class="font-medium">{{ str_replace('_', ' ', ucfirst($entry->status)) }}</p><p class="mt-1 text-xs text-gray-500">{{ $entry->created_at?->format('d M Y H:i') }}</p>@if(!empty($entry->gateway_response['notes']))<p class="mt-2 text-gray-600">{{ $entry->gateway_response['notes'] }}</p>@endif</div>@empty<p class="text-sm text-gray-500">No recorded history.</p>@endforelse</div></section>
</div>
@endsection
