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




        Generate filters
        ***************************

        $collection = collect($filters)->unique(function ($item) {
            return [ $item['property_name'] => $item['property_value']];
        })
        ->mapToGroups(function ($item) {
            return [$item['property_name'] => $item['property_value']];
        });

        return $collection->all();




         public function demo($filters)
    {

        // return Filter::select(['property_name', 'property_value'])->get();

        $collection = collect($filters)->unique(function ($item) {
            return [ $item['property_name'] => $item['property_value']];
        })
        ->mapToGroups(function ($item) {
            return [$item['property_name'] => $item['property_value']];
        });

        return $collection->all();
    }


    public function filterDemo()
    {
        $category = Category::find(11);
        return $this->demo(FilterResource::collection($category->filters));
    }


    public function filterOptionsDemo()
    {

        $arrs = [

            'me' => ['8GB', '4GB', '5GB'],
            'processor' => ['i5', 'i7', 'i9'],
        ];
        
        $keys = array_keys($arrs);
        
        // create option types
        $types = collect($keys)->map(function ($item) {
            return OptionType::create(['name' => $item, 'input_type' => 'dropdown']);
        });
       
       
        // create options with option type
        $options = collect($types)->map(function ($type) use ($arrs) {
            return $type->attributes()
                ->createMany($this->getOptions($arrs, $type->name));
        })
        ->collapse()
        ->pluck('id');


        //assign products with options
        $product = Product::find(1); //demo product
        $product->options()->syncWithoutDetaching($options);


        //generating product filters
        $filters = collect($keys)->map(function ($key) use ($arrs, $product) {
            return $product->filters()
                ->createMany($this->getFilters($arrs, $key));
        });
     


        return ['options' => $options, 'filters' => $filters];
    }
   


    private function getOptions($arr, $key)
    {
        $options = [];
        foreach ($arr[$key] as $option) {
            $options[] = ['name' => $option];
        }
        return $options;
    }


    private function getFilters($arr, $key)
    {

        $filters= [];
        foreach ($arr[$key] as $filter) {
            $filters[] = [
                'property_name' => Str::of($key)->lower(),
                'property_value' => $filter
            ];
        }
        return $filters;
    }




////products

<?php
 
declare(strict_types=1);

namespace App\Domains\Products\Actions;

use App\Domains\Categories\Models\Category;
use App\Domains\Filters\Models\Filter;
use App\Domains\Filters\Resource\FilterResource;
use App\Domains\Options\Models\OptionType;
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
use Illuminate\Support\Str;

class ProductService
{

    //todos
    //1. create product
    //2. add to variations
    //3. set sku for products
    //4. create limited or unlimited stock
    
    public function storeProduct()
    {
    }

    /**
     * Return all products loaded relationships
     *
     * @return  Illuminate\Pagination\LengthAwarePaginator;
     */
    public function getProducts(): LengthAwarePaginator
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
    public function getProduct(): Product
    {
        $product = Product::find(1);
        $product->load(['sku.stockCount', 'variations.sku.StockCount', 'options.types', 'properties']);
        
        return $product;
    }

    /**
     * Store product variations
     *
     * @param  App\Domains\Products\Models\Product $product
     * @param  array   $variants
     * @return void
     */
    public function storeVariations(Product $product, array $variants): void
    {
        $product->variations()->createMany($variants);
    }

    

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









        