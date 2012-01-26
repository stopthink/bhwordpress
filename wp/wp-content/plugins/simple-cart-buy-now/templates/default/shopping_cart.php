<?php if($cart->itemcount > 0) { ?>
	
	<form action='<?php echo $post_url ?>' method='post'>
	<table border='0' cellpadding='5' cellspacing='2' class="cart" align='center' width='100%'>	
		<thead>
		<tr class="thead">
			<th scope="col" class="cart_qty_col">Qty</th>
			<th scope="col" class="cart_product_name_col">Items</th>
            <th scope="col" class="cart_price_col">Price</th>
            <th scope="col" class="cart_remove_col"></th>
		</tr>
		</thead>	
<?php
	$i=0;
		foreach($cart->get_contents() as $item) {

?>				
		  <tr class = "ck_content">
			<td align="center">
            <input type='hidden' name='item_<?php  echo $i; ?>' value='<?php echo $item['id']; ?>' />
            <input type='text' name='qty_<?php  echo $i; ?>' size='2' value='<?php echo $item['qty'] ?>' class = 'qty_<?php  echo $item['id']; ?>' title='<?php echo $item['id']; ?>' /></td>
				<!--<td><a href='<?php echo $item['url'] ?>'><strong><?php echo $item['name'] ?></strong>-->
				<td><strong><?php echo $item['name'] ?></strong>
				<?php 
                if (count($item['options']) > 0){
                    echo ', ';
                    echo scabn_item_options($item['options']);
				} 
				?>
                
                </td>
				<td align='right'><?php echo $currency ?> <?php echo number_format($item['price'],2) ?>
<?php				
				if ($remove_url == ""){
				$remove_query = array();
				$remove_query['remove'] = $item['id'];
				$remove_url = add_query_arg($remove_query);
				}
				
?>				
			    </td><td align="right">	
				<a href='<?php echo $remove_url ?>' class ='remove_item' name = '<?php echo $item['id'] ?>'>Remove</a>
				</td>
				</tr>
<?php 

			$i ++;
			}

?>				
			<!--	
				<tr class='ck_content'>
				<td align='right' colspan='2'>Sub-total</td>
				<td align='right'><?php echo $currency ?> <?php echo number_format($cart->total,2) ?></td>
				</tr>		
				<tr class='ck_content shipping'>
				<td align='right' colspan='2'>Shipping</td>
				<td align='right'>TBD</td>
				</tr>			  
			-->	
				<tr class='ck_content total'>
                    <td align='left' class='buttons'>            
                        <input type='submit' name='update' value='Update' class ='update_cart' />
                    </td>
                    <td align='right'><b>Total</b></td>
                    <td align='right'><b><?php echo $currency ?> <?php echo number_format($cart->total,2) ?></b></td>
				</tr>
                <tr><td class='ck_content go_to_checkout' colspan="3">
               <?php   if (empty($cart_url)) { ?>
				 <span class='val_error'><strong>ERROR:</strong> Include the Checkout/Process Page Url on the Plugin Settings</span>
				<?php  } else {	 ?>					
				 <!--<span class='go_to_checkout'><a href='<?php echo $cart_url ?>'><strong>Go to Checkout</strong></a> </span> -->
				<?php } ?>
                </td></tr>
                					   
        </table>
        </form>	
<br /><br />
        
<?php 	} else {  ?>
	   
		<span class='no_items'>No items in your cart</span>
        
<?php  } ?>	
	



				  
