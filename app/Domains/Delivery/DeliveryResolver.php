<?php

namespace App\Domains\Delivery;

use App\Domains\Delivery\Contract\DeliveryResolvableContract;

class DeliveryResolver implements DeliveryResolvableContract
{
    /**
     * Return a the desired delivery provider
     *
     * @param string $string
     *
     * @return void
     */
    public function provide(string $string)
    {
        return match ($string) {
            'swoove' => config('modules.deliveries.swoove'),
            'hosted' => config('modules.deliveries.hosted'),
            'files' => config('modules.deliveries.files'),
            'default' => throw new \Exception('sorry no agent')
        };
    }
}
