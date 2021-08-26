<?php

declare(strict_types=1);

namespace Domain\Delivery\Dispatchers;

use App\Core\Helpers\Dispatchers\RunDispatcher;
use App\Domains\Products\Product\Models\ProductVariation;
use Domain\Orders\Order;
use Domain\Products\Product\Product;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

class DispatchOrder
{

    /**
     * Automatically handles dispatching the order to the appropriate service
     *
     * @param Order $order
     * @return void
     */
    public function dispatch(Order $order): void
    {
        $order->load(['orderable','products', 'products.skuable' => function (MorphTo $morphTo) {
            $morphTo->morphWith([
                Product::class,
                ProductVariation::class => ['product:id,name'],
            ]);
        }]);

        $order['products']->groupBy(function ($item) {
            return $item['skuable']['type'];
        })->map(function ($item, $key) use ($order) {
            $this->dispatcher($order, $item, $key);
        });
    }

    /**
     * Determines which dispatcher to be use to handle the order
     *
     * @param array|null $items
     * @param string $key
     * @param string $service
     * @return void
     */
    protected function dispatcher(
        Order $order,
        Collection $items,
        string $key,
    ): void {
        $files = config('dispatchers.files');
        $physical = config("dispatchers.physical.$order->service");
        $tickets = config("dispatchers.tickets");

        $payload = $this->extractOrderInfo($order, $items);

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
     * @return array
     */
    protected function extractOrderInfo(Order $order, Collection $items): array
    {
        return [
            'service' => $order->service ?? null,
            'order_id' => $order->id,
            'instructions' => $order->instructions ?? null,
            'customer_email' => $order->orderable->email,
            'customer_number' => $order->orderable->mobile,
            'items' => $order->service === 'swoove' ? $items : null
        ];
    }
}
