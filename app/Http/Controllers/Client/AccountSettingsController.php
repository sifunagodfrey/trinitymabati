<?php

/*
   Handles the client account settings page: showing the current
   profile, saving profile details (name, phone, gender, date of
   birth, profile photo), and saving a new password. Profile and
   password are two independent actions with their own validation.
*/

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Users\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountSettingsController extends Controller
{
    // ---------------
    // Show account settings (read + edit)
    // ---------------
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->profile;

        return view('client.account-settings.index', compact('user', 'profile'));
    }

    // ---------------
    // Save profile details: name, phone, gender, date of birth and
    // profile photo. Does not touch the password.
    // ---------------
    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $profile = $user->profile ?? new UserProfile(['user_id' => $user->id]);

        $validated = $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'phone'          => ['required', 'string', 'max:20', Rule::unique('su_users', 'phone')->ignore($user->id)],
            'gender'         => 'nullable|in:male,female,other',
            'date_of_birth'  => 'nullable|date|before:today',
            'profile_photo'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->update([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'phone'      => $validated['phone'],
        ]);

        $profileData = [
            'gender'        => $validated['gender'] ?? null,
            'date_of_birth' => $validated['date_of_birth'] ?? null,
        ];

        // ---------------
        // Profile photo upload
        // ---------------
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/users');

            if (! file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);

            if ($profile->profile_photo && file_exists(public_path('uploads/users/' . $profile->profile_photo))) {
                unlink(public_path('uploads/users/' . $profile->profile_photo));
            }

            $profileData['profile_photo'] = $filename;
        }

        if ($profile->exists) {
            $profile->update($profileData);
        } else {
            $profile->fill($profileData);
            $profile->save();
        }

        return redirect()->route('client.settings.account')
            ->with('success', 'Profile updated successfully.');
    }

    // ---------------
    // Save a new password. Independent of the profile form.
    // ---------------
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('client.settings.account')
            ->with('success', 'Password updated successfully.');
    }
}
