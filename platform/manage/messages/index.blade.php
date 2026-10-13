{{-- -------------------------------------------------- --}}
{{-- Admin: System Messages (Inbox)                     --}}
{{-- -------------------------------------------------- --}}
@extends('manage.layouts.app')

@section('title', 'System Messages')
@section('page-title', 'System Messages')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- Success message --}}
    @if(session('success'))
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-[8px]">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-[8px] shadow-md overflow-hidden">

        {{-- Header with unread count and mark all read --}}
        <div class="border-b border-gray-200 bg-gray-50 px-6 py-4 flex flex-wrap justify-between items-center gap-3">
            <div>
                <h3 class="text-lg font-medium text-gray-900">System Messages</h3>
                <p class="text-sm text-gray-600 mt-1">{{ $unreadCount }} unread message(s)</p>
            </div>
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('manage.messages.mark-all-read') }}">
                    @csrf
                    <button type="submit" class="bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-[8px] text-sm hover:bg-gray-50">
                        <i class="fas fa-check-double mr-1"></i> Mark all as read
                    </button>
                </form>
            @endif
        </div>

        {{-- Search & Filter Form --}}
        <div class="px-6 py-4 border-b border-gray-200">
            <form method="GET" action="{{ route('manage.messages.index') }}" class="flex flex-wrap gap-3 items-end">
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="w-full rounded-[8px] border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm"
                           placeholder="Subject, message, sender name...">
                </div>
                <div class="w-36">
                    <label class="block text-xs font-medium text-gray-700 mb-1">From date</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full rounded-[8px] border-gray-300 shadow-sm text-sm">
                </div>
                <div class="w-36">
                    <label class="block text-xs font-medium text-gray-700 mb-1">To date</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="w-full rounded-[8px] border-gray-300 shadow-sm text-sm">
                </div>
                <div>
                    <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-[8px] text-sm hover:bg-primary-700">
                        <i class="fas fa-search mr-1"></i> Filter
                    </button>
                    @if(request('search') || request('date_from') || request('date_to'))
                        <a href="{{ route('manage.messages.index') }}" class="ml-2 text-sm text-gray-500 hover:text-gray-700">
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Bulk Action Form --}}
        <form method="POST" action="{{ route('manage.messages.bulk-action') }}" id="bulkForm">
            @csrf
            <div class="px-6 py-3 bg-gray-50 border-b border-gray-200 flex flex-wrap gap-2 items-center">
                <button type="submit" name="action" value="mark_read" class="bg-green-600 text-white px-3 py-1.5 rounded-md text-xs hover:bg-green-700">
                    <i class="fas fa-envelope-open mr-1"></i> Mark Read
                </button>
                <button type="submit" name="action" value="mark_unread" class="bg-yellow-600 text-white px-3 py-1.5 rounded-md text-xs hover:bg-yellow-700">
                    <i class="fas fa-envelope mr-1"></i> Mark Unread
                </button>
                <button type="submit" name="action" value="delete" class="bg-red-600 text-white px-3 py-1.5 rounded-md text-xs hover:bg-red-700" onclick="return confirm('Delete selected messages?')">
                    <i class="fas fa-trash-alt mr-1"></i> Delete
                </button>
                <span class="text-xs text-gray-500 ml-auto">Select messages below</span>
            </div>

            {{-- Messages list --}}
            @if($messages->count() > 0)
                <ul class="divide-y divide-gray-100">
                    @foreach($messages as $msg)
                        @php
                            $senderName = $msg->sender ? $msg->sender->first_name . ' ' . $msg->sender->last_name : 'System';
                            $isUnread = !$msg->is_read;
                        @endphp
                        <li class="hover:bg-gray-50 transition {{ $isUnread ? 'bg-blue-50' : '' }}">
                            <div class="px-6 py-4">
                                <div class="flex items-start gap-3">
                                    {{-- Checkbox --}}
                                    <div class="pt-0.5">
                                        <input type="checkbox" name="message_ids[]" value="{{ $msg->id }}" 
                                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                    </div>
                                    <div class="flex-1">
                                        <a href="{{ route('manage.messages.show', $msg->id) }}" class="block">
                                            <div class="flex flex-wrap justify-between items-start gap-2">
                                                <h4 class="text-sm font-semibold text-gray-900 {{ $isUnread ? 'font-bold' : '' }}">
                                                    {{ $msg->subject }}
                                                </h4>
                                                <span class="text-xs text-gray-400">{{ $msg->created_at->format('M d, Y H:i') }}</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                                                {{ Str::limit(strip_tags($msg->message), 150) }}
                                            </p>
                                            <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                                                <span><i class="fas fa-user mr-1"></i> From: {{ $senderName }}</span>
                                                @if($isUnread)
                                                    <span class="inline-block w-2 h-2 bg-blue-500 rounded-[12px]"></span>
                                                    <span class="text-blue-600">Unread</span>
                                                @else
                                                    <span class="text-gray-400">Read</span>
                                                @endif
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                {{-- Pagination --}}
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    {{ $messages->withQueryString()->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">No messages found.</p>
                </div>
            @endif
        </form>
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