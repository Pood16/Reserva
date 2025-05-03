<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class AdminProfileController extends Controller
{
    /**
     * Display the admin's profile.
     */
    public function show()
    {
        $user = Auth::user();
        return view('admin.profile.show', compact('user'));
    }

    /**
     * Show the form for editing the admin's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    /**
     * Update the admin's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if it exists
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }

            // Store new picture
            $profilePicturePath = $request->file('profile_picture')->store('profile-pictures', 'public');
            $user->profile_picture = $profilePicturePath;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('admin.profile.show')->with('success', 'Profile updated successfully');
    }

    /**
     * Show the form for changing password.
     */
    public function showChangePasswordForm()
    {
        return view('admin.profile.change-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::min(8)->uncompromised()],
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('admin.profile.show')->with('success', 'Password changed successfully');
    }
}
