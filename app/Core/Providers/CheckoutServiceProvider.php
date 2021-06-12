<?php

namespace App\Core\Providers;

use App\Domains\Orders\Checkouts\CheckOutService;
use App\Domains\Orders\Checkouts\Downloading\DownloadService;
use App\Domains\Orders\Checkouts\Shipping\ShippingService;
use App\Services\DetectCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class CheckoutServiceProvider extends ServiceProvider
{
    use DetectCustomer;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(CheckOutService::class, function ($app) {
            $request  =  app(Request::class);
            $customer = $this->detect($request);
            $service  =  $this->moduleResolver($request->service);
            return new  $service($customer);
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
     * Resolve the service to be used
     *
     * @param string $serviceType
     * @return string
     */
    public function moduleResolver(string $serviceType): string
    {
        return config("modules.checkouts.$serviceType");
    }
}
