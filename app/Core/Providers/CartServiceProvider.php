<?php

namespace App\Core\Providers;

use App\Domains\Cart\Contracts\CartContract;
use App\Domains\Cart\Services\Cart;
use App\Domains\User\Visitor;
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
            return new Cart();
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
