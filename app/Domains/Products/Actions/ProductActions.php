<?php
 
declare(strict_types=1);

namespace App\Domains\Products\Actions;

use App\Domains\Filters\Models\Filter;
use App\Domains\Products\Models\Product;
use App\Domains\Products\Resource\ProductResource;
use App\Domains\Products\Resource\SingleProductResource;
use App\Domains\Products\Scopes\Filters\CategoryScope;
use App\Domains\Properties\Models\Property;
use App\Domains\Properties\Resource\PropertyResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductActions
{
    
    public function storeProduct()
    {
    }


    /**
     * Return all products loaded relationships
     *
     * @return  Illuminate\Pagination\LengthAwarePaginator;
     */
    public function products(): LengthAwarePaginator
    {
        $products = Product::with('sku', 'sku.stockCount', 'options', 'options.types', 'variations')
            ->withFilter($this->scopes())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
 
        return $products;
    }


    /**
     * Returns a single product
     *
     * @param  App\Domains\Products\Models\Product $product
     * @return App\Domains\Products\Models\Product;;
     */
    public function product(): Product
    {
        $product = Product::find(1);
        $product->load(['sku.stockCount', 'variations.sku.StockCount', 'options.types', 'properties']);
        
        return $product;
    }


    public function demo(): array
    {

        $filters =  Filter::select(['property_name', 'property_value'])->get();

        $collection = collect($filters)->unique(function ($item) {
            return [ $item['property_name'] => $item['property_value']];
        })
        ->mapToGroups(function ($item) {
            return [$item['property_name'] => $item['property_value']];
        });

        return $collection->all();


        // // Property::distinct()->select('property_name')->groupBy('property_name')->get();

        // $collect = DB::table('filters')
        //     ->select('property_name', 'property_value')
        //     ->distinct()
        //     ->get();

        //   $arr = collect($collect)->groupBy('property_name');

        // foreach ($arr as $key => $value) {
        //     echo $key;
        // }

        // return collect(PropertyResource::collection(Property::all())->distinct()->groupBy('property_name'));
    }

    //todos
    //1. create product
    //2. add to variations
    //3. set sku for products
    //4. create limited or unlimited stock

    /**
     * Searchable scopes for products
     *
     * @return array
     */
    protected function scopes(): array
    {
        return [ 'category' => new CategoryScope() ];
    }
}
