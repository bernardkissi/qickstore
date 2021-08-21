<?php

declare(strict_types=1);

namespace App\Domains\Delivery\Traits;

trait CanRankStates
{
    public function rankState(string $state): int
    {
        return match ($state) {
            'pending'    => 1,
            'failed'     => 0,
            'assigned'   => 2,
            'pickingup'  => 3,
            'pickedup'   => 4,
            'delivering' => 5,
            'delivered'  => 6,
        };
    }
}
