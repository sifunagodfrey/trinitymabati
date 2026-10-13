<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Frontend\Blog;
use App\Models\Manage\Blogs\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    // ---------------
    // Blog listing page
    // ---------------
    public function index(Request $request)
    {
        $query = Blog::published()
            ->with(['author', 'category'])
            ->orderByDesc('published_at');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        $posts      = $query->paginate(9)->withQueryString();
        $categories = BlogCategory::whereHas('posts', fn ($q) => $q->where('is_published', true))
            ->orderBy('name')
            ->get();

        // ---------------
        // Featured post (first published with thumbnail)
        // ---------------
        $featured = Blog::published()
            ->whereNotNull('thumbnail')
            ->with(['author', 'category'])
            ->orderByDesc('published_at')
            ->first();

        return view('frontend.blog.index', compact('posts', 'categories', 'featured'));
    }

    // ---------------
    // Single post page
    // ---------------
    public function show(string $slug)
    {
        $post = Blog::published()
            ->with(['author', 'category', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        // ---------------
        // Increment view count
        // ---------------
        $post->increment('views');

        // ---------------
        // Related posts - same category, excluding current
        // ---------------
        $related = Blog::published()
            ->with(['author', 'category'])
            ->where('id', '!=', $post->id)
            ->when($post->category_id, fn ($q) => $q->where('category_id', $post->category_id))
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('frontend.blog.show', compact('post', 'related'));
    }
}
