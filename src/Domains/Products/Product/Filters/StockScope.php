<?php

declare(strict_types=1);

namespace Domain\Products\Product\Filters;

use App\Helpers\Scopes\ScopeContract;
use Domain\Products\Product\Traits\FilterModes;
use Domain\Products\Stocks\StockView;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class StockScope implements ScopeContract
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
            $builder->where('stock', $this->mode($value), $this->getMedian())->orderBy('stock', 'desc');
        });
    }

    public function getMedian(): int
    {
        return DB::table('product_stock_view')
                ->select('stock')
                ->get()
                ->median('stock');
    }
}
