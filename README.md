Author: Zephni  
Description: For making PayPal API calls with ease  
 
  
**Example standard usage**  

```php
// PayPalHelper construct (with endpoint url and version passed)  
$PayPalHelper = new PayPalHelper("https://api-3t.sandbox.paypal.com/nvp", "202");  
  
// Config that will be passed to all API calls  
$PayPalHelper->SetConfig(array(  
	 "USER"			=> "USERNAME",  
	 "PWD"			=> "PASSWORD",  
	 "SIGNATURE"	=> "SIGNATURE"  
));  
  
// Make the API call  
$PayPalHelper->DoCall(array(  
	 "METHOD"		=> "SetExpressCheckout",  
	 "AMT"			=> "10.0",  
	 "cancelUrl"	=> "http://www.example.com/cancel.html",  
	 "returnUrl"	=> "http://www.example.com/success.html"  
));  
  
// Check success  
if($PayPalHelper->Success())  
	 var_dump($PayPalHelper->Result);  
else  
	 echo "Error: ".$PayPalHelper->Result["L_LONGMESSAGE0"];
```


**Example of using different modes**

Note that ENDPOINT is a special config property that will override the default passed in the constructor.


```php
// Define PayPal config modes  
define("SANDBOXMODE", 0);  
define("LIVEMODE", 1);  
  
// PayPalHelper construct (no endpoint or version passed, version is currently 202 by default)
$PayPalHelper = new PayPalHelper();  
  
// Set sandbox config
$PayPalHelper->SetConfig(array(
	 "ENDPOINT"		=> "https://api-3t.sandbox.paypal.com/nvp",
	 "USER"			=> "SANDBOX-USERNAME",  
	 "PWD"			=> "SANDBOX-PASSWORD",  
	 "SIGNATURE"	=> "SANDBOX-SIGNATURE"  
), SANDBOXMODE);  
  
// Set live config
$PayPalHelper->SetConfig(array(
	 "ENDPOINT"		=> "https://api-3t.paypal.com/nvp",  
	 "USER"			=> "USERNAME",  
	 "PWD"			=> "PASSWORD",  
	 "SIGNATURE"	=> "SIGNATURE"  
), LIVEMODE);  
  
// Set mode  
$PayPalHelper->SetMode(SANDBOXMODE);  
  
// Then make the call as usual
...
```
