<?php

namespace App\Domains\Delivery\Contract;

use App\Domains\Orders\Model\Order;
use Illuminate\Http\Request;

interface DeliverableContract
{
    /**
     * Process delivery of the order
     *
     * @return void
     */

    public static function dispatch(Request $request): array; // takes in an order

    /**
     * Get the delivery information of the order
     *
     * @param Order $order
     *
     * @return array
     */
    public function deliveryInfo(Order $order): array;
}
