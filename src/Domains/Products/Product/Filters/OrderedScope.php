<?php

declare(strict_types=1);

namespace Domain\Products\Product\Filters;

use App\Helpers\Scopes\ScopeContract;
use Domain\Products\Product\Traits\FilterModes;
use Illuminate\Database\Eloquent\Builder;

class OrderedScope implements ScopeContract
{
    use FilterModes;
    /**
     * Filter products based on categories
     *
     * @param  Builder $builder
     * @param  string  $value
     *
     * @return Builder
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('stock', function ($builder) use ($value) {
            $builder->where('ordered', $this->mode($value), 1)->orderBy('stock', 'desc');
        });
    }
}
