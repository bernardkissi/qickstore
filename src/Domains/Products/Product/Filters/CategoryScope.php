<?php

declare(strict_types=1);

namespace Domain\Products\Product\Filters;

use App\Helpers\Scopes\ScopeContract;
use Illuminate\Database\Eloquent\Builder;

class CategoryScope implements ScopeContract
{
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
        return $builder->whereHas('categories', function ($builder) use ($value) {
            $builder->where('slug', $value);
        });
    }
}
