<?php

declare(strict_types=1);

namespace Domain\User\Traits;

use Domain\User\Address\Address;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAddress
{
    /**
     * Return the user's addresses.
     *
     * @return MorphMany
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }
}
