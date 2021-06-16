<?php


namespace App\Domains\Delivery;

use App\Domains\Delivery\Contract\DeliveryResolvableContract;
use App\Domains\Delivery\Services\SwooveDelivery;

class DeliveryResolver implements DeliveryResolvableContract
{
    /**
     * Return a the desired delivery provider
     *
     * @param string $string
     * @return void
     */
    public function provide(string $string)
    {
        $service = match ($string) {
            'swoove' => config('modules.deliveries.swoove'),
            'hosted' => config('modules.deliveries.hosted'),
            'files' =>  config('modules.deliveries.files'),
            'default' => throw new \Exception('sorry no agent')
        };

        return $service;
    }
}
