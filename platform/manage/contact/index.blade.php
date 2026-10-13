{{-- ---------------
-- Manage Contact Messages Index
-- --------------- --}}
@extends('manage.layouts.app')

@section('title', 'Contact Messages - Trinity Mabati Factory Admin')

@section('content')

    {{-- ---------------
    -- Breadcrumb & Page Header
    -- --------------- --}}
    <div class="mb-6">
        <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center gap-2">
                <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
                <li>/</li>
                <li class="text-black font-semibold">Contact Messages</li>
            </ol>
        </nav>

        <div>
            <h1 class="text-2xl font-semibold text-black">Contact Messages</h1>
            <p class="text-sm text-muted">Messages submitted via the public contact form.</p>
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

    <div class="bg-background border border-border rounded-[12px] p-6 shadow-sm">

        {{-- ---------------
        -- Search & Filters
        -- --------------- --}}
        <form method="GET" action="{{ route('manage.contact.index') }}"
              class="mb-6 flex flex-wrap items-center gap-3">

            <div class="flex-1 min-w-[220px] flex items-center bg-white border border-border rounded-[12px] overflow-hidden">
                <i class="fa-solid fa-magnifying-glass text-muted pl-4 pr-2 text-sm flex-shrink-0"></i>
                <input type="search" name="search" value="{{ $search }}"
                    placeholder="Search by name, email or message..."
                    class="flex-1 px-2 py-3 text-sm text-black outline-none bg-transparent border-0" />
                @if ($search)
                    <a href="{{ route('manage.contact.index', request()->except(['search', 'page'])) }}"
                        class="pr-3 text-muted hover:text-red-400 transition text-xs">
                        <i class="fa-solid fa-xmark"></i>
                    </a>
                @endif
            </div>

            <select name="filter" onchange="this.form.submit()"
                class="rounded-[12px] border border-border bg-white px-4 py-3 text-sm text-black outline-none transition focus:border-primary">
                <option value="">All Messages</option>
                <option value="unread" {{ $filter === 'unread' ? 'selected' : '' }}>Unread</option>
                <option value="read"   {{ $filter === 'read'   ? 'selected' : '' }}>Read</option>
            </select>

            <button type="submit"
                class="px-4 py-3 bg-primary text-white text-sm font-semibold rounded-[12px] hover:opacity-90 transition">
                <i class="fas fa-search"></i>
            </button>
        </form>

        {{-- ---------------
        -- Messages Table
        -- --------------- --}}
        @if ($messages->isNotEmpty())

            <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[600px]">
                    <thead>
                        <tr class="border-b border-border text-left">
                            <th class="pb-3 pr-4 font-semibold text-muted">Name</th>
                            <th class="pb-3 pr-4 font-semibold text-muted">Email</th>
                            <th class="pb-3 pr-4 font-semibold text-muted">Message Preview</th>
                            <th class="pb-3 pr-4 font-semibold text-muted">Received</th>
                            <th class="pb-3 font-semibold text-muted">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach ($messages as $msg)
                            <tr class="hover:bg-gray-50 transition cursor-pointer {{ $msg->is_read ? '' : 'font-semibold' }}"
                                onclick="window.location='{{ route('manage.contact.show', $msg->id) }}'">

                                <td class="py-4 pr-4">
                                    <div class="flex items-center gap-2">
                                        @if (! $msg->is_read)
                                            <span class="w-2 h-2 rounded-[12px] bg-primary flex-shrink-0"></span>
                                        @else
                                            <span class="w-2 h-2 flex-shrink-0"></span>
                                        @endif
                                        <span class="text-black">{{ $msg->name }}</span>
                                    </div>
                                </td>

                                <td class="py-4 pr-4 text-muted text-xs">{{ $msg->email }}</td>

                                <td class="py-4 pr-4 text-muted">
                                    {{ Str::limit($msg->message, 60) }}
                                </td>

                                <td class="py-4 pr-4 text-muted text-xs">
                                    {{ \Carbon\Carbon::parse($msg->received_at)->format('d M Y, H:i') }}
                                </td>

                                <td class="py-4" onclick="event.stopPropagation()">
                                    <a href="{{ route('manage.contact.show', $msg->id) }}"
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-sky-100 text-sky-700 text-xs font-semibold rounded-[8px] hover:bg-sky-200 transition">
                                        <i class="fas fa-eye text-xs"></i>
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ---------------
            -- Pagination
            -- --------------- --}}
            @if ($messages->hasPages())
                <div class="mt-6">
                    {{ $messages->links() }}
                </div>
            @endif

        @else
            <div class="text-center py-16">
                <div class="w-16 h-16 rounded-[12px] bg-gray-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-2xl text-gray-300"></i>
                </div>
                <p class="text-muted text-sm">No contact messages found.</p>
            </div>
        @endif

    </div>

@endsection
