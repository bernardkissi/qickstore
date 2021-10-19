<?php

declare(strict_types=1);

namespace Domain\Sales\Actions;

use Domain\Products\Product\Filters\CategoryScope;
use Domain\Products\Product\Filters\OrderedScope;
use Domain\Products\Product\Filters\StockScope;
use Domain\Products\Product\Product;

class FetchSalesProducts
{
    public static function get()
    {
        return Product::with(['sku'])
        ->withFilter(static::scopes())
        ->select(['id', 'name'])
        ->paginate(10);
    }

    /**
     * Searchable scopes for products
     *
     * @return array
     */
    public static function scopes(): array
    {
        return [
            'stock' => new StockScope(),
            'category' => new CategoryScope(),
            'ordered' => new OrderedScope()
        ];
    }
}
