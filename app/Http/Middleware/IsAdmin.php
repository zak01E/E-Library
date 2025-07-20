<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()->route('admin.login');
        }

        if ($request->user()->role !== 'admin') {
            // Rediriger les auteurs vers leur espace au lieu d'afficher une erreur
            if ($request->user()->role === 'author') {
                return redirect()->route('author.dashboard')->with('warning', 'Vous avez été redirigé vers votre espace auteur.');
            }

            // Pour les autres rôles, afficher l'erreur 403
            abort(403, 'Access denied. Admin only.');
        }

        return $next($request);
    }
}