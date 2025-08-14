<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureCorrectDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $currentPath = $request->path();
            
            // If admin is on user dashboard, redirect to admin dashboard
            if ($user->role === 'admin' && $currentPath === 'dashboard') {
                return redirect()->route('admin.dashboard');
            }
            
            // If author is on user dashboard, redirect to author dashboard
            if ($user->role === 'author' && $currentPath === 'dashboard') {
                return redirect()->route('author.dashboard');
            }
        }
        
        return $next($request);
    }
}
