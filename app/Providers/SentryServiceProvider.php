<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Sentry\Laravel\Integration;

class SentryServiceProvider extends ServiceProvider
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
        if ($this->app->bound('sentry')) {
            $this->app->make('sentry')->configureScope(function (\Sentry\State\Scope $scope): void {
                $scope->setTag('component', 'api');
                $scope->setTag('service', 'flory-backend');
            });
        }
    }
}
