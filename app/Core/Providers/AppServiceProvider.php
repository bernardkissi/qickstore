<?php

namespace App\Core\Providers;

use App\Domains\Products\Attributes\Resource\AttributeResource;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
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
            'Visitor' => 'App\Domains\User\Visitor',
        ]);

        AttributeResource::withoutWrapping();
    }
}
