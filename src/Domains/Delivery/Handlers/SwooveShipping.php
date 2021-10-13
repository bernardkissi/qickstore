<?php

namespace Domain\Delivery\Handlers;

use App\Helpers\Dispatchers\Dispatcher;
use Domain\Delivery\Dtos\DeliveryDto;
use Domain\Delivery\Traits\CanCreateDelivery;
use Domain\Orders\Order;
use Illuminate\Support\Facades\DB;
use Integration\Swoove\Delivery\CreateDelivery;
use Integration\Swoove\Delivery\SwooveDto;

use const Cerbero\Dto\CAMEL_CASE_ARRAY;

class SwooveShipping extends Dispatcher
{
    use CanCreateDelivery;

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

            $some = CreateDelivery::build()
                    ->withData(SwooveDto::deliveryTransferObject($this->order))
                    ->send()
                    ->json();

            dump($some);
            $order = Order::find($this->order['order_id']);
            $order->transitionState('processing');
        });
    }
}
