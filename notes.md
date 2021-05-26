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


