<?php

declare(strict_types=1);

namespace Domain\Orders\Processors;

use App\Helpers\Processor\Processor;
use Domain\Orders\OrderStatus;

class CompletedProcessor extends Processor
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
        var_dump('
            Thank customer for shopping on your store
            with suggested products similar to what he ordered
        ');
    }
}
