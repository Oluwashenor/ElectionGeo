<?php

namespace App\Providers;

use App\Services\AEService;
use Illuminate\Support\ServiceProvider;

class AEServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AEService::class, function ($app) {
            return new AEService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
