<?php

declare(strict_types=1);

namespace Domain\Orders\Traits;

trait ManageSubscription
{
    public function fetchSubscriableProducts()
    {
        return $this->load(['products' => fn ($query) => $query->select('skuable_type', 'skuable_id')
            ->where('skuable_type', '=', 'Subscription'),
            'products.skuable:id,plan_code',
        ]);
    }

    public function fetchSubscribedProduct()
    {
        return $this->load([
            'products' => fn ($query) => $query->where('skuable_type', 'Subscription'),
            'products.skuable',
        ])->products->first();
    }
}
