<?php

use Domain\Delivery\Processors\DeliveredProcessor;
use Domain\Delivery\Processors\DeliveringProcessor;
use Domain\Delivery\Processors\PickedProcessor;
use Domain\Delivery\Processors\PickingProcessor;
use Domain\Disputes\Processors\AcceptedProcessor;
use Domain\Disputes\Processors\DeclinedProcessor;
use Domain\Disputes\Processors\OpenProcessor;
use Domain\Disputes\Processors\ResolvedProcessor;
use Domain\Orders\Processors\CancelledProcessor;
use Domain\Orders\Processors\CompletedProcessor;
use Domain\Orders\Processors\DeliveryProcessor;
use Domain\Orders\Processors\DisputedProcessor;
use Domain\Orders\Processors\FailedProcessor;
use Domain\Orders\Processors\PaidProcessor;
use Domain\Orders\Processors\ProcessedProcessor;
use Domain\Orders\Processors\RefundedProcessor;
use Domain\Orders\Processors\ShippedProcessor;

return [

    /*
    |--------------------------------------------------------------------------
    | Processors to handle states in our application
    |--------------------------------------------------------------------------
    |
    | Here you can specify the processors to handle the states in our application.
    | For example: state changes in delivery, orders, disputes ..etc. You can add
    | as many processors as you want.
    */

    'delivery' => [
       'delivered' => DeliveredProcessor::class,
       'deliverring' => DeliveringProcessor::class,
       'assigned' => AssignedProcessor::class,
       'pickingup'  => PickingProcessor::class,
       'pickedup'  => PickedProcessor::class,
       'failed' => FailedProcessor::class,
    ],

    'order' => [
        'paid' => PaidProcessor::class,
        'processing' => ProcessedProcessor::class,
        'failed' => FailedProcessor::class,
        'shipped'  => ShippedProcessor::class,
        'delivered' => DeliveryProcessor::class,
        'completed' => CompletedProcessor::class,
        'cancelled' => CancelledProcessor::class,
        'disputed' => DisputedProcessor::class,
        'refunded' => RefundedProcessor::class,
    ],

    'dispute' => [
        'open' => OpenProcessor::class,
        'accepted' => AcceptedProcessor::class,
        'declined'    => DeclinedProcessor::class,
        'resolved'   => ResolvedProcessor::class,
    ],

    'refund' => [
       'pending' => DeliveredProcessor::class,
       'refunded' => DeliveringProcessor::class,
    ],

];
