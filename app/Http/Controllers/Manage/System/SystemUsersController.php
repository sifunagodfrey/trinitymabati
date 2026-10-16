<?php

namespace App\Http\Controllers\Manage\System;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Users\UserRole; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Services\AdminEmailService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SystemUsersController extends Controller
{
    // ---------------
    // Index - list all system users with search and pagination
    // ---------------
    public function index(Request $request)
    {
        $search = $request->input('search', '');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('manage.system-users.index', compact('users', 'search'));
    }

    // ---------------
    // Show create form
    // ---------------
    public function create()
    {
        $roles = UserRole::orderBy('name')->get();
        return view('manage.system-users.create', compact('roles'));
    }

    // ---------------
    // Store new user
    // ---------------
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => 'required|email|unique:su_users,email',
            'phone'      => 'nullable|string|max:20',
            'role_id'    => 'required|exists:su_roles,id',
            'status'     => 'required|in:active,pending,suspended',
            'password'   => 'nullable|string|min:8|max:255',
        ]);

        // Admin-chosen password, or a random one when the field is left blank
        $password = $request->filled('password') ? $request->password : Str::random(10);
        $hashedPassword = Hash::make($password);

        // Convert checkbox to string status
        $status = $request->boolean('status') ? 'active' : 'inactive';

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => $hashedPassword,
            'status'     => $request->status,
        ]);

        $user->roles()->sync([$request->role_id]);

        try {
            (new AdminEmailService())->sendUserCreatedEmail($user, $password);
        } catch (\Throwable $e) {
            Log::warning('Failed to send user creation email: ' . $e->getMessage());
        }

        $this->logAction('Created user: ' . $user->name . ' (' . $user->email . ')');
        $this->notifyAdmin($user, $password);

        return redirect()->route('manage.system-users.index')
            ->with('success', 'User account created successfully. Password: ' . $password);
    }

    // ---------------
    // Show single user (read-only)
    // ---------------
    public function show(string $id)
    {
        $user = User::with('role')->findOrFail($id);
        return view('manage.system-users.show', compact('user'));
    }

    // ---------------
    // Show edit form
    // ---------------
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = UserRole::orderBy('name')->get();
        return view('manage.system-users.edit', compact('user', 'roles'));
    }

    // ---------------
    // Update user â€“ tracks changes and sends email with diff
    // ---------------
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => ['required', 'email', Rule::unique('su_users', 'email')->ignore($user->id)],
            'phone'      => 'nullable|string|max:20',
            'role_id'    => 'required|exists:su_roles,id',
            'status'     => 'required|in:active,pending,suspended',
            'password'   => 'nullable|string|min:8|max:255',
        ]);

        // Convert checkbox to string status
        $newStatus = $request->boolean('status') ? 'active' : 'inactive';

        // Capture old values for email diff (including status as readable string)
        $old = [
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'email'      => $user->email,
            'phone'      => $user->phone,
            'role_id'    => $user->role_id,
            'status'     => ucfirst($user->status),
        ];

        // Update user - the password is only touched when a new one was typed in
        $data = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'status'     => $request->status,
        ];

        $passwordChanged = $request->filled('password');
        if ($passwordChanged) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $user->roles()->sync([$request->role_id]);
        $user->unsetRelation('role');

        // Build changes array (only fields that actually changed)
        $changes = [];
        $new = [
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'email'      => $user->email,
            'phone'      => $user->phone,
            'role_id'    => $user->role_id,
            'status'     => ucfirst($user->status),
        ];

        $fieldLabels = [
            'first_name' => 'First Name',
            'last_name'  => 'Last Name',
            'email'      => 'Email Address',
            'phone'      => 'Phone Number',
            'role_id'    => 'Role',
            'status'     => 'Status',
        ];

        // Fetch role names for better readability
        $roles = DB::table('su_roles')->pluck('name', 'id');
        $old['role_name'] = $roles[$old['role_id']] ?? 'Unknown';
        $new['role_name'] = $roles[$new['role_id']] ?? 'Unknown';

        // Compare old vs new
        foreach ($old as $field => $oldValue) {
            if ($oldValue != $new[$field]) {
                $changes[$fieldLabels[$field] ?? $field] = [
                    'old' => $oldValue,
                    'new' => $new[$field],
                ];
            }
        }

        // Never email the password itself - just flag that it was changed
        if ($passwordChanged) {
            $changes['Password'] = ['old' => '********', 'new' => 'Changed by an administrator'];
        }

        // Send update email with changes (only if there are any changes)
        if (!empty($changes)) {
            try {
                (new AdminEmailService())->sendUserUpdatedEmail($user, $changes);
            } catch (\Throwable $e) {
                Log::warning('User update email failed: ' . $e->getMessage());
            }
        }

        $this->logAction('Updated user: ' . $user->name . ' (' . $user->email . ')' . ($passwordChanged ? ' - password changed' : ''));

        return redirect()->route('manage.system-users.index')
            ->with('success', $passwordChanged ? 'User updated and password changed.' : 'User updated successfully.');
    }

    // ---------------
    // Soft delete user (prevent deletion of super admins)
    // ---------------
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Prevent deletion of super admins or admins
        if ($user->roles()->whereIn('su_roles.id', [1, 2])->exists()) {
            return redirect()->route('manage.system-users.index')
                ->with('error', 'This user cannot be deleted.');
        }

        $user->delete();

        try {
            (new AdminEmailService())->sendUserDeletedEmail($user);
        } catch (\Throwable $e) {
            Log::warning('User deletion email failed: ' . $e->getMessage());
        }

        $this->logAction('Deleted user: ' . $user->name . ' (' . $user->email . ')');

        return redirect()->route('manage.system-users.index')
            ->with('success', 'User deleted successfully.');
    }

    // ---------------
    // Helper: log system action
    // ---------------
    private function logAction(string $description)
    {
        if (!auth()->check()) return;
        DB::table('su_system_logs')->insert([
            'user_id'     => auth()->id(),
            'ip_address'  => request()->ip(),
            'description' => $description,
            'user_agent'  => request()->userAgent(),
            'created_at'  => now(),
        ]);
    }

    // ---------------
    // Helper: notify admin via email (optional)
    // ---------------
    private function notifyAdmin($user, $plainPassword)
    {
        $adminEmail = 'admin@haromienergy.com';
        $subject = 'New User Registered on Trinity Mabati Factory';
        $message = "Hello Admin,\n\nA new user has been created:\n\n" .
                   "Name: {$user->name}\n" .
                   "Email: {$user->email}\n" .
                   "Phone: {$user->phone}\n" .
                   "Created by: " . (auth()->user()->email ?? 'System') . "\n" .
                   "IP Address: " . request()->ip() . "\n\n" .
                   "Password for the user: {$plainPassword}\n\nRegards,\nTrinity Mabati Factory System";

        @mail($adminEmail, $subject, $message, "From: no-reply@haromienergy.com");
    }
}
