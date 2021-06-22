<?php

namespace App\Core\Providers;

use App\Domains\Orders\Checkouts\Contract\CheckoutableContract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class CheckoutServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CheckoutableContract::class, function ($app) {
            $customer = request('visitor', auth()->user());
            $service = $this->resolveService();
            return new $service($customer);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // add boot services here
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [CheckoutableContract::class];
    }

    /**
     * Resolves the tracking service to be instantiated
     *
     * @return void
     */
    protected function resolveService(): string
    {
        $type = request('type', 'default');
        return config("modules.checkout.${type}");
    }
}
