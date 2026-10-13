{{-- -------------------------------------------------- --}}
{{-- Client Inbox – Single message (read)              --}}
{{-- -------------------------------------------------- --}}
@extends('client.layouts.app')

@section('title', $message->subject)
@section('page-title', 'Message')

@section('breadcrumbs')
<div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
    <a href="{{ route('client.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <a href="{{ route('client.inbox.index') }}" class="hover:text-primary-600">Inbox</a>
    <span>/</span>
    <span class="text-gray-800 truncate">{{ $message->subject }}</span>
</div>
@endsection

@section('content')
<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-[8px] shadow-md overflow-hidden">

        {{-- Header --}}
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="flex items-start justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $message->subject }}</h3>
                    <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                        <span>
                            <i class="fas fa-user mr-1"></i>
                            From:
                            {{ $message->sender ? $message->sender->first_name . ' ' . $message->sender->last_name : 'System' }}
                        </span>
                        <span>
                            <i class="far fa-calendar-alt mr-1"></i>
                            {{ $message->created_at->format('M d, Y H:i') }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('client.inbox.index') }}"
                   class="text-sm text-gray-500 hover:text-gray-700 transition">
                    <i class="fas fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>

        {{-- Message body --}}
        <div class="p-6 prose prose-sm max-w-none">
            {!! nl2br(e($message->message)) !!}
        </div>

    </div>
</div>
@endsection
