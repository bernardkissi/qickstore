<?php

declare(strict_types=1);

namespace Domain\Products\Product\Actions;

use Domain\Products\Product\Bundle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateProductBundle
{
    public static function create(array $data): void
    {
        DB::transaction(function () use ($data) {
            $bundlePrice = $data['bundle_price'] ?? 0;
            $newPrice = $data['set_price'] ?? 0;

            tap(Bundle::create([
                'name' => $name = $data['name'],
                'description' => $data['description'],
                'slug' => Str::slug($name),
                'is_active' => $data['is_active'] ?? false,
                'schedule_at' => $data['schedule_at'] ?? null,
                'bundle_price' => $bundlePrice ?? null,
                'percentage_decrease' => $data['set_price'] ? ($bundlePrice - $newPrice) / $bundlePrice * 100 : null,
            ]), function (Bundle $bundle) use ($data) {
                $bundle->skus()->syncWithoutDetaching($data['skus']);
            });
        });
    }
}
