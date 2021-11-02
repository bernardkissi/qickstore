<?php

declare(strict_types=1);

namespace Domain\Products\Product\Actions;

use Domain\Products\Product\Filters\CategoryScope;
use Domain\Products\Product\Jobs\SyncPlan;
use Domain\Products\Product\Product;
use Domain\Products\Product\ProductPlan;
use Domain\Products\Product\ProductVariation;
use Domain\Products\Skus\Sku;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ProductActions
{
    //TODO: use upserts to handle product insert/update
    /**
     * Create a product in store
     *
     * @param Request $data
     *
     * @return void
     */
    public function createProduct(array $data)
    {
        return tap(Product::create([

            'name' => $data['name'],
            'description' => $data['description'],
            'slug' => Str::slug($data['name']),
            'barcode' => $data['barcode'],

        ]), function (Product $product) use ($data) {
            $this->syncProductSkuStock($product, $data['meta']);
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
     * Add variations to a product
     *
     * @param Product $product
     * @param Request $request
     *
     * @return void
     */
    public function addProductVariations(Product $product, array $data): void
    {
        collect($data['variations'])->map(function ($variant) use ($product) {
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
     * Add plans to a product
     *
     * @param Product $product
     *
     * @return void
     */
    public static function addProductPlans(Product $product, array $plans): void
    {
        collect($plans)->map(function ($plan) use ($product) {
            return tap($product->plans()->create([

                'plan_name' => $plan['plan_name'],
                'plan_code' => $plan['plan_code'],
                'price'     => $plan['price'],
                'plan_description' => $plan['plan_description'],
                'interval' => $plan['interval'],
                'currency' => $plan['currency'],
                'duration' => $plan['duration'],
                'send_sms' => $plan['send_sms'] ?? null,

            ]), function (ProductPlan $productPlan) use ($plan) {
                static::syncProductSkuStock($productPlan, [
                    'price' => $plan['price'],
                    'stock' => 0,
                    'unlimited' => true
                ]);
                SyncPlan::dispatch($productPlan);
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
    protected static function syncProductSkuStock(Model $product, array $data)
    {
        return tap($product->sku()->create([
            'price' => $data['price'],
            'min_stock' => $data['stock'] ?? 0,
            'unlimited' => $data['unlimited'] ?? false,

        ]), function (Sku $sku) use ($data) {
            $sku->stocks()->create(['quantity' => $data['stock'] ?? 0]);
        });
    }
}
