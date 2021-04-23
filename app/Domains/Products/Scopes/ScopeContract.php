<?php


namespace App\Domains\Products\Scopes;

use Illuminate\Database\Eloquent\Builder;

interface ScopeContract
{
	/**
	 * Scoping contract method
	 * 
	 * @param  Builder $builder 
	 * @param  [type]  $value   
	 * @return [type]           
	 */
    public function apply(Builder $builder, $value);
}
