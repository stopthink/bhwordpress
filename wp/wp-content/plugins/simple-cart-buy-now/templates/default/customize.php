<?php


function getItemPricing($itemname,$qty,$inputprice) {
	//This is the function that sets the pricing
	//for all items in your cart. If you want to use
	//the pricing that is input by the user then just return
	//the $inputprice. This lets you set pricing in the simple
	//wordpress syntax of [scabn name="ItemName" price="1.00"]
	//however, this number is set by the user's computer and 
	//thus can easily be edited by a hacker to set the price
	//to anything. For better security, and the ability to
	//automatically apply price-breaks, you can have this 
	//function return the pricing based entirely on some 
	//internal criteria and ignore the user-supplied price ($inputprice)
	
	//Not secure but simple
	//return $inputprice 

	//Sample db query	
	//global $wpdb;
	//$sql=$wpdb->prepare('SELECT price FROM pricing where name=%s and minimum <= %s order by minimum desc',$itemname,$qty);
	//$price = $wpdb->get_var($sql);
	//if ( $price == Null ) {		
		//print 'Error getting price for item '.$itemid.'. Please contact us about this problem.';
		//This will get the buyer to notice the error and complain. Price should not be null from db query		
		//$price=99999.99;

	//default to just use input for user
	$price=$inputprice;
	return $price;

	}	
	
	


function getItemWeight($itemname,$qty,$inputweight) {
	//This is the function that sets the weight
	//for all items in your cart. If you want to use
	//the weight that is input by the user then just return
	//the $inputweight. This lets you set pricing in the simple
	//wordpress syntax of [scabn name="ItemName" weight="1.00"]
	
	//NOTE: needs testing on weight per unit, vs total weight for this time	
	
	return $qty*$inputweight;
 
	} 
 


function getCustomCart($uuid) {
	//Return a list of items for custom cart based on the uuid of the cart
	//Return nothing is no cart found.

	//Sample db query to get custom cart:
	//global $wpdb;	
	//$sql=$wpdb->prepare('SELECT id,name,qty,price, weight FROM customcartitems, customcart where customcart.id = customcartitems.id and customcart.id =%s and customcart.expire > now()',$uuid);	
	//$items = $wpdb->get_results($sql);	
	//$cartitems=array();	
	//foreach ($items as $item) {
	//	$cartitems[]=array("id"=>$item->id,"name"=>$item->name,"qty"=>$item->qty,"price"=>$item->price,"weight"=>$item->weight);
	//}		
		
	$cartitems=NULL;
	return $cartitems;	
	
}

function displayCustomCart($uuid) {
	//This is a function that takes as custom cart uuid number
	//and generates a custom cart. We do a db query to get
	//the item(s) and pricing, etc, and then call paypal / google functions
	//to make a buy now buttons. 

	$options=get_scabn_options();
	$items=getCustomCart($uuid);	
	if ($items) {
			
		echo displayCustomCartContents($items);
		echo scabn_make_paypal_button($options,$items);
		echo scabn_make_google_button($options,$items);				
	} else {				
		echo 'Could not find your custom cart, or the cart has expired';
	}
	return;
}


function getShippingOptions($items) {
	//Currently only used for Google, as Paypal needs this hard-coded into
	//their website, this gives a list of the shipping options and pricing.
	//in principle this can be a function of them items being shipped
	//their weight, etc. 
	//We could put option on Paypal button for shipping, but shipping options
	//depend on shipping location which we don't ask for. So put your shipping
	//formula into paypal website. 
	//region can be "all" "NotUSA" or "USA"
	$ship=array();
	$ship[]=array("name" => "USPS Standard Shipping", "price" => "5", "region" => "all");
	$ship[]=array("name" => "USPS Priority Shipping (USA Only)", "price" => "10", "region" => "USA");
	$ship[]=array("name" => "USPS Express Shipping (USA Only)", "price" => "20", "region" => "USA");
	$ship[]=array("name" => "Global Priority (6-10 days)", "price" => "20", "region" => "NotUSA");
	$ship[]=array("name" => "Global Express (6 days)", "price" => "30", "region" => "NotUSA" );
	return $ship;
}


function displayCustomCartContents($items) {
	if ($items) {	
		?>	
		<table border='0' cellpadding='5' cellspacing='1' class='entryTable' align='center' width='96%'>	
		<thead>
		<tr class="thead">
			<th scope="col">Qty</th>
			<th scope="col">Items</th>
			<th scope="col" align="right">Unit Price</th>
		</tr>
		</thead>	
		<?php
		$options=get_scabn_options();
		$currency = scabn_curr_symbol($options['currency']);		
		foreach($items as $item) {

			?>				
		   <tr class = "ck_content">
				<td><?php echo $item['qty'] ?> </td>            
				<td><?php echo $item['name'] ?></td>
				<td align='right'><?php echo $currency ?> <?php echo number_format($item['price'],2) ?>	</td>
			</tr>
			<?php 
		}
		echo "</table>";		
	}
}


	





?>