<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SiteSettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share site settings with all views
        try {
            $settings = SiteSetting::getAllSettings();
            View::share('siteSettings', $settings);
        } catch (\Exception $e) {
            // Handle case where database is not yet migrated
            View::share('siteSettings', []);
        }
    }
}
