<?php

declare(strict_types=1);

namespace Domain\Subscription\Processors;

use App\Helpers\Processor\Processor;
use Domain\Subscription\ProductSubscription;

class PendingProcessor extends Processor
{
    /**
     * Class constructor
     *
     * @var ProductSubscription $subscription
     */
    public function __construct(public ProductSubscription $subscription)
    {
    }

    /**
     * Returns a new instance of the processor.
     *
     * @return Processor
     */
    public function getInstance(): Processor
    {
        return new self($this->subscription);
    }

    /**
     * Process the order.
     *
     * @return void
     */
    public function execute(): void
    {
    }
}
