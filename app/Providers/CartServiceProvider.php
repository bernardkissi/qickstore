<?php

namespace App\Providers;

use Domain\Cart\Cart;
use Domain\Cart\Contracts\CartContract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CartContract::class, function ($app) {
            $customer = request('visitor', auth()->user());
            $user = $customer?->load(['cart.stockCount', 'cart.skuable']);

            return new Cart($user);
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
        return [CartContract::class];
    }
}
