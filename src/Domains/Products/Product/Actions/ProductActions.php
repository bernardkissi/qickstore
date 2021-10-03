<?php

declare(strict_types=1);

namespace Domain\Products\Product\Actions;

use Domain\Products\Product\Product;
use Domain\Products\Product\ProductVariation;
use Domain\Products\Product\Scopes\Filters\CategoryScope;
use Domain\Products\Skus\Sku;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ProductActions
{
    /**
     * Create a product in store
     *
     * @param Request $data
     *
     * @return void
     */
    public function createProduct(Request $request)
    {
        return tap(Product::create([

            'name' => $request['name'],
            'description' => $request['description'],
            'slug' => Str::slug($request['name']),
            'barcode' => $request['barcode'],

        ]), function (Product $product) use ($request) {
            $this->syncProductSkuStock($product, $request['meta']);
        });
    }

    /**
     *  Attach images to products on S3 buckets
     *
     * @param Product $product
     *
     * @return void
     */
    public function uploadImage(): void
    {
        $product = Product::find(1);
        $product->toS3Bucket('image');
    }

    /**
     * Return all products in store
     *
     * @return Illuminate\Pagination\LengthAwarePaginator;
     */
    public function getProducts(): LengthAwarePaginator
    {
        return Product::with([
            'sku',
            'sku.stockCount',
            'options',
            'options.types',
            'variations',
        ])
            ->withFilter($this->scopes())
            ->orderBy('created_at', 'asc')
            ->paginate(10);
    }

    /**
     * Returns a single product
     *
     * @param  App\Domains\Products\Models\Product $product
     *
     * @return App\Domains\Products\Models\Product;
     */
    public function getProduct(Product $product): Product
    {
        $product->load([
            'sku.stockCount',
            'variations',
            'options.types',
            'filters',
        ]);

        return $product;
    }

    /**
     * Store product options
     *
     * @param Product $product
     * @param array $options
     *
     * @return void
     */
    public function assignOptions(Product $product, array $options): void
    {
        $product->options()->syncWithoutDetaching($options);
    }

    /**
     * Creates Product variations
     *
     * @param Product $product
     * @param Request $request
     *
     * @return void
     */
    public function createVariations(Request $request): void //Product $product,
    {
        $product = Product::find(1);
        collect($request['variations'])->map(function ($variant) use ($product) {
            return tap($product->variations()->create([

                'name' => $variant['name'],
                'properties' => json_encode($variant['properties']),
                'slug' => Str::slug($variant['name']),

            ]), function (ProductVariation $variation) use ($variant) {
                $this->syncProductSkuStock($variation, $variant['meta']);
            });
        });
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

    /**
     *  Attach sku and stocks to a product or va
     *
     * @param Model $product
     * @param array $data
     *
     * @return void
     */
    protected function syncProductSkuStock(Model $product, array $data)
    {
        return tap($product->sku()->create([

            'code' => $data['sku'],
            'price' => 1000,
            'min_stock' => $data['stock'],
            'unlimited' => $data['unlimited'],

        ]), function (Sku $sku) use ($data) {
            $sku->stocks()->create(['quantity' => $data['stock'] ?? 0]);
        });
    }
}
