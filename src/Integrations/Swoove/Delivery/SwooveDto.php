<?php

declare(strict_types=1);

namespace Integration\Swoove\Delivery;

use Domain\Delivery\Dtos\DeliveryDto;
use const Cerbero\Dto\CAMEL_CASE_ARRAY;

class SwooveDto
{
    /**
     * Swoove API transfer Object
     *
     * @param array $data
     * @return array
     */
    private static function transferObject(array $data): array
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
                'lat' => 5.563102400000001,
                'lng' =>  -0.1813863,
                'location' => 'F739, 2 Oxford St, Accra, Ghana',
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
                'lat' => 5.6676151,
                'lng' => -0.1650122,
                'location' => 'Rawlings Circle, Madina,Ghana',
            ],
            'items' => [
                [
                    'itemName' => 'foo',
                    'itemQuantity' => 2,
                    'itemCost' => 300,
                    'itemWeight' => 1,
                    'is_fragile' => true,
                ],
            ],
            'vehicle_type' => 'MOTORCYCLE',
            'instructions' => '',
            'reference' => '',
            'estimate_id' => '',
        ];

        return DeliveryDto::make($data, CAMEL_CASE_ARRAY)->toArray();
    }

    /**
    * Prepare the data to be sent to the Estimate endpoint.
    *
    * @param array $data
    * @return array
    */

    public static function estimateTransferObject(array $data): array
    {
        return static::transferObject($data);
    }

    /**
     * Prepare the data to be sent to the delivery API.
     *
     * @param array $data
     * @return array
     */
    public static function deliveryTransferObject(array $data): array
    {
        return static::transferObject($data);
    }
}
