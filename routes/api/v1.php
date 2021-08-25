<?php

namespace App;

use App\Domains\Orders\Model\Order;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/orders/{order}', function (Order $order) {
    $order->load(['orderable','products', 'products.skuable' => function (MorphTo $morphTo) {
        $morphTo->morphWith([
            Product::class,
            ProductVariation::class => ['product:id,name'],
        ]);
    }]);
    return $order;
});
