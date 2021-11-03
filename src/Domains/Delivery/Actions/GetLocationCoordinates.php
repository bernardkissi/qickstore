<?php

declare(strict_types=1);

namespace Domain\Delivery\Actions;

use Spatie\Geocoder\Geocoder;

class GetLocationCoordinates
{
    /**
     * Fetches the coordinates of a location.
     *
     * @param string $location
     *
     * @return array
     */
    public static function fetch(string $location): array
    {
        $client = new \GuzzleHttp\Client();

        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));
        $geocoder->setCountry(config('geocoder.country', 'GH'));
        $results = $geocoder->getCoordinatesForAddress($location);

        return [
            'lat' => $results['lat'],
            'lng' => $results['lng'],
            'address' => $results['formatted_address'],
        ];
    }
}
