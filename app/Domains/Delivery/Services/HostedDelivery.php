<?php

namespace App\Domains\Delivery\Services;

use App\Domains\Delivery\Contract\DeliverableContract;
use App\Domains\Orders\Model\Order;
use Illuminate\Http\Request;

class HostedDelivery implements DeliverableContract
{
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
        return ['your hosted order is ready for download'];
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
