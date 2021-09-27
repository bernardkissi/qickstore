<?php

declare(strict_types=1);

namespace Domain\Orders\Traits;

use Illuminate\Support\Arr;

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
        $history = Arr::add(
            $this->updated_from ?? ['pending' => ['state' => 'pending', 'time' => $this->created_at]],
            "${from}",
            ['state' => $from, 'time' => now()]
        );

        $this->update(['state' => $state, 'updated_from' => $history]);
    }
}
