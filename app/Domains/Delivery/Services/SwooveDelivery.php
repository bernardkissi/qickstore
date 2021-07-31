<?php

namespace App\Domains\Delivery\Services;

use App\Domains\APIs\Swoove\Delivery\CreateDelivery;
use App\Domains\APIs\Swoove\Delivery\DeliveryRequest;
use App\Domains\Delivery\Contract\DeliverableContract;
use App\Domains\Orders\Model\Order;
use Illuminate\Http\Request;

class SwooveDelivery implements DeliverableContract
{
    use DeliveryRequest;

    public static function init(): static
    {
        return new static();
    }

    /**
     * dispatch the delivery to the agent
     *
     * @return void
     */
    public static function dispatch(Request $request): array
    {
        return CreateDelivery::build()
        ->withData(static::data($request))
        ->send()
        ->json();
    }

    /**
     * Get the delivery information of the order
     *
     * @param Order $order
     *
     * @return array
     */
    public function deliveryInfo(Order $order): array
    {
        return ['user', 'information'];
    }
}
