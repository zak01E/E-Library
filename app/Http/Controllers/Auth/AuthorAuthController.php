<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthorAuthController extends Controller
{
    /**
     * Display the author login view.
     */
    public function create(): View
    {
        return view('auth.author-login');
    }

    /**
     * Handle an incoming author authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Vérifier que l'utilisateur est auteur
        if (Auth::user()->role !== 'author') {
            Auth::logout();
            return redirect()->route('author.login')->withErrors([
                'email' => 'Accès réservé aux auteurs.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('author.dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('author.login');
    }
}
