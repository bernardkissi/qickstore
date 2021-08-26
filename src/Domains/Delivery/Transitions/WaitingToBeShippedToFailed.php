<?php

declare(strict_types=1);

namespace Domain\Delivery\Transitions;

use Domain\Delivery\Delivery;
use Domain\Delivery\States\Failed;
use Spatie\ModelStates\Transition;

class WaitingToBeShippedToFailed extends Transition
{
    public function __construct(public Delivery $delivery, public string $error)
    {
    }

    public function handle()
    {
        $this->delivery->state = new Failed($this->order);
        // $this->delivery->failed_at = now(); //TODO Add failed_at column to deliveries table
        $this->delivery->error = $this->error;
        $this->delivery->save();
    }
}
