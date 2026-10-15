@extends('manage.layouts.app')
@section('title', 'Manual Payment Options')
@section('content')
<div class="mx-auto max-w-6xl space-y-6"><header><h1 class="text-2xl font-semibold text-gray-900">Manual Payment Options</h1><p class="mt-2 text-sm text-gray-500">Configure the three payment options, then enable the ones customers may use.</p></header>
@foreach(['success','error'] as $flash)
    @if(session($flash))
        <p class="rounded-lg border bg-white p-4 text-sm">{{ session($flash) }}</p>
    @endif
@endforeach
<div class="grid gap-5 lg:grid-cols-3">@foreach($methods as $method)<article class="space-y-4 rounded-lg border border-gray-200 bg-white p-5"><h2 class="text-lg font-semibold text-primary">{{ $method->name }}</h2><p class="text-sm text-gray-500">{{ $method->is_active ? 'Enabled' : 'Disabled' }}{{ $method->is_default ? ' · Default' : '' }}</p><p class="text-sm text-gray-600">{{ $method->isConfigured() ? 'Payment details configured.' : 'Enter the payment details before enabling.' }}</p><div class="flex flex-wrap gap-3"><a href="{{ route('manage.payments.methods.edit', $method->id) }}" class="rounded-lg bg-primary px-4 py-2 text-sm font-semibold text-white">Configure</a><form method="POST" action="{{ route('manage.payments.methods.toggle', $method->id) }}">@csrf @method('PATCH')<button type="submit" class="rounded-lg border border-gray-300 px-4 py-2 text-sm">{{ $method->is_active ? 'Disable' : 'Enable' }}</button></form></div></article>@endforeach</div>
<a href="{{ route('manage.payments.transactions.index') }}" class="inline-block text-sm font-semibold text-primary">Review payment submissions →</a></div>
@endsection
