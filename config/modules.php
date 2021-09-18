<?php

use CashlessCheckout;
use Domain\Cart\Cart;
use Domain\Delivery\Handlers\FileDelivery;
use Domain\Delivery\Handlers\SwooveShipping;
use Domain\Delivery\Handlers\VendorShipping;
use Domain\Delivery\Mappers\SwooveMapper;
use Domain\Delivery\Mappers\TracktryMapper;
use Domain\Orders\Checkouts\StandardCheckout;
use Domain\Payments\Gateways\CashOnDelivery;
use Domain\Payments\Gateways\Flutterwave;
use Domain\Payments\Gateways\Paystack;
use Domain\Payouts\Services\FlutterwavePayoutService;
use Domain\Tracking\DeliveryServices\FilesTracking;
use Domain\Tracking\DeliveryServices\HostedTracking;
use Domain\Tracking\DeliveryServices\SwooveTracking;
use Service\Notifications\Types\Sms\Providers\Arksel as ArkselSms;
use Service\Notifications\Types\Sms\Providers\Mnotify as MnotifySms;
use Service\Notifications\Types\Voice\Providers\Arksel as ArkselVoice;

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
        'default' => StandardCheckout::class,
        'cashless' => CashlessCheckout::class,
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
        'swoove' => SwooveShipping::class,
        'hosted' => VendorShipping::class,
        'files'  => FileDelivery::class
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
        'paystack' => Paystack::class,
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
