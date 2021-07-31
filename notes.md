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
