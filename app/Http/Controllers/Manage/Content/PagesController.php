<?php

/* -------------------
   Admin pages management - list, create, edit, toggle and delete the
   editable site pages stored in su_pages (refund policy, terms,
   privacy policy and any custom pages).
------------------- */

namespace App\Http\Controllers\Manage\Content;

use App\Http\Controllers\Controller;
use App\Models\Core\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PagesController extends Controller
{
    // ---------------
    // List all pages
    // ---------------
    public function index(): View
    {
        $pages = Page::when(request('search'), fn ($q) =>
                $q->where('title', 'like', '%' . request('search') . '%'))
            ->orderBy('title')
            ->paginate(20)
            ->withQueryString();

        return view('manage.content.pages.index', compact('pages'));
    }

    // ---------------
    // Show create form
    // ---------------
    public function create(): View
    {
        return view('manage.content.pages.create');
    }

    // ---------------
    // Store a new page
    // ---------------
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $data['slug'] = $this->uniqueSlug($request->input('slug') ?: $data['title']);

        Page::create($data + ['created_at' => now()]);

        return redirect()->route('manage.content.pages.index')
            ->with('success', 'Page "' . $data['title'] . '" created successfully.');
    }

    // ---------------
    // Show edit form
    // ---------------
    public function edit(string $id): View
    {
        $page = Page::findOrFail($id);

        return view('manage.content.pages.edit', compact('page'));
    }

    // ---------------
    // Update an existing page
    // ---------------
    public function update(Request $request, string $id): RedirectResponse
    {
        $page = Page::findOrFail($id);
        $data = $this->validated($request);

        $slugInput = $request->input('slug') ?: $data['title'];
        if (Str::slug($slugInput) !== $page->slug) {
            $data['slug'] = $this->uniqueSlug($slugInput, $page->id);
        }

        $page->update($data);

        return redirect()->route('manage.content.pages.index')
            ->with('success', 'Page "' . $page->title . '" updated successfully.');
    }

    // ---------------
    // Toggle a page between active and hidden
    // ---------------
    public function toggle(string $id): RedirectResponse
    {
        $page = Page::findOrFail($id);
        $page->update(['is_active' => ! $page->is_active]);

        return back()->with('success', 'Page visibility updated.');
    }

    // ---------------
    // Delete a page
    // ---------------
    public function destroy(string $id): RedirectResponse
    {
        Page::findOrFail($id)->delete();

        return redirect()->route('manage.content.pages.index')
            ->with('success', 'Page deleted.');
    }

    // ---------------
    // Shared validation
    // ---------------
    private function validated(Request $request): array
    {
        return $request->validate([
            'title'            => 'required|string|max:150',
            'slug'             => 'nullable|string|max:160',
            'content'          => 'nullable|string',
            'meta_title'       => 'nullable|string|max:160',
            'meta_description' => 'nullable|string|max:255',
            'is_active'        => 'required|boolean',
        ]);
    }

    // ---------------
    // Generate a unique slug
    // ---------------
    private function uniqueSlug(string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source);
        $slug = $base;
        $n    = 2;

        while (Page::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '<>', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $n;
            $n++;
        }

        return $slug;
    }
}
