<?php

declare(strict_types=1);

namespace Domain\Delivery\Dispatchers;

use App\Helpers\Dispatchers\RunDispatcher;
use Domain\Orders\Order;
use Illuminate\Support\Collection;

class DispatchOrder
{
    /**
     * Automatically handles dispatching the order to the appropriate service
     *
     * @param Order $order
     *
     * @return void
     */
    public function dispatch(Order $order): void
    {
        $groups = $order->groupItemsByDelivery();
        $num_of_groups = $groups->count();

        $groups->map(function ($item, $key) use ($order, $num_of_groups) {
            $this->dispatcher($order, $item, $key, $num_of_groups);
        });
    }

    /**
     * Determines which dispatcher to be use to handle the order
     *
     * @param array|null $items
     * @param string $key
     * @param string $service
     *
     * @return void
     */
    protected function dispatcher(
        Order $order,
        Collection $items,
        string $key,
        int $count
    ): void {
        $files = config('dispatchers.files');
        $physical = config("dispatchers.physical.$order->shipping_service");
        $tickets = config('dispatchers.tickets');

        $payload = $this->extractOrderInfo($order, $items, $count);

        $class = match ($key) {
            'physical' => new $physical($payload),
            'digital' => new $files($payload),
            'tickets' => new $tickets($payload),
            'default' => logger('error finding the dispatcher')
        };

        RunDispatcher::run($class);
    }

    /**
     * Extract required information from order to create delivery
     *
     * @param Order $order
     *
     * @return array
     */
    protected function extractOrderInfo(Order $order, Collection $items, int $num_of_groups): array
    {
        return [
            'service' => $order->shipping_service ?? null,
            'order_id' => $order->id,
            'instructions' => $order->instructions ?? null,
            'customer_email' => $order->orderable->email,
            'customer_number' => $order->orderable->mobile,
            'count' => $num_of_groups,
            'items' => $order->shipping_service === 'swoove' || 'DHL' ? $items : null,
        ];
    }
}
