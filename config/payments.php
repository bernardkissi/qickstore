<?php

/*
|--------------------------------------------------------------------------
| Payment Gateways Endpoints
|--------------------------------------------------------------------------

| Tracking services for the delivery channels defined above. Add a tracking
| service when you add a new delivery channel.
*/

return [

    'flutterwave' =>[
        'charge' => 'https://api.flutterwave.com/v3/payments',
        'payout' => 'https://api.flutterwave.com/v3/transfers'
    ]

];
