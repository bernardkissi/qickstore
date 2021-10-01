<?php

declare(strict_types=1);

namespace Domain\User\Address\Actions;

use Domain\User\Address\Address;

class AddressCreate
{
    public static function createAddress(array $data)
    {
        Address::create([
            'city' => $data['city'],
            'region' => $data['region'],
            'country' => $data['country'],
            'state' => $data['state'],
            'digital_address' => $data['digital_address'],
            'country' => $data['country'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone' => $data['phone'],
            'email' => $data['email'],
        ]);
    }
}
