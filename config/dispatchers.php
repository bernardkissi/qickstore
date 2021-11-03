<?php

use Domain\Delivery\Handlers\DHLShipping;
use Domain\Delivery\Handlers\FileDelivery;
use Domain\Delivery\Handlers\SwooveShipping;
use Domain\Delivery\Handlers\TicketGenerator;
use Domain\Delivery\Handlers\VendorShipping;

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
    'tickets'  => TicketGenerator::class,

    /**
    * Process phyisical goods for physical goods orders
    */
    'physical' => [
        'swoove' => SwooveShipping::class,
        'DHL' => DHLShipping::class,
        'custom' => VendorShipping::class,
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
