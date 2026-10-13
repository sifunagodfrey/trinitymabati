@extends('frontend.layouts.app')

@section('title', $post->title . ' - Trinity Mabati Factory Blog')
@section('meta_description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))
@section('og_title', $post->title)
@section('og_description', $post->excerpt ?? Str::limit(strip_tags($post->content), 160))
@if ($post->banner || $post->thumbnail)
    @section('og_image', asset($post->banner ?? $post->thumbnail))
@endif

@section('content')

    {{-- ---------------
    -- Banner Hero
    -- --------------- --}}
    @if ($post->banner)
        <div class="relative w-full h-72 md:h-96 overflow-hidden">
            <img src="{{ asset($post->banner) }}"
                 alt="{{ $post->title }}"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
        </div>
    @endif

    {{-- ---------------
    -- Breadcrumb
    -- --------------- --}}
    <div class="bg-gray-50 border-b border-border">
        <div class="max-w-4xl mx-auto px-4 py-2.5 text-xs text-gray-500 flex items-center gap-2 flex-wrap">
            <a href="{{ route('frontend.home') }}" class="hover:text-primary transition">Home</a>
            <i class="fas fa-chevron-right text-gray-300 text-[10px]"></i>
            <a href="{{ route('frontend.blog') }}" class="hover:text-primary transition">Blog</a>
            @if ($post->category)
                <i class="fas fa-chevron-right text-gray-300 text-[10px]"></i>
                <a href="{{ route('frontend.blog', ['category' => $post->category->slug]) }}"
                   class="hover:text-primary transition">
                    {{ $post->category->name }}
                </a>
            @endif
            <i class="fas fa-chevron-right text-gray-300 text-[10px]"></i>
            <span class="text-gray-800 font-medium line-clamp-1">{{ $post->title }}</span>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 py-10">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            {{-- ---------------
            -- Main Article Column
            -- --------------- --}}
            <article class="lg:col-span-2">

                {{-- Category badge --}}
                @if ($post->category)
                    <a href="{{ route('frontend.blog', ['category' => $post->category->slug]) }}"
                       class="inline-block bg-primary/10 text-primary text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-[12px] mb-4 hover:bg-primary hover:text-white transition">
                        {{ $post->category->name }}
                    </a>
                @endif

                {{-- Title --}}
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">
                    {{ $post->title }}
                </h1>

                {{-- Meta row --}}
                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500 mb-6 pb-6 border-b border-border">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-[12px] bg-primary/10 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-user text-primary text-xs"></i>
                        </div>
                        <span class="font-medium text-gray-800">
                            {{ optional($post->author)->first_name }}
                            {{ optional($post->author)->last_name }}
                        </span>
                    </div>
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-calendar text-gray-400"></i>
                        {{ $post->published_at?->format('d M Y') }}
                    </span>
                    <span class="flex items-center gap-1.5">
                        <i class="fas fa-eye text-gray-400"></i>
                        {{ number_format($post->views ?? 0) }} views
                    </span>
                </div>

                {{-- Thumbnail (if no banner) --}}
                @if (! $post->banner && $post->thumbnail)
                    <div class="mb-6 rounded-[12px] overflow-hidden border border-border">
                        <img src="{{ asset($post->thumbnail) }}"
                             alt="{{ $post->title }}"
                             class="w-full object-cover max-h-72">
                    </div>
                @endif

                {{-- Excerpt --}}
                @if ($post->excerpt)
                    <p class="text-lg text-gray-600 leading-relaxed mb-6 italic border-l-4 border-primary pl-4">
                        {{ $post->excerpt }}
                    </p>
                @endif

                {{-- ---------------
                -- Post Content (Quill-generated HTML)
                -- --------------- --}}
                <div class="prose-blog">
                    {!! $post->content !!}
                </div>

                {{-- ---------------
                -- Tags
                -- --------------- --}}
                @if ($post->tags->isNotEmpty())
                    <div class="mt-8 pt-6 border-t border-border">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider mr-2">Tags:</span>
                        @foreach ($post->tags as $tag)
                            <a href="{{ route('frontend.blog', ['search' => $tag->name]) }}"
                               class="inline-block text-xs font-medium bg-gray-100 text-gray-600 px-3 py-1 rounded-[12px] mr-2 mb-2 hover:bg-primary hover:text-white transition">
                                # {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                {{-- ---------------
                -- Share Strip
                -- --------------- --}}
                <div class="mt-8 pt-6 border-t border-border flex items-center gap-3 flex-wrap">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Share:</span>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"
                       target="_blank" rel="noopener"
                       class="w-8 h-8 rounded-[12px] bg-gray-900 text-white flex items-center justify-center hover:opacity-80 transition">
                        <i class="fab fa-x-twitter text-xs"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                       target="_blank" rel="noopener"
                       class="w-8 h-8 rounded-[12px] bg-blue-600 text-white flex items-center justify-center hover:opacity-80 transition">
                        <i class="fab fa-facebook-f text-xs"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}"
                       target="_blank" rel="noopener"
                       class="w-8 h-8 rounded-[12px] bg-blue-700 text-white flex items-center justify-center hover:opacity-80 transition">
                        <i class="fab fa-linkedin-in text-xs"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}"
                       target="_blank" rel="noopener"
                       class="w-8 h-8 rounded-[12px] bg-green-500 text-white flex items-center justify-center hover:opacity-80 transition">
                        <i class="fab fa-whatsapp text-xs"></i>
                    </a>
                </div>

                {{-- ---------------
                -- Back link
                -- --------------- --}}
                <div class="mt-8">
                    <a href="{{ route('frontend.blog') }}"
                       class="inline-flex items-center gap-2 text-sm font-semibold text-primary hover:underline">
                        <i class="fas fa-arrow-left text-xs"></i> Back to Blog
                    </a>
                </div>

            </article>

            {{-- ---------------
            -- Sidebar
            -- --------------- --}}
            <aside class="lg:col-span-1 space-y-6">

                {{-- Related Posts --}}
                @if ($related->isNotEmpty())
                    <div class="bg-white border border-border rounded-[12px] p-5 shadow-sm">
                        <h3 class="font-bold text-gray-900 text-sm mb-4 pb-3 border-b border-border uppercase tracking-wide">
                            Related Articles
                        </h3>
                        <div class="space-y-4">
                            @foreach ($related as $rel)
                                <a href="{{ route('frontend.blog.show', $rel->slug) }}"
                                   class="flex gap-3 group">
                                    <div class="w-16 h-14 rounded-[8px] overflow-hidden bg-gray-100 flex-shrink-0 border border-border">
                                        @if ($rel->thumbnail)
                                            <img src="{{ asset($rel->thumbnail) }}"
                                                 alt="{{ $rel->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-200">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fas fa-newspaper text-gray-300 text-lg"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-semibold text-gray-800 leading-snug line-clamp-2 group-hover:text-primary transition-colors">
                                            {{ $rel->title }}
                                        </p>
                                        <p class="text-xs text-gray-400 mt-1">
                                            {{ $rel->published_at?->format('d M Y') }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Browse by Category --}}
                <div class="bg-white border border-border rounded-[12px] p-5 shadow-sm">
                    <h3 class="font-bold text-gray-900 text-sm mb-4 pb-3 border-b border-border uppercase tracking-wide">
                        Browse Categories
                    </h3>
                    @php
                        $sidebarCategories = \App\Models\Manage\Blogs\BlogCategory::whereHas(
                            'posts', fn ($q) => $q->where('is_published', true)
                        )->orderBy('name')->get();
                    @endphp
                    @if ($sidebarCategories->isNotEmpty())
                        <ul class="space-y-2">
                            @foreach ($sidebarCategories as $cat)
                                <li>
                                    <a href="{{ route('frontend.blog', ['category' => $cat->slug]) }}"
                                       class="flex items-center justify-between text-sm text-gray-600 hover:text-primary transition group">
                                        <span class="flex items-center gap-2">
                                            <i class="fas fa-folder text-gray-300 group-hover:text-primary transition text-xs"></i>
                                            {{ $cat->name }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-xs text-gray-400">No categories yet.</p>
                    @endif
                </div>

            </aside>

        </div>

    </div>

    {{-- ---------------
    -- Prose / Rich Content Styles
    -- --------------- --}}
    <style>
        /* ---------------
         * Style Quill-generated HTML
         * --------------- */
        .prose-blog { color: #374151; line-height: 1.8; font-size: 16px; }
        .prose-blog h1, .prose-blog h2, .prose-blog h3,
        .prose-blog h4, .prose-blog h5, .prose-blog h6 {
            font-weight: 700; color: #111827; margin: 1.5em 0 0.5em;
        }
        .prose-blog h1 { font-size: 2em; }
        .prose-blog h2 { font-size: 1.5em; }
        .prose-blog h3 { font-size: 1.25em; }
        .prose-blog p  { margin: 0.85em 0; }
        .prose-blog a  { color: var(--color-primary, #3b82f6); text-decoration: underline; }
        .prose-blog a:hover { opacity: .8; }
        .prose-blog ul { list-style: disc;   padding-left: 1.5rem; margin: 0.85em 0; }
        .prose-blog ol { list-style: decimal; padding-left: 1.5rem; margin: 0.85em 0; }
        .prose-blog li { margin: 0.3em 0; }
        .prose-blog blockquote {
            border-left: 4px solid var(--color-primary, #3b82f6);
            padding: 0.5rem 1rem;
            margin: 1.25em 0;
            color: #6b7280;
            background: #f9fafb;
            border-radius: 0 0.5rem 0.5rem 0;
        }
        .prose-blog pre, .prose-blog code {
            background: #f3f4f6;
            border-radius: 0.5rem;
            padding: 0.2em 0.4em;
            font-size: 0.9em;
            font-family: ui-monospace, monospace;
        }
        .prose-blog pre { padding: 1em 1.25em; overflow-x: auto; }
        .prose-blog img {
            max-width: 100%; height: auto; border-radius: 0.75rem;
            margin: 1.5em auto; display: block;
            border: 1px solid #e5e7eb;
        }
        .prose-blog iframe {
            max-width: 100%; border-radius: 0.75rem; margin: 1.5em 0;
            aspect-ratio: 16/9; width: 100%;
        }
        .prose-blog table { width: 100%; border-collapse: collapse; margin: 1em 0; font-size: 0.95em; }
        .prose-blog th, .prose-blog td { border: 1px solid #e5e7eb; padding: 0.5em 0.75em; }
        .prose-blog th { background: #f9fafb; font-weight: 600; }
    </style>

@endsection
