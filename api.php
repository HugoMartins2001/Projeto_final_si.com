<?php

use Iluminate\Http\Request;





Route::midleware('auth:api')->get('/user', function(Request $request){
	return $request->user();
});

Route::post('create-payment', function(){
	$apiContext = new \PayPal\Rest\ApiContext(
	new \PayPal\Auth\OAuthtokenCredential(
	'AVlR02emP8L_qosJTgopxUIMbz_NdjEIjVyNBuRsbGhzPv6NUaS5xsQ4oesxk-x_6NRS_L2CVNhouBVt',
	
	'ELSjI94_hZMKe53wX8UIbCIjqc_ulgFOIyMeAiqSo4ZTqa3WrINQY4V4aRSLnR23bEdfAnk4NqpwrmMu'
	)
});

$payer = new Payer();
$payer->setPaymentMethod("paypal");

$item1 = new Item();
$item1->setName('Ground Coffee 40 oz')
    ->setCurrency('USD')
    ->setQuantity(1)
    ->setSku("123123") // Similar to `item_number` in Classic API
    ->setPrice(7.5);
$item2 = new Item();
$item2->setName('Granola bars')
    ->setCurrency('USD')
    ->setQuantity(5)
    ->setSku("321321") // Similar to `item_number` in Classic API
    ->setPrice(2);

$itemList = new ItemList();
$itemList->setItems(array($item1, $item2));

$details = new Details();
$details->setShipping(1.2)
    ->setTax(1.3)
    ->setSubtotal(17.50);

$amount = new Amount();
$amount->setCurrency("USD")
    ->setTotal(20)
    ->setDetails($details);

$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setItemList($itemList)
    ->setDescription("Payment description")
    ->setInvoiceNumber(uniqid());

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl("$baseUrl/ExecutePayment.php?success=true")
    ->setCancelUrl("$baseUrl/ExecutePayment.php?success=false");

$payment = new Payment();
$payment->setIntent("sale")
    ->setPayer($payer)
    ->setRedirectUrls($redirectUrls)
    ->setTransactions(array($transaction));

try {
    $payment->create($apiContext);
} catch (Exception $ex) {
	echo $ex;
	exit(1);
}

return $payment;