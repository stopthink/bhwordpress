<span class="tiny_cart">
<?php if($cart->itemcount > 0) { ?>

		<a href='<?php echo $cart_url ?>'><strong><?php echo $item_num ?></strong> items in your cart</a>
        
<?php 	} else {  ?>
Your cart is empty	   
<?php  } ?>	
</span>
