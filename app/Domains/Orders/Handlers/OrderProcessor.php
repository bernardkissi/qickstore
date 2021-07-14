<?php

declare(strict_types=1);

namespace App\Domains\Orders\Handlers;

abstract class OrderProcessor
{
    /**
     * Returns a processor to handle the order.
     *
     * @return OrderProcessor
     */
    abstract public function processor(): OrderProcessor;


    public function execute(): string
    {
        return $this->processor()->execute();
    }
}
