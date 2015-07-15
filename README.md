Author: Zephni  
Description: For making PayPal API calls with ease  
 
  
**Example standard usage**  

```php
// PayPalHelper construct (with endpoint url and version passed)  
$PayPalHelper = new PayPalHelper("https://api-3t.sandbox.paypal.com/nvp", "109.0");  
  
// Config that will be passed to all API calls  
$PayPalHelper->SetConfig(array(  
	 "USER"			=> "USERNAME",  
	 "PWD"			=> "PASSWORD",  
	 "SIGNATURE"	=> "SIGNATURE"  
));  
  
// Make the API call  
$PayPalHelper->DoCall(array(  
	 "METHOD"			=> "DoDirectPayment",  
	 "PAYMENTACTION" 	=> "SALE",  
	 "IPADDRESS"		=> $_SERVER['SERVER_ADDR'],  
	 "CREDITCARDTYPE"	=> "MASTERCARD",  
	 "ACCT"				=> "1234567812345678",  
	 "EXPDATE"			=> "052018",  
	 "CVV2"				=> "123",  
	 "FIRSTNAME"		=> "Bob",  
	 "LASTNAME"			=> "McSquab",  
	 "STREET"			=> "12 Warne Avenue",  
	 "CITY"				=> "Braintree",  
	 "STATE"			=> "Essex",  
	 "COUNTRYCODE"		=> "UK",  
	 "ZIP"				=> "CM75FE",  
	 "AMT"				=> "10.00",  
	 "CURRENCYCODE"		=> "GBP",  
	 "DESC"				=> "Description"  
));  
  
// Check success  
if($PayPalHelper->Success())  
	 var_dump($PayPalHelper->Result);  
else  
	 echo "Error: ".$PayPalHelper->Result["L_LONGMESSAGE0"];
```


**Example of using different modes**


```php
// Define PayPal config modes  
define("SANDBOXMODE", 0);  
define("LIVEMODE", 1);  
  
// PayPalHelper construct (with endpoint url and version passed)  
$PayPalHelper = new PayPalHelper("https://api-3t.sandbox.paypal.com/nvp", "109.0");  
  
// Set sandbox config
$PayPalHelper->SetConfig(array(  
	 "USER"			=> "SANDBOX-USERNAME",  
	 "PWD"			=> "SANDBOX-PASSWORD",  
	 "SIGNATURE"	=> "SANDBOX-SIGNATURE"  
), SANDBOXMODE);  
  
// Set live config
$PayPalHelper->SetConfig(array(  
	 "USER"			=> "USERNAME",  
	 "PWD"			=> "PASSWORD",  
	 "SIGNATURE"	=> "SIGNATURE"  
), LIVEMODE);  
  
// Set mode  
$PayPalHelper->SetMode(SANDBOXMODE);  
  
// Then make the call as usual
...
```
