<?php

declare(strict_types=1);

namespace App\Domains\Orders\Processors;

use App\Core\Helpers\Processor\Processor;
use App\Domains\Orders\Model\Order;

class FailedProcessor extends Processor
{
    /**
      * Order Property
      *
      * @return Order
      */
    public Order $order;

    /**
     * Returns a new instance of the processor.
     *
     * @return Processor
     */
    public static function getInstance(): Processor
    {
        return new self;
    }

    /**
     * Get Order to be processed
     *
     * @param Order $order
     * @return self
     */
    public function setModel(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Process the order.
     *
     * @return string
     */
    public function execute(): void
    {
        //
    }
}
