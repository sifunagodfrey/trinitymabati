{{-- ---------------
-- Manage Contact Message View
-- --------------- --}}
@extends('manage.layouts.app')

@section('title', 'Contact Message #' . $contactMessage->id . ' - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li><a href="{{ route('manage.contact.index') }}" class="hover:text-primary">Contact Messages</a></li>
                <li>/</li>
                <li class="text-black font-semibold">#{{ $contactMessage->id }}</li>
            </ol>
        </nav>

        <div class="flex items-center gap-3">
            <a href="{{ route('manage.contact.index') }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-muted hover:text-black transition">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                Back
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-black">Message #{{ $contactMessage->id }}</h1>
                <p class="text-sm text-muted">From {{ $contactMessage->name }} &mdash; {{ $contactMessage->email }}</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ---------------
        -- Message + Reply Form
        -- --------------- --}}
        <div class="lg:col-span-2 space-y-5">

            {{-- ---------------
            -- Original Message
            -- --------------- --}}
            <div class="bg-background border border-border rounded-[12px] overflow-hidden">
                <div class="px-5 py-3 border-b border-border bg-gray-50 flex items-center justify-between">
                    <p class="text-sm font-semibold text-black">Message</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-[12px] text-xs font-semibold
                        {{ $contactMessage->is_read ? 'bg-gray-100 text-gray-600' : 'bg-blue-100 text-blue-700' }}">
                        {{ $contactMessage->is_read ? 'Read' : 'Unread' }}
                    </span>
                </div>
                <div class="p-5">
                    <p class="text-sm text-black whitespace-pre-line leading-relaxed">{{ $contactMessage->message }}</p>
                </div>
            </div>

            {{-- ---------------
            -- Reply Form
            -- --------------- --}}
            <div class="bg-background border border-border rounded-[12px] p-5">
                <p class="text-sm font-semibold text-black mb-4">Send Reply</p>
                <form method="POST" action="{{ route('manage.contact.reply', $contactMessage->id) }}">
                    @csrf
                    <div class="mb-4">
                        <textarea name="reply_message" rows="5"
                            class="w-full px-4 py-3 text-sm border border-border rounded-[12px] bg-white outline-none focus:border-primary resize-none transition @error('reply_message') border-red-400 @enderror"
                            placeholder="Type your reply to {{ $contactMessage->name }}..."
                            required>{{ old('reply_message') }}</textarea>
                        @error('reply_message')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1.5 text-xs text-muted">
                            Reply will be sent to <strong>{{ $contactMessage->email }}</strong>.
                            @php
                                $hasAccount = \Illuminate\Support\Facades\DB::table('su_users')
                                    ->where('email', $contactMessage->email)
                                    ->where('status', 'active')
                                    ->exists();
                            @endphp
                            @if ($hasAccount)
                                <span class="text-emerald-600 font-medium">This sender has an active account - reply will also appear in their inbox.</span>
                            @endif
                        </p>
                    </div>
                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('manage.contact.index') }}"
                            class="px-5 py-2.5 text-sm font-semibold text-black bg-gray-100 rounded-[12px] hover:bg-gray-200 transition">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 text-sm font-semibold text-white bg-primary rounded-[12px] hover:opacity-90 transition">
                            <i class="fas fa-reply mr-1.5"></i>
                            Send Reply
                        </button>
                    </div>
                </form>
            </div>

        </div>

        {{-- ---------------
        -- Sender Details Sidebar
        -- --------------- --}}
        <div class="space-y-5">

            {{-- Sender Info --}}
            <div class="bg-background border border-border rounded-[12px] p-5">
                <p class="text-xs font-semibold text-muted uppercase tracking-wide mb-3">Sender</p>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-[12px] bg-primary/10 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-bold text-primary">
                            {{ strtoupper(substr($contactMessage->name, 0, 1)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-black">{{ $contactMessage->name }}</p>
                        <p class="text-xs text-muted">{{ $contactMessage->email }}</p>
                    </div>
                </div>
                @if ($hasAccount)
                    <div class="flex items-center gap-1.5 text-xs text-emerald-600 font-medium">
                        <i class="fas fa-circle-check"></i>
                        Active account on platform
                    </div>
                @else
                    <div class="flex items-center gap-1.5 text-xs text-muted">
                        <i class="fas fa-user-slash"></i>
                        No account on platform
                    </div>
                @endif
            </div>

            {{-- Message Meta --}}
            <div class="bg-background border border-border rounded-[12px] p-5 text-sm space-y-3">
                <p class="text-xs font-semibold text-muted uppercase tracking-wide mb-3">Details</p>
                <div class="flex justify-between">
                    <span class="text-muted">Received</span>
                    <span class="text-black font-medium">
                        {{ \Carbon\Carbon::parse($contactMessage->received_at)->format('d M Y') }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-muted">Time</span>
                    <span class="text-black font-medium">
                        {{ \Carbon\Carbon::parse($contactMessage->received_at)->format('H:i') }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-muted">Status</span>
                    <span class="{{ $contactMessage->is_read ? 'text-gray-500' : 'text-blue-600 font-semibold' }}">
                        {{ $contactMessage->is_read ? 'Read' : 'Unread' }}
                    </span>
                </div>
            </div>

        </div>

    </div>

@endsection
