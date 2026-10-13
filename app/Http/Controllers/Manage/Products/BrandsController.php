<?php

namespace App\Http\Controllers\Manage\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\Manage\Products\StoreBrandRequest;
use App\Http\Requests\Manage\Products\UpdateBrandRequest;
use App\Models\Manage\Products\Brand;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class BrandsController extends Controller
{
    // ---------------
    // List All Brands
    // ---------------
    public function index()
    {
        $brands = Brand::withCount('products')
            ->orderBy('name')
            ->paginate(20);

        return view('manage.products.brands.index', compact('brands'));
    }

    // ---------------
    // Show Create Form
    // ---------------
    public function create()
    {
        return view('manage.products.brands.create');
    }

    // ---------------
    // Helper: Save Uploaded Image
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

        $destination = public_path('uploads/brands/' . $subfolder);
        if (! is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $name = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = sprintf('%s-%s.%s', time(), $name ?: 'image', $file->getClientOriginalExtension());
        $destinationPath = $destination . DIRECTORY_SEPARATOR . $filename;

        if (! @copy($tmpPath, $destinationPath)) {
            throw new \RuntimeException(sprintf('Unable to save uploaded file from [%s] to [%s].', $tmpPath, $destinationPath));
        }

        return 'uploads/brands/' . $subfolder . '/' . $filename;
    }

    // ---------------
    // Store New Brand
    // ---------------
    public function store(StoreBrandRequest $request)
    {
        // ---------------
        // Handle Image Uploads
        // ---------------
        $logoPath        = null;
        $bannerImagePath = null;

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $logoPath = $this->saveImage($request->file('logo'), 'logos');
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
        while (Brand::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $i++;
        }

        Brand::create([
            'name'         => $request->name,
            'slug'         => $slug,
            'description'  => $request->description,
            'logo'         => $logoPath,
            'banner_image' => $bannerImagePath,
        ]);

        return redirect()->route('manage.products.brands.index')
            ->with('success', 'Brand "' . $request->name . '" created successfully.');
    }

    // ---------------
    // Show Edit Form
    // ---------------
    public function edit(string $id)
    {
        $brand = Brand::findOrFail($id);

        return view('manage.products.brands.edit', compact('brand'));
    }

    // ---------------
    // Update Brand
    // ---------------
    public function update(UpdateBrandRequest $request, string $id)
    {
        $brand = Brand::findOrFail($id);

        // ---------------
        // Regenerate Slug Only If Name Changed
        // ---------------
        $slug = $brand->slug;
        if ($request->name !== $brand->name) {
            $slug         = Str::slug($request->name);
            $originalSlug = $slug;
            $i            = 1;
            while (Brand::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $i++;
            }
        }

        // ---------------
        // Handle Image Uploads
        // ---------------
        $logoPath        = $brand->logo;
        $bannerImagePath = $brand->banner_image;

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $logoPath = $this->saveImage($request->file('logo'), 'logos');
        }
        if ($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) {
            $bannerImagePath = $this->saveImage($request->file('banner_image'), 'banners');
        }

        $brand->update([
            'name'         => $request->name,
            'slug'         => $slug,
            'description'  => $request->description,
            'logo'         => $logoPath,
            'banner_image' => $bannerImagePath,
        ]);

        return redirect()->route('manage.products.brands.index')
            ->with('success', 'Brand "' . $brand->name . '" updated successfully.');
    }

    // ---------------
    // Delete Brand
    // ---------------
    public function destroy(string $id)
    {
        $brand = Brand::withCount('products')->findOrFail($id);

        if ($brand->products_count > 0) {
            return redirect()->route('manage.products.brands.index')
                ->with('error', 'Cannot delete "' . $brand->name . '" - it has ' . $brand->products_count . ' product(s) using this brand.');
        }

        $name = $brand->name;
        $brand->delete();

        return redirect()->route('manage.products.brands.index')
            ->with('success', 'Brand "' . $name . '" deleted successfully.');
    }
}
