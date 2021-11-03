<?php

declare(strict_types=1);

namespace Domain\Disputes\Traits;

trait CanTransitionDispute
{
    /**
     * @param string $state
     *
     * @return bool
     */
    public function transitionDisputeTo(string $state): bool
    {
        if ($this->state->canTransitionTo($state)) {
            $this->state->transitionTo($state);
            $this->updateTimeline($state);
            return true;
        }
        return false;
    }
}
