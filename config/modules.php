<?php

/*
|--------------------------------------------------------------------------
| APP Modules
|--------------------------------------------------------------------------
|
| Here are the application modules which are registered with the application
| on loading. Feel free to register or replace any module which will be resolved
| and register in the service container.
*/

return [

    'cart'=> ['vcart' => App\Domains\Cart\Services\Cart::class],
    'checkouts' => [
        'download' => App\Domains\Orders\Checkouts\Downloading\DownloadService::class,
        'shipping' => App\Domains\Orders\Checkouts\Shipping\ShippingService::class
    ]

];
