<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        // Redirect authors to their specific profile route if they're on the general profile page
        if ($user->role === 'author' && !$request->routeIs('author.profile.edit')) {
            return redirect()->route('author.profile.edit');
        }

        // Redirect admins to their specific profile route if they're on the general profile page
        if ($user->role === 'admin' && !$request->routeIs('admin.profile.edit')) {
            return redirect()->route('admin.profile.edit');
        }

        // Determine which view to use based on user role and current route
        switch ($user->role) {
            case 'admin':
                return view('profile.admin-edit', [
                    'user' => $user,
                ]);
            case 'author':
                return view('profile.author-edit', [
                    'user' => $user,
                ]);
            default:
                return view('user.profile.edit', [
                    'user' => $user,
                ]);
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        // Determine redirect route based on user role
        $route = match($request->user()->role) {
            'admin' => 'admin.profile.edit',
            'author' => 'author.profile.edit',
            default => 'profile.edit'
        };

        return Redirect::route($route)
            ->with('success', '✓ Profil mis à jour avec succès')
            ->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    /**
     * Update the user's profile photo.
     */
    public function updatePhoto(Request $request): RedirectResponse
    {
        $request->validate([
            'profile_photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = $request->user();

        // Delete old photo if exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Store new photo
        $path = $request->file('profile_photo')->store('profile-photos', 'public');

        $user->update([
            'profile_photo' => $path,
        ]);

        // Determine redirect route based on user role
        $route = match($user->role) {
            'admin' => 'admin.profile.edit',
            'author' => 'author.profile.edit',
            default => 'profile.edit'
        };

        return Redirect::route($route)
            ->with('success', '✓ Photo de profil mise à jour')
            ->with('status', 'profile-photo-updated');
    }

    /**
     * Delete the user's profile photo.
     */
    public function destroyPhoto(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }

        // Determine redirect route based on user role
        $route = match($user->role) {
            'admin' => 'admin.profile.edit',
            'author' => 'author.profile.edit',
            default => 'profile.edit'
        };

        return Redirect::route($route)
            ->with('success', '✓ Photo de profil supprimée')
            ->with('status', 'profile-photo-deleted');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        // Delete profile photo if exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}