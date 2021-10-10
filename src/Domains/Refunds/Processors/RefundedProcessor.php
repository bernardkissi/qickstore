<?php

declare(strict_types=1);

namespace Domain\Disputes\Processors;

use App\Helpers\Processor\Processor;
use Domain\Disputes\Dispute;
use Domain\Refunds\Refund;

class RefundedProcessor extends Processor
{
    /**
     * Class constructor
     *
     * @var Dispute $order
     */
    public function __construct(public Refund $refund)
    {
    }

    /**
     * Returns a new instance of the processor.
     *
     * @return Processor
     */
    public function getInstance(): Processor
    {
        return new self($this->refund);
    }

    /**
     * Process the order.
     *
     * @return void
     */
    public function execute(): void
    {
        dump('update dispute state to resolved');
    }
}
