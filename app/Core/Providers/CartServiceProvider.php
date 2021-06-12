<?php

namespace App\Core\Providers;

use App\Domains\Cart\Services\Cart;
use App\Domains\User\User;
use App\Domains\User\Visitor;
use App\Services\DetectCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
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
}
