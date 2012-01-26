<?php
global $wpdb;
$wpdb->show_errors(); 

$options = $scabn_options;

$post_url = add_query_arg( array() );
$remove_url = "";
$cart_url = $options['cart_url'];
$cart_theme = $options['cart_theme'];
$cart_type = $options['cart_type'];
$currencybad = scabn_curr_symbol($options['currency']);
$currency = $options['currency'];


$paypal_email = $options['paypal_email'];	
$paypal_url = $options['paypal_url'];
$gc_merchantid = $options['gc_merchantid'];
$gc_merchantkey = $options['gc_merchantkey'];


$cart = $_SESSION['wfcart'];

$holditems=array();
foreach($cart->get_contents() as $item) {									
	$weight = 2.4; //Should get this from db query in future.
	$holditems[]=array("id"=>$item['id'],"name"=>$item['name'],"qty"=>$item['qty'],"price"=>getItemPricing($item['id'],$item['qty'],$item['price']),"options"=>$item['options'],"weight"=>getItemWeight($item['id'],$item['qty'],$item['weight']));	
	}
	

   

echo scabn_make_paypal_button($options,$holditems);
echo scabn_make_google_button($options,getShippingOptions($holditems),$holditems);
	
 ?>
