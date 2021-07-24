<?php

declare(strict_types=1);

namespace App\Domains\Delivery\Processors;

use App\Core\Helpers\Processor\Processor;
use App\Domains\Delivery\Facade\Delivery;

class DeliveredProcessor extends Processor
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
