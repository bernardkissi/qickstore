<?php

namespace Domain\Delivery\Handlers;

use App\Helpers\Dispatchers\Dispatcher;
use Domain\Delivery\Traits\CanCreateDelivery;
use Domain\Orders\Order;
use Domain\Orders\States\Processing;
use Illuminate\Support\Facades\DB;
use Integration\Swoove\Delivery\DeliveryRequest;

class SwooveShipping extends Dispatcher
{
    use DeliveryRequest,CanCreateDelivery;

    /**
     * Class constructor
     *
     * @param array $order
     * @param string $fileUrl
     */
    public function __construct(
        public array $order
    ) {
    }

    /**
     * Returns an instance of the File Delivery
     *
     * @return Dispatcher
     */
    public function getInstance(): Dispatcher
    {
        return new self($this->order);
    }

    /**
     * Send downloadable file link to the customer's email.
     *
     * @return void
     */
    public function dispatch(): void
    {
        DB::transaction(function () {
            $this->createDelivery($this->order);

            $order = Order::find($this->order['order_id']);
            $order->transitionState('processing');
        });
    }
}
