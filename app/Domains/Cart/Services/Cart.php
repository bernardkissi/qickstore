<?php

namespace App\Domains\Cart\Services;

use App\Domains\Cart\Contracts\CartContract;
use App\Domains\user\Guest;
use App\Domains\User\User;
use Cknow\Money\Money;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Cart implements CartContract
{
    /**
     * checks is cart changes
     *
     * @var boolean
     */
    protected $changed =  false;

    /**
     * Delivery service used
     *
     * @var Model
     */
    protected Model $delivery;

   
    /**
     * Class Constructor
     *
     * @param string $customer
     */
    public function __construct(protected User|Guest $customer)
    {
    }


    /**
     * Returns the delivery option
     *
     * @param integer $cost
     * @return integer
     */
    public function withDelivery(int $deliveryId): int
    {
        return $deliveryId ? $deliveryId : 0;
    }


    /**
     * Calculates delivery cost
     *
     * @param integer $deliveryId
     * @return Money
     */
    public function deliveryCost(int $deliveryId): Money
    {
        return Money::GHS($this->withDelivery($deliveryId));
    }

    /**
     * Get guest|user cart contents
     *
     * @return void
     */
    public function cartContents()
    {
        return $this->customer->cart;
    }

    /**
     * Add items to cart
     *
     * @param array $products
     * @return void
     */
    public function add(array $products): void
    {
        $this->customer->cart()->syncWithoutDetaching($this->getStorepayload($products));
    }


    /**
     * Prepare cart items payload
     *
     * @param array $products
     * @return array
     */
    private function getStorePayload(array $products): array
    {
        return collect($products)->keyBy('id')->map(function ($product) {
            return [ "quantity" => $product['quantity'] + $this->getCurrentQuanity($product['id'])];
        })->toArray();
    }

    /**
     * Return existing cart product quantity
     *
     * @param integer $skuId
     * @return integer
     */
    private function getCurrentQuanity(int $productId): int
    {
        if ($product = $this->customer->cart->where('id', $productId)->first()) {
            return $product->pivot->quantity;
        }
        return 0;
    }

    /**
     * Update items in cart
     *
     * @param integer $skuId
     * @param integer $quantity
     * @return void
     */
    public function update(int $productId, int $quantity): void
    {
        $this->customer->cart()->updateExistingPivot($productId, ['quantity' => $quantity ]);
    }

    /**
     * Remove items from cart
     *
     * @param integer $productId
     * @return void
     */
    public function delete(int $productId): void
    {
        $this->customer->cart()->detach($productId);
    }

    /**
     * Clear items from cart
     *
     * @return void
     */
    public function clear(): void
    {
        $this->customer->cart()->detach();
    }

    /**
     * Checks if cart is empty
     *
     * @return boolean
     */
    public function isEmpty(): bool
    {
        return $this->customer->cart->sum('pivot.quantity') === 0;
    }

    /**
     * Checks if cart has changed
     *
     * @return boolean
     */
    public function hasChanged(): bool
    {
        return $this->changed;
    }

    /**
     *  Sync items in the cart with stock
     *
     * @return void
     */
    public function sync(): void
    {
        $this->customer->cart->each(function ($product) {
            $quantity = $product->minStock($product->pivot->quantity);
            if ($quantity != $product->pivot->quantity) {
                $this->changed = true;
            }
            $product->pivot->update(['quantity' => $quantity]);
        });
    }

    /**
     * Returns cart subtotal
     *
     * @return Money
     */
    public function subTotal(): Money
    {
        $subTotal = $this->customer->cart->sum(function ($product) {
            return Money::parse($product->price, 'GHS')->amount()->multiply($product->pivot->quantity)->getAmount();
        });

        return Money::GHS($subTotal);
    }

    /**
     * Returns the total cart volume
     *
     * @return Money
     */
    public function total(): Money
    {
        return $this->subTotal()->add($this->deliveryCost(2000));
    }
}
