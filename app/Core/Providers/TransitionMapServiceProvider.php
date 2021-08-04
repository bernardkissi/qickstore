<?php

namespace App\Core\Providers;

use App\Core\Helpers\Transitions\TransitionMapper;
use App\Core\Resolver\ResolveTrait;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class TransitionMapServiceProvider extends ServiceProvider implements DeferrableProvider
{
    use ResolveTrait;
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TransitionMapper::class, function ($app) {
            $mapper = $this->resolveService('mapper', 'tracktry', 'modules.mappers');
            return new $mapper();
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
        return [TransitionMapper::class];
    }
}
