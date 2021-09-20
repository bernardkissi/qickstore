<?php

declare(strict_types=1);

namespace App\Helpers\Processor;

abstract class Processor
{
    /**
     * Returns a processor to handle the order.
     *
     * @return Processor
     */
    abstract public function getInstance(): Processor;

    /**
     * Execute the processor
     *
     * @return void
     */
    public function execute(): void
    {
        $this->getInstance()->execute();
    }
}
