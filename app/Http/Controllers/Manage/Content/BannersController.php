<?php

/* -------------------
   Admin banner management - list, create, edit, reorder, toggle and
   delete the homepage hero slides stored in su_banners.
------------------- */

namespace App\Http\Controllers\Manage\Content;

use App\Http\Controllers\Controller;
use App\Models\Core\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BannersController extends Controller
{
    // ---------------
    // List all banners
    // ---------------
    public function index(): View
    {
        $banners = Banner::orderBy('position')->orderBy('id')->paginate(20)->withQueryString();

        return view('manage.content.banners.index', compact('banners'));
    }

    // ---------------
    // Show create form
    // ---------------
    public function create(): View
    {
        $nextPosition = (int) Banner::max('position') + 1;

        return view('manage.content.banners.create', compact('nextPosition'));
    }

    // ---------------
    // Store a new banner
    // ---------------
    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, imageRequired: true);

        $data['image'] = $this->saveImage($request->file('image'));

        Banner::create($data + ['created_at' => now()]);

        return redirect()->route('manage.content.banners.index')
            ->with('success', 'Banner added successfully.');
    }

    // ---------------
    // Show edit form
    // ---------------
    public function edit(string $id): View
    {
        $banner = Banner::findOrFail($id);

        return view('manage.content.banners.edit', compact('banner'));
    }

    // ---------------
    // Update an existing banner
    // ---------------
    public function update(Request $request, string $id): RedirectResponse
    {
        $banner = Banner::findOrFail($id);
        $data   = $this->validated($request, imageRequired: false);

        if ($request->hasFile('image')) {
            $data['image'] = $this->saveImage($request->file('image'));
        } else {
            unset($data['image']);
        }

        $banner->update($data);

        return redirect()->route('manage.content.banners.index')
            ->with('success', 'Banner updated successfully.');
    }

    // ---------------
    // Toggle a banner between active and hidden
    // ---------------
    public function toggle(string $id): RedirectResponse
    {
        $banner = Banner::findOrFail($id);
        $banner->update(['is_active' => ! $banner->is_active]);

        return back()->with('success', 'Banner visibility updated.');
    }

    // ---------------
    // Delete a banner
    // ---------------
    public function destroy(string $id): RedirectResponse
    {
        Banner::findOrFail($id)->delete();

        return redirect()->route('manage.content.banners.index')
            ->with('success', 'Banner deleted.');
    }

    // ---------------
    // Shared validation
    // ---------------
    private function validated(Request $request, bool $imageRequired): array
    {
        return $request->validate([
            'title'     => 'nullable|string|max:150',
            'image'     => ($imageRequired ? 'required' : 'nullable') . '|image|mimes:jpg,jpeg,png,webp|max:4096',
            'link_url'  => 'nullable|string|max:255',
            'position'  => 'required|integer|min:0',
            'is_active' => 'required|boolean',
        ]);
    }

    // ---------------
    // Save the uploaded slide image under public/uploads/banners
    // ---------------
    private function saveImage(UploadedFile $file): string
    {
        $destination = public_path('uploads/banners');
        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '-' . substr(uniqid(), -6) . '.' . strtolower($file->getClientOriginalExtension());

        $file->move($destination, $filename);

        return 'uploads/banners/' . $filename;
    }
}
