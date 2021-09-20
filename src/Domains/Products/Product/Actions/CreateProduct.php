<?php

declare(strict_types=1);

namespace Domain\Products\Product\Actions;

use Domain\Products\Product\Product;
use Domain\Products\Skus\Sku;
use Domain\Products\Stocks\Stock;
use Illuminate\Support\Str;

class CreateProduct
{
    /**
     * Returns data from request
     *
     * @var array
     */
    public array $payload;

    /**
     * Product model
     *
     * @var Product
     */
    public Product $product;

    /**
     * Product sku
     *
     * @var Sku
     */
    public Sku $sku;

    /**
     * Product stock
     *
     * @var Stock
     */
    public Stock $stock;

    /**
     * Prepare data for creating product
     *
     * @param array $payload
     *
     * @return self
     */
    public function payload(array $payload): self
    {
        $this->payload = array_merge($payload, ['slug' => Str::slug($payload['name'])]);
        return $this;
    }

    /**
     * Create product into database
     *
     * @return self
     */
    public function create(): self
    {
        $product = Product::create($this->payload);
        $this->product = $product;

        return $this;
    }

    /**
     * Generate sku for product
     *
     * @return self
     */
    public function generateSku(): self
    {
        $sku = $this->product->sku()->create([
            'code' => $this->payload['metadata']['sku'],
            'price' => 1000,
            'min_stock' => $this->payload['metadata']['stock'],
            'unlimited' => $this->payload['metadata']['unlimited'],
        ]);
        $this->sku = $sku;

        return $this;
    }

    /**
     * Assign stock to product
     *
     * @return self
     */
    public function assignStock(): self
    {
        $stock = $this->sku->stocks()->create(['quantity' => $this->payload['metadata']['stock'] ?? 0]);
        $this->stock = $stock;

        return $this;
    }

    /**
     * Returns the created product model
     *
     * @return Product
     */
    public function fetch(): Product
    {
        return $this->product;
    }
}
