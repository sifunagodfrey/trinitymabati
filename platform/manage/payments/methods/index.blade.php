@extends('manage.layouts.app')

@section('title', 'Payment Methods')
@section('meta-description', 'Enable or disable available payment options in the Trinity Mabati Factory.')

@section('content')
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.payments.transactions.index') }}" class="hover:text-primary">Payments</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Payment Methods</li>
            </ol>
        </nav>

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-black">Payment Methods</h1>
                <p class="text-sm text-muted">Enable, disable, or configure payment options available on the platform.</p>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">
        <div class="overflow-hidden rounded-[12px] border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
            <table class="min-w-[720px] divide-y divide-border text-sm">
                <thead class="bg-background text-left text-xs uppercase tracking-wide text-muted">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">Method</th>
                        <th class="px-4 py-3">Description</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Configured</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border bg-white">
                    @foreach($methods as $index => $method)
                        <tr class="hover:bg-slate-50">
                            <td class="px-4 py-4 font-medium text-black">{{ $loop->iteration }}</td>
                            <td class="px-4 py-4 font-semibold text-black">
                                {{ $method->name }}
                                @if ($method->is_default)
                                    <span class="ml-1.5 inline-flex rounded-[12px] px-2 py-0.5 text-[10px] font-bold bg-primary/10 text-primary align-middle">Default</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-black max-w-md">{{ $method->description }}</td>
                            <td class="px-4 py-4">
                                @if($method->is_active)
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-800">Enabled</span>
                                @else
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-amber-100 text-amber-800">Disabled</span>
                                @endif
                            </td>
                            <td class="px-4 py-4">
                                @if(!empty($method->config))
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-emerald-100 text-emerald-800">Yes</span>
                                @else
                                    <span class="inline-flex rounded-[12px] px-3 py-1 text-xs font-semibold bg-rose-100 text-rose-800">No</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-right">
                                <a href="{{ route('manage.payments.methods.edit', $method->id) }}"
                                   class="inline-flex items-center gap-2 rounded-[8px] bg-primary px-4 py-2 text-xs font-medium text-white transition hover:bg-primary-dark">
                                    <i class="fa-solid fa-gear"></i>
                                    Configure
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
    </div>
@endsection