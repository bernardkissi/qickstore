<?php

namespace App\Providers;

use App\Traits\ResolveTrait;
use Domain\Payments\Contract\PaymentableContract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider implements DeferrableProvider
{
    use ResolveTrait;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PaymentableContract::class, function ($app) {
            $gateway = $this->resolveService('gateway', 'paystack', 'modules.payments');
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
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [PaymentableContract::class];
    }
}
