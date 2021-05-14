<?php
 
declare(strict_types=1);

namespace App\Domains\Products\Actions;

use App\Domains\Products\Models\Product;
use App\Domains\Products\Scopes\Filters\CategoryScope;
use Illuminate\Pagination\LengthAwarePaginator;

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
     * @return Illuminate\Pagination\LengthAwarePaginator;
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
     * @return App\Domains\Products\Models\Product;
     */
    public function getProduct(Product $product): Product
    {
        $product->load(['sku.stockCount', 'variations.sku.StockCount', 'options.types', 'properties']);
        
        return $product;
    }

    /**
     * Store product variations
     *
     * @param  App\Domains\Products\Models\Product $product
     * @param  array                               $variants
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
