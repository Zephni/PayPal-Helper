Author: Zephni  
Description: For making PayPal API calls with ease  
 
  
Example usage:  

```php
$PayPalHelper = new PayPalHelper("https://api-3t.sandbox.paypal.com/nvp");  
  
$PayPalHelper->SetConfig(array(  
	 "USER"			=> "USERNAME",  
	 "PWD"			=> "PASSWORD",  
	 "SIGNATURE"	=> "SIGNATURE",  
	 "VERSION"		=> "109.0"  
));  
  
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
  
if($PayPalHelper->Success)  
	 var_dump($PayPalHelper->Result);  
else  
	 echo "Error: ".$PayPalHelper->Result["L_LONGMESSAGE0"];
```
