<?php

use App\Domains\Cart\Services\Cart;
use App\Domains\Delivery\Dispatchers\HostedDelivery;
use App\Domains\Delivery\Dispatchers\SwooveDelivery;
use App\Domains\Delivery\Mappers\SwooveMapper;
use App\Domains\Delivery\Mappers\TracktryMapper;
use App\Domains\Delivery\Services\Dispatchers\FilesDelivery;
use App\Domains\Orders\Checkouts\Services\CheckoutService;
use App\Domains\Payments\Gateways\CashOnDelivery;
use App\Domains\Payments\Gateways\Flutterwave;
use App\Domains\Payouts\Services\FlutterwavePayoutService;
use App\Domains\Services\Notifications\Types\Sms\Providers\Arksel as ArkselSms;
use App\Domains\Services\Notifications\Types\Sms\Providers\Mnotify as MnotifySms;
use App\Domains\Services\Notifications\Types\Voice\Providers\Arksel as ArkselVoice;
use App\Domains\Tracking\DeliveryServices\FilesTracking;
use App\Domains\Tracking\DeliveryServices\HostedTracking;
use App\Domains\Tracking\DeliveryServices\SwooveTracking;

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
        'vcart' => Cart::class
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
        'default' => CheckoutService::class
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
        'swoove' => SwooveDelivery::class,
        'hosted' => HostedDelivery::class,
        'files'  => FilesDelivery::class
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
        'files' => FilesTracking::class,
        'swoove' => SwooveTracking::class,
        'hosted' => HostedTracking::class,
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
        'flutterwave' => Flutterwave::class,
        'cash' => CashOnDelivery::class,
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
        'flutterwave' => FlutterwavePayoutService::class,
        //'paystack' => '',
    ],


    /*
    |--------------------------------------------------------------------------
    | SMS Gateways
    |--------------------------------------------------------------------------
    |
    | This services will handle payout to merchants manually or automatically
    | if configured through store settings. Additional payout services can be
    | added to be used by stores;
    */
    'sms' => [
        'arksel' => ArkselSms::class,
        'mnotify' => MnotifySms::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Voice Gateways
    |--------------------------------------------------------------------------
    |
    | This services will handle payout to merchants manually or automatically
    | if configured through store settings. Additional payout services can be
    | added to be used by stores;
    */
    'voice' => [
        'arksel' => ArkselVoice::class,
    ],


     /*
    |--------------------------------------------------------------------------
    | Voice Gateways
    |--------------------------------------------------------------------------
    |
    | This services will handle payout to merchants manually or automatically
    | if configured through store settings. Additional payout services can be
    | added to be used by stores;
    */
    'mappers' => [
        'swoove' => SwooveMapper::class,
        'tracktry' => TracktryMapper::class
    ]
];
