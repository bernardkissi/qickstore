<?php

declare(strict_types=1);

namespace Domain\Orders\Processors;

use App\Helpers\Processor\Processor;
use Domain\Orders\OrderStatus;

class DisputedProcessor extends Processor
{
    /**
     * Class constructor
     *
     * @var OrderStatus $order
     */
    public function __construct(public OrderStatus $order)
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
        var_dump('notify seller and administrators that order has been disputed');
        var_dump('attach the link of the disputed order to msg');
    }
}
