<?php

declare(strict_types=1);

namespace Domain\Delivery\Traits;

use Domain\Delivery\Delivery;
use Illuminate\Support\Str;

trait CanCreateDelivery
{
    public function createDelivery(array $payload): Delivery
    {
        return Delivery::create([
            'service' => $payload['service'],
            'order_id' => $payload['order_id'],
            'reference' => Str::uuid(),
            'tracking_code' => Str::random(6),
            'instructions' => $payload['instructions'],
            'download_link' => $payload['download_link'] ?? null,
            'provider_code' => $payload['provider_code'] ?? null,
            'estimate_id' => $payload['estimate_id'] ?? null,
            'agent_details' => $payload['agent_details'] ?? null,
            'vehicle' => $payload['vehicle'] ?? null,
        ]);
    }
}
