<?php

namespace App\Providers;

use App\Traits\ResolveTrait;
use Domain\Delivery\Dispatchers\DispatchOrder;
use Illuminate\Support\ServiceProvider;

class DeliveryServiceProvider extends ServiceProvider
{
    use ResolveTrait;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Dispatcher', function ($app) {
            return new DispatchOrder();
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
}
