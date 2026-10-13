{{-- -------------------
     Manage Media Library
     Displays all images from database + public/images + public/uploads
-- -------------------}}

@extends('manage.layouts.app')

@section('title', 'Media Library')

@section('content')
<div>

    {{-- Breadcrumb --}}
    <nav class="text-sm text-muted mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center gap-2">
            <li><a href="{{ route('manage.dashboard.index') }}" class="hover:text-primary">Dashboard</a></li>
            <li>/</li>
            <li class="text-black font-semibold">Media Library</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-black">Media Library</h1>
            <p class="text-sm text-muted">All images from database, /images, and /uploads folders.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('manage.media.refresh') }}"
               class="inline-flex items-center gap-2 rounded-[12px] bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200 transition">
                <i class="fa-solid fa-arrows-rotate"></i> Refresh Files
            </a>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="mb-6 rounded-[12px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 rounded-[12px] border border-red-200 bg-red-50 p-4 text-sm text-red-900">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-[12px] p-6 shadow-sm">

        {{-- Upload Form --}}
        <div class="mb-8 border-b border-gray-100 pb-6">
            <h2 class="text-base font-semibold text-black mb-3">Upload New File</h2>
            <form method="POST" action="{{ route('manage.media.upload') }}" enctype="multipart/form-data" class="flex flex-wrap items-end gap-4">
                @csrf
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-medium text-gray-700 mb-1">File *</label>
                    <input type="file" name="file" required class="w-full text-sm border border-gray-200 rounded-[8px] p-2 bg-gray-50">
                </div>
                <div class="w-40">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" class="w-full rounded-[8px] border border-gray-200 p-2 text-sm">
                        <option value="">Auto-detect</option>
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                        <option value="pdf">PDF</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="flex-1 min-w-[200px]">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Caption</label>
                    <input type="text" name="caption" class="w-full rounded-[8px] border border-gray-200 p-2 text-sm" placeholder="Optional description">
                </div>
                <button type="submit" class="bg-primary text-white px-5 py-2 rounded-[8px] text-sm font-medium hover:bg-primary-dark transition">
                    <i class="fa-solid fa-upload mr-1"></i> Upload
                </button>
            </form>
        </div>

        {{-- Search & Filter Bar --}}
        <div class="mb-6 flex flex-wrap gap-3 items-center justify-between">
            <form method="GET" class="flex flex-wrap gap-3 items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by caption or path..." class="border border-gray-200 rounded-[8px] px-4 py-2 text-sm w-full sm:w-64">
                <select name="type" class="border border-gray-200 rounded-[8px] px-4 py-2 text-sm">
                    <option value="">All Types</option>
                    <option value="image" {{ request('type')=='image' ? 'selected' : '' }}>Images</option>
                    <option value="video" {{ request('type')=='video' ? 'selected' : '' }}>Videos</option>
                    <option value="pdf" {{ request('type')=='pdf' ? 'selected' : '' }}>PDFs</option>
                    <option value="other" {{ request('type')=='other' ? 'selected' : '' }}>Other</option>
                </select>
                <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-[8px] text-sm">Filter</button>
                @if(request()->hasAny(['search', 'type']))
                    <a href="{{ route('manage.media.index') }}" class="text-sm text-primary underline">Clear</a>
                @endif
            </form>
            <p class="text-sm text-gray-500">Total: {{ $media->total() }} files</p>
        </div>

        {{-- Media Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse($media as $item)
                <div class="border border-gray-200 rounded-[12px] overflow-hidden bg-white shadow-sm group relative transition hover:shadow-md">
                    {{-- Preview Area --}}
                    <div class="aspect-square bg-gray-50 flex items-center justify-center relative overflow-hidden">
                        @if($item['type'] === 'image')
                            <img src="{{ asset($item['file_path']) }}" alt="{{ $item['caption'] ?? $item['filename'] }}" class="w-full h-full object-cover">
                        @elseif($item['type'] === 'video')
                            <video class="w-full h-full object-cover" controls muted>
                                <source src="{{ asset($item['file_path']) }}">
                            </video>
                        @elseif($item['type'] === 'pdf')
                            <div class="text-center">
                                <i class="fa-regular fa-file-pdf text-5xl text-red-400"></i>
                                <p class="text-xs mt-1 text-gray-500">PDF</p>
                            </div>
                        @else
                            <div class="text-center">
                                <i class="fa-regular fa-file text-4xl text-gray-400"></i>
                                <p class="text-xs mt-1 text-gray-500">{{ ucfirst($item['type'] ?? 'Other') }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Info Footer --}}
                    <div class="p-3">
                        <p class="text-xs text-gray-500 truncate" title="{{ $item['file_path'] }}">{{ $item['file_path'] }}</p>
                        @if($item['caption'])
                            <p class="text-sm font-medium text-gray-800 mt-1 line-clamp-2">{{ $item['caption'] }}</p>
                        @endif
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-[10px] font-mono bg-gray-100 px-2 py-0.5 rounded-[12px] text-gray-600">
                                {{ $item['source'] === 'database' ? 'DB' : 'Filesystem' }}
                            </span>
                            @if($item['source'] === 'database')
                                <form method="POST" action="{{ route('manage.media.destroy', $item['id']) }}" onsubmit="return confirm('Delete this file permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 text-xs transition">
                                        <i class="fa-regular fa-trash-can"></i> Delete
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-gray-400 italic">Read‑only</span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500">
                    <i class="fa-regular fa-image text-5xl mb-3 block text-gray-300"></i>
                    <p>No media files found.</p>
                    @if(request()->hasAny(['search', 'type']))
                        <a href="{{ route('manage.media.index') }}" class="text-sm text-primary underline mt-2 inline-block">Clear filters</a>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($media->hasPages())
            <div class="mt-8">
                {{ $media->links() }}
            </div>
        @endif

    </div>
</div>
@endsection