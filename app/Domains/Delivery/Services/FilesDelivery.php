<?php

namespace App\Domains\Delivery\Services;

use App\Domains\Delivery\Contract\DeliverableProviderContract;
use App\Domains\Orders\Model\Order;

class FilesDelivery implements DeliverableProviderContract
{
    /**
     * di9spatch the delivery to the agent
     *
     * @return void
     */
    public function dispatch(): string
    {
        return 'your order is ready for download';
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
