<?php

declare(strict_types=1);

namespace App\Domains\Orders\Handlers\Processors;

use App\Domains\Orders\Handlers\OrderProcessor;

class FailedProcessor extends OrderProcessor
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
     * @return string
     */
    public function execute(): string
    {
        return 'failed processor';
    }
}
