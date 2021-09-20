<?php

declare(strict_types=1);

namespace Domain\Delivery\Mappers;

use App\Helpers\Transitions\TransitionMapper;
use Domain\Delivery\States\Assigned;
use Domain\Delivery\States\Delivering;
use Domain\Delivery\States\PickedUp;
use Domain\Delivery\States\PickingUp;
use Domain\Orders\States\Delivered;

class TracktryMapper implements TransitionMapper
{
    /**
     * Map swoove states to internal delivery states.
     *
     * @param string $state
     *
     * @return string
     */
    public function map(string $state): string
    {
        return match ($state) {
            'Shipped' => Assigned::$name,
            'PickingUp' => PickingUp::$name,
            'PickedUp' => PickedUp::$name,
            'drop off' => Delivering::$name,
            'dropped off' => Delivered::$name,
            'Ended' => 'oh wow'
        };
    }
}
