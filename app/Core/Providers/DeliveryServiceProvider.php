<?php

namespace App\Core\Providers;

use App\Domains\Delivery\Contract\DeliverableProvider;
use App\Domains\Delivery\Contract\DeliveryResolvableContract;
use App\Domains\Delivery\DeliveryResolver;
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
            return new DeliveryResolver();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
