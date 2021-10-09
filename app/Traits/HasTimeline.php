<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Arr;

trait HasTimeline
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
            $this->history ?? ['open' => ['state' => 'Awaiting Merchant Response', 'time' => $this->created_at]],
            "${from}",
            ['state' => $from->status(), 'time' => now()]
        );

        $this->update(['state' => $state, 'history' => $history]);
    }
}
