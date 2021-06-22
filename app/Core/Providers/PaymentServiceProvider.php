<?php

namespace App\Core\Providers;

use App\Domains\Payments\Contract\PaymentableContract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PaymentableContract::class, function ($app) {
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
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [PaymentableContract::class];
    }

    /**
     * Resolves the payment gateway to be instantiated
     *
     * @return void
     */
    protected function resolveService(): string
    {
        $gateway = request('gateway', 'flutterwave');
        return config("modules.payments.${gateway}");
    }
}
