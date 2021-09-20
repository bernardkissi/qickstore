<?php

declare(strict_types=1);

namespace Domain\Delivery\Actions;

use Domain\Delivery\Resource\ShippingProviderResource;
use Domain\Delivery\ShippingProvider;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;

class ShippingProviderAction
{
    /**
     * Create a shipping service provider
     *
     * @param array $payload
     *
     * @return void
     */
    public function createShippingService(array $payload): void
    {
        ShippingProvider::create([
            'name' => $name = $payload['name'],
            'slug' => Str::slug($name),
            'description' => $payload['description'],
            'price' => $payload['price'] ?? null,
            'constraints' => $payload['constraints'] ? $payload['constraints'] : null,
        ]);
    }

    /**
     * Returns all shipping services
     *
     * @return AnonymousResourceCollection
     */
    public function getShippingServices(): AnonymousResourceCollection
    {
        return ShippingProviderResource::collection(ShippingProvider::all());
    }

    /**
     * Add logo to the provider
     *
     * @param ShippingProvider $provider
     * @param string $image
     *
     * @return void
     */
    public function addLogo(ShippingProvider $provider, string $image): void
    {
        $provider->addMediaFromRequest($image)
            ->toMediaCollection('carriers');
    }

    /**
     * Update shipping provider
     *
     * @param shippingProvider $provider
     * @param array $payload
     *
     * @return void
     */
    public function updateShippingProvider(shippingProvider $provider, array $payload): void
    {
        $provider->update([
            'name' => $payload['name'],
            'descritpion' => $payload['description'],
            'price' => $payload['price'],
        ]);
    }

    /**
     * Delete shipping provider
     *
     * @param shippingProvider $provider
     *
     * @return void
     */
    public function deleteShippingProvider(shippingProvider $provider): void
    {
        $provider->delete();
    }
}
