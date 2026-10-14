@extends('frontend.layouts.app')

@section('title', 'Blog - Trinity Mabati Factory')
@section('meta_description', 'Read the latest articles, guides, and wellness tips and updates from the Trinity Mabati Factory team.')
@section('og_title', 'Trinity Mabati Factory Blog')
@section('og_description', 'Read the latest articles, guides, and wellness tips and updates from the Trinity Mabati Factory team.')

@section('content')

    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="bg-gray-50 border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5 text-xs text-gray-500 flex items-center gap-2">
            <a href="{{ route('frontend.home') }}" class="hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right text-gray-300 text-[10px]"></i>
            <span class="text-gray-800 font-medium">Blog</span>
            @if (request('category'))
                <i class="fas fa-chevron-right text-gray-300 text-[10px]"></i>
                <span class="text-gray-800 font-medium">
                    {{ $categories->firstWhere('slug', request('category'))?->name ?? request('category') }}
                </span>
            @endif
        </div>
    </div>

    {{-- ---------------
    -- Featured Post Hero (only on first page with no filters)
    -- --------------- --}}
    @if ($featured && ! request()->hasAny(['search', 'category']) && $posts->currentPage() === 1)
        <div class="relative w-full h-80 md:h-[420px] overflow-hidden">
            <img src="{{ asset($featured->thumbnail) }}"
                 alt="{{ $featured->title }}"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-black/30 to-transparent"></div>
            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10 max-w-7xl mx-auto">
                @if ($featured->category)
                    <span class="inline-block bg-primary text-white text-xs font-semibold px-3 py-1 rounded-[12px] mb-3">
                        {{ $featured->category->name }}
                    </span>
                @endif
                <h2 class="text-2xl md:text-4xl font-bold text-white leading-snug mb-3 max-w-2xl">
                    {{ $featured->title }}
                </h2>
                <div class="flex items-center gap-4 text-white/80 text-xs mb-4">
                    <span>
                        <i class="fas fa-user-circle mr-1"></i>
                        {{ optional($featured->author)->first_name }} {{ optional($featured->author)->last_name }}
                    </span>
                    <span>
                        <i class="fas fa-calendar mr-1"></i>
                        {{ $featured->published_at?->format('d M Y') }}
                    </span>
                </div>
                <a href="{{ route('frontend.blog.show', $featured->slug) }}"
                   class="inline-flex items-center gap-2 bg-white text-primary font-semibold text-sm px-5 py-2.5 rounded-[12px] hover:bg-primary hover:text-white transition">
                    Read Article <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    @else
        {{-- ---------------
        -- Page Header (when featured hero not shown)
        -- --------------- --}}
        <div class="bg-primary/5 border-b border-border py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Trinity Mabati Factory Blog</h1>
                <p class="text-gray-500 text-sm max-w-xl mx-auto">
                    News, guides, and wellness tips and updates from the Trinity Mabati Factory team.
                </p>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- ---------------
        -- Search + Category Filter Bar
        -- --------------- --}}
        <div class="flex flex-col md:flex-row items-start md:items-center gap-4 mb-8">

            {{-- Search --}}
            <form method="GET" action="{{ route('frontend.blog') }}"
                  class="flex-1 flex items-center bg-white border border-border rounded-[12px] overflow-hidden shadow-sm">
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <i class="fas fa-search text-gray-400 pl-4 pr-2 text-sm flex-shrink-0"></i>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search articles..."
                    class="flex-1 px-2 py-2.5 text-sm text-gray-800 outline-none bg-transparent border-0">
                @if (request('search'))
                    <a href="{{ route('frontend.blog', request()->except(['search', 'page'])) }}"
                       class="pr-3 text-gray-400 hover:text-red-400 transition text-xs">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
                <button type="submit"
                    class="bg-primary text-white text-xs font-semibold px-5 py-2.5 rounded-[12px] hover:opacity-90 transition">
                    Search
                </button>
            </form>

            {{-- Category tabs (scrollable on mobile) --}}
            @if ($categories->isNotEmpty())
                <div class="flex items-center gap-2 overflow-x-auto pb-1 flex-shrink-0 max-w-full">
                    <a href="{{ route('frontend.blog', request()->except(['category', 'page'])) }}"
                       class="whitespace-nowrap text-xs font-semibold px-4 py-2 rounded-[12px] transition
                           {{ ! request('category') ? 'bg-primary text-white' : 'bg-gray-100 text-gray-600 hover:bg-primary/10 hover:text-primary' }}">
                        All
                    </a>
                    @foreach ($categories as $cat)
                        <a href="{{ route('frontend.blog', array_merge(request()->except(['category', 'page']), ['category' => $cat->slug])) }}"
                           class="whitespace-nowrap text-xs font-semibold px-4 py-2 rounded-[12px] transition
                               {{ request('category') === $cat->slug ? 'bg-primary text-white' : 'bg-gray-100 text-gray-600 hover:bg-primary/10 hover:text-primary' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>
            @endif

        </div>

        {{-- ---------------
        -- Post Cards Grid
        -- --------------- --}}
        @if ($posts->isEmpty())
            <div class="py-20 text-center">
                <i class="fas fa-newspaper text-5xl text-gray-200 mb-4"></i>
                <p class="text-gray-500 text-sm mb-4">No articles found.</p>
                @if (request()->hasAny(['search', 'category']))
                    <a href="{{ route('frontend.blog') }}"
                       class="text-primary text-sm font-semibold hover:underline">
                        Clear filters
                    </a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                @foreach ($posts as $post)
                    <a href="{{ route('frontend.blog.show', $post->slug) }}"
                       class="group flex flex-col bg-white border border-border rounded-[12px] overflow-hidden shadow-sm hover:shadow-md transition-shadow">

                        {{-- ---------------
                        -- Post thumbnail
                        -- --------------- --}}
                        <div class="relative h-48 overflow-hidden bg-gray-100">
                            @if ($post->thumbnail)
                                <img src="{{ asset($post->thumbnail) }}"
                                     alt="{{ $post->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                    <i class="fas fa-newspaper text-4xl text-gray-200"></i>
                                </div>
                            @endif

                            @if ($post->category)
                                <span class="absolute top-3 left-3 bg-primary text-white text-[10px] font-bold px-2.5 py-1 rounded-[12px] uppercase tracking-wide">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                        </div>

                        {{-- ---------------
                        -- Post body
                        -- --------------- --}}
                        <div class="flex flex-col flex-1 p-5">
                            <h3 class="font-bold text-gray-900 text-base leading-snug mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                                {{ $post->title }}
                            </h3>

                            @if ($post->excerpt)
                                <p class="text-gray-500 text-sm leading-relaxed line-clamp-3 mb-4">
                                    {{ $post->excerpt }}
                                </p>
                            @endif

                            <div class="flex items-center justify-between mt-auto pt-3 border-t border-border">
                                <div class="flex items-center gap-2 text-xs text-gray-500">
                                    <i class="fas fa-user-circle text-gray-300"></i>
                                    <span>
                                        {{ optional($post->author)->first_name }}
                                        {{ optional($post->author)->last_name }}
                                    </span>
                                </div>
                                <span class="text-xs text-gray-400">
                                    {{ $post->published_at?->format('d M Y') }}
                                </span>
                            </div>
                        </div>

                    </a>
                @endforeach
            </div>

            {{-- ---------------
            -- Pagination
            -- --------------- --}}
            @if ($posts->hasPages())
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm text-gray-500">
                        Showing {{ $posts->firstItem() }}–{{ $posts->lastItem() }} of {{ $posts->total() }} articles
                    </p>
                    {{ $posts->links() }}
                </div>
            @endif
        @endif

    </div>

@endsection
