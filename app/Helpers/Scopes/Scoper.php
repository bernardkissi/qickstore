<?php

declare(strict_types=1);

namespace App\Helpers\Scopes;

use App\Helpers\Scopes\ScopeContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class Scoper
{
    /**
     * Class Constructor
     *
     * @param Illuminate\Http\Request; $request
     */
    public function __construct(public Request $request)
    {
    }

    /**
     *  Applying  all scopes applied
     *
     * @param  Builder $builder
     * @param  array   $scopes
     *
     * @return Builder
     */
    public function apply(Builder $builder, array $scopes): Builder
    {
        foreach ($this->limitscopes($scopes) as $key => $scope) {
            if (! $scope instanceof ScopeContract) {
                continue;
            }

            $scope->apply($builder, $this->request->get($key));
        }

        return $builder;
    }

    /**
     * Limiting scopes to those in array only
     *
     * @param  array  $scopes
     *
     * @return array
     */
    protected function limitscopes(array $scopes): array
    {
        return Arr::only($scopes, array_keys($this->request->all()));
    }
}
