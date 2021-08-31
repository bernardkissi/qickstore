<?php

declare(strict_types=1);

namespace Domain\Products\Product\Actions;

use Domain\Products\Product\Product;
use Domain\Products\Skus\Sku;
use Domain\Products\Stocks\Stock;
use Illuminate\Support\Str;

class CreateProduct
{
    public array $payload;

    public Product $product;

    public Sku $sku;

    public Stock $stock;

    public function payload(array $payload): self
    {
        $this->payload = array_merge($payload, ['slug' => Str::slug($payload['name'])]);
        return $this;
    }


    public function create(): self
    {
        $product = Product::create($this->payload);
        $this->product = $product;

        return $this;
    }


    public function generateSku():self
    {
        $sku = $this->product->sku()->create([
            'code' => $this->payload['metadata']['sku'],
            'price' => 1000,
            'min_stock' => $this->payload['metadata']['stock'],
            'unlimited' => $this->payload['metadata']['unlimited']
        ]);
        $this->sku = $sku;

        return $this;
    }

    public function assignStock():self
    {
        $stock = $this->sku->stocks()->create(['quantity' => $this->payload['metadata']['stock'] ?? 0]);
        $this->stock = $stock;

        return $this;
    }


    public function getProduct(): Product
    {
        return $this->product;
    }
}
