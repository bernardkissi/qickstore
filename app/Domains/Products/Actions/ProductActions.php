<?php
 
declare(strict_types=1);

namespace App\Domains\Products\Actions;

use App\Domains\Products\Models\Product;
use App\Domains\Products\Resource\ProductResource;
use App\Domains\Products\Resource\SingleProductResource;
use App\Domains\Products\Scopes\Filters\CategoryScope;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

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
        $product = Product::find(353);
        $product->load(['sku.stockCount', 'variations.sku.StockCount', 'options.types']);
        
        return $product;
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
