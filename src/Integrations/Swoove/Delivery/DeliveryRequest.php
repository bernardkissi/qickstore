<?php

namespace Integration\Swoove\Delivery;

use const Cerbero\Dto\CAMEL_CASE_ARRAY;
use Domain\Delivery\Dtos\DeliveryDto;

trait DeliveryRequest
{
    /**
     * Prepare request data to swoove ddelivery endpoint
     *
     * @param Order $order
     *
     * @return array
     */
    public static function data(array $order): array
    {
        $data = [
            'pickup' => [
                'type' => 'LATLNG',
                'value' => 'string',
                'contact' => [
                    'name' => 'bernard kissi',
                    'mobile' => '05430637089',
                    'email' => 'bernardkissi@gmail.com',
                ],
                'country_code' => 'GH',
                'lat' => 6.663449,
                'lng' => -1.662625,
                'location' => 'Marina Mall, Accra',
            ],
            'dropoff' => [
                'type' => 'LATLNG',
                'value' => 'string',
                'contact' => [
                    'name' => 'Derricl Kissi',
                    'mobile' => '0243343810',
                    'email' => 'derricl@gmail.com',
                ],
                'country_code' => 'GH',
                'lat' => 6.691877,
                'lng' => -1.62872,
                'location' => 'Achimota Mall, Accra',
            ],
            'items' => [
                ['itemName' => 'foo', 'itemQuantity' => 2, 'itemCost' => 300],
            ],
            'vehicle_type' => 'MOTORCYCLE',
        ];

        return DeliveryDto::make($data, CAMEL_CASE_ARRAY)->toArray();
    }
}
