<?php

namespace App\Helpers\Scopes;

use Illuminate\Database\Eloquent\Builder;

interface ScopeContract
{
    /**
     * Undocumented function
     *
     * @param Builder $builder
     * @param string $value
     *
     * @return void
     */
    public function apply(Builder $builder, string $value): Builder;
}
