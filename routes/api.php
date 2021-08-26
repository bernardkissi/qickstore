<?php

namespace App;

use App\Core\Helpers\Transitions\MapState;
use App\Domains\Cart\Actions\CartActions;

use App\Domains\Cart\Services\Cart;
use App\Domains\Delivery\Actions\ShippingProviderAction;
use App\Domains\Delivery\Dispatchers\CustomVendorShipping;
use App\Domains\Delivery\Dispatchers\DispatchOrder;
use App\Domains\Delivery\Dispatchers\HostedDelivery;
use App\Domains\Delivery\Mappers\SwooveMapper;
use App\Domains\Delivery\Model\Delivery;
use App\Domains\Delivery\Model\ShippingProvider;
use App\Domains\Delivery\Notifications\ReminderVendorOfUpdateNotification;
use App\Domains\Delivery\Notifications\SendFileLinkToEmailNotification;
use App\Domains\Delivery\Resource\DueDeliveryUpdateResource;
use App\Domains\Delivery\Services\DeliveryCheckers\VendorDeliveryChecker;
use App\Domains\Delivery\Webhooks\Signatures\SwooveSign;
use App\Domains\Delivery\Webhooks\Signatures\TracktrySign;

use App\Domains\Orders\Actions\OrderActions;

use App\Domains\Orders\Checkouts\Contract\CheckoutableContract;
use App\Domains\Orders\Checkouts\Facade\Checkout;
use App\Domains\Orders\Model\Order;
use App\Domains\Orders\Model\OrderStatus;
use App\Domains\Orders\Resource\OrderDeliveryResource;
use App\Domains\Orders\Resource\OrderResource;
use App\Domains\Orders\Resource\OrderStatusResource;
use App\Domains\Payments\Facade\Payment;
use App\Domains\Payouts\Facade\Payout;
use App\Domains\Products\Product\Actions\ProductActions;
use App\Domains\Products\Product\Models\Product;
use App\Domains\Products\Product\Models\ProductVariation;
use App\Domains\Products\Product\Resource\ProductResource;
use App\Domains\Products\Skus\Model\Sku;
use App\Domains\Services\Notifications\Channels\SmsChannel;
use App\Domains\Services\Notifications\Types\Sms\Facade\Sms;
use App\Domains\Services\Notifications\Types\Voice\Facade\Voice;
use App\Domains\Tracking\Contract\TrackableContract;
use App\Domains\User\User;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\Support\MediaStream;
use Spatie\WebhookClient\Models\WebhookCall;
use Spatie\WebhookClient\WebhookConfig;

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
Route::get('/test/products', function (Request $request, Product $product) {
    return ProductResource::collection((new ProductActions())->getProducts());
});
Route::get('/test/{product}', function (Request $request, Product $product) {
    // (new ProductActions())->uploadImage($request);

    // return CategoryResource::collection(Category::with('subcategories.subcategories')
    //     ->categories()
    //     ->ordered()
    //     ->get());

    // return  ProductResource::collection(Product::with('options', 'options.attributes', 'variations')->get());
    // return  Product::where('id', 1)->options()->get();

    // $scopes = [ 'category' => new CategoryScope() ];

    // $prod = Product::with('options', 'options.attributes', 'variations')
    //  ->withFilter($this->scopes)
    //  ->orderBy('created_at', 'desc')
    //  ->paginate(10);

    // return ProductResource::collection($prod);
    return new ProductResource((new ProductActions())->getProduct($product));
    // $product = Product::find(1);
        // $product->sku()->create(['code' => 'abc126', 'price' => 1000]);
        //
        //
        // return StockView::all();
});

Route::post('/test2', function (Request $request) {
    (new ProductActions())->createProduct($request);
    // $product =  Product::find(1);
    // (new AttributeActions())->storeFilters($product, $request->arr);
    // return (new OptionActions($request->arr))->storeOptions();
});

Route::post('cart', function (Request $request, Cart $cart) {
    return (new CartActions($cart))->addToCart($request->products);
})->middleware('customer');

Route::get('cart/items', function (Request $request, Cart $cart) {
    return (new CartActions($cart))->getCart($request->query());
})->middleware('customer');

Route::get('/cookie', function (Request $request) {
    $minutes = 10;
    setcookie('identifier', (string) Str::uuid(), time() + 3600);
    // print_r($_COOKIE["name"]);
    // $cookie = cookie('name', (string) Str::uuid(), $minutes);
    // return response('')->cookie($cookie);
});

Route::get('/cookie-set', function (Request $request) {
    return $request->cookie('identifier');
});

Route::get('/middleware', function (Request $request) {
    return $request->visitor;
})->middleware('customer');

// Route::post('/orders', function (Request $request) {
//     return (new OrderActions())->createOrder();
// });

// Route::post('/paid', function (Request $request) {
//     return (new OrderActions())->createOrder();
// });

Route::get('dtos', function (Request $request) {
    // return VisitorData::fromRequest($request);
    $user = User::find(1);
    return (new Cart($user))->withDelivery($request->query())->deliveryDetails();
});

Route::get('encryption', function (Request $request) {
    // return Crypt::encryptString($request->value);
    return [
        get_class(request('visitor', auth()->user())),
        $request->visitor,
    ];
})->middleware('customer');

Route::get('decrypt', function (Request $request) {
    return Crypt::decryptString('eyJpdiI6InVRcHVKSmcvdysvRndNZWRLSFZyelE9PSIsInZhbHVlIjoiK1Q1M2RwYnp6eUpUcnFHWWhpSzV1QT09IiwibWFjIjoiNDU1YTQ5NWRjMGVlODZiODg3N2UxNjVhODU3MjYxNDJmMDk2Y2VmN2YzNWQxMmEwZTE2YjZiOTBiMzk4NzM4YyJ9');
});

Route::post('checkout', function (CheckoutableContract $checkout, Cart $cart, Request $request) {
    //return $checkout->createOrder($cart);
    return Checkout::createOrder();
})->middleware('customer');

Route::post('delivery', function (Request $request) {
    // $service = $provider->provide('hosted');
    config(['delivery-services.active' => 'swoove']);
    return Delivery::dispatch($request);
    // return $provide::dispatch();
    // return app($provider->provide($request->service))->dispatch();
})->middleware('customer');

Route::get('tracking', function (Request $request, TrackableContract $provider) {
    return [ $provider->track(), $request->service ];
})->middleware('customer');

Route::get('payments', function (Request $request) {
    return Payment::charge($request->all());
    // return $payment->pay($request);
    // return [ $gateway->charge($request->visitor, 2000/10), $request->gateway ];
    // dd(PaymentData::fromRequest($request)->toArray());
})->middleware('customer');

Route::post('payouts', function (Request $request) {
    Payout::onQueue()->execute($request->all());
})->middleware('customer');


Route::post('tests', function () {
    // return SwooveRequest::build()->withData([])->send()->json();
});


Route::post('/order-actions', function (Request $request) {
    return (new OrderActions())->checkout($request->all());
})->middleware('customer');

Route::post('sms', function (Request $request) {
    return Sms::send($request->all());
});

Route::post('voice', function (Request $request) {
    return Voice::call($request->all());
});


Route::get('ordertry', function () {
    $order = Order::where('id', 3)->select('id')->first();
    return OrderStatusResource::collection($order->statuses);
});


Route::patch('order_history', function () {
    $order = OrderStatus::where('id', 3)->select('id', 'state', 'updated_from', 'updated_at')->first();

    // $order->updateHistory('delivered');

    return $order->updated_from;
});


Route::post('webhook', function (Request $request) {
    return [ $request->all(), $request->input()];
});

Route::get('signatures', function (Request $request, WebhookConfig $config) {
    return TracktrySign::sign($request, $config);
});

Route::get('mappers', function (Request $request) {
    //return MapState::map('Shipped');

    // $payload = DueDeliveryUpdateResource::collection(Delivery::with('order')->updateDue()->get())
    // ->groupBy('service')->toArray();
    // return VendorDeliveryChecker::getUpdates($payload['swoove']);

    $order = Order::where('id', 11)->first();
    return $order->products->count();
});


Route::patch('updateState', function (Request $request) {
    // dd('fssdf');
    $delivery = Delivery::where('id', 1)->first();
    $delivery->updateDeliveryStatus('pickedup');
});

Route::post('mail', function (Request $request) {
    // Notification::route(SmsChannel::class, '0543063709')
    //         ->notify(new ReminderVendorOfUpdateNotification($request->all()));
    $order = Order::where('id', 3)->first();

    Notification::route('mail', 'bernardkissi18@gmail.com')
            ->notify(new SendFileLinkToEmailNotification($order));
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


Route::post('addMedia', function (Request $request) {
    $order = Sku::where('id', 6)->first();

    $order->addMediaFromRequest('image')
            ->toMediaCollection('products');
});

Route::post('create/carriers', function (Request $request) {
    return (new ShippingProviderAction())->createShippingService($request->all());
});

Route::get('carriers', function (Request $request) {
    return (new ShippingProviderAction())->getShippingServices();
});


Route::post('delivery/{order}', function (Order $order) {
    //return (new CustomVendorShipping())->dispatch($order);
});


Route::get('/multipleDelivery', function (Request $request) {
    $delivery = Delivery::where('id', 3)->first();
    $order = $delivery->order;

    return $order->transitionOrderState($delivery);
});


Route::post('/orders/{order}', function (Order $order) {
    $order->load(['orderable','products', 'products.skuable' => function (MorphTo $morphTo) {
        $morphTo->morphWith([
            Product::class,
            ProductVariation::class => ['product:id,name'],
        ]);
    }]);
    return $order;
    //(new DispatchOrder())->dispatch($order);
});
