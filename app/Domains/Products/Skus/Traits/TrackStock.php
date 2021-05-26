<?php

declare(strict_types=1);

namespace App\Domains\Products\Skus\Traits;

trait TrackStock
{
    /**
     * Checks in product is in stock
     *
     * @return bool
     */
    public function inStock(): bool
    {
        return $this->stockCount->stock > 0 || $this->unlimited;
    }

    /**
     *  Determine whether product is low stock
     *
     * @return bool
     */
    public function onlowStock(): bool
    {
        return $this->stockCount->stock <= $this->min_stock && ! $this->unlimited;
    }

    /**
     *  Set Minimum allowable stock
     *
     * @param int $value
     *
     * @return void
     */
    public function setMinStockAttribute(int $value): void
    {
        $this->attributes['min_stock'] = $this->calcLowStockValue($value);
    }

    /**
     * Determine the minimum allowable stock
     *
     * @param int $value
     *
     * @return void
     */
    private function calcLowStockValue(int $value): int
    {
        $level = 90 / 100 * $value;
        return (int) $value -= $level;
    }



    public function minStock($count)
    {
        return min($this->stockCount(), $count);
    }
}
