{{-- -------------------------------------------------- --}}
{{-- Admin: View Single System Message                  --}}
{{-- -------------------------------------------------- --}}
@extends('manage.layouts.app')

@section('title', $message->subject)
@section('page-title', 'Message Details')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-6">

    <div class="bg-white rounded-[8px] shadow-md overflow-hidden">

        {{-- Header --}}
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <div class="flex flex-wrap justify-between items-start gap-3">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $message->subject }}</h3>
                    <div class="flex items-center gap-3 mt-1 text-sm text-gray-500">
                        <span><i class="fas fa-user mr-1"></i> 
                            From: {{ $message->sender ? $message->sender->first_name . ' ' . $message->sender->last_name : 'System' }}
                        </span>
                        <span><i class="far fa-calendar-alt mr-1"></i> 
                            {{ $message->created_at->format('M d, Y H:i') }}
                        </span>
                        @if(!$message->is_read)
                            <span class="inline-flex items-center gap-1 text-blue-600">
                                <span class="w-2 h-2 bg-blue-500 rounded-[12px]"></span> Unread
                            </span>
                        @endif
                    </div>
                </div>
                <a href="{{ route('manage.messages.index') }}" 
                   class="text-sm text-gray-500 hover:text-gray-700 transition">
                    <i class="fas fa-arrow-left mr-1"></i> Back to Inbox
                </a>
            </div>
        </div>

        {{-- Message body --}}
        <div class="p-6 prose prose-sm max-w-none">
            {!! nl2br(e($message->message)) !!}
        </div>

        {{-- Optional reply note --}}
        <div class="border-t border-gray-100 bg-gray-50 px-6 py-4 text-sm text-gray-500">
            <i class="fas fa-info-circle mr-1"></i> 
            To reply, please create a new message via the "Send Message" feature (if available).
        </div>
    </div>

</div>
@endsection