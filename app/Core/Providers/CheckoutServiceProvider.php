<?php

namespace App\Core\Providers;

use App\Domains\Orders\Checkouts\Contract\CheckoutableProvider;
use App\Domains\Orders\Checkouts\Services\CheckoutService;
use App\Services\DetectCustomer;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class CheckoutServiceProvider extends ServiceProvider implements DeferrableProvider
{
    use DetectCustomer;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CheckoutableProvider::class, function ($app) {
            $request  =  app(Request::class);
            $customer = $this->detect($request);

            return new CheckoutService($customer);
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
        return [CheckoutService::class];
    }
}
