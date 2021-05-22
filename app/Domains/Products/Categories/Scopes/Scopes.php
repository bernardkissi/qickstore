<?php

declare(strict_types=1);

namespace App\Domains\Products\Categories\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait Scopes
{
    /**
     * Scope to return parent categories
     *
     * @param  Builder $builder [description]
     *
     * @return void;
     */
    public function scopeCategories(Builder $builder): void
    {
        $builder->whereNull('parent_id');
    }

    /**
     * Scope to order categories in asc order
     *
     * @param  Builder $builder   Illuminate\Database\Eloquent\Builder
     * @param  string  $direction
     *
     * @return void
     */
    public function scopeOrdered(Builder $builder, $direction = 'asc'): void
    {
        $builder->orderBy('order', $direction);
    }
}
