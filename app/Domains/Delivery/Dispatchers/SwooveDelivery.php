<?php

namespace App\Domains\Delivery\Dispatchers;

use App\Domains\APIs\Swoove\Delivery\CreateDelivery;
use App\Domains\APIs\Swoove\Delivery\DeliveryRequest;
use App\Domains\Delivery\Contract\DeliverableContract;
use App\Domains\Orders\Model\Order;

class SwooveDelivery implements DeliverableContract
{
    use DeliveryRequest;

    /**
     * dispatch the delivery to the agent
     *
     * @return void
     */
    public static function dispatch(Order $request): void
    {
        // return CreateDelivery::build()
        // ->withData(static::data($request))
        // ->send()
        // ->json();
    }
}
