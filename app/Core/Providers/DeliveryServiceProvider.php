<?php

namespace App\Core\Providers;

use App\Domains\Delivery\Contract\DeliveryResolvableContract;
use App\Domains\Delivery\Services\DeliveryResolver;
use Illuminate\Support\ServiceProvider;

class DeliveryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DeliveryResolvableContract::class, function ($app) {
            $gateway = $this->resolveService();
            return new $gateway();
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
     * Resolves the payment gateway to be instantiated
     *
     * @return void
     */
    protected function resolveService(): string
    {
        $provider = config('delivery-services.active');
        $gateway = request('service', $provider);
        return config("modules.deliveries.${gateway}");
    }
}
