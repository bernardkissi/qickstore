<?php

declare(strict_types=1);

namespace Domain\Delivery\Traits;

trait CanTransitionDelivery
{
    public function transitionDelivery(string $state)
    {
        if ($this->state->canTransitionTo($state)) {
            $this->state->transitionTo($state);
            $this->updateTimeline($state);
        }
    }
}
