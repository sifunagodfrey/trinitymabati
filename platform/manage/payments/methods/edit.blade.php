@extends('manage.layouts.app')
@section('title', 'Configure Payment Option')
@section('content')
<div class="mx-auto max-w-3xl space-y-5"><div class="flex items-center justify-between gap-3"><h1 class="text-2xl font-semibold">Configure {{ $method->name }}</h1><a href="{{ route('manage.payments.methods.index') }}" class="text-sm text-primary">Back to options</a></div>
@if($errors->any())<div role="alert" class="rounded-lg bg-red-50 p-4 text-sm text-red-700"><ul class="list-disc pl-5">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('manage.payments.methods.update', $method->id) }}" class="space-y-5 rounded-lg border bg-white p-5">@csrf @method('PUT')
<div><label for="method-name" class="mb-2 block text-sm font-semibold">Payment option name *</label><input id="method-name" name="name" value="{{ old('name', $method->name) }}" required maxlength="100" class="w-full rounded-lg border px-3 py-2.5"></div>
<div><label for="method-description" class="mb-2 block text-sm font-semibold">Short description</label><textarea id="method-description" name="description" rows="2" maxlength="2000" class="w-full rounded-lg border px-3 py-2.5">{{ old('description', $method->description) }}</textarea></div>
<div class="grid gap-4 sm:grid-cols-2">@foreach(['bank_name' => 'Bank name (optional)', 'paybill' => 'M-Pesa Paybill', 'account_number' => 'Account / reference number', 'account_name' => 'Account name'] as $key => $label)<div><label for="config-{{ $key }}" class="mb-2 block text-sm font-semibold">{{ $label }}</label><input id="config-{{ $key }}" name="{{ $key }}" type="text" maxlength="{{ $key === 'paybill' ? 10 : ($key === 'account_number' ? 100 : 160) }}" value="{{ old($key, $method->config[$key] ?? '') }}" class="w-full rounded-lg border px-3 py-2.5"></div>@endforeach</div>
<div><label for="method-instructions" class="mb-2 block text-sm font-semibold">Additional payment instructions</label><textarea id="method-instructions" name="instructions" rows="4" maxlength="2000" class="w-full rounded-lg border px-3 py-2.5">{{ old('instructions', $method->config['instructions'] ?? '') }}</textarea></div>
<label class="flex items-center gap-2 text-sm"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $method->is_active))> Enabled in checkout</label><label class="flex items-center gap-2 text-sm"><input type="hidden" name="is_default" value="0"><input type="checkbox" name="is_default" value="1" @checked(old('is_default', $method->is_default))> Use as default (also enables this option)</label>
<button type="submit" class="rounded-lg bg-primary px-6 py-3 font-semibold text-white">Save payment option</button>
</form></div>
@endsection
