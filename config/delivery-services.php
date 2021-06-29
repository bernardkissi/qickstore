<?php


return [

    'active' => 'swoove',

    /*
    |--------------------------------------------------------------------------
    | Delivery Services
    |--------------------------------------------------------------------------
    |
    | These are the delivery agents currently supported by qickshops. Feel free to
    | add more delivery agents.
    */

    'swoove' => [
        'public_key' => env('SWOOVE_TEST_KEY'),
        'live_key' => env('SWOOVE_PROD_SECRET'),
        'endpoint' => env('SWOOVE_ENDPOINT'),
    ],

    'gigs' => [
        'public_key' => env('GIGS_TEST_KEY'),
        'live_key' => env('GIGS_PROD_SECRET'),
        'endpoint' => env('GIGS_ENDPOINT'),
    ],


];
