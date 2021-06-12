<?php

namespace App\Domains\Cart\Services;

use App\Domains\Cart\Contracts\CartContract;
use App\Domains\Cart\Resource\CartResource;
use App\Domains\User\User;
use App\Domains\User\Visitor;
use Cknow\Money\Money;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class Cart implements CartContract
{
    /**
     * checks is cart changes
     *
     * @var boolean
     */
    protected $changed = false;

    /**
     * Delivery service used
     *
     * @var string
     */
    protected User|array|null $delivery;


    /**
     * Class Constructor
     *
     * @param User|Visitor $customer
     */
    public function __construct(protected User|Visitor $customer)
    {
    }

    /**
     * Set Delivery on cart
     *
     * @param array|null $delivery
     * @return self
     */
    public function withDelivery(?array $delivery): self
    {
        $type = key((array)$delivery);

        $option = match ($type) {
            'swoove' => $delivery,
            'hosted' => User::find($delivery['hosted']),
            null => null
        };

        $this->delivery = $option;
        return $this;
    }

    /**
     * Returns delivery details
     *
     * @return array|null
     */
    public function deliveryDetails(): ?array
    {
        return $this->delivery;
    }

    /**
     * Calculates delivery cost
     *
     * @param integer $deliveryId
     * @return Money
     */
    public function deliveryCost(): Money
    {
        return Money::GHS($this->delivery['price'] ?? '0');
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
        return $this->subTotal()->add(Money::GHS($this->delivery['price'] ?? '0'));
    }
}
