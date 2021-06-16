<?php

namespace App\Core\Providers;

use App\Domains\Cart\Services\Cart;
use App\Services\DetectCustomer;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider implements DeferrableProvider
{
    use DetectCustomer;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Cart::class, function ($app) {
            $customer = $this->detect(app(Request::class));
            return new Cart($customer->load(['cart.stockCount', 'cart.skuable']));
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
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Cart::class];
    }
}
