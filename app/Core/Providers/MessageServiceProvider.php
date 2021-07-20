<?php

namespace App\Core\Providers;

use App\Core\Resolver\ResolveTrait;
use App\Domains\Services\Sms\SMSContract;
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
        $this->app->singleton(SMSContract::class, function ($app) {
            $gateway = $this->resolveService('gateway', 'mnotify', 'modules.sms');
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
        return [SMSContract::class];
    }
}
