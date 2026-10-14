<?php

namespace App\Http\Controllers\Manage\Content;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ClientStoriesController extends Controller
{
    private function table(string $kind): string
    {
        abort_unless(in_array($kind, ['testimonials', 'projects'], true), 404);
        return $kind === 'testimonials' ? 'su_client_testimonials' : 'su_client_projects';
    }

    private function upload($file, string $kind): string
    {
        $directory = public_path('uploads/client-' . $kind);
        File::ensureDirectoryExists($directory);
        $name = Str::uuid() . '.' . $file->extension();
        $file->move($directory, $name);
        return 'uploads/client-' . $kind . '/' . $name;
    }

    private function deletePhoto(?string $path): void
    {
        if ($path && Str::startsWith($path, 'uploads/client-')) {
            File::delete(public_path($path));
        }
    }

    public function index(string $kind)
    {
        $table = $this->table($kind);
        $items = DB::table($table)->orderBy('sort_order')->latest()->paginate(20);
        return view('manage.client-stories.index', compact('items', 'kind'));
    }

    public function create(string $kind)
    {
        $this->table($kind);
        return view('manage.client-stories.form', ['kind' => $kind, 'item' => null]);
    }

    public function edit(string $kind, int $id)
    {
        $item = DB::table($this->table($kind))->find($id);
        abort_unless($item, 404);
        return view('manage.client-stories.form', compact('kind', 'item'));
    }

    private function validated(Request $request, string $kind, ?int $id = null): array
    {
        $shared = [
            'is_published' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ];
        if ($kind === 'testimonials') {
            return $request->validate(array_merge($shared, [
                'client_name' => ['required', 'string', 'max:160'],
                'location' => ['nullable', 'string', 'max:160'],
                'role' => ['nullable', 'string', 'max:160'],
                'testimonial' => ['required', 'string', 'max:5000'],
                'rating' => ['required', 'integer', 'between:1,5'],
                'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            ]));
        }
        return $request->validate(array_merge($shared, [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'alpha_dash', 'max:255', Rule::unique('su_client_projects', 'slug')->ignore($id)],
            'location' => ['nullable', 'string', 'max:160'],
            'roofing_profile' => ['nullable', 'string', 'max:160'],
            'completion_date' => ['nullable', 'date'],
            'description' => ['nullable', 'string', 'max:20000'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'gallery' => ['nullable', 'array', 'max:12'],
            'gallery.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'remove_gallery' => ['nullable', 'array'],
            'remove_gallery.*' => ['string'],
        ]));
    }

    public function store(Request $request, string $kind)
    {
        return $this->save($request, $kind);
    }

    public function update(Request $request, string $kind, int $id)
    {
        return $this->save($request, $kind, $id);
    }

    private function save(Request $request, string $kind, ?int $id = null)
    {
        $table = $this->table($kind);
        $item = $id ? DB::table($table)->find($id) : null;
        abort_if($id && !$item, 404);
        $data = $this->validated($request, $kind, $id);
        foreach (['is_published', 'is_featured'] as $flag) {
            $data[$flag] = $request->boolean($flag);
        }
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        unset($data['photo'], $data['cover_image'], $data['gallery'], $data['remove_gallery']);
        if ($kind === 'testimonials') {
            if ($request->hasFile('photo')) {
                if ($item) $this->deletePhoto($item->photo);
                $data['photo'] = $this->upload($request->file('photo'), $kind);
            }
        } else {
            $data['slug'] = $data['slug'] ?: Str::slug($data['title']);
            if (DB::table($table)->where('slug', $data['slug'])->when($id, fn($q) => $q->where('id', '!=', $id))->exists()) {
                return back()->withErrors(['slug' => 'This project URL is already used. Enter a unique slug.'])->withInput();
            }
            if ($request->hasFile('cover_image')) {
                if ($item) $this->deletePhoto($item->cover_image);
                $data['cover_image'] = $this->upload($request->file('cover_image'), $kind);
            }
            $existing = $item ? (json_decode($item->gallery ?: '[]', true) ?: []) : [];
            $remove = array_intersect($existing, $request->input('remove_gallery', []));
            foreach ($remove as $path) $this->deletePhoto($path);
            $gallery = array_values(array_diff($existing, $remove));
            foreach ($request->file('gallery', []) as $file) $gallery[] = $this->upload($file, $kind);
            $data['gallery'] = json_encode($gallery);
        }
        $data['updated_at'] = now();
        if ($item) {
            DB::table($table)->where('id', $id)->update($data);
        } else {
            $data['created_at'] = now();
            DB::table($table)->insert($data);
        }
        return redirect()->route('manage.content.client-stories.index', $kind)->with('success', 'Content saved successfully.');
    }

    public function destroy(string $kind, int $id)
    {
        $table = $this->table($kind);
        $item = DB::table($table)->find($id);
        abort_unless($item, 404);
        if ($kind === 'testimonials') {
            $this->deletePhoto($item->photo);
        } else {
            $this->deletePhoto($item->cover_image);
            foreach (json_decode($item->gallery ?: '[]', true) ?: [] as $path) $this->deletePhoto($path);
        }
        DB::table($table)->where('id', $id)->delete();
        return back()->with('success', 'Content deleted.');
    }
}
