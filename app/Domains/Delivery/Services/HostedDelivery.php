<?php

namespace App\Domains\Delivery\Services;

use App\Domains\Delivery\Contract\DeliverableProviderContract;
use App\Domains\Orders\Model\Order;

class HostedDelivery implements DeliverableProviderContract
{
    /**
     * di9spatch the delivery to the agent
     *
     * @return void
     */
    public function dispatch(): string
    {
        return 'We are hosted delivery and you welcome';
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
