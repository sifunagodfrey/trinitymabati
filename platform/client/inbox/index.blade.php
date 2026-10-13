{{-- -------------------------------------------------- --}}
{{-- Client Inbox – List of received messages           --}}
{{-- -------------------------------------------------- --}}
@extends('client.layouts.app')

@section('title', 'Inbox')
@section('page-title', 'Inbox')

@section('breadcrumbs')
<div class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
    <a href="{{ route('client.dashboard') }}" class="hover:text-primary-600">Dashboard</a>
    <span>/</span>
    <span class="text-gray-800">Inbox</span>
</div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto">

    @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-[8px]">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[8px] shadow-md overflow-hidden">

        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Your Messages</h3>
            <p class="text-sm text-gray-600 mt-1">
                Messages from system, vendors, and support
            </p>
        </div>

        @if($messages->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($messages as $msg)
                    @php
                        $senderName = $msg->sender
                            ? $msg->sender->first_name . ' ' . $msg->sender->last_name
                            : 'System';
                        $isUnread = !$msg->is_read;
                    @endphp
                    <a href="{{ route('client.inbox.show', $msg->id) }}"
                       class="block px-6 py-4 hover:bg-gray-50 transition {{ $isUnread ? 'bg-blue-50' : '' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-1">
                                    <h4 class="text-sm font-semibold text-gray-900 {{ $isUnread ? 'font-bold' : '' }}">
                                        {{ $msg->subject }}
                                    </h4>
                                    @if($isUnread)
                                        <span class="inline-block w-2 h-2 bg-blue-500 rounded-[12px]"></span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 line-clamp-2">
                                    {{ Str::limit(strip_tags($msg->message), 120) }}
                                </p>
                                <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                                    <span>
                                        <i class="fas fa-user mr-1"></i>
                                        From: {{ $senderName }}
                                    </span>
                                    <span>
                                        <i class="far fa-clock mr-1"></i>
                                        {{ $msg->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                            <i class="fas fa-chevron-right text-gray-300 ml-3 mt-1"></i>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $messages->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                <p class="text-gray-500">Your inbox is empty</p>
                <p class="text-sm text-gray-400 mt-1">Messages from vendors and support will appear here</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush