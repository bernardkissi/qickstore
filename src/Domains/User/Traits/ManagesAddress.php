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
     * @param int|null $addressId
     *
     * @return Address
     */
    public function createAddress(?array $address, ?int $addressId): Address
    {
        if ($addressId) {
            $addr = $this->addresses->where('id', $addressId)->first();
        }

        if ($address) {
            $addr = $this->addresses()->create([
                'city' => $address['city'],
                'full_address' => $address['full_address'],
                'country' => $address['country'],
                'state' => $address['state'] ?? null,
                'digital_address' => $address['digital_address'] ?? null,
                'country' => $address['country'] ?? null,
                'firstname' => $address['firstname'],
                'lastname' => $address['lastname'],
                'phone' => $address['phone'],
                'email' => $address['email'],
            ]);
        }
        return $addr;
    }
}
