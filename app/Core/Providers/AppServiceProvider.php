<?php

namespace App\Core\Providers;

use App\Domains\Attributes\Resource\AttributeResource;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            
            'Product' => 'App\Domains\Products\Models\Product',
            'Variation' => 'App\Domains\Products\Models\ProductVariation',
        ]);

        AttributeResource::withoutWrapping();
    }
}
