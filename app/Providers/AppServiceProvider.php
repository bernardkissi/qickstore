<?php

namespace App\Providers;

use Domain\Products\Attributes\Resource\AttributeResource;
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
        Relation::enforceMorphMap([

            'Product' => 'Domain\Products\Product\Product',
            'Bundle' => 'Domain\Products\Product\Bundle',
            'Variation' => 'Domain\Products\Product\ProductVariation',
            'User' => 'Domain\User\User',
            'Sku' => 'Domain\Products\Skus\Sku',
            'Visitor' => 'Domain\User\Visitor',
            'Order' => 'Domain\Orders\Order',
            'Payout' => 'Domain\Payouts\Payout',
            'Dispute' => 'Domain\Disputes\Dispute',
            'DisputeAction' => 'Domain\Disputes\DisputeAction'
        ]);

        AttributeResource::withoutWrapping();
        Model::preventLazyLoading();
    }
}
