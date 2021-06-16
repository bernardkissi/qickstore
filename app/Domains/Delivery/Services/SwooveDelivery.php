<?php

namespace App\Domains\Delivery\Services;

use App\Domains\Delivery\Contract\DeliverableProvider;
use App\Domains\Delivery\Contract\DeliverableProviderContract;
use App\Domains\Orders\Model\Order;

class SwooveDelivery implements DeliverableProviderContract
{
    public static function init(): static
    {
        return new static();
    }
    /**
     * di9spatch the delivery to the agent
     *
     * @return void
     */
    public function dispatch(): string
    {
        return 'We are swoove and you welcome';
    }

    /**
     * Get the delivery information of the order
     *
     * @param Order $order
     * @return array
     */
    public function deliveryInfo(Order $order): array
    {
        return ['user', 'information'];
    }
}
