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

    /*
    |--------------------------------------------------------------------------
    | Store Cart System
    |--------------------------------------------------------------------------
    |
    | This service acts as the cart system for stores. feel free to swap with
    | different cart service.
    */

    'cart'=> [
        'vcart' => App\Domains\Cart\Services\Cart::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Checkout Gateways
    |--------------------------------------------------------------------------
    |
    | Checkout gateway acts a the checkout service used to checkout the customer.
    | Feel free to add checkout services to this service to handle different
    | orders or swap default.
    */

    'checkout' => [
        'default' => App\Domains\Orders\Checkouts\Services\CheckoutService::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Delivery Channels
    |--------------------------------------------------------------------------
    |
    | Below are the current the delivery channels available to stores. Feel
    | free to add more channels to stores.
    */

    'deliveries' => [
        'swoove' => App\Domains\Delivery\Services\SwooveDelivery::class,
        'hosted' => App\Domains\Delivery\Services\HostedDelivery::class,
        'files'  => App\Domains\Delivery\Services\FilesDelivery::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Tracking Services
    |--------------------------------------------------------------------------
    |
    | Tracking services for the delivery channels defined above. Add a tracking
    | service when you add a new delivery channel.
    */

    'tracking' => [
        'files' => App\Domains\Tracking\DeliveryServices\FilesTracking::class,
        'swoove' => App\Domains\Tracking\DeliveryServices\SwooveTracking::class,
        'hosted' => App\Domains\Tracking\DeliveryServices\HostedTracking::class,
    ],


    /*
    |--------------------------------------------------------------------------
    | Payment Gateways
    |--------------------------------------------------------------------------
    |
    | Payment gateways currently available to the storefronts. Feel free to add
    | additional payment providers. eg. Crypto payments...
    */

    'payments' => [
        'flutterwave' => App\Domains\Payments\Gateways\Flutterwave::class,
        'cash' => App\Domains\Payments\Gateways\CashOnDelivery::class,
    ],


    /*
    |--------------------------------------------------------------------------
    | Payout Services
    |--------------------------------------------------------------------------
    |
    | This services will handle payout to merchants manually or automatically
    | if configured through store settings. Additional payout services can be
    | added to be used by stores;
    */

    'payouts' => [
        'flutterwave' => App\Domains\Payouts\Services\FlutterwavePayoutService::class,
        //'paystack' => '',
    ]

];
