<?php

namespace App\Http\Controllers\Manage\System;

use App\Http\Controllers\Controller;
use App\Models\Manage\System\Permission;
use App\Models\Users\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionsController extends Controller
{
    // ---------------
    // Index - show role selector (excluding customer accounts)
    // ---------------
    public function index(Request $request)
    {
        // Exclude customer roles
        $excludedRoles = ['customer'];

        $roles = UserRole::whereNotIn('name', $excludedRoles)
            ->orderBy('name')
            ->get();

        $permissions = Permission::orderBy('name')->get();

        $selectedRoleId = $request->integer('role_id') ?: null;
        $selectedRole = null;
        $selectedPermissions = collect();

        if ($selectedRoleId) {
            $selectedRole = UserRole::whereNotIn('name', $excludedRoles)
                ->where('id', $selectedRoleId)
                ->first();

            if ($selectedRole) {
                $selectedPermissions = $selectedRole->permissions->pluck('id');
            } else {
                // If the selected role is excluded or not found, reset selection
                $selectedRoleId = null;
            }
        }

        return view('manage.permissions.index', compact(
            'roles',
            'permissions',
            'selectedRoleId',
            'selectedRole',
            'selectedPermissions'
        ));
    }

    // ---------------
    // Update - sync permissions for a role and notify affected users
    // Returns JSON for AJAX submission
    // ---------------
    public function update(Request $request)
    {
        $roleId = $request->integer('role_id');

        if (!$roleId) {
            return response()->json(['status' => 'error', 'message' => 'Invalid role ID.']);
        }

        // Exclude the same roles from update as well
        $excludedRoles = ['customer'];
        $role = UserRole::whereNotIn('name', $excludedRoles)
            ->where('id', $roleId)
            ->first();

        if (!$role) {
            return response()->json(['status' => 'error', 'message' => 'Role not found or cannot be modified.']);
        }

        // Super Admin (id=1) permissions are locked
        if ($roleId === 1) {
            return response()->json(['status' => 'error', 'message' => 'Super Admin permissions cannot be modified.']);
        }

        // Sync permissions - validate IDs before syncing
        $rawIds = $request->input('permissions', []);
        $validIds = Permission::whereIn('id', array_filter($rawIds, 'is_numeric'))
            ->pluck('id')
            ->toArray();

        $role->permissions()->sync($validIds);

        // Notify all users assigned to this role via system messages
        $senderId  = auth()->id();
        $subject   = 'Role Permissions Updated';
        $msgBody   = "The permissions for the role '{$role->name}' have been updated. Please review the changes.";
        $relatedUrl = route('manage.permissions.index', ['role_id' => $roleId]);

        $userIds = \Illuminate\Support\Facades\DB::table('su_user_roles')->where('role_id', $roleId)->pluck('user_id');

        if ($userIds->isNotEmpty()) {
            $now  = now();
            $rows = $userIds->map(fn ($uid) => [
                'sender_id'    => $senderId,
                'recipient_id' => $uid,
                'subject'      => $subject,
                'message'      => $msgBody,
                'related_url'  => $relatedUrl,
                'is_read'      => 0,
                'is_user_read' => 0,
                'created_at'   => $now,
            ])->toArray();

            DB::table('su_system_messages')->insert($rows);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Permissions updated successfully and notifications sent.',
        ]);
    }
}