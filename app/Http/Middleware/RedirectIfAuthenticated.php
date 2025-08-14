<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                
                // Redirect based on user role
                $redirectTo = match($user->role ?? null) {
                    'admin' => route('admin.dashboard'),
                    'author' => route('author.dashboard'),
                    default => route('user.dashboard')
                };
                
                return redirect($redirectTo);
            }
        }

        return $next($request);
    }
}