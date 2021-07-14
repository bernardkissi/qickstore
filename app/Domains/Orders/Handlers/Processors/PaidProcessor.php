<?php

declare(strict_types=1);

namespace App\Domains\Orders\Handlers\Processors;

use App\Domains\Orders\Handlers\OrderProcessor;

class PaidProcessor extends OrderProcessor
{
    /**
     * Returns a new instance of the processor.
     *
     * @return OrderProcessor
     */
    public function processor(): OrderProcessor
    {
        return new self();
    }

    /**
     * Process the order.
     *
     * @return void
     */
    public function execute(): string
    {
        return 'paid processor';
    }
}
