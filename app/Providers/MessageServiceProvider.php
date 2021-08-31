<?php

namespace App\Providers;

use App\Traits\ResolveTrait;
use Domain\Services\Notifications\Types\Sms\SmsContract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class MessageServiceProvider extends ServiceProvider implements DeferrableProvider
{
    use ResolveTrait;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SmsContract::class, function ($app) {
            $gateway = $this->resolveService('gateway', 'arksel', 'modules.sms');
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
    * Get the services provided by the provider.
    *
    * @return array
    */
    public function provides()
    {
        return [SmsContract::class];
    }
}
