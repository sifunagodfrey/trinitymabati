<?php

namespace App\Http\Controllers\Manage\Content;

use App\Http\Controllers\Controller;
use App\Models\Core\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TeamMembersController extends Controller
{
    public function index()
    {
        $members = TeamMember::displayOrder()->paginate(20);
        return view('manage.team.index', compact('members'));
    }

    public function create()
    {
        return view('manage.team.form', ['member' => new TeamMember()]);
    }

    public function edit(int $id)
    {
        return view('manage.team.form', ['member' => TeamMember::findOrFail($id)]);
    }

    public function store(Request $request)
    {
        return $this->save($request, new TeamMember());
    }

    public function update(Request $request, int $id)
    {
        return $this->save($request, TeamMember::findOrFail($id));
    }

    private function save(Request $request, TeamMember $member)
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:80'],
            'last_name' => ['required', 'string', 'max:80'],
            'title' => ['nullable', 'string', 'max:160'],
            'bio' => ['nullable', 'string', 'max:5000'],
            'photo' => [$member->photo ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:1000000'],
            'is_published' => ['nullable', 'boolean'],
        ]);
        unset($data['photo']);
        $data['first_name'] = trim($data['first_name']);
        $data['last_name'] = trim($data['last_name']);
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        $oldPhoto = $member->photo;
        $newPhoto = null;
        if ($request->hasFile('photo')) {
            $directory = public_path('uploads/team');
            File::ensureDirectoryExists($directory);
            $name = Str::uuid() . '.' . $request->file('photo')->extension();
            $request->file('photo')->move($directory, $name);
            $newPhoto = 'uploads/team/' . $name;
            $data['photo'] = $newPhoto;
        }
        try {
            $member->fill($data)->save();
        } catch (\Throwable $exception) {
            $this->deletePhoto($newPhoto);
            throw $exception;
        }
        if ($newPhoto && $oldPhoto) $this->deletePhoto($oldPhoto);
        return redirect()->route('manage.content.team.index')->with('success', 'Team member saved.');
    }

    public function destroy(int $id)
    {
        $member = TeamMember::findOrFail($id);
        $photo = $member->photo;
        $member->delete();
        $this->deletePhoto($photo);
        return redirect()->route('manage.content.team.index')->with('success', 'Team member deleted.');
    }

    private function deletePhoto(?string $photo): void
    {
        if ($photo && str_starts_with($photo, 'uploads/team/') && basename($photo) === substr($photo, strlen('uploads/team/'))) {
            File::delete(public_path($photo));
        }
    }
}
