<?php

declare(strict_types=1);

namespace Domain\Disputes\Processors;

use App\Helpers\Processor\Processor;
use Domain\Disputes\Dispute;
use Domain\Refunds\Actions\ProcessRefund;

class AcceptedProcessor extends Processor
{
    /**
     * Class constructor
     *
     * @var Dispute $order
     */
    public function __construct(public Dispute $dispute)
    {
    }

    /**
     * Returns a new instance of the processor.
     *
     * @return Processor
     */
    public function getInstance(): Processor
    {
        return new self($this->dispute);
    }

    /**
     * Process the order.
     *
     * @return void
     */
    public function execute(): void
    {
        ProcessRefund::refund($this->dispute);
    }
}
