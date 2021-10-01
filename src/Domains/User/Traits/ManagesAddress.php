<?php

declare(strict_types=1);

namespace Domain\User\Traits;

use Domain\User\Address\Address;

trait ManagesAddress
{
    /**
     * Create a new address.
     *
     * @param array|null $address
     * @param integer|null $addressId
     * @return Address
     */
    public function createAddress(?array $address, ?int $addressId): Address
    {
        $address = $this->addresses->select('id')
            ->where('id', $addressId)->firstOr(function () use ($address) {
                return $this->addresses()->create([
                    'city' => $address['city'],
                    'region' => $address['region'],
                    'country' => $address['country'],
                    'state' => $address['state'],
                    'digital_address' => $address['digital_address'],
                    'country' => $address['country'],
                    'firstname' => $address['firstname'],
                    'lastname' => $address['lastname'],
                    'phone' => $address['phone'],
                    'email' => $address['email'],
                ])->id;
            });

        return $address;
    }
}
