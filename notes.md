# sample data

### create variation

```
{
	"variations": [

		{
			"name": "RedX",
			"properties": ["Red", "X"],
			"meta":{
				"stock": 15,
				"price": 500,
				"sku": "00133"
			}
		},

		{
			"name": "RedM",
			"properties": ["Red", "M"],
			"meta":{
				"stock": 15,
				"price": 500,
				"sku": "00134"
			}
		},
		{
			"name": "RedXl",
			"properties": ["Red", "Xl"],
			"meta":{
				"stock": 15,
				"price": 500,
				"sku": "00135"
			}
		}

	]

}
```

### products

```
{
	 "name": "milk pancake mix",
	 "description": "delicious pancake mix for the family",
	 "meta":{
		 "stock": 20,
		 "price": 100,
		 "sku": "10333"
	 }
}
```

### opiton types, options and product options

```
{
   {
    "arr" : {
        "color": ["spacegray", "rosegold", "something", "wild", "home"],
        "some":  [
					"64GB",
					"12GB",
					"23GB",
					"48GB",
					"234GB",
					"51GB",
					"90GB",
					"17GB",
					"10GB",
					"1GB",
					"0.5GB",
					"0.4GB",
					"0.1GB"
				]
		}
}
}

```

### generate product filters

```
{
    "arr" : {
        "color": ["spacegray", "rosegold"],
        "newd":  ["64GB", "12GB"]
		}
}

```

### swoove api data object

```
{
  'pickup'=>[
    'type'=>'LATLNG',
    'value'=>'string',
    'contact'=>[
      'name' => 'bernard kissi',
      'mobile'=>"05430637089",
      'email'=>'bernardkissi@gmail.com'
    ],
    'country_code': 'GH',
    'lat' => 6.663449,
    'lng'=> -1.662625,
    'location'=>'Opoku Ware Senior High'
  ],
  'dropoff'=> [
    'type'=> 'LATLNG',
    'value' => 'string',
    'contact' => [
	  'name' => 'Derricl Kissi',
      'mobile'=>"0243343810",
      'email'=>'derricl@gmail.com'
	],
    'country_code' => "GH",
    'lat'=> 6.691877,
    'lng'=> -1.62872,
    'location'=> 'Adum'
  ],
  'items'=> [['itemName => 'foo, 'itemQuantity' => 2, 'itemCost => 300]],
  'vehicle_type'=> 'MOTORCYCLE'
}
```

### flutterwave payment webhook payload

```
{
    "event":"charge.completed",
    "data":{
        "id":2322194,
        "tx_ref":"b64bbc5e-0e8b-456d-80df-6d0651068da2" === tx_ref,
        //"flw_ref":"flwm3s4m0c1625160879002",
        //"device_fingerprint":"f9c2684b752ad50a1c52e99ad1437842",
        //"amount":3000,
        //"currency":"GHS",
        "charged_amount":3000 === amount,
        "app_fee":75,
        //"merchant_fee":0,
        "processor_response":"Approved" === provider ,
        "auth_model":"MOBILEMONEY" === channel
        "ip":"52.209.154.143",
        //"narration":"Zippvite",
        "status":"successful" === status,
        //"payment_type":"mobilemoneygh",
        //"created_at":"2021-07-01T17:34:38.000Z",
        //"account_id":11513,
        //"customer":{
         //   "id":1256082,
         //  "name":"Bernard Kissi",
         // "phone_number":"0543063709",
         // "email":"bernardkissi18@gmail.com",
         //  "created_at":"2021-06-30T17:05:37.000Z"
        }
    },
    "event.type":"MOBILEMONEYGH_TRANSACTION"
}
```

ordering system pipeline

# order processing pipeline

# order processor

# delivery processor

processor will be an inheritable interface

```
	class {state}Processor implements Processor
	{
  	   public function execute(): void;
	}

```

# inhertiable interface

```
  interface Processor {

  	   public function run(): void
  }

```

## All processor will be run in the OrderStateListener::class

```
	public function handle(Event $event)
	{
		RunProcessor::run($process);
	}
```

Transition state can be invoked in any of the three ways to run a processor

    Develop a transition mapper
    1. interface class
    ```
    	public function transitionMapper(): string
    ```
    2. implementation class
    ```
    	SwooveTransition implements transitionMapper(): string
    	{
    		$state = match($string){
    			// transition mapping to our defined states
    		}
    	}

    ```
    ```
    	AnotherTransition implements transitionMapper(): string
    	{
    		$state = match($string){
    			// transition mapping to our defined states
    		}
    	}

    ```
    3.

1.  ## Through a webhook

    ```

      public function __invoke(string $orderId): void
      {
      	$delivery = Delivery::where('delivery_id', $deliveryId)->first();

        //Run the transition mapper and return the result
        $state = MapState::map($state);

        //check if the delivery retrieved can transition to thr returned state
        if (!$delivery->state->canTransitionTo($state)) {

            //throws NotTransitionableException();
        }

        $delivery->state->transitionTo($state);

      }

    ```

    ## if we manually check for the state of the delivery through scheduler

        ```
        The time difference between now and ( created_at ) is > 4 hours
        and is in all state except ['delivered'] to get the collection

    of delivery or deliveries to be checked

        ```

    Delivery::query()->where('') ... // build query chain

    After state has been retrieved from provider (sleep 3)

    // if returned state for the delivery equals the current state
    // contiune with the rest
    // Transition to the state returned

2.  Through a action
    this

    ```
    	1. Get the model intended for transition update
    	2. check if the transition to be applied is applicable
    	3. throw an exception or error status that model can be transition to the that
    	4. Else transistion to state
    ```

3.  Through a state processor

    ```
    	check if transition is applicable to model
        if not skip and contiune.
    ```

sales ser

Returning where not In collections
$collection = collect([
['product' => 'Desk', 'price' => 200],
['product' => 'Chair', 'price' => 100],
['product' => 'Bookcase', 'price' => 150],
['product' => 'Door', 'price' => 100],
]);

$filtered = $collection->whereNotIn('price', [150, 200]);
$filtered->all()

if updated_at is greater than
$dtOttawa->diffInHours($dtVancouver);

### Order Process flow

# transition

    -Paid
        - notify customer
        - notify vendor
        - create delivery

# transition

    - Processing
        - send sms to the buyer
        - listen to delivery hooks
            - assigned
            - picking up
            - picked up
            - delivering
            - delivered

# transition

    - Failed
        - log failed reason
        - send notification to buyer with re-purchase link

#

# for digital files

    - Transition to paid after payment is successful
    - Create a delivery
        - retrieve the order
        - get the related media associated with the product
        - we create a delivery record in the delivery database a signed url to customer using spatie media
        - if fails retry is set 3 times and with interval of a min

        # on success
        - we create a delivery record with order id
        - Run the deliveredProcessor

        #on failure
        - set retry after a min interval
        - send slack notification to development team

# for hosted delivery

    - We retrieve the order and and a delivery is created
    - vendor is then notified of the delivery details

    #on failure
    <!-- - set retry after a 2 mins interval -->
    - send a slack notification to the delvelopment to intervene

# System logistics

    - retrieve the order
    - retrieve the delivery details

    - prepare to hit the provider endpoint with details
    - retry is set to 3 in 5 mins

    # on success
    - create and a persist a delivery record
    - transition order and delivery to the appropriate transitionable class

    # on failure
    - set retry after 2 mins interval
    - send a slack notification

# similarities

    - on failure action
    - on success

# differences

    - delivery process

# Monitoring and dispatch different product types

1.  stage 1

    -   Grab an order you want to process
    -   Group order items into types
    -   Run a loop over types and call respective dispatchers to handle delivery

2.  stage 2
    Check:- given an order with different types

        if(true)
            -create delivery with batch number
        if(false)
            - create delivery no batch number

3.  stage 3.
    Updating main order
    transitionOrderState ($delivery):
        $deliveries = $order->deliveries;
            if($order->count() > 1){

        }
        $order->state->canTransition(state::class) ?
        $order->state->transitionTo(state::class): null

// assumptions

1. delivery will be passed into each process

    - we can retrieve the order of the specific delivery

    - use the order to fetch all the deliveries
    - we exclude the current delivery from collection list
    - compare if the current delivery state is less than other delivery state ---- transition
    - or the state are the same transition
    - if not dont transition

    - if single transition with state.

### SUBSCRIPTION CREATED

```
{
2  "status": true,
3  "message": "Subscription successfully created",
4  "data": {
5      "customer": 24259516,
6      "plan": 49122,
7      "integration": 428626,
8      "domain": "test",
9      "start": 1590152172,
10      "status": "active",
11      "quantity": 1,
12      "amount": 500000,
13      "authorization": {
14        "authorization_code": "AUTH_pmx3mgawyd",
15        "bin": "408408",
16        "last4": "4081",
17        "exp_month": "12",
18        "exp_year": "2020",
19        "channel": "card",
20        "card_type": "visa DEBIT",
21        "bank": "Test Bank",
22        "country_code": "NG",
23        "brand": "visa",
24        "reusable": true,
25        "signature": "SIG_2Gvc6pNuzJmj4TCchXfp",
26        "account_name": null
27      },
28      "invoice_limit": 0,
29      "subscription_code": "SUB_i6wmhzi0lu95oz7",
30      "email_token": "n27dvho4kjsf1sq",
31      "id": 161872,
32      "createdAt": "2020-05-22T12:56:12.514Z",
33      "updatedAt": "2020-05-22T12:56:12.514Z",
34      "cron_expression": "0 0 22 * *",
35      "next_payment_date": "2020-06-22T00:00:00.000Z"
36  }
37}

    EVENT HOOK FOR SUBSCRIPTION CREATED

    {
2  "event": "subscription.create",
3  "data": {
4    "domain": "test",
5    "status": "active",
6    "subscription_code": "SUB_vsyqdmlzble3uii",
7    "amount": 50000,
8    "cron_expression": "0 0 28 * *",
9    "next_payment_date": "2016-05-19T07:00:00.000Z",
10    "open_invoice": null,
11    "createdAt": "2016-03-20T00:23:24.000Z",
12    "plan": {
13      "name": "Monthly retainer",
14      "plan_code": "PLN_gx2wn530m0i3w3m",
15      "description": null,
16      "amount": 50000,
17      "interval": "monthly",
18      "send_invoices": true,
19      "send_sms": true,
20      "currency": "NGN"
21    },
22    "authorization": {
23      "authorization_code": "AUTH_96xphygz",
24      "bin": "539983",
25      "last4": "7357",
26      "exp_month": "10",
27      "exp_year": "2017",
28      "card_type": "MASTERCARD DEBIT",
29      "bank": "GTBANK",
30      "country_code": "NG",
31      "brand": "MASTERCARD",
32      "account_name": "BoJack Horseman"
33    },
34    "customer": {
35      "first_name": "BoJack",
36      "last_name": "Horseman",
37      "email": "bojack@horsinaround.com",
38      "customer_code": "CUS_xnxdt6s1zg1f4nx",
39      "phone": "",
40      "metadata": {},
41      "risk_action": "default"
42    },
43    "created_at": "2016-10-01T10:59:59.000Z"
44  }
45}


```

### SUBSCRIPTION CHARGE PAYMENT

```
{
2  "event": "charge.success",
3  "data": {
4    "id": 895091250,
5    "domain": "test",
6    "status": "success",
7    "reference": "683e6787-7645-557a-a270-c9035c3a2b65",
8    "amount": 110000,
9    "message": null,
10    "gateway_response": "Approved",
11    "paid_at": "2020-11-23T11:00:09.000Z",
12    "created_at": "2020-11-23T11:00:03.000Z",
13    "channel": "card",
14    "currency": "NGN",
15    "ip_address": null,
16    "metadata": { "invoice_action": "create" },
17    "log": null,
18    "fees": 1650,
19    "fees_split": null,
20    "authorization": {
21      "authorization_code": "AUTH_v56svuyn23",
22      "bin": "408408",
23      "last4": "4081",
24      "exp_month": "12",
25      "exp_year": "2020",
26      "channel": "card",
27      "card_type": "visa ",
28      "bank": "TEST BANK",
29      "country_code": "NG",
30      "brand": "visa",
31      "reusable": true,
32      "signature": "SIG_H8F4hDXIARayPS41IUwG",
33      "account_name": null,
34      "receiver_bank_account_number": null,
35      "receiver_bank": null
36    },
37    "customer": {
38      "id": 31352593,
39      "first_name": "Test",
40      "last_name": "Two",
41      "email": "test2@live.com",
42      "customer_code": "CUS_mfkew13owtwcmb2",
43      "phone": "",
44      "metadata": null,
45      "risk_action": "default",
46      "international_format_phone": null
47    },
48    "plan": {
49      "id": 60905,
50      "name": "10% off first month",
51      "plan_code": "PLN_a5vr5skxg72f4lr",
52      "description": null,
53      "amount": 110000,
54      "interval": "monthly",
55      "send_invoices": true,
56      "send_sms": true,
57      "currency": "NGN"
58    },
59    "subaccount": {},
60    "split": {},
61    "order_id": null,
62    "paidAt": "2020-11-23T11:00:09.000Z",
63    "requested_amount": 110000
64  }
```
