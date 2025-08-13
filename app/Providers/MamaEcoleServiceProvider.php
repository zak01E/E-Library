<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MamaEcole\VoiceService;

class MamaEcoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Enregistrer le service VoiceService comme singleton
        $this->app->singleton(VoiceService::class, function ($app) {
            return new VoiceService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Configuration Twilio
        $this->mergeConfigFrom(
            __DIR__.'/../../config/mama-ecole.php',
            'mama-ecole'
        );
    }
}
