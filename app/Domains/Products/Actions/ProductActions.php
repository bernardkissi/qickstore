<?php
 
declare(strict_types=1);

namespace App\Domains\Products\Actions;

use App\Domains\Products\Models\Product;
use App\Domains\Products\Scopes\Filters\CategoryScope;
use App\Domains\Skus\Model\Sku;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductActions
{
    public function createProduct(Request $data)
    {
        return tap(Product::create([

            'name' => $data['name'],
            'description' => $data['description'],
            'slug' => $data['slug'],
            'barcode' => $data['barcode'],
            
        ]), function (Product $product) use ($data) {
            return tap($product->sku()->create(['code' => $data['code'], 'price' => 1000, ]), function (Sku $sku) {
                $sku->stocks()->create(['quantity' => 20]);
            });
        });
    }

    /**
     * Return all products
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
     * Store product options
     *
     * @param Product $product
     * @param array $options
     * @return void
     */
    public function assignOptions(Product $product, array $options): void
    {
        $product->options()->syncWithoutDetaching($options);
    }

    /**
     * Store product variations
     *
     * @param  App\Domains\Products\Models\Product $product
     * @param  array $variants
     * @return void
     */
    public function createVariations(Product $product, array $variants): void
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
