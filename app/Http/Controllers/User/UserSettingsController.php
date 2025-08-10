<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserSettingsController extends Controller
{
    /**
     * Display the user settings page.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get current user settings
        $settings = [
            'language' => $user->language ?? 'fr',
            'timezone' => $user->timezone ?? 'Europe/Paris',
            'email_notifications' => $user->email_notifications ?? true,
            'reading_goal' => $user->reading_goal ?? 5,
            'default_view' => $user->default_view ?? 'grid',
            'preferred_genres' => $user->preferred_genres ?? [],
            'auto_bookmark' => $user->auto_bookmark ?? true,
            'reading_timer' => $user->reading_timer ?? false,
            'focus_mode' => $user->focus_mode ?? false,
            'new_books_notifications' => $user->new_books_notifications ?? true,
            'reading_reminders' => $user->reading_reminders ?? true,
            'goal_notifications' => $user->goal_notifications ?? true,
            'newsletter_subscription' => $user->newsletter_subscription ?? false,
            'notification_frequency' => $user->notification_frequency ?? 'weekly',
            'public_profile' => $user->public_profile ?? true,
            'public_stats' => $user->public_stats ?? false,
            'analytics_collection' => $user->analytics_collection ?? true,
            'theme' => $user->theme ?? 'light',
            'font_size' => $user->font_size ?? 'medium',
            'density' => $user->density ?? 'comfortable',
        ];

        return view('user.settings.index', compact('settings'));
    }

    /**
     * Update general settings.
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'language' => ['required', 'string', 'in:fr,en,es,de'],
            'timezone' => ['required', 'string'],
            'email_notifications' => ['boolean'],
        ]);

        $user = Auth::user();
        $user->update($validated);

        return redirect()->route('user.settings.index')
            ->with('success', 'Paramètres généraux mis à jour avec succès.');
    }

    /**
     * Update reading preferences.
     */
    public function updateReading(Request $request)
    {
        $validated = $request->validate([
            'reading_goal' => ['required', 'integer', 'min:1', 'max:50'],
            'default_view' => ['required', 'string', 'in:grid,list,compact'],
            'preferred_genres' => ['nullable', 'array'],
            'preferred_genres.*' => ['string', 'max:50'],
            'auto_bookmark' => ['boolean'],
            'reading_timer' => ['boolean'],
            'focus_mode' => ['boolean'],
        ]);

        $user = Auth::user();
        $user->update($validated);

        return redirect()->route('user.settings.index')
            ->with('success', 'Préférences de lecture mises à jour avec succès.');
    }

    /**
     * Update notification settings.
     */
    public function updateNotifications(Request $request)
    {
        $validated = $request->validate([
            'new_books_notifications' => ['boolean'],
            'reading_reminders' => ['boolean'],
            'goal_notifications' => ['boolean'],
            'newsletter_subscription' => ['boolean'],
            'notification_frequency' => ['required', 'string', 'in:daily,weekly,monthly,never'],
        ]);

        $user = Auth::user();
        $user->update($validated);

        return redirect()->route('user.settings.index')
            ->with('success', 'Paramètres de notification mis à jour avec succès.');
    }

    /**
     * Update privacy settings.
     */
    public function updatePrivacy(Request $request)
    {
        $validated = $request->validate([
            'public_profile' => ['boolean'],
            'public_stats' => ['boolean'],
            'analytics_collection' => ['boolean'],
        ]);

        $user = Auth::user();
        $user->update($validated);

        return redirect()->route('user.settings.index')
            ->with('success', 'Paramètres de confidentialité mis à jour avec succès.');
    }

    /**
     * Update appearance settings.
     */
    public function updateAppearance(Request $request)
    {
        $validated = $request->validate([
            'theme' => ['required', 'string', 'in:light,dark,auto'],
            'font_size' => ['required', 'string', 'in:small,medium,large,extra-large'],
            'density' => ['required', 'string', 'in:compact,comfortable,spacious'],
        ]);

        $user = Auth::user();
        $user->update($validated);

        return redirect()->route('user.settings.index')
            ->with('success', 'Paramètres d\'apparence mis à jour avec succès.');
    }

    /**
     * Export user data.
     */
    public function exportData()
    {
        $user = Auth::user();
        
        $data = [
            'user_info' => [
                'name' => $user->name,
                'email' => $user->email,
                'created_at' => $user->created_at,
            ],
            'settings' => [
                'language' => $user->language,
                'timezone' => $user->timezone,
                'reading_goal' => $user->reading_goal,
                'preferred_genres' => $user->preferred_genres,
            ],
            'exported_at' => now(),
        ];

        $filename = 'user_data_' . $user->id . '_' . now()->format('Y-m-d') . '.json';

        return response()->json($data)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Reset settings to default.
     */
    public function resetToDefault(Request $request)
    {
        $user = Auth::user();
        
        $defaultSettings = [
            'language' => 'fr',
            'timezone' => 'Europe/Paris',
            'email_notifications' => true,
            'reading_goal' => 5,
            'default_view' => 'grid',
            'preferred_genres' => [],
            'auto_bookmark' => true,
            'reading_timer' => false,
            'focus_mode' => false,
            'new_books_notifications' => true,
            'reading_reminders' => true,
            'goal_notifications' => true,
            'newsletter_subscription' => false,
            'notification_frequency' => 'weekly',
            'public_profile' => true,
            'public_stats' => false,
            'analytics_collection' => true,
            'theme' => 'light',
            'font_size' => 'medium',
            'density' => 'comfortable',
        ];

        $user->update($defaultSettings);

        return redirect()->route('user.settings.index')
            ->with('success', 'Paramètres réinitialisés aux valeurs par défaut.');
    }
}
