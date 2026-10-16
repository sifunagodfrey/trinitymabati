<?php

namespace App\Http\Controllers\Manage\Content;

use App\Http\Controllers\Controller;
use App\Models\Core\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PartnersController extends Controller
{
    public function index()
    {
        $partners = Partner::displayOrder()->paginate(20);
        return view('manage.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('manage.partners.form', ['partner' => new Partner()]);
    }

    public function edit(int $id)
    {
        return view('manage.partners.form', ['partner' => Partner::findOrFail($id)]);
    }

    public function store(Request $request)
    {
        return $this->save($request, new Partner());
    }

    public function update(Request $request, int $id)
    {
        return $this->save($request, Partner::findOrFail($id));
    }

    private function save(Request $request, Partner $partner)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:160'],
            'image' => [$partner->image ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'is_published' => ['nullable', 'boolean'],
            'is_association' => ['nullable', 'boolean'],
        ]);
        unset($data['image']);
        $data['name'] = trim($data['name']);
        $data['is_published'] = $request->boolean('is_published');
        $data['is_association'] = $request->boolean('is_association');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $oldImage = $partner->image;
        $newImage = null;
        if ($request->hasFile('image')) {
            $directory = public_path('uploads/partners');
            File::ensureDirectoryExists($directory);
            $name = Str::uuid() . '.' . $request->file('image')->extension();
            $request->file('image')->move($directory, $name);
            $newImage = 'uploads/partners/' . $name;
            $data['image'] = $newImage;
        }
        try {
            $partner->fill($data)->save();
        } catch (\Throwable $exception) {
            $this->deleteImage($newImage);
            throw $exception;
        }
        if ($newImage && $oldImage) $this->deleteImage($oldImage);
        return redirect()->route('manage.content.partners.index')->with('success', 'Partner saved.');
    }

    public function destroy(int $id)
    {
        $partner = Partner::findOrFail($id);
        $image = $partner->image;
        $partner->delete();
        $this->deleteImage($image);
        return redirect()->route('manage.content.partners.index')->with('success', 'Partner deleted.');
    }

    private function deleteImage(?string $image): void
    {
        if ($image && str_starts_with($image, 'uploads/partners/') && basename($image) === substr($image, strlen('uploads/partners/'))) {
            File::delete(public_path($image));
        }
    }
}
