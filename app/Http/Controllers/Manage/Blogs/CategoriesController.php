<?php

namespace App\Http\Controllers\Manage\Blogs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Blogs\StoreBlogCategoryRequest;
use App\Http\Requests\Manage\Blogs\UpdateBlogCategoryRequest;
use App\Models\Manage\Blogs\BlogCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    // ---------------
    // List all categories
    // ---------------
    public function index()
    {
        $categories = BlogCategory::withCount('posts')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('manage.blogs.categories.index', compact('categories'));
    }

    // ---------------
    // Show create form
    // ---------------
    public function create()
    {
        return view('manage.blogs.categories.create');
    }

    // ---------------
    // Store new category
    // ---------------
    public function store(StoreBlogCategoryRequest $request)
    {
        $data = $request->validated();

        $data['slug'] = $data['slug']
            ? Str::slug($data['slug'])
            : Str::slug($data['name']);

        // ---------------
        // Handle banner upload
        // ---------------
        if ($request->hasFile('banner')) {
            $data['banner'] = $request->file('banner')
                ->store('uploads/blog/categories', 'public');
        }

        BlogCategory::create($data);

        return redirect()->route('manage.blogs.categories.index')
            ->with('success', 'Category created successfully.');
    }

    // ---------------
    // Show edit form
    // ---------------
    public function edit(string $id)
    {
        $category = BlogCategory::findOrFail($id);

        return view('manage.blogs.categories.edit', compact('category'));
    }

    // ---------------
    // Update category
    // ---------------
    public function update(UpdateBlogCategoryRequest $request, string $id)
    {
        $category = BlogCategory::findOrFail($id);
        $data     = $request->validated();

        $data['slug'] = $data['slug']
            ? Str::slug($data['slug'])
            : Str::slug($data['name']);

        // ---------------
        // Replace banner if new file uploaded
        // ---------------
        if ($request->hasFile('banner')) {
            if ($category->banner) {
                Storage::disk('public')->delete($category->banner);
            }
            $data['banner'] = $request->file('banner')
                ->store('uploads/blog/categories', 'public');
        }

        $category->update($data);

        return redirect()->route('manage.blogs.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    // ---------------
    // Delete category
    // ---------------
    public function destroy(string $id)
    {
        $category = BlogCategory::findOrFail($id);

        if ($category->banner) {
            Storage::disk('public')->delete($category->banner);
        }

        $category->delete();

        return redirect()->route('manage.blogs.categories.index')
            ->with('success', 'Category deleted.');
    }
}
