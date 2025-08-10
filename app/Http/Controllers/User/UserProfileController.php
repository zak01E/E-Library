<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ReadingSession;
use App\Models\UserFavorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        
        // Get user statistics for the profile sidebar
        $userStats = [
            'books_read' => $this->getBooksReadCount($user->id),
            'favorites' => $this->getFavoritesCount($user->id),
            'member_since' => $user->created_at,
        ];

        return view('user.profile.edit', compact('user', 'userStats'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'bio' => ['nullable', 'string', 'max:1000'],
        ]);

        $user->update($validated);

        return redirect()->route('user.profile.edit')
            ->with('success', 'Profil mis à jour avec succès.');
    }

    /**
     * Update the user's reading preferences.
     */
    public function updatePreferences(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'preferred_genres' => ['nullable', 'array'],
            'preferred_genres.*' => ['string', 'max:50'],
            'reading_goal' => ['nullable', 'integer', 'min:1', 'max:50'],
            'preferred_language' => ['nullable', 'string', 'in:fr,en,es,de'],
        ]);

        // Store preferences in user profile or separate table
        $user->update([
            'preferred_genres' => $validated['preferred_genres'] ?? [],
            'reading_goal' => $validated['reading_goal'] ?? 3,
            'preferred_language' => $validated['preferred_language'] ?? 'fr',
        ]);

        return redirect()->route('user.profile.edit')
            ->with('success', 'Préférences de lecture mises à jour.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = Auth::user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('user.profile.edit')
            ->with('success', 'Mot de passe mis à jour avec succès.');
    }

    /**
     * Update notification settings.
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'email_notifications' => ['boolean'],
            'new_books_notifications' => ['boolean'],
            'recommendations_notifications' => ['boolean'],
            'newsletter_subscription' => ['boolean'],
        ]);

        // Store notification preferences
        $user->update([
            'notification_preferences' => $validated,
        ]);

        return redirect()->route('user.profile.edit')
            ->with('success', 'Préférences de notification mises à jour.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = Auth::user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Votre compte a été supprimé avec succès.');
    }

    /**
     * Get count of books read by user
     */
    private function getBooksReadCount($userId)
    {
        try {
            return ReadingSession::where('user_id', $userId)
                ->whereNotNull('ended_at')
                ->distinct('book_id')
                ->count();
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get count of favorite books
     */
    private function getFavoritesCount($userId)
    {
        try {
            return UserFavorite::where('user_id', $userId)->count();
        } catch (\Exception $e) {
            return 0;
        }
    }
}
