<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class RouteHelper
{
    /**
     * Generate a route URL with fallback
     *
     * @param string $routeName
     * @param mixed $parameters
     * @param string|null $fallback
     * @return string
     */
    public static function routeWithFallback($routeName, $parameters = [], $fallback = null)
    {
        if (Route::has($routeName)) {
            return route($routeName, $parameters);
        }

        if ($fallback) {
            return $fallback;
        }

        // Generate fallback from route name
        $parts = explode('.', $routeName);
        $url = '/' . implode('/', $parts);
        
        if (!empty($parameters)) {
            if (is_array($parameters)) {
                $url .= '/' . implode('/', $parameters);
            } else {
                $url .= '/' . $parameters;
            }
        }

        return $url;
    }

    /**
     * Check if current request matches a route pattern
     *
     * @param string $pattern
     * @return bool
     */
    public static function isRoute($pattern)
    {
        return request()->is($pattern) || request()->routeIs($pattern);
    }
}