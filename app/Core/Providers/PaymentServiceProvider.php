<?php

namespace App\Core\Providers;

use App\Domains\Payments\Contract\PaymentableContract;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
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
        //
    }

    /**
    * Resolves the payment gateway to be instantiated
    *
    * @return void
    */
    protected function resolveService(): string
    {
        $gateway = request('gateway', 'flutterwave');
        return config("modules.payments.$gateway");
    }
}
