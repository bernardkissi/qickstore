<?php

declare(strict_types=1);

namespace App\Domains\Products\Attributes\Actions;

use App\Domains\Products\Attributes\Models\Attribute;
use App\Domains\Products\Attributes\Resource\AttributeResource;
use App\Domains\Products\Categories\Models\Category;
use App\Domains\Products\Product\Models\Product;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class AttributeActions
{
    /**
     *  Store product filters
     *
     * @param  Product $product
     * @param  array   $arr
     *
     * @return void
     */
    public function storeFilters(Product $product, array $arrs): void
    {
        collect(array_keys($arrs))->map(function ($key) use ($arrs, $product) {
            $product->filters()->createMany($this->setFilters($arrs, $key));
        });
    }

    /**
     * Return filters under a category
     *
     * @param  App\Domains\Categories\Models\Category $category
     *
     * @return array
     */
    public function getCategoryFilters(Category $category): array
    {
        return $this->groupFilters(AttributeResource::collection($category->filters));
    }

    /**
     * Delete a filter
     *
     * @param  App\Domains\Filters\Models\Filter $filter
     *
     * @return void
     */
    public function deleteFilter(Attribute $filter): void
    {
        $filter->delete();
    }

    /**
     * Edit filter properties
     *
     * @param  App\Domains\Filters\Models\Filter $filter
     * @param  array $property
     *
     * @return bool
     */
    public function editFilter(Attribute $filter, string $property): bool
    {
        return $filter->update(
            [
                'property_value' => $property->value,
                'property_name' => $property->name === null ? $filter->property_name : $property->name,
            ]
        );
    }

    /**
     * Grouping filters
     *
     * @param  Illuminate\Http\Resources\Json\AnonymousResourceCollection $filters
     *
     * @return array
     */
    private function groupFilters(AnonymousResourceCollection $filters): array
    {
        $collection = collect($filters)->unique(function ($item) {
            return [ $item['property_name'] => $item['property_value']];
        })
            ->mapToGroups(function ($item) {
                return [$item['property_name'] => $item['property_value']];
            });

        return $collection->all();
    }

    /**
     *  Prepare product filters for storing
     *
     * @param array  $arr
     * @param string $key
     *
     * @return array
     */
    private function setFilters(array $arr, string $key): array
    {
        $filters = [];
        foreach ($arr[$key] as $filter) {
            $filters[] = [
                'property_name' => Str::of($key)->lower(),
                'property_value' => $filter,
            ];
        }
        return $filters;
    }
}
