<?php

namespace App\Core\Providers;

use App\Domains\Products\Attributes\Resource\AttributeResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Laravel\Telescope\TelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([

            'Product' => 'App\Domains\Products\Product\Models\Product',
            'Variation' => 'App\Domains\Products\Product\Models\ProductVariation',
            'User' => 'App\Domains\User\User',
            'Sku' => 'App\Domains\Products\Skus\Model\Sku',
            'Visitor' => 'App\Domains\User\Visitor',
        ]);

        AttributeResource::withoutWrapping();
        Model::preventLazyLoading();
    }
}
