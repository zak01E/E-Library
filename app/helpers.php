<?php

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Route;

if (!function_exists('site_setting')) {
    /**
     * Get a site setting value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function site_setting($key, $default = null)
    {
        return SiteSetting::get($key, $default);
    }
}

if (!function_exists('site_logo')) {
    /**
     * Get site logo URL
     *
     * @param string $type
     * @param string|null $fallback
     * @return string|null
     */
    function site_logo($type = 'site_logo', $fallback = null)
    {
        return SiteSetting::getLogo($type, $fallback);
    }
}

if (!function_exists('site_favicon')) {
    /**
     * Get site favicon URL
     *
     * @return string
     */
    function site_favicon()
    {
        return SiteSetting::getFavicon();
    }
}

if (!function_exists('site_name')) {
    /**
     * Get site name
     *
     * @return string
     */
    function site_name()
    {
        return SiteSetting::get('site_name', config('app.name', 'E-Library'));
    }
}

if (!function_exists('admin_route')) {
    /**
     * Generate admin route with fallback
     *
     * @param string $name
     * @param mixed $parameters
     * @return string
     */
    function admin_route($name, $parameters = [])
    {
        $routeName = 'admin.' . $name;
        
        if (Route::has($routeName)) {
            return route($routeName, $parameters);
        }
        
        // Generate fallback URL
        $url = '/admin/' . str_replace('.', '/', $name);
        
        if (!empty($parameters)) {
            if (is_array($parameters)) {
                $url .= '/' . implode('/', $parameters);
            } elseif (is_object($parameters) && method_exists($parameters, 'getKey')) {
                $url .= '/' . $parameters->getKey();
            } else {
                $url .= '/' . $parameters;
            }
        }
        
        return $url;
    }
}
