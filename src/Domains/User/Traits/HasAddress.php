<?php

declare(strict_types=1);

namespace Domain\User\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasAddress
{
    /**
     * Return the user's addresses.
     *
     * @return HasMany
     */
    public function addresses(): MorphMany
    {
        return $this->morphMany(Comment::class, 'addressable');
    }
}
