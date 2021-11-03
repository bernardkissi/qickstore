<?php

declare(strict_types=1);

namespace Domain\Products\Skus\Traits;

trait CanBeBundled
{
    /**
     * Calculates product discounted price
     *
     * @return int
     */
    public function calcDiscountPrice(): int|float
    {
        $difference = round($this->price * $this->pivot->discount / 100);
        return $this->price - $difference;
    }
}
