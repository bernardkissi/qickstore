<?php

use Domain\Cart\Actions\CartActions;
use Domain\Cart\Facade\Cart;
use Domain\Coupons\Facade\Coupon;
use Domain\Delivery\Actions\CheckInDeliveryZone;
use Domain\Delivery\Actions\GetLocationCoordinates;
use Domain\Delivery\Dispatchers\Dispatcher;
use Domain\Delivery\Services\SwooveServiceZones;
use Domain\Delivery\ShippingZone;
use Domain\Orders\Actions\OrderCheckout;
use Domain\Orders\Actions\OrderVerification;
use Domain\Orders\Order;
use Domain\Payments\Facade\Payment;
use Domain\Payouts\Actions\GetBankBranches;
use Domain\Payouts\Actions\GetBanks;
use Domain\Payouts\Bank;
use Domain\Payouts\Facade\Payout;
use Domain\Products\Product\Actions\CreateProduct;
use Domain\Products\Product\Actions\ProductActions;
use Domain\Products\Product\Product;
use Domain\Products\Product\ProductPlan;
use Domain\Products\Product\ProductVariation;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Service\Notifications\Types\Sms\Facade\Sms;
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
    },
    ]);

    //return $order;
    Dispatcher::dispatch($order);
});

Route::post('/create', function (Request $request) {
    return (new CreateProduct())
        ->payload($request->all())
        ->create()
        ->generateSku()
        ->assignStock()
        ->fetch();
})->name('create');

Route::get('download/{order}', function (Request $request, Order $order) {
    if (! $request->hasValidSignature()) {
        return response()->json(['error' => 'Invalid signature'], 400);
    }
    $files = $order->load(['products.media']);

    if ($files->count() > 1) {
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

Route::post('/paystack', function (Request $request) {
    return Payment::charge($request->all());
})->name('paystack');

Route::post('cart', function (Request $request, Cart $cart) {
    return (new CartActions($cart))->addToCart($request->products);
})->middleware('customer')->name('cart');

Route::get('cart/items', function (Request $request, Cart $cart) {
    return (new CartActions($cart))->getCart($request->query());
})->middleware(['customer', 'cart.sync'])->name('cart.items');

Route::post('/orders', function (Request $request) {
    return (new OrderCheckout())->checkout($request->all());
})->middleware(['customer', 'cart.empty'])->name('orders');

Route::get('/verification', function (Request $request) {
    return OrderVerification::verify($request->reference);
    //VerifyOrderJob::dispatch($request->reference);
    //return PaymentRetry::getPaymentLink($request->reference);
    //OrderCancel::cancel($request->reference);
})->middleware('customer')->name('verification');

Route::get('/multiDelivery', function () {
    $order = Order::firstWhere('id', 1522);
    $order->transitionState('processing');
});

Route::post('/coupons', function (Request $request) {
    return Coupon::create($request->all(), 3);
});

Route::get('/coupons', function (Request $request) {
    return $request->visitor->redeemCode($request->code);
})->middleware('customer')->name('coupons');

Route::get('/service-zones', function () {
    return SwooveServiceZones::getZones();
});

Route::post('/delivery-zone', function (Request $request) {
    return CheckInDeliveryZone::check($request->longitude, $request->latitude);
});

Route::get('/check-zone', function (Request $request) {
    $point = new Point($request->latitude, $request->longitude, 4326);

    return ShippingZone::query()->contains('area', $point)->get();
});

Route::get('/geocoder', function (Request $request) {
    return GetLocationCoordinates::fetch($request->location);
});

Route::post('/payouts', function (Request $request) {
    Payout::pay($request->all());
})->middleware('customer');

Route::get('/banks', function (Request $request) {
    return GetBanks::get($request->country);
});

Route::get('/banks/{bank}/branches', function (Request $request, Bank $bank) {
    return GetBankBranches::get($bank->bank_id);
});

Route::get('/order/{order}/status', function (Request $request, Order $order) {
    //$order->status->updateTimeline($request->state);
    return $order->status->history;
})->name('update');

Route::post('/product/{product}/plans', function (Request $request, Product $product) {
    //dd($request->plans);
    ProductActions::addProductPlans($product, $request->plans);
})->name('product_plans');

Route::get('/order/{order}', function (Request $request, Order $order) {
    return $order->load(['orderable','products', 'products.skuable' => function (MorphTo $morphTo) {
        $morphTo->morphWith([
            Product::class,
            ProductVariation::class => ['product:id,name'],
            ProductPlan::class => ['product' => function ($query) {
                $query->orderBy('created_at', 'desc')->select('id', 'type');
            },
            ],
        ]);
    },
    ]);

    return $order['products']->groupBy(function ($item) {
        return $item['skuable']['type'];
    });

    //return $results->products;
})->name('product_plans');

Route::get('/subscribes/{order}', function (Request $request, Order $order) {
    return $order->load(['products'
            => fn ($query) => $query->select('skuable_type', 'skuable_id')->where('skuable_type', '=', 'Subscription'),
            'products.skuable:id,plan_code']);
})->name('product_subscribed');
