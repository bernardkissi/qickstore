<?php

declare(strict_types=1);

namespace Domain\Sales\Actions;

use Carbon\Carbon;
use Domain\Sales\Jobs\RunSalesJob;
use Domain\Sales\Sale;
use Illuminate\Support\Facades\DB;

class CreateSales
{
    public static function create(array $data, string $container_id): void
    {
        $sale = Sale::query()
                    ->where('container_id', $container_id)
                    ->where('state', 'active')
                    ->first();

        if ($sale) {
            abort(400, 'You can only run one sale at a time');
        }

        DB::transaction(function () use ($data, $container_id) {
            tap(Sale::create([

            'container_id' => $container_id,
            'banner_message' => $data['banner_message'],
            'starts_on' => now()->addSeconds(120)->toDateTimeString('minute'),
            'ends_on' => now()->addSeconds(270)->toDateTimeString('minute'),
            'percentage_reduction' => $data['percentage_reduction'],

            ]), function (Sale $sale) use ($data) {
                $sale->skus()->syncWithoutDetaching($data['products']);
            });
        });
    }
}
