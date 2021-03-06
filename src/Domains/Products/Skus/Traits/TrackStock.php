<?php

declare(strict_types=1);

namespace Domain\Products\Skus\Traits;

trait TrackStock
{
    /**
     * Checks a product is in stock
     *
     * @return bool
     */
    public function inStock(): bool
    {
        return $this->stockCount->in_stock > 0 || $this->unlimited === true;
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
        if ($this->unlimited) {
            return $count;
        }
        return (int) min($this->stockCount->stock, $count);
    }

    /**
     * Determine the minimum allowable stock
     *
     * @param int $value
     *
     * @return int
     */
    private function calcLowStockValue(int $value = 1): int
    {
        $level = 90 / 100 * $value;
        return (int) $value -= $level;
    }
}
