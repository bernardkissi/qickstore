<?php

namespace App\Providers;

use App\Domains\Tracking\Contract\TrackableContract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class TrackingServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TrackableContract::class, function ($app) {
            $provider = $this->resolveService();
            return new $provider();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [TrackableContract::class];
    }

    /**
     * Resolves the tracking service to be instantiated
     *
     * @return void
     */
    protected function resolveService(): string
    {
        $type = request('service', 'swoove');
        return config("modules.tracking.${type}");
    }
}
