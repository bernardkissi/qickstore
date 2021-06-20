<?php

declare(strict_types=1);

namespace App\Domains\Products\Skus\Traits;

trait TrackStock
{
    /**
     * Checks a product is in stock
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
     * Returns minstock count
     *
     * @param int $count
     *
     * @return int
     */
    public function minStock(int $count): int
    {
        return (int) min($this->stockCount->stock, $count);
    }

    /**
     * Determine the minimum allowable stock
     *
     * @param int $value
     *
     * @return int
     */
    private function calcLowStockValue(int $value): int
    {
        $level = 90 / 100 * $value;
        return (int) $value -= $level;
    }
}
