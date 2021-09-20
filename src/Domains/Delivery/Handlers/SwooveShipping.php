<?php

namespace Domain\Delivery\Handlers;

use App\Helpers\Dispatchers\Dispatcher;
use Domain\APIs\Swoove\Delivery\CreateDelivery;
use Domain\Delivery\Traits\CanCreateDelivery;
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
        $this->createDelivery($this->order);

        // $some = CreateDelivery::build()
        // ->withData(static::data($this->order))
        // ->send()
        // ->json();

        //send vendor notification after delivery is succesfully created
        // customer will be notified by email/sms.
    }
}
