<?php

declare(strict_types=1);

namespace App\Core\Helpers\Dispatchers;

abstract class Dispatcher
{
    /**
     * Returns a processor to handle the order.
     *
     * @return Dispatcher
     */
    abstract public function getInstance(): Dispatcher;

    /**
     * Execute the processor
     *
     * @return void
     */
    public function dispatch(): void
    {
        $this->getInstance()->dispatch();
    }
}
