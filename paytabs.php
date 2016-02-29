<?php 
/**	Paytab API Integration 
**  debugger@hotmail.co.uk
**  https://www.paytabs.com/PayTabs-API-Documentation-V-2.1.pdf
*/
$postdata = http_build_query(
    array(
        'merchant_id' => 'test@testing.com',
        'merchant_password' => 'secret123'
    )
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);

$result = file_get_contents('https://www.paytabs.com/api/authentication', false, $context);

$response = json_decode($result);
$api_key =  $response->{'api_key'};

$name = explode(" ", $aData['cust_name']);

$b_firstname = $name[0];
$b_lastname = isset($name[1])? $name[1]: '';
$b_address = '';
$b_state = 'Dubai';
$b_email = $aData['cust_email'];
$b_telephone =  $aData['cust_phone'];

$s_firstname = $name[0];
$s_lastname = isset($name[1])? $name[1]: '';
$s_address = $aData['delivery'];
$s_state = 'Dubai';
$s_email = $aData['cust_email'];
$s_telephone = $aData['cust_phone'];

$ip_address = $_SERVER['REMOTE_ADDR'];

$product = ucwords($aData['product']);

$postdata1 = http_build_query(
    array(
		 "api_key" => $api_key,
		 "cc_first_name" => $b_firstname,
		 "cc_last_name" => $b_lastname,
		 "phone_number" => $b_telephone,
		 "billing_address" => $b_address,
		 "city" => $b_state,
		 "state" => $b_state,
		 "postal_code" => "00000",
		 "country" => "AE",
		 "email" => $b_email,
		 "amount" => $arData['total_amount'],
		 "discount " => "0",
		 "reference_no " => $aData['order_id'],
		 "currency" => "AED",
		 "title" => $b_firstname." ".$b_lastname,
		 "ip_customer" => $ip_address,
		 "ip_merchant" => "185.56.88.104",
		 "unit_price" => $aData['price_amount'],
		 "quantity" => "1",
		 "address_shipping" => $s_address,
		 "state_shipping" => $s_state,
		 "city_shipping" => $s_state,
		 "postal_code_shipping"=>"00000",
		 "country_shipping" => "UAE",
		 "product_per_title" => $product,
		 "channelOfOperations"=>"Physical Goods",
		 "Product Category" =>"Services",
		 "ProductName" => $product,
		 "ShippingMethod" => "Courier Service",
		 "DeliveryType" =>"Local Courier",
		 "CustomerID" => $aData['order_id'],
		 "msg_lang" => "English",
		 "return_url" => "http://www.example.ae/thankyou.html"
		)
);

$opts1 = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata1
    )
);

$context1  = stream_context_create($opts1);
$result1 = file_get_contents('https://www.paytabs.com/api/create_pay_page', false, $context1);
$response1 = json_decode($result1);
$payment_url =  $response1->{'payment_url'};

header("Location: $payment_url");
?>