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

1. ## Through a webhook
   ```
  
     public function __invoke(string $orderId): void
     {
     	//retrieve the delivery
     	$delivery = Delivery::where('delivery_id', $deliveryId)->first();

       //Run the transition mapper and return the result
       $state = TransitionMapper::map($state): string

       //check if the delivery retrieved can transition to thr returned state
       if(!$delivery->state->canTransitionTo($state)) {

       	    throws NotTransitionableException();
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


2. Through a action
	```
		1. Get the model intended for transition update 
		2. check if the transition to be applied is applicable
		3. throw an exception or error status that model can be transition to the that
		4. Else transistion to state
	```

3. Through a state processor

	```
		check if transition is applicable to model
        if not skip and contiune.
	```
   
sales ser
   




