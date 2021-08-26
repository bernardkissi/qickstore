<?php

declare(strict_types=1);

namespace Domain\Products\Product\Scopes\Filters;

use Domain\Products\Product\Scopes\ScopeContract;
use Illuminate\Database\Eloquent\Builder;

class CategoryScope implements ScopeContract
{
    /**
     * Filter products based on categories
     *
     * @param  Illuminate\Database\Eloquent\Builder $builder
     * @param  string  $value
     *
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder, $value): Builder
    {
        return $builder->whereHas('categories', function ($builder) use ($value) {
            $builder->where('slug', $value);
        });
    }
}
