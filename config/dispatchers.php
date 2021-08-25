<?php

use App\Domains\Delivery\Dispatchers\CustomVendorShipping;
use App\Domains\Delivery\Dispatchers\FileDelivery;
use App\Domains\Delivery\Dispatchers\SwooveShipping;

return [

    /*
    |--------------------------------------------------------------------------
    | Dispatchers
    |--------------------------------------------------------------------------
    |
    | Feel free to add your own dispatcher to the list. Dispatchers are used to process
    | orders. eg. tickets, physical goods, files, etc.
    */



    /**
    * Process tickets generation for tickets orders
    */
    'tickets'  => null,

    /**
    * Process phyisical goods for physical goods orders
    */
    'physical' => [
        'swoove' => SwooveShipping::class,
        'custom' => CustomVendorShipping::class,
        'gigs'   => null,
    ],

    /**
    * Process files for files orders
    */
    'files' => FileDelivery::class,

    /**
    * Process logins,codes generation for service orders
    */
    'services' => null,

    /**
    * Process payments for courses orders
    */
    'course'   => null,


];
