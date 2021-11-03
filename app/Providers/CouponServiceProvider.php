<?php

namespace App\Providers;

use Domain\Coupons\Services\CouponGenerator;
use Domain\Coupons\Services\Coupons;
use Illuminate\Support\ServiceProvider;

class CouponServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('coupon', function ($app) {
            $generator = new CouponGenerator(config('coupons.characters'), config('coupons.mask'));
            $generator->setPrefix(config('coupons.prefix'));
            $generator->setSuffix(config('coupons.suffix'));
            return new Coupons($generator);
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
}
