<?php

namespace App\Core\Providers;

use App\Domains\Payouts\Contract\PayableContract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PayoutServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(PayableContract::class, function ($app) {
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
        return [PayableContract::class];
    }

    /**
     * Resolves the payment gateway to be instantiated
     *
     * @return void
     */
    protected function resolveService(): string
    {
        $gateway = request('service', 'flutterwave');
        return config("modules.payouts.${gateway}");
    }
}
