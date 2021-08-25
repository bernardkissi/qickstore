<?php

namespace App\Core\Providers;

use App\Core\Resolver\ResolveTrait;
use App\Domains\Delivery\Contract\DeliverableContract;
use App\Domains\Delivery\Dispatchers\DispatchOrder;
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
