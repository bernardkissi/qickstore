<?php

namespace App\Core\Providers;

use App\Domains\Cart\Services\Cart;
use App\Domains\User\User;
use App\Domains\User\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Cart::class, function ($app) {
            $customer = $this->detectCustomer();
            return new Cart($customer);
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
     * detects the current customer
     *
     * @return void
     */
    protected function detectCustomer(): User|Visitor
    {
        $request = app(Request::class);
        $visitor = $request->visitor;
        $condition = $request->has('visitor') && $visitor instanceof Visitor ? true : false;

        $customer = match ($condition) {
            true => $visitor,
            false => auth()->user()
        };
        
        return $customer;
    }
}
