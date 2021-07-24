<?php

declare(strict_types=1);

namespace App\Domains\Orders\Processors;

use App\Core\Helpers\Processor\Processor;
use App\Domains\Orders\Model\Order;

class DeliveryProcessor extends Processor
{
    /**
    * Class constructor
    *
    * @var Order $order
    */
    public function __construct(public Order $order)
    {
    }

    /**
     * Returns a new instance of the processor.
     *
     * @return Processor
     */
    public function getInstance(): Processor
    {
        return new self($this->order);
    }

    /**
     * Process the order.
     *
     * @return void
     */
    public function execute(): void
    {
        dump($this->order);
    }
}
