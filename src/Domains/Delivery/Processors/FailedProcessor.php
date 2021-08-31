<?php

declare(strict_types=1);

namespace Domain\Delivery\Processors;

use App\Helpers\Processor\Processor;
use Domain\Delivery\Delivery;

class FailedProcessor extends Processor
{
    /**
    * Class constructor
    *
    * @var Order $order
    */
    public function __construct(public Delivery $delivery)
    {
    }

    /**
     * Returns a new instance of the processor.
     *
     * @return Processor
     */
    public function getInstance(): Processor
    {
        return new self($this->delivery);
    }

    /**
     * Process the order.
     *
     * @return void
     */
    public function execute(): void
    {
        dump($this->delivery);
    }
}