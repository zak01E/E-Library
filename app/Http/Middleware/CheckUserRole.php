<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     * Vérifie que l'utilisateur a le bon rôle pour accéder à la route
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Si aucun rôle spécifié, on laisse passer
        if (empty($roles)) {
            return $next($request);
        }

        // Vérifier si l'utilisateur a l'un des rôles autorisés
        if (!in_array($user->role, $roles)) {
            // Rediriger vers le bon dashboard selon le rôle
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')
                        ->with('error', 'Vous n\'avez pas accès à cette section. Vous avez été redirigé vers votre espace administrateur.');
                    
                case 'author':
                    return redirect()->route('author.dashboard')
                        ->with('error', 'Vous n\'avez pas accès à cette section. Vous avez été redirigé vers votre espace auteur.');
                    
                case 'user':
                default:
                    return redirect()->route('dashboard')
                        ->with('error', 'Vous n\'avez pas accès à cette section. Vous avez été redirigé vers votre espace utilisateur.');
            }
        }

        return $next($request);
    }
}