<?php

namespace App\Core\Providers;

use App\Core\Resolver\ResolveTrait;
use App\Domains\Delivery\Contract\DeliverableContract;
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
        $this->app->singleton(DeliverableContract::class, function ($app) {
            $gateway = $this->resolveService('service', 'swoove', 'modules.deliveries');
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
}
