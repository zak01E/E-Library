<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAuthor
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() || !in_array($request->user()->role, ['admin', 'author'])) {
            abort(403, 'Access denied. Author or Admin only.');
        }

        return $next($request);
    }
}