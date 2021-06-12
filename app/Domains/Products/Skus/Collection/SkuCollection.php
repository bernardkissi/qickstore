<?php

namespace App\Domains\Products\Skus\Collection;

use Illuminate\Database\Eloquent\Collection;

class SkuCollection extends Collection
{
    public function toCollect()
    {
        return $this->keyBy('id')->map(function ($product) {
            return ['quantity' => $product->pivot->quantity ];
        })->toArray();
    }
}
