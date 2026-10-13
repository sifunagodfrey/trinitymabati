<?php

namespace App\Http\Controllers\Manage\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Products\StoreCategoryRequest;
use App\Http\Requests\Manage\Products\UpdateCategoryRequest;
use App\Models\Manage\Products\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    // ---------------
    // List All Categories
    // ---------------
    public function index()
    {
        $categories = Category::with(['parent', 'children'])
            ->withCount('products')
            ->orderBy('name')
            ->paginate(20);

        return view('manage.products.categories.index', compact('categories'));
    }

    // ---------------
    // Show Create Form
    // ---------------
    public function create()
    {
        $parents = Category::whereNull('parent_id')->orderBy('name')->get();

        return view('manage.products.categories.create', compact('parents'));
    }

    // ---------------
    // Helper: Save Uploaded Image (returns only filename)
    // ---------------
    private function saveImage(UploadedFile $file, string $subfolder): string
    {
        if (! $file->isValid()) {
            throw new \RuntimeException('Uploaded file is not valid. Error: ' . $file->getError());
        }

        $tmpPath = $file->getRealPath() ?: $file->getPathname();
        if (! $tmpPath || ! file_exists($tmpPath)) {
            throw new \RuntimeException('Uploaded temporary file is missing: ' . $tmpPath);
        }

        // Destination: public/categories/{icons|featured|banners}
        $destination = public_path('categories/' . $subfolder);
        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = sprintf('%s-%s.%s', time(), $name ?: 'image', $file->getClientOriginalExtension());
        $destinationPath = $destination . DIRECTORY_SEPARATOR . $filename;

        if (! @copy($tmpPath, $destinationPath)) {
            throw new \RuntimeException(sprintf('Unable to save uploaded file from [%s] to [%s].', $tmpPath, $destinationPath));
        }

        // Return only the filename (not the full path)
        return $filename;
    }

    // ---------------
    // Helper: Make Category The Only Default
    // ---------------
    private function makeDefault(Category $category): void
    {
        DB::transaction(function () use ($category) {
            Category::where('id', '!=', $category->id)
                ->where('is_default', true)
                ->update(['is_default' => false]);

            $category->update(['is_default' => true]);
        });
    }

    // ---------------
    // Store New Category
    // ---------------
    public function store(StoreCategoryRequest $request)
    {
        // ---------------
        // Handle Image Uploads
        // ---------------
        $iconPath          = null;
        $featuredImagePath = null;
        $bannerImagePath   = null;

        if ($request->hasFile('icon') && $request->file('icon')->isValid()) {
            $iconPath = $this->saveImage($request->file('icon'), 'icons');
        }
        if ($request->hasFile('featured_image') && $request->file('featured_image')->isValid()) {
            $featuredImagePath = $this->saveImage($request->file('featured_image'), 'featured');
        }
        if ($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) {
            $bannerImagePath = $this->saveImage($request->file('banner_image'), 'banners');
        }

        // ---------------
        // Generate Unique Slug
        // ---------------
        $slug         = Str::slug($request->name);
        $originalSlug = $slug;
        $i            = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        $category = Category::create([
            'name'            => $request->name,
            'slug'            => $slug,
            'parent_id'       => $request->parent_id,
            'description'     => $request->description,
            'icon'            => $iconPath,
            'featured_image'  => $featuredImagePath,
            'banner_image'    => $bannerImagePath,
        ]);

        // ---------------
        // Set As Default (only one allowed)
        // ---------------
        if ($request->boolean('is_default')) {
            $this->makeDefault($category);
        }

        return redirect()->route('manage.products.categories.index')
            ->with('success', 'Category "' . $request->name . '" created successfully.');
    }

    // ---------------
    // Show Edit Form
    // ---------------
    public function edit(string $id)
    {
        $category = Category::findOrFail($id);
        $parents  = Category::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->orderBy('name')
            ->get();

        return view('manage.products.categories.edit', compact('category', 'parents'));
    }

    // ---------------
    // Update Category
    // ---------------
    public function update(UpdateCategoryRequest $request, string $id)
    {
        $category = Category::findOrFail($id);

        // ---------------
        // Regenerate Slug Only If Name Changed
        // ---------------
        $slug = $category->slug;
        if ($request->name !== $category->name) {
            $slug         = Str::slug($request->name);
            $originalSlug = $slug;
            $i            = 1;
            while (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $i++;
            }
        }

        // ---------------
        // Handle Image Uploads
        // ---------------
        $iconPath          = $category->icon;
        $featuredImagePath = $category->featured_image;
        $bannerImagePath   = $category->banner_image;

        if ($request->hasFile('icon') && $request->file('icon')->isValid()) {
            $iconPath = $this->saveImage($request->file('icon'), 'icons');
        }
        if ($request->hasFile('featured_image') && $request->file('featured_image')->isValid()) {
            $featuredImagePath = $this->saveImage($request->file('featured_image'), 'featured');
        }
        if ($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) {
            $bannerImagePath = $this->saveImage($request->file('banner_image'), 'banners');
        }

        $category->update([
            'name'            => $request->name,
            'slug'            => $slug,
            'parent_id'       => $request->parent_id,
            'description'     => $request->description,
            'icon'            => $iconPath,
            'featured_image'  => $featuredImagePath,
            'banner_image'    => $bannerImagePath,
        ]);

        // ---------------
        // Set As Default (only one allowed)
        // ---------------
        if ($request->boolean('is_default')) {
            $this->makeDefault($category);
        }

        return redirect()->route('manage.products.categories.index')
            ->with('success', 'Category "' . $category->name . '" updated successfully.');
    }

    // ---------------
    // Delete Category
    // ---------------
    public function destroy(string $id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            return redirect()->route('manage.products.categories.index')
                ->with('error', 'Cannot delete "' . $category->name . '" - it has ' . $category->products_count . ' product(s) assigned to it.');
        }

        if ($category->is_default) {
            return redirect()->route('manage.products.categories.index')
                ->with('error', 'Cannot delete "' . $category->name . '" - it is the default category. Set another category as default first.');
        }
        
        $name = $category->name;
        $category->delete();

        return redirect()->route('manage.products.categories.index')
            ->with('success', 'Category "' . $name . '" deleted successfully.');
    }
}