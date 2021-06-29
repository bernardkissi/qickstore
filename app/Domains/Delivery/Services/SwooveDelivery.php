<?php

namespace App\Domains\Delivery\Services;

use App\Domains\Delivery\Contract\DeliverableProviderContract;
use App\Domains\Delivery\Traits\SwooveTransfer;
use App\Domains\Delivery\Transporters\Swoove\CreateDelivery;
use App\Domains\Orders\Model\Order;
use Illuminate\Http\Request;

class SwooveDelivery implements DeliverableProviderContract
{
    use SwooveTransfer;

    public static function init(): static
    {
        return new static();
    }
    /**
     * di9spatch the delivery to the agent
     *
     * @return void
     */
    public static function dispatch(Request $request): array
    {
        $response  = CreateDelivery::build()
                        ->withData(static::data($request))
                        ->send()
                        ->json();
        return $response;
    }

    /**
     * Get the delivery information of the order
     *
     * @param Order $order
     *
     * @return array
     */
    public function deliveryInfo(Order $order): array
    {
        return ['user', 'information'];
    }
}
