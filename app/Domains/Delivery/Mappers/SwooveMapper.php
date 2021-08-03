<?php

declare(strict_types=1);

namespace App\Domains\Delivery\Mappers;

use App\Core\Helpers\Transitions\TransitionableMapper;
use App\Domains\Delivery\States\Assigned;
use App\Domains\Delivery\States\Delivered;
use App\Domains\Delivery\States\Delivering;
use App\Domains\Delivery\States\PickedUp;
use App\Domains\Delivery\States\PickingUp;

class SwooveMapper implements TransitionableMapper
{
    /**
     * Map swoove transition state to
     *
     * @param string $state
     * @return string
     */
    public function map(string $state): string
    {
        $result = match($state) {

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
