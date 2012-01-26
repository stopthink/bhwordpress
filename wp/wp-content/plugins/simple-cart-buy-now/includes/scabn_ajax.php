<?php

if (!function_exists('add_action'))  {
  require_once("../../../../wp-config.php");
}

require_once("cart.php");
require_once ("commun.php");
require_once ("scabn_codes.php");

session_start();      // start the session


$cart =& $_SESSION['wfcart'];  
//$cart = $_SESSION['wfcart'];  

if(!is_object($cart)) $cart = new wfCart(); 

//scabn_request();  -- this is already run by the top require_once function for some reason.


if($_POST['no_cart'] ) header ('Location:'.$cart->cart_info['url']);

$cart_info = $cart->cart_info;

$post_url = "#";
$remove_url = "#";
$cart_url = $cart_info['url'];
$cart_theme = $cart_info['theme'];
$cart_type = $cart_info['type'];
$currency = scabn_curr_symbol($cart_info['curr']);

	
if (empty($cart_theme)  ) $cart_theme = 'default';

if ($cart_type == 'tiny'){
	$items = 0;
	foreach($cart->get_contents() as $item) {
	$item_num = $item_num + $item['qty']; 
}
   if ( file_exists("../templates/".$cart_theme."/tiny_cart.php")) {
   	include ("../templates/".$cart_theme."/tiny_cart.php"); 
   } else {
		include ("../templates/default/tiny_cart.php");
	}
} else {
	if ( file_exists("../templates/".$cart_theme."/shopping_cart.php")) {
		include ("../templates/".$cart_theme."/shopping_cart.php");
	} else {
		include ("../templates/default/shopping_cart.php");
	}

 } 
 
 ?>
