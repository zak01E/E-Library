<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'text', $description = null)
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'description' => $description,
            ]
        );
    }

    /**
     * Get all settings as key-value pairs
     */
    public static function getAllSettings()
    {
        return static::pluck('value', 'key')->toArray();
    }

    /**
     * Get logo URL with fallback
     */
    public static function getLogo($type = 'site_logo', $fallback = null)
    {
        $logo = static::get($type);
        if ($logo) {
            return asset('storage/' . $logo);
        }
        return $fallback;
    }

    /**
     * Get favicon URL with fallback
     */
    public static function getFavicon()
    {
        $favicon = static::get('site_favicon');
        if ($favicon) {
            return asset('storage/' . $favicon);
        }
        return asset('favicon.ico'); // Default Laravel favicon
    }
}
