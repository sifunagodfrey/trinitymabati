<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Controller;
use App\Models\Manage\Media\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class MediaController extends Controller
{
    // ---------------
    // Display media library (database + filesystem)
    // ---------------
    public function index(Request $request)
    {
        // 1. Get database records
        $dbMedia = Media::orderBy('created_at', 'desc')->get()
            ->map(function ($item) {
                return [
                    'id'          => $item->id,
                    'source'      => 'database',
                    'file_path'   => $item->file_path,
                    'type'        => $item->type,
                    'caption'     => $item->caption,
                    'filename'    => basename($item->file_path),
                    'size'        => null,
                    'modified_at' => $item->updated_at?->timestamp ?? $item->created_at?->timestamp ?? time(),
                    'updated_at'  => $item->updated_at?->timestamp ?? $item->created_at?->timestamp ?? time(),
                ];
            })
            ->toBase();

        // 2. Scan filesystem for images
        $fsImages = $this->scanImagesFromPublic();

        // 3. Merge collections
        $allMedia = $dbMedia->merge($fsImages);

        // 4. Filter by type (only 'image' for filesystem, any type for DB)
        if ($request->filled('type')) {
            $allMedia = $allMedia->filter(fn($item) => $item['type'] === $request->type);
        }

        // 5. Search filter
        if ($request->filled('search')) {
            $search = strtolower($request->search);
            $allMedia = $allMedia->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['caption'] ?? $item['filename'] ?? ''), $search)
                    || str_contains(strtolower($item['file_path']), $search);
            });
        }

        // 6. Sort by last modified (descending)
        $allMedia = $allMedia->sortByDesc(fn($item) => $item['modified_at'])->values();

        // 7. Paginate
        $perPage = 24;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $currentPageItems = $allMedia->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $media = new LengthAwarePaginator(
            $currentPageItems,
            $allMedia->count(),
            $perPage,
            $currentPage,
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        return view('manage.media.index', compact('media'));
    }

    // ---------------
    // Scan public/images and public/uploads for all image files
    // ---------------
    private function scanImagesFromPublic(): \Illuminate\Support\Collection
    {
        $cacheKey = 'media_scan_results_v2';
        $ttl = 300; // 5 minutes

        return Cache::remember($cacheKey, $ttl, function () {
            $images = collect();
            $directories = [
                public_path('images'),
                public_path('uploads'),
            ];

            foreach ($directories as $baseDir) {
                if (!File::exists($baseDir)) continue;

                $files = File::allFiles($baseDir);
                foreach ($files as $file) {
                    $extension = strtolower($file->getExtension());
                    if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp', 'svg'])) {
                        continue; // skip non‑images
                    }

                    $relativePath = str_replace(public_path(), '', $file->getPathname());
                    $relativePath = ltrim($relativePath, DIRECTORY_SEPARATOR);
                    $relativePath = str_replace('\\', '/', $relativePath);

                    $images->push([
                        'id'          => null,
                        'source'      => 'filesystem',
                        'file_path'   => $relativePath,
                        'type'        => 'image',
                        'caption'     => null,
                        'filename'    => $file->getFilename(),
                        'size'        => $file->getSize(),
                        'modified_at' => $file->getMTime(),
                        'updated_at'  => $file->getMTime(),
                    ]);
                }
            }
            return $images;
        });
    }

    // ---------------
    // Upload media file (saves to public/uploads/media)
    // ---------------
    public function upload(Request $request)
    {
        $request->validate([
            'file'    => 'required|file|max:10240', // 10MB max
            'type'    => 'nullable|in:image,video,pdf,other',
            'caption' => 'nullable|string|max:255',
        ]);

        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();
        $mime = $file->getMimeType();

        // Auto‑detect type if not provided
        $type = $request->type;
        if (!$type) {
            if (str_starts_with($mime, 'image/')) $type = 'image';
            elseif (str_starts_with($mime, 'video/')) $type = 'video';
            elseif ($mime === 'application/pdf') $type = 'pdf';
            else $type = 'other';
        }

        // Unique filename
        $filename = time() . '_' . uniqid() . '.' . $extension;
        $directory = public_path('uploads/media');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        $file->move($directory, $filename);
        $relativePath = 'uploads/media/' . $filename;

        // Next position
        $maxPosition = Media::max('position') ?? 0;

        Media::create([
            'type'      => $type,
            'file_path' => $relativePath,
            'caption'   => $request->caption,
            'position'  => $maxPosition + 1,
        ]);

        // Clear filesystem cache so new file appears immediately
        Cache::forget('media_scan_results_v2');

        return redirect()->route('manage.media.index')
            ->with('success', 'File uploaded successfully.');
    }

    // ---------------
    // Delete media record and its physical file
    // ---------------
    public function destroy($id)
    {
        $media = Media::findOrFail($id);

        $fullPath = public_path($media->file_path);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }

        $media->delete();

        // Re‑scan after deletion
        Cache::forget('media_scan_results_v2');

        return redirect()->route('manage.media.index')
            ->with('success', 'Media deleted.');
    }

    // ---------------
    // Manually refresh filesystem cache
    // ---------------
    public function refresh()
    {
        Cache::forget('media_scan_results_v2');
        return redirect()->route('manage.media.index')
            ->with('success', 'File cache refreshed. New images from filesystem are now visible.');
    }
}