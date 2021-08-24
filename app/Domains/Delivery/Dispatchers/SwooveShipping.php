<?php

namespace App\Domains\Delivery\Dispatchers;

use App\Core\Helpers\Dispatchers\Dispatcher;
use App\Domains\APIs\Swoove\Delivery\CreateDelivery;
use App\Domains\APIs\Swoove\Delivery\DeliveryRequest;
use App\Domains\Orders\Model\Order;

class SwooveShipping extends Dispatcher
{
    use DeliveryRequest;

    /**
     * Class constructor
     *
     * @param Order $order
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
        CreateDelivery::build()
        ->withData(static::data($this->order))
        ->send()
        ->json();
    }
}
