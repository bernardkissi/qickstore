<?php

namespace App\Domains\Delivery\Traits;

use App\Domains\Delivery\Dtos\DeliveryDto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use const Cerbero\Dto\CAMEL_CASE_ARRAY;

trait SwooveTransfer
{
    /**
     * Prepare user payment information
     *
     * @param Request $request
     *
     * @return PaymentDto
     */
    public static function data(Request $request): array
    {
        $data = [
                    'pickup'=>[
                        'type'=>'LATLNG',
                        'value'=>'string',
                        'contact'=>[
                        'name' => 'bernard kissi',
                        'mobile'=>"05430637089",
                        'email'=>'bernardkissi@gmail.com'
                        ],
                        'country_code'=>'GH',
                        'lat' => 6.663449,
                        'lng'=> -1.662625,
                        'location'=>'Opoku Ware Senior High'
                    ],
                    'dropoff' => [
                        'type'=> 'LATLNG',
                        'value' => 'string',
                        'contact' => [
                        'name' => 'Derricl Kissi',
                        'mobile'=>"0243343810",
                        'email'=>'derricl@gmail.com'
                        ],
                        'country_code' => "GH",
                        'lat'=> 6.691877,
                        'lng'=> -1.62872,
                        'location'=> 'Adum'
                    ],
                    'items'=> [
                        ['itemName' => 'foo', 'itemQuantity' => 2, 'itemCost' => 300],
                    ],
                    'vehicle_type' => 'MOTORCYCLE'
                ];

        return DeliveryDto::make($data, CAMEL_CASE_ARRAY)->toArray();
    }
}
