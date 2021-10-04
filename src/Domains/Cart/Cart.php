<?php

namespace Domain\Cart;

use Cknow\Money\Money;
use Domain\Cart\Contracts\CartContract;
use Domain\Cart\Resource\CartResource;
use Domain\Delivery\ShippingProvider;
use Domain\User\User;
use Domain\User\Visitor;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class Cart implements CartContract
{
    /**
     * checks is cart changes
     *
     * @var bool
     */
    protected $changed = false;

    /**
     * Delivery service used
     *
     * @var string
     */
    protected array | null $delivery;


    /**
     * Shipping provider used
     *
     * @var ShippingProvider
     */
    protected ShippingProvider $shipping;


    /**
    * Number of items in cart
    *
    * @var Integer
    */
    protected int $ItemsCount = 0;


    /**
     * Class Constructor
     *
     * @param User|Visitor $customer
     */
    public function __construct(
        public User | Visitor | null $customer
    ) {
    }

    /**
     * Set shipping on cart
     *
     * @param array|null $delivery
     *
     * @return self
     */
    public function withShipping(?int $shippingId): self
    {
        if ($shippingId) {
            $this->shipping = ShippingProvider::find($shippingId);
        }

        return $this;
    }

    /**
     * Set cart without shipping
     *
     * @param array|null $delivery
     *
     * @return self
     */
    public function withoutShipping(): self
    {
        $this->shipping = null;

        return $this;
    }

    /**
     * Returns delivery details
     *
     * @return array|null
     */
    public function shippingDetails(): ShippingProvider
    {
        return $this->shipping;
    }

    /**
     * Calculates delivery cost
     *
     * @return Money
     */
    public function shippingCost(): Money
    {
        return Money::GHS($this->shipping->price ?? '0');
    }

    /**
     * Get customer cart contents
     *
     * @return JsonResource
     */
    public function cartContents(): JsonResource
    {
        return new CartResource($this->customer);
    }

    /**
     * Get customer cart contents
     *
     * @return Collection
     */
    public function products(): Collection
    {
        return $this->customer->cart;
    }

    /**
     * Add items to cart
     *
     * @param array $products
     *
     * @return void
     */
    public function add(array $products): void
    {
        $this->customer->cart()->syncWithoutDetaching($this->getStorepayload($products));
    }

    /**
     * Update items in cart
     *
     * @param int $skuId
     * @param int $quantity
     *
     * @return void
     */
    public function update(int $productId, int $quantity): void
    {
        $this->customer->cart()->updateExistingPivot($productId, ['quantity' => $quantity ]);
    }

    /**
     * Remove items from cart
     *
     * @param int $productId
     *
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
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->customer->cart->sum('pivot.quantity') <= 0;
    }

    /**
     * Checks if cart has changed
     *
     * @return bool
     */
    public function hasChanged(): bool
    {
        return $this->changed;
    }


    /**
     * Get count items in cart
     *
     * @return integer
     */
    public function countItems(): int
    {
        $items = $this->customer->loadCount('cart');
        $this->ItemsCount = $items->cart_count;

        return $this->ItemsCount;
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
            if ($quantity !== $product->pivot->quantity) {
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
        return $this->subTotal()->add(Money::GHS($this->shipping->price ?? '0'));
    }

    /**
     * Prepare cart items payload
     *
     * @param array $products
     *
     * @return array
     */
    private function getStorePayload(array $products): array
    {
        return collect($products)->keyBy('id')->map(function ($product) {
            return [ 'quantity' => $product['quantity'] + $this->getCurrentQuanity($product['id'])];
        })->toArray();
    }

    /**
     * Return existing cart product quantity
     *
     * @param int $skuId
     *
     * @return int
     */
    private function getCurrentQuanity(int $productId): int
    {
        $product = $this->customer->cart->where('id', $productId)->first();
        if ($product) {
            return $product->pivot->quantity;
        }
        return 0;
    }
}
