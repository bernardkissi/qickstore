<?php

namespace App;

use Domain\Delivery\Dispatchers\Dispatcher;
use Domain\Delivery\Dispatchers\DispatchOrder;
use Domain\Orders\Order;
use Domain\Products\Product\Product;
use Domain\Products\Product\ProductVariation;
use Domain\Services\Notifications\Types\Sms\Facade\Sms;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\MediaLibrary\Support\MediaStream;

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

    //return $order;
    Dispatcher::dispatch($order);
});


Route::get('download/{order}', function (Request $request, Order $order) {
    if (! $request->hasValidSignature()) {
        abort(401);
    }
    $files = $order->load(['products.media']);

    if ($files->count()  > 1) {
        $downloads = $files->products->map(function ($file) {
            return $file->getMedia('products');
        })->unique();
        return MediaStream::create('download.zip')->addMedia(...$downloads);
    }
    return $files->products[0]->getMedia('products')->first();
})->name('download');

Route::post('/sms', function (Request $request) {
    return Sms::send($request->all());
})->name('sms');
