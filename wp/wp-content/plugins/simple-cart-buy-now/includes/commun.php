<?php

/**
 * Cart Request
 */


function scabn_request(){


	$cart =& $_SESSION['wfcart'];	
	
	
    
	if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'add_item'  ){	    
		
		if ( ( $_REQUEST['item_options'] != 'undefined') && ( $_REQUEST['item_options'] != '') ) {
		
			$item_options = array ($_REQUEST['item_options_name'] => $_REQUEST['item_options']);
			
			$item_id = sanitize_title($_REQUEST['item_id']."-".$_REQUEST['item_options']);			
		}
		
		else {
		
			$item_options = array ();
				
			$item_id = $_REQUEST['item_id'];
		   
		}
		 
		//print "<BR>Running add_item with qty=".$_REQUEST['item_qty'].'<BR><HR></hr>';
		$cart->add_item($item_id,$_REQUEST['item_qty'],$_REQUEST['item_price'],$_REQUEST['item_name'],$item_options,$_REQUEST['item_url'],$_REQUEST['item_shipping']);
		//print 'Finish run<HR></hr>';
	}
	
	if (isset ($_REQUEST['remove']) && $_REQUEST['remove'] ){
	   $cart->del_item($_REQUEST['remove']);
	}
	
	if (isset($_REQUEST['empty']) && $_REQUEST['empty']  ){
	   $cart->empty_cart();
	}
	
	if (isset($_REQUEST['update']) && $_REQUEST['update']  ){
	   for ($i=0; $i<$cart->itemcount; $i++){
	   if (ctype_digit($_POST['qty_'.$i])){
	   echo is_int($_POST['qty_'.$i]);
	   $cart->edit_item($_POST['item_'.$i],$_POST['qty_'.$i]);
	   }
	   }
	}
	
	if (isset($_REQUEST['update_item']) && $_REQUEST['update_item']  ){
	   if (ctype_digit($_REQUEST['qty'])){ 
	   $cart->edit_item($_REQUEST['id'],$_REQUEST['qty']);
	   }
	}	

}


/**
 * Return Items Options Pair
 */

function scabn_item_options ($options_arr){

	foreach($options_arr as $key=>$value){
	
    //$options_pair = $key."-".$value."<br />"; // we're just using options for quantities, so we don't need option name for now
    $options_pair = $value;
    
	
	}
	
	return $options_pair;

}

/**
 *  Currency code & symbol
 */


function scabn_curr_symbol($code){	

    global $scabn_currency_codes;
	
	$d = $scabn_currency_codes[$code][0];
	
	$symbol = "&#".$d.";";
	
	return $symbol;

}



?>
