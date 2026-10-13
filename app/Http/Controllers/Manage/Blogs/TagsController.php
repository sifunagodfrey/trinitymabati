<?php

namespace App\Http\Controllers\Manage\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Blogs\StoreBlogTagRequest;
use App\Http\Requests\Manage\Blogs\UpdateBlogTagRequest;
use App\Models\Manage\Blogs\BlogTag;
use Illuminate\Support\Str;

class TagsController extends Controller
{
    // ---------------
    // List all tags (with inline form)
    // ---------------
    public function index()
    {
        $tags    = BlogTag::withCount('posts')->orderBy('name')->get();
        $editTag = null;

        if (request()->filled('edit')) {
            $editTag = BlogTag::find(request('edit'));
        }

        return view('manage.blogs.tags.index', compact('tags', 'editTag'));
    }

    // ---------------
    // Store new tag
    // ---------------
    public function store(StoreBlogTagRequest $request)
    {
        $data         = $request->validated();
        $data['slug'] = $data['slug']
            ? Str::slug($data['slug'])
            : Str::slug($data['name']);

        BlogTag::create($data);

        return redirect()->route('manage.blogs.tags.index')
            ->with('success', 'Tag added successfully.');
    }

    // ---------------
    // Update tag
    // ---------------
    public function update(UpdateBlogTagRequest $request, string $id)
    {
        $tag          = BlogTag::findOrFail($id);
        $data         = $request->validated();
        $data['slug'] = $data['slug']
            ? Str::slug($data['slug'])
            : Str::slug($data['name']);

        $tag->update($data);

        return redirect()->route('manage.blogs.tags.index')
            ->with('success', 'Tag updated successfully.');
    }

    // ---------------
    // Delete tag
    // ---------------
    public function destroy(string $id)
    {
        $tag = BlogTag::findOrFail($id);
        $tag->posts()->detach();
        $tag->delete();

        return redirect()->route('manage.blogs.tags.index')
            ->with('success', 'Tag deleted.');
    }
}
