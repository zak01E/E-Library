<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthorGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si l'utilisateur est connecté et est un auteur, rediriger vers le dashboard auteur
        if (Auth::check() && Auth::user()->role === 'author') {
            return redirect()->route('author.dashboard');
        }

        return $next($request);
    }
}
