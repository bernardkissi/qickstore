<?php

declare(strict_types=1);

namespace Domain\Orders\Traits;

trait HasTransitionTimeline
{
    /**
     * Updates the state transistion history of the inherited model
     *
     * @param string $state
     *
     * @return void
     */
    public function updateTimeline(string $state): void
    {
        $from = $this->getOriginal('state');
        $initialState = $this->history ?? [['state' => 'pending', 'time' => $this->created_at]];
        $history = array_push($initialState, ['state' => $state, 'time' => now()]);

        $this->update(['state' => $state, 'history' => $initialState]);
    }
}
