<?php

namespace App\Http\Controllers\Manage\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Blogs\StoreBlogPostRequest;
use App\Http\Requests\Manage\Blogs\UpdateBlogPostRequest;
use App\Models\Manage\Blogs\BlogCategory;
use App\Models\Manage\Blogs\BlogTag;
use App\Models\Manage\Blogs\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    // ---------------
    // List all posts
    // ---------------
    public function index(Request $request)
    {
        $query = Post::with(['author', 'category'])
            ->orderByDesc('created_at');

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published' ? 1 : 0);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $posts      = $query->paginate(20)->withQueryString();
        $categories = BlogCategory::orderBy('name')->get();

        return view('manage.blogs.posts.index', compact('posts', 'categories'));
    }

    // ---------------
    // Show create form
    // ---------------
    public function create()
    {
        $categories = BlogCategory::orderBy('name')->get();
        $tags       = BlogTag::orderBy('name')->get();

        return view('manage.blogs.posts.create', compact('categories', 'tags'));
    }

    // ---------------
    // Store new post
    // ---------------
    public function store(StoreBlogPostRequest $request)
    {
        $data = $request->validated();

        $data['author_id']    = Auth::id();
        $data['slug']         = Str::slug($data['title']) . '-' . Str::random(5);
        $data['is_published'] = $request->boolean('is_published');
        $data['published_at'] = $data['is_published'] ? now() : null;

        // ---------------
        // Handle thumbnail upload
        // ---------------
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $this->saveBlogFile($request->file('thumbnail'), 'thumbnail');
        }

        // ---------------
        // Handle banner upload
        // ---------------
        if ($request->hasFile('banner')) {
            $data['banner'] = $this->saveBlogFile($request->file('banner'), 'banner');
        }

        unset($data['tags']);

        $post = Post::create($data);

        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('manage.blogs.posts.index')
            ->with('success', 'Blog post created successfully.');
    }

    // ---------------
    // Show edit form
    // ---------------
    public function edit(string $id)
    {
        $post       = Post::with('tags')->findOrFail($id);
        $categories = BlogCategory::orderBy('name')->get();
        $tags       = BlogTag::orderBy('name')->get();
        $postTagIds = $post->tags->pluck('id')->toArray();

        return view('manage.blogs.posts.edit', compact('post', 'categories', 'tags', 'postTagIds'));
    }

    // ---------------
    // Update post
    // ---------------
    public function update(UpdateBlogPostRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        $data = $request->validated();

        $data['is_published'] = $request->boolean('is_published');

        if ($data['is_published'] && ! $post->is_published) {
            $data['published_at'] = now();
        }

        // ---------------
        // Replace thumbnail if new file uploaded
        // ---------------
        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                @unlink(public_path($post->thumbnail));
            }
            $data['thumbnail'] = $this->saveBlogFile($request->file('thumbnail'), 'thumbnail');
        }

        // ---------------
        // Replace banner if new file uploaded
        // ---------------
        if ($request->hasFile('banner')) {
            if ($post->banner) {
                @unlink(public_path($post->banner));
            }
            $data['banner'] = $this->saveBlogFile($request->file('banner'), 'banner');
        }

        unset($data['tags']);

        $post->update($data);
        $post->tags()->sync($request->tags ?? []);

        return redirect()->route('manage.blogs.posts.index')
            ->with('success', 'Blog post updated successfully.');
    }

    // ---------------
    // Delete post
    // ---------------
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);

        if ($post->thumbnail) {
            @unlink(public_path($post->thumbnail));
        }
        if ($post->banner) {
            @unlink(public_path($post->banner));
        }

        $post->tags()->detach();
        $post->delete();

        return redirect()->route('manage.blogs.posts.index')
            ->with('success', 'Blog post deleted.');
    }

    // ---------------
    // Toggle publish status
    // ---------------
    public function togglePublish(string $id)
    {
        $post               = Post::findOrFail($id);
        $post->is_published = ! $post->is_published;
        $post->published_at = $post->is_published ? now() : null;
        $post->save();

        $label = $post->is_published ? 'published' : 'unpublished';

        return redirect()->route('manage.blogs.posts.index')
            ->with('success', "Post {$label} successfully.");
    }

    // ---------------
    // Inline Editor Media Upload - used by Quill's image/video toolbar buttons
    // ---------------
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,webp,gif,mp4,webm,ogg|max:20480',
        ]);

        $file = $request->file('file');
        $path = $this->saveBlogFile($file, 'content');

        return response()->json(['url' => asset($path)]);
    }

    // ---------------
    // Save an uploaded blog file (thumbnail, banner, or inline content) to public/uploads/blog
    // ---------------
    private function saveBlogFile(\Illuminate\Http\UploadedFile $file, string $prefix = 'file'): string
    {
        $destination = public_path('uploads/blog');
        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $name     = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = sprintf('%s-%s.%s', time(), $name ?: $prefix, $file->getClientOriginalExtension());

        if (! @copy($file->getRealPath(), $destination . DIRECTORY_SEPARATOR . $filename)) {
            throw new \RuntimeException('Unable to save blog file: ' . $filename);
        }

        return 'uploads/blog/' . $filename;
    }
}
