<?php

namespace App\Domains\Cart\Contracts;

use Cknow\Money\Money;

// use Illuminate\Support\Collection;

interface CartContract
{
    /**
     * Add items to cart
     *
     * @param array $products
     *
     * @return void
     */
    public function add(array $products): void;

    /**
     * Update in the cart
     *
     * @param int $skuId
     * @param int $quantity
     *
     * @return void
     */
    public function update(int $skuId, int $quantity): void;

    /**
     * Delete items in cart
     *
     * @param int $skuId
     *
     * @return void
     */
    public function delete(int $skuId): void;

    /**
     * Return cart contents
     *
     * @return Collection
     */
    public function cartContents();

    /**
     * Empty cart
     *
     * @return void
     */
    public function clear(): void;

    /**
     * Checks if cart is empty
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Sync items in cart
     *
     * @return void
     */
    public function sync(): void;

    /**
     * Checks if cart has changed
     *
     * @return bool
     */
    public function hasChanged(): bool;

    /**
     * Calculates the subtotal
     *
     * @return Money
     */
    public function subTotal(): Money;

    /**
     * Calculates the total
     *
     * @return Money
     */
    public function total(): Money;

    /**
     * Calculates the delivery cost
     *
     * @param int $deliveryId
     *
     * @return Money
     */
    public function deliveryCost(): Money;

    /**
     * Check if which delivery option is to be used
     *
     * @param int $deliveryId
     *
     * @return self
     */
    public function withDelivery(?array $delivery): self; // return a delivery model{self}
}
