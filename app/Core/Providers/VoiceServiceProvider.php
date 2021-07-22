<?php

namespace App\Core\Providers;

use App\Core\Resolver\ResolveTrait;
use App\Domains\Services\Notifications\Types\Voice\VoiceContract;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class VoiceServiceProvider extends ServiceProvider implements DeferrableProvider
{
    use ResolveTrait;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(VoiceContract::class, function ($app) {
            $gateway = $this->resolveService('gateway', 'arksel', 'modules.voice');
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
        return [VoiceContract::class];
    }
}
