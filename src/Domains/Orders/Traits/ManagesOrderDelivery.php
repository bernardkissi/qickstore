<?php

declare(strict_types=1);

namespace Domain\Orders\Traits;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Collection;

trait ManagesOrderDelivery
{
    public function groupItemsByDelivery(): Collection
    {
        $order = $this->load(['orderable','products', 'products.skuable' => function (MorphTo $morphTo) {
            $morphTo->morphWith([
                Product::class,
                ProductVariation::class => ['product:id,name'],
            ]);
        }]);

        return $order['products']->groupBy(function ($item) {
            return $item['skuable']['type'];
        });
    }
}
