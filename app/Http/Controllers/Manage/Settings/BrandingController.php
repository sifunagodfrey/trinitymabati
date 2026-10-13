<?php

namespace App\Http\Controllers\Manage\Settings;

use App\Http\Controllers\Controller;
use App\Models\Core\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class BrandingController extends Controller
{
    private const FILE_KEYS = ['logo_main', 'logo_white', 'logo_dark', 'site_icon', 'apple_touch_icon'];

    public function index(): View
    {
        return view('manage.settings.branding.index', [
            'values' => Setting::siteBranding(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name'         => ['required', 'string', 'max:100'],
            'primary_color'     => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'secondary_color'   => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'tertiary_color'    => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'logo_main'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'logo_white'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'logo_dark'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'site_icon'         => ['nullable', 'file', 'mimes:png,jpg,jpeg,webp,ico', 'max:1024'],
            'apple_touch_icon'  => ['nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:1024'],
        ]);

        foreach (['site_name', 'primary_color', 'secondary_color', 'tertiary_color'] as $key) {
            Setting::put($key, trim($validated[$key]));
        }

        foreach (self::FILE_KEYS as $key) {
            if ($request->hasFile($key) && $request->file($key)->isValid()) {
                $oldPath = Setting::get($key);
                $newPath = $this->storeBrandAsset($request->file($key), $key);
                Setting::put($key, $newPath);
                $this->deleteOldBrandAsset($oldPath, $newPath);
            }
        }

        return redirect()->route('manage.settings.branding.index')
            ->with('success', 'Site branding updated successfully.');
    }

    private function storeBrandAsset(UploadedFile $file, string $key): string
    {
        $directory = base_path('uploads/branding');
        File::ensureDirectoryExists($directory);
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());
        $filename = $key . '-' . now()->format('YmdHis') . '-' . bin2hex(random_bytes(3)) . '.' . $extension;
        $file->move($directory, $filename);

        return 'uploads/branding/' . $filename;
    }

    private function deleteOldBrandAsset(?string $oldPath, string $newPath): void
    {
        if (!$oldPath || $oldPath === $newPath || !str_starts_with($oldPath, 'uploads/branding/')) {
            return;
        }

        $absolutePath = base_path($oldPath);
        if (File::isFile($absolutePath)) {
            File::delete($absolutePath);
        }
    }
}
