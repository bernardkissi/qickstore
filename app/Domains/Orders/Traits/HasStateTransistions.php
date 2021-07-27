<?php

declare(strict_types=1);

namespace App\Domains\Orders\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait HasStateTransistions
{

    /**
     * Returns all transitions made to the order.
     *
     * @return void
     */
    public function transistionHistory()
    {
        $states = $this->getStates()->flatten();
        $transitionableStates = $this->state->transitionableStates();
        $transitions = $this->getNextTransitionables($transitionableStates);
        $finalTrans = collect($transitions)->merge($transitionableStates)->flatten()->unique()->toArray();
        $filtered = $states->diff($finalTrans);

        $results = $this->filterTransitions($filtered);
        return $this->getHistory($results);
    }



    /**
     * Returns a list of the transition history in desc order.
     *
     * @param Collection $transitions
     * @return void
     */
    protected function getHistory(Collection $transitions): Collection
    {
        return $transitions->map(function ($value) {
            return [ 'name' => $value, 'order' => $this->generateOrder($value) ];
        })->sortBy('order', SORT_NATURAL)->pluck('name');
    }


    /**
     * Undocumented function
     *
     * @param Collection $transitionableStates
     * @return void
     */
    protected function getNextTransitionables(array $transitionableStates): array
    {
        return collect($transitionableStates)->map(function ($state) {
            $stateClassName = Str::ucfirst($state);
            $state = "App\\Domains\\Orders\\States\\{$stateClassName}";
            $stateClass = new $state($this);
            return $stateClass->transitionableStates();
        })->all();
    }


    /**
     * Filters transition history for the current state
     *
     * @param Collection $collection
     * @return Collection
     */
    protected function filterTransitions(Collection $collection): Collection
    {
        if ($this->failed_at === null) {
            $collection = $collection->reject(fn ($value) => $value == 'failed');
        }

        if ($this->cancelled_at === null) {
            $collection = $collection->reject(fn ($value) => $value == 'cancelled');
        }

        if ($this->cancelled_at !== null) {
            $collection = collect([$this->getDefaultStateFor('state'), (string) $this->state]);
        }

        if ($this->order->service === 'digital') {
            $collection= $collection->reject(fn ($value) => $value == 'shipped');
        }

        return $collection;
    }
}

    // const PENDING = 1;
    // const CANCELLED = 2;
    // const FAILED = 3;
    // const PAID = 4;
    // const SHIPPED = 5;
    // const DELIVERED = 6;
    // const REFUNDED = 7;


// /**
//      * Returns state arrangement order number
//      *
//      * @param string $state
//      * @return void
//      */
//     public function generateOrder(string $state): int
//     {
//         return match ($state) {
//             'pending' => self::PENDING,
//             'cancelled' => self::CANCELLED,
//             'failed' => self::FAILED,
//             'paid' => self::PAID,
//             'shipped' => self::SHIPPED,
//             'delivered' => self::DELIVERED,
//             'refunded' => self::REFUNDED,
//         };
//     }
