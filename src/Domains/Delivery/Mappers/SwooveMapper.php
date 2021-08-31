<?php

declare(strict_types=1);

namespace Domain\Delivery\Mappers;

use App\Helpers\Transitions\TransitionMapper;
use Domain\Delivery\States\Assigned;
use Domain\Delivery\States\Delivering;
use Domain\Delivery\States\PickedUp;
use Domain\Delivery\States\PickingUp;
use Domain\Orders\States\Delivered;

class SwooveMapper implements TransitionMapper
{
    /**
     * Map swoove states to internal delivery states.
     *
     * @param string $state
     * @return string
     */
    public function map(string $state): string
    {
        $result = match ($state) {
            'Assigned' => Assigned::$name,
            'PickingUp' => PickingUp::$name,
            'PickedUp' => PickedUp::$name,
            'Delivering' => Delivering::$name,
            'Delivered' => Delivered::$name,
            'Ended' => 'oh wow'
        };

        return $result;
    }
}
