@extends('manage.layouts.app')

@section('title', 'Message Customer - ' . $customer->first_name . ' ' . $customer->last_name . ' - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.customers.index') }}" class="hover:text-primary">Customers</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.ecommerce.customers.show', $customer->id) }}" class="hover:text-primary">
                    {{ $customer->first_name }} {{ $customer->last_name }}
                </a></li>
                <li>/</li>
                <li class="text-black font-semibold">Send Message</li>
            </ol>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('manage.ecommerce.customers.show', $customer->id) }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-black">Send Message</h1>
                <p class="text-sm text-muted">To: {{ $customer->first_name }} {{ $customer->last_name }} - {{ $customer->email }}</p>
            </div>
        </div>
    </div>

    {{-- ---------------
    -- Session Alerts
    -- --------------- --}}
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

    <div class="grid gap-6 lg:grid-cols-3">

        {{-- ---------------
        -- Compose Form
        -- --------------- --}}
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('manage.ecommerce.customers.send-message', $customer->id) }}"
                  class="bg-background border border-border rounded-[12px] p-6 shadow-sm space-y-5">
                @csrf

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-muted uppercase tracking-wide">Subject</label>
                    <input type="text" name="subject" value="{{ old('subject') }}" required
                        placeholder="e.g. Order Update, Account Notice..."
                        class="rounded-[12px] border border-border bg-white px-4 py-2.5 text-sm text-black outline-none focus:border-primary @error('subject') border-red-400 @enderror" />
                    @error('subject')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-muted uppercase tracking-wide">Message</label>
                    <textarea name="message" rows="7" required
                        placeholder="Write your message here..."
                        class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none focus:border-primary resize-none @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ---------------
                -- Form Actions
                -- --------------- --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('manage.ecommerce.customers.show', $customer->id) }}"
                        class="inline-flex items-center gap-2 rounded-[12px] border border-border bg-background px-5 py-2.5 text-sm font-medium text-muted transition hover:bg-slate-100">
                        Cancel
                    </a>
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-[12px] bg-primary px-5 py-2.5 text-sm font-medium text-white transition hover:bg-primary-dark">
                        <i class="fa-solid fa-paper-plane"></i>
                        Send Message
                    </button>
                </div>

            </form>
        </div>

        {{-- ---------------
        -- Message History Sidebar
        -- --------------- --}}
        <div class="bg-background border border-border rounded-[12px] p-5 shadow-sm">
            <h2 class="text-sm font-semibold text-black mb-4">Previous Messages</h2>

            @if ($messages->isEmpty())
                <p class="text-sm text-muted text-center py-6">No previous messages.</p>
            @else
                <div class="space-y-3">
                    @foreach ($messages as $msg)
                        <div class="rounded-[12px] bg-slate-50 px-4 py-3 border border-border">
                            <div class="flex items-start justify-between gap-2 mb-1">
                                <p class="text-xs font-semibold text-black line-clamp-1">{{ $msg->subject }}</p>
                                <span class="text-xs text-muted whitespace-nowrap">{{ $msg->created_at?->format('d M') ?? '-' }}</span>
                            </div>
                            <p class="text-xs text-muted line-clamp-2">{{ $msg->message }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

@endsection
