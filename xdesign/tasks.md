//TODO: Task 1 1/07/2021
Task 1 handle order process flow

// creating orders
// 1. sync items in cart with quantity
// 2. check if the the cart is not empty
// 3. get items from cart
// 4. create the order -- set the transition state to pending
// 5. make payment of the order -- after the webhook response we set order to state of paid

//jobs behind the scene

// OnPaid
//1. Empty the cart of the user or visitior
//2. sent an SMS/Voice to the seller.
//3. Sent an email/SMS to the buyer with tracking code
//4. A delivery is made to the swoove delivery network -- create a delivery table to handle this with status

// OnFailed
// they buyer is alerted on failure of order
// we log the reason on failure on the order
// buyer can retry the order on a signed url with ttl set

//onDelivery
// We alert user everystep on the way
// From pickup to drop off
// we automatically close the order after 4 hours
// we send customer satisfaction order link to rate his order

// OnCompleted
// we send a satisfaction message for store rating // anyway we can improve our service
// And finally we dispatch the funds to the buyer.

// on refund
//create dispute with proof with images
// shop owner / super admins are notified
// The outcome of the dispute is
//send sms to the customer about the refund details

//TODO: Task 2 2/07/2021
//TODO: Task 3 3/07/2021
//TODO: Task 4 4/07/2021
//TODO: Task 5 3/07/2021

if swoove is used
// a delivery will be created and both customer and seller will be notified
if hosted delivery-
// a notification is sent to the seller alerting him to create a delivery for the purchase
if files delivery
// a download link is sent to your email or sms to download the resource paid for.

Unique jobs

Pending order ---- failed / Paid

1. empty cart ----- on Paid only

Order Paid ------- to shipped / delivered ---- Refunded

2. Sending of sms to seller
3. sending of sms to buyer 4. if swoove {
4. a delivery is created and the user is notifie  
   if hosted a notification is sent to the seller on the basis of delivery
   if files delivery - a download link will be sent to your email or sms to download the resource you have paid for.

Order Failure 5. We log the reason of failure 6. The order repayment is opened for n period 7. Buyer will be sent an email/sms with the repayment link

shipped ------ delievered ---- refunded
Shipped Order 8. buyer is alerted of the of his delivery through sms/ or email 9. We Listen to webhook events from swoove to update customer on every move

----- delivered
Order Delivered 10. Order is automatically close after 4 hours of delivery 11. A satisfaction link is sent to customer to rate his experience 12. And finally cash is dispatched to the appropriate channel

-----refunded
Order Refund Raised 13. A Message is sent to the seller ^ admin raising a dispute 14. Refund approval notice is sent to the customer
if necessary, Repayment is made to the customer or buyer

Why dont you cache the image content with apc ?

if(!apc*exists('img*'.$id)){
    apc_store('img_'.$id,file_get_content(...));
}

echo apc*fetch('img*'.$id);

this way image content will not be read from your disk more than once.

// if ($this->failed_at === null) {
        //     $filtered = $filtered->reject(fn ($value) => $value == 'failed');
// }

        // if ($this->cancelled_at === null) {
        //     $filtered = $filtered->reject(fn ($value) => $value == 'cancelled');
        // }

//TODO: inventory triggers

// /\*_
// _ Create order related delivery
// _
// _ @param array $payload
    //  * @return void
    //  */
    // public function createDelivery(array $payload): void
    // {
    //     $this->delivery()->create($payload);
// }

1. we create our exception class to handle errors
2. we report through slack and use sentry for reporting app on production
3. use when and unless to make code more readable
4. use whereRelation instead of whereHas
5. keep code shorter and performant
6. design patterns are highly recommended & solid principles
7. Discuss on using Auto routes to handle routing
8.

```
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

payment successfull

{
    "event":"charge.success",
    "data":{
        "id":1314205631,
        "domain":"test",
        "status":"success",
        "reference":"3cd8088b-57fd-406e-9ebe-076cd8c86f5f",
        "amount":200,
        "message":null,
        "gateway_response":"Approved",
        "paid_at":"2021-09-08T23:18:01.000Z",
        "created_at":"2021-09-08T23:16:46.000Z",
        "channel":"mobile_money",
        "currency":"GHS",
        "ip_address":"154.160.26.131",
        "metadata":{
            "order_id":"1423",
            "has_subscription":"false"
        },
        "log":
        {
            "start_time":1631143076,
            "time_spent":2,
            "attempts":1,
            "errors":0,
            "success":false,
            "mobile":false,
            "input":[],
            "history":[
                {
                    "type":"action",
                    "message":"Attempted to pay with mobile money",
                    "time":2
                }
            ]
        },
            "fees":4,
            "fees_split":null,
            "authorization":{
                "authorization_code":"AUTH_l005bxe6e5",
                "bin":"055XXX",
                "last4":"X987",
                "exp_month":"12",
                "exp_year":"9999",
                "channel":"mobile_money",
                "card_type":null,
                "bank":"MTN",
                "country_code":"GH",
                "brand":"Mtn",
                "reusable":false,
                "signature":null,
                "account_name":null,
                "receiver_bank_account_number":null,
                "receiver_bank":null
            },
            "customer":{
                "id":31727301,
                "first_name":"bernard",
                "last_name":"kissi",
                "email":"bernardkissi18@gmail.com",
                "customer_code":"CUS_6zrgz1q8hrz5man",
                "phone":"+2330543063709",
                "metadata":null,
                "risk_action":"default",
                "international_format_phone":"+233543063709"
            },
            "plan":[],
            "subaccount":[],
            "split":[],
            "order_id":null,
            "paidAt":"2021-09-08T23:18:01.000Z",
            "requested_amount":200,
            "pos_transaction_data":null,
            "source":{
                "type":"api",
                "source":"merchant_api",
                "identifier":null
            }
            },
            "order":null,
            "business_name":"qickstores"
            }

```

// $some = CreateDelivery::build()
        // ->withData(static::data($this->order))
// ->send()
// ->json();

        //send vendor notification after delivery is succesfully created
        // customer will be notified by email/sms.

try {
$status = $order->load(['status'])['status'];
            $order->transition($status, $state);

            return collect($status->updated_from)
            ->sortByDesc('time')
            ->reverse()
            ->all();
        } catch (\Error $e) {
            return response()->json(['error' => 'State cannot be found'], 404);
        }

paystack order details

Delivery address

-   full address
-   City
-   Region

-   Delivery note / Instructions

User Information

-   First name and last name
-   email address
-   mobile number

$factory->define(App\Note::class, function (Faker $faker) {
$noteable = $faker->randomElement([
App\User::class,
App\Complex::class,
]);

    return [
        'noteable_id' => factory($noteable),
        'noteable_type' => array_search($noteable, Relation::$morphMap),
        ...
    ];

});

# subscription charge success

```
"event" => "charge.success"
  "data" => array:27 [
    "id" => 1569920434
    "domain" => "test"
    "status" => "success"
    "reference" => "cdb32ccd-8dc7-55b4-b33a-b2244d056d29"
    "amount" => 300
    "message" => null
    "gateway_response" => "Approved"
    "paid_at" => "2022-01-18T03:00:34.000Z"
    "created_at" => "2022-01-18T03:00:05.000Z"
    "channel" => "card"
    "currency" => "GHS"
    "ip_address" => null
    "metadata" => array:1 [
      "invoice_action" => "create"
    ]
    "log" => null
    "fees" => 6
    "fees_split" => null
    "authorization" => array:15 [
      "authorization_code" => "AUTH_u6g2hz9dbh"
      "bin" => "408408"
      "last4" => "4081"
      "exp_month" => "12"
      "exp_year" => "2030"
      "channel" => "card"
      "card_type" => "visa"
      "bank" => "TEST BANK"
      "country_code" => "GH"
      "brand" => "visa"
      "reusable" => true
      "signature" => "SIG_7iwW1QZ1hEpllSnnuseg"
      "account_name" => null
      "receiver_bank_account_number" => null
      "receiver_bank" => null
    ]
    "customer" => array:9 [
      "id" => 67489095
      "first_name" => null
      "last_name" => null
      "email" => "bernardkissi18@live.com"
      "customer_code" => "CUS_aslzwdvtzavwh6u"
      "phone" => null
      "metadata" => null
      "risk_action" => "default"
      "international_format_phone" => null
    ]
    "plan" => array:9 [
      "id" => 215118
      "name" => "Basic ZVollier"
      "plan_code" => "PLN_0m2oz2zcyl65kig"
      "description" => null
      "amount" => 300
      "interval" => "hourly"
      "send_invoices" => true
      "send_sms" => false
      "currency" => "GHS"
    ]
    "subaccount" => []
    "split" => []
    "order_id" => null
    "paidAt" => "2022-01-18T03:00:34.000Z"
    "requested_amount" => 300
    "pos_transaction_data" => null
    "source" => array:3 [
      "source" => "merchant_api"
      "identifier" => null
      "event_type" => "api"
    ]
    "fees_breakdown" => null
  ]
  "order" => null
  "business_name" => "qickstores"
]

```

# invoice.create payload

```
"event" => "invoice.create"
  "data" => array:15 [
    "id" => 4163894
    "domain" => "test"
    "invoice_code" => "INV_apf526wejvgh8o0"
    "amount" => 300
    "period_start" => "2022-01-18T03:00:00.000Z"
    "period_end" => "2022-01-18T03:59:59.000Z"
    "status" => "success"
    "paid" => true
    "paid_at" => "2022-01-18T03:00:34.000Z"
    "description" => null
    "authorization" => array:13 [
      "authorization_code" => "AUTH_u6g2hz9dbh"
      "bin" => "408408"
      "last4" => "4081"
      "exp_month" => "12"
      "exp_year" => "2030"
      "channel" => "card"
      "card_type" => "visa"
      "bank" => "TEST BANK"
      "country_code" => "GH"
      "brand" => "visa"
      "reusable" => true
      "signature" => "SIG_7iwW1QZ1hEpllSnnuseg"
      "account_name" => null
    ]
    "subscription" => array:7 [
      "status" => "active"
      "subscription_code" => "SUB_gmsivrku570bks2"
      "email_token" => "sd457cl04stz0zk"
      "amount" => 300
      "cron_expression" => "0 * * * *"
      "next_payment_date" => "2022-01-18T04:00:01.000Z"
      "open_invoice" => null
    ]
    "customer" => array:9 [
      "id" => 67489095
      "first_name" => null
      "last_name" => null
      "email" => "bernardkissi18@live.com"
      "customer_code" => "CUS_aslzwdvtzavwh6u"
      "phone" => null
      "metadata" => null
      "risk_action" => "default"
      "international_format_phone" => null
    ]
    "transaction" => array:4 [
      "reference" => "cdb32ccd-8dc7-55b4-b33a-b2244d056d29"
      "status" => "success"
      "amount" => 300
      "currency" => "GHS"
    ]
    "created_at" => "2022-01-18T03:00:04.000Z"
  ]
]


```

# invoice.payment_failed

```
"event" => "invoice.payment_failed"
  "data" => array:15 [
    "id" => 4163190
    "domain" => "test"
    "invoice_code" => "INV_qbhf2wk5mzwjqqw"
    "amount" => 300
    "period_start" => "2022-01-18T00:00:00.000Z"
    "period_end" => "2022-01-18T00:59:59.000Z"
    "status" => "failed"
    "paid" => false
    "paid_at" => null
    "description" => "Email does not match Authorization code. Authorization may be inactive or belong to a different email. Please confirm."
    "authorization" => array:13 [
      "authorization_code" => "AUTH_leifonndr4"
      "bin" => "055XXX"
      "last4" => "X987"
      "exp_month" => "12"
      "exp_year" => "9999"
      "channel" => "mobile_money"
      "card_type" => null
      "bank" => "MTN"
      "country_code" => "GH"
      "brand" => "Mtn"
      "reusable" => false
      "signature" => null
      "account_name" => null
    ]
    "subscription" => array:7 [
      "status" => "attention"
      "subscription_code" => "SUB_ih1duh8h8u1f25g"
      "email_token" => "1brpp85zhc2nwpn"
      "amount" => 300
      "cron_expression" => "0 * * * *"
      "next_payment_date" => "2022-01-18T04:00:01.000Z"
      "open_invoice" => "INV_qbhf2wk5mzwjqqw"
    ]
    "customer" => array:9 [
      "id" => 65399761
      "first_name" => null
      "last_name" => null
      "email" => "bernardkissi9@live.com"
      "customer_code" => "CUS_dia2akpp3comqq4"
      "phone" => null
      "metadata" => null
      "risk_action" => "default"
      "international_format_phone" => null
    ]
    "transaction" => []
    "created_at" => "2022-01-18T00:00:14.000Z"
  ]
]

```
