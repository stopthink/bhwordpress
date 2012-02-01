<?php 


function scabn_ini(){

	session_start();      // start the session
	
	$cart =& $_SESSION['wfcart'];  
	if(!is_object($cart)) $cart = new wfCart();
	
	global $scabn_options;	    
	$options = $scabn_options;	
	
	$cart->c_info($options['cart_type'], $options['cart_title'], $options['cart_url'], $options['currency'], $options['cart_theme']);

	scabn_request();
	
	//scabn_w_register();

}

/**
 * Inserting files on the header
 */ 
function scabn_head() {

	global $scabn_options;	    
	$options = $scabn_options;
    
	$scabn_header =  "\n<!-- Simple Cart and Buy Now -->\n";		
	$scabn_header .= "<script type=\"text/javascript\">scabn_c_url =\"".SCABN_PLUGIN_URL."/includes/scabn_ajax.php\";</script>\n";
	if (file_exists(SCABN_PLUGIN_DIR . "/templates/" . $options['cart_theme'] . "/scabn.js ")) {   
		$scabn_header .= "<script type=\"text/javascript\" src=\"".SCABN_PLUGIN_URL."/templates/".$options['cart_theme']."/scabn.js\"></script>\n";	
	} else {
	$scabn_header .= "<script type=\"text/javascript\" src=\"".SCABN_PLUGIN_URL."/templates/default/scabn.js\"></script>\n";
	}
	if (file_exists(SCABN_PLUGIN_DIR."/templates/".$options['cart_theme']."/style.css")) {
		$scabn_header .= "<link href=\"".SCABN_PLUGIN_URL."/templates/".$options['cart_theme']."/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";	
	} else {
		$scabn_header .= "<link href=\"".SCABN_PLUGIN_URL."/templates/default/style.css\" rel=\"stylesheet\" type=\"text/css\" />\n";
	}
	$scabn_header .=  "\n<!-- Simple Cart and Buy Now End-->\n";		
            
	print($scabn_header);
	
}

/**
 *  Get Options or default
 */
function get_scabn_options(){

	global $scabn_options;

	// Default Values
	$scabn_options_d = array(
								'cart_url' => '',
								'currency' => 'USD',
								'paypal_url' => 'sandbox',
								'paypal_email' => '',
								'cart_theme' => 'default',
								'cart_title' => 'Shopping Cart',
								'cart_type' => 'full',						
								'version' => '1.0.2'
							  );	

	if ( isset($scabn_options) )	return $scabn_options;

	$scabn_options = get_option('scabn_options');
	
	if (  empty($scabn_options) ) $scabn_options = $scabn_options_d;
	
	return $scabn_options;

}

function scabn_customcart() {		
	if ( isset($_GET['ccuuid'])) {		
		$uuid=$_GET['ccuuid'];
	} else if ( isset($_POST['ccuuid'])) {
		$uuid=$_POST['ccuuid'];
	}
	
	
	if ( isset($uuid)) {
		echo displayCustomCart($uuid); 
		
		
	} else {
		?><BR>Please enter the custom cart id here:
		<form name="input" action="custom-cart" method="GET">
		Custom Cart ID: <input type="text" name="ccuuid" /><p>
		<input type="submit" value="Submit" /></p>
		</form>

		<?php


	}

}

/**
 *  Shortcode
 */ 	
function scabn_sc($atts) {

	global $post;

	//session_start();
	
	$cart = $_SESSION['wfcart'];
		
	extract(shortcode_atts(array(
			'name' => $post->post_title,
           //'url' => $post->guid,
			'price' => '',
			'fshipping' => '',
			'weight' => '',
			'options_name' => '',
			'options' => '',		
			'b_title' => '',
            'qty_field' => '',
			'no_cart' => FALSE,
            'img_url' => get_bloginfo('template_url') . '/images/eggs.png',
            'desc' => '',
			), $atts));
		
	if (!empty ($atts)){
	
		global $post;
		   
		$id = $post->ID;
		$url =  $post->guid;
		
	    global $scabn_options;	    

        $currency = scabn_curr_symbol($scabn_options['currency']);
	
		if ($no_cart) {
			$action_url = SCABN_PLUGIN_URL."/includes/scabn_ajax.php";
			$add_class = '';			
		} else {
			$action_url = add_query_arg( array() );
			$add_class = 'class="add"';
		}

		$item_id = sanitize_title($name);
		
		//."-".$id;
		
        $output = '<div class="product cf">'."\n";
        $output .= '<img src="' . $img_url . '" class="product-image" />' . "\n";
        $output .= '<span>';
		$output .= '<form method="post" class="' . $item_id . '" action="' . $action_url . '">' . "\n";		
		$output .= '<input type="hidden" value="add_item" name="action"/>'."\n";
		$output .= '<input type="hidden" class="item_url" value="' . $url . '" name="item_url" />' . "\n";
		$output .= '<input type="hidden" value="' . $item_id  .'" name="item_id" />' . "\n";
		$output .= '<input type="hidden" class="item_name" value="' . $name . '" name="item_name" />' . "\n";
		$output .= '<input type="hidden" class="item_price" value="' . $price . '" name="item_price" />' . "\n";
		$output .= '<input type="hidden" class="item_shipping" value="' . $fshipping . '" name="item_shipping" />' . "\n";

		$output .= '<div class="product-title">' . $name . '</div>';
		  
		 
			if (!empty ($options)){
                #$output .= $options_name."\n"; // don't display option name since we're only using one option right now (qty)
                $output .= '<div class="product-options">';
                $output .= '<input type="hidden" value="' . $options_name . '" name="item_options_name" class="item_options_name" />' . "\n";
			
                $options = explode(',',$options);      
                if (count($options) == 1) {
                    $output .= "$options[0]\n";
                } else {
                    $output .= '<select name="item_options" class = "item_options" >' . "\n";
                    foreach ($options as $option){ 
                        $output .= "<option value='".$option."'>".$option."</option>\n";
                    }
                    $output .= "</select>\n";
                }
                $output .= "</div>\n";
            } else {
                $output .= '<div class="product-desc">' . $desc . '</div>';
            }

			if($qty_field) {
			$output .= "Qty: <input type='text' class='item_qty' value='1' size='2' name='item_qty'/>\n";
			} else {
			$output .= "<input type='hidden' class='item_qty' value='1' size='2' name='item_qty'/>\n";           
			}  

						

			if ($no_cart) {
				$output .= "<input type='hidden' value='true' name='no_cart'/>\n";			
			}	
		$output .= '<div class="add_to_cart_btn "><input type="submit" id="' . $item_id . '" class="add green-button" name="add" value="' . $b_title . '" /></div>' . "\n";
		$output .= '<div class="product-price">' . $currency.number_format($price,2) . '</div>';
		$output .= "</form>\n";
		$output .= "</span>\n";
		$output .= "</div>\n";
		
		return $output;
		
	} else {
	
	
		return scabn_process();

	}
}


/**
 *  The widget
 */
 
 
class scabnWidget extends WP_Widget {
    /** constructor */
    function scabnWidget() {
		$widget_ops = array('classname' => 'wpchkt_w', 'description' => __( 'Allows to display the shopping cart'));
		$this->WP_Widget('wpchkt_w', __('SCABN Checkout Cart'), $widget_ops);
	}
	
    /** @see WP_Widget::widget */
    function widget($args, $instance) {		
        extract( $args );
	
        $title = apply_filters('widget_title', $instance['title']);
		$type= isset($instance['type']) ? esc_attr($instance['type']) : 'full';

        ?>
              <?php echo $before_widget; ?>
                  <?php if ($type == 'full' && isset( $title )) {
                        echo $before_title . $title . $after_title;             	 		 
                        } 
							echo "<div id='wpchkt_widget'>";
							scabn_cart();
							echo "</div>"; 
						echo $after_widget;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
	
					
	$instance = $old_instance;
	$instance['title'] = strip_tags($new_instance['title']);
	$instance['type'] = strip_tags($new_instance['type']);
	
	global $scabn_options;
	    
	$options = $scabn_options;
	
	$cart_type = $options['cart_type'];
	$cart_title = $options['cart_title'];
	
	$cart_options = array('cart_type' => $cart_type, 'cart_type' => $cart_title);
	
	$newoptions = array();
	
	$newoptions['cart_type'] = strip_tags($new_instance['type']);
	$newoptions['cart_title'] = strip_tags($new_instance['title']);

	if ( $cart_options != $newoptions ) {
		$options['cart_type'] = $newoptions['cart_type'];
		$options['cart_title'] = $newoptions['cart_title'];
		update_option('scabn_options', $options);
		
		$scabn_options = $options;			
	}	
	
	
	
	
        return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {	
	
		$title = isset($instance['title']) ? esc_attr($instance['title']) : '';
		$type= isset($instance['type']) ? esc_attr($instance['type']) : 'full';		
        ?>
            <div class = "wpchkt_cart_w">
            <table border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td><input name="<?php echo $this->get_field_name('type'); ?>" type="radio" value="full"  <?php if ( $type == 'full') echo "checked" ?> class = "wpchkt_cart_f"/></td>
                <td><strong>Use Full Cart</strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>Title <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></td>
              </tr>
            </table>
            </div>
            
            <div class = "wpchkt_cart_w">
            <table border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td><input name="<?php echo $this->get_field_name('type'); ?>" id="<?php echo $this->get_field_id('type'); ?>" type="radio" value="tiny" <?php if( $type == 'tiny') echo "checked" ?> /></td>
                <td><strong>Use Tiny Cart</strong></td>
              </tr>
        
            </table>
            </div>
        <?php 
    }

} // class scabnWidget


// register scabnWidget widget
add_action('widgets_init', create_function('', 'return register_widget("scabnWidget");'));



/**
 * The Cart 
 */
 
function scabn_cart($type = 'full',$checkout = FALSE) {

	global $scabn_options;
	
	$options = $scabn_options;
	
	$post_url = add_query_arg( array() );
	$remove_url = "";
	$cart_url = $options['cart_url'];
	$cart_theme = $options['cart_theme'];
	$cart_type = $options['cart_type'];
	$currency = scabn_curr_symbol($options['currency']);
    
	$cart = $_SESSION['wfcart'];	
	
	if ($type == "tiny" || $cart_type == "tiny" && !$checkout){
	    foreach($cart->get_contents() as $item) {
	
		   $item_num = $item_num + $item['qty']; 
		   
		}
		
		if ( file_exists(SCABN_PLUGIN_DIR."/templates/".$cart_theme."/tiny_cart.php")) {		
			include (SCABN_PLUGIN_DIR."/templates/".$cart_theme."/tiny_cart.php");
		} else {			
			include (SCABN_PLUGIN_DIR."/templates/default/tiny_cart.php");
		}
	} else {		 
		if ( file_exists(SCABN_PLUGIN_DIR."/templates/".$cart_theme."/shopping_cart.php")) { 
			include (SCABN_PLUGIN_DIR."/templates/".$cart_theme."/shopping_cart.php");
		} else {
			include (SCABN_PLUGIN_DIR."/templates/default/shopping_cart.php");
		}
	}

} 

function scabn_add_query_arg ($key,$value){

	$remove_query = array();
	$remove_query[$key] = $value;
	
	$url = 'http://'.$_SERVER['HTTP_HOST'].add_query_arg($remove_query);

	return $url;

}

/**
 * Cart Process
 */
 
function scabn_process() {

	global $scabn_options;
	    
	$options = $scabn_options;
	
	//require_once SCABN_PLUGIN_DIR. '/includes/paypal.class.php';
   //global $scabn_states_code;
	//global $scabn_country_code;
	
	
	$post_url = add_query_arg( array() );
	$currency = scabn_curr_symbol($options['currency']);
	$currency_code = $options['currency'];
	
	$cart =& $_SESSION['wfcart'];
	$show_form=true;

	if(true == $show_form){
		
		if (isset($error_hash)){
			
			echo "<div class='val_error'>";
			echo "<p><strong>Please fill out the requiered fields</strong></p>";
			foreach($error_hash as $inpname => $inp_err)
			{
			  echo "<p>$inp_err</p>\n";
			}
			echo "</div>";		 
		}		
        //echo "<h3>".$options['cart_title']."</h3>"; // cant find this being set anywhere
        echo '<h3>View Cart</h3>';
		echo "<div id='wpchkt_checkout'>";
		scabn_cart('full', TRUE);
		echo "</div>";

		if($cart->itemcount > 0) {					 
			if ( file_exists(SCABN_PLUGIN_DIR."/templates/".$options['cart_theme']."/process.php")) { 
				include (SCABN_PLUGIN_DIR."/templates/".$options['cart_theme']."/process.php");
			} else {
				include (SCABN_PLUGIN_DIR."/templates/default/process.php");
			}
		}		
	}	
}


function scabn_make_paypal_button($options,$items) {
    /*
	$currency = $options['currency'];
	$paypal_email = $options['paypal_email'];	
	$paypal_url = $options['paypal_url'];
	$paypal_return_url=$options['paypal_return_url'];
	$paypal_cancel_url=$options['paypal_cancel_url'];
	$paypal_cert_id = $options['paypal_cert_id'];
	$OPENSSL=$options['openssl_command'];
	$MY_CERT_FILE= $options['paypal_my_cert_file'];
	$MY_KEY_FILE = $options['paypal_key_file'];
	$PAYPAL_CERT_FILE=$options['paypal_paypal_cert_file'];	
	
	if ($paypal_url == "live" ) {
		$ppo="<form method=\"post\" action=\"https://www.paypal.com/cgi-bin/webscr\">\n";
	} else { 
	 	$ppo="<form method=\"post\" action=\"https://www.sandbox.paypal.com/cgi-bin/webscr\"> \n";
	}
	
	$ppoptions=array();
	$ppoptions[]=array("business",$paypal_email);
	$ppoptions[]=array("cmd","_cart");
	$ppoptions[]=array("currency_code",$currency);
	$ppoptions[]=array("lc","US");
	$ppoptions[]=array("bn","PP-BuyNowBF");
	$ppoptions[]=array("upload","1");
	if ( $paypal_return_url != "" ) $ppoptions[]=array("return",$paypal_return_url);
	if ( $paypal_cancel_url != "" ) $ppoptions[]=array("cancel_return",$paypal_cancel_url);
	$ppoptions[]=array("weight_unit","lbs");	
		
	$count=0;
	foreach($items as $item) {					
		$count++;			
		$ppoptions[]=array("quantity_". (string)$count, $item['qty']);
		$ppoptions[]=array("item_name_". (string)$count,$item['name']);
		$ppoptions[]=array("amount_". (string)$count, $item['price']);
		$ppoptions[]=array("weight_". (string)$count, $item['weight']);		
      }
      	
	if ( ( $options['paypal_paypal_cert_file'] != "" ) & ( $options['paypal_key_file'] != "" ) & ( $options['paypal_my_cert_file'] !=  "" ) & ( $options['openssl_command'] != "" ) & (  $options['paypal_cert_id'] !="" ) ) {						
		$ppoptions[]=array("cert_id",$paypal_cert_id); 			
		
		$ppencrypt="";						
		foreach($ppoptions as $value) {		
			$ppencrypt .= $value[0] . "=" . $value[1] . "\n";
			}			
		$openssl_cmd = "($OPENSSL smime -sign -signer $MY_CERT_FILE -inkey $MY_KEY_FILE " .
						"-outform der -nodetach -binary <<_EOF_\n$ppencrypt\n_EOF_\n) | " .
						"$OPENSSL smime -encrypt -des3 -binary -outform pem $PAYPAL_CERT_FILE";
		exec($openssl_cmd, $output, $error);
		#echo "<BR>DATA:<BR>".$ppencrypt. "<BR>END DATA<BR>";
		if ($error) {
			echo "ERROR: encryption failed: $error";		
 		} else {
		
		$ppo .= "<input type=\"hidden\" name=\"cmd\" value=\"_s-xclick\">\n";
		$ppo .= "<input type=\"hidden\" name=\"encrypted\" value=\"" . implode("\n",$output) . "\">\n";	
		}	 					 
	
	} else {			
		//echo "No Encryption";		
		foreach($ppoptions as $value) {		
			$ppo .= "<input type=\"hidden\" name=\"" . $value[0] . "\" value=\"" . $value[1] . "\">\n"; 
		}
	}
	$ppo .= "<input type=\"image\" border=\"0\" name=\"submit\"
         src=\"https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif\" 
         alt=\"Make payments with PayPal - it's fast, free and secure!\"></form>";
    return $ppo;
     */

}


function CalcHmacSha1($data,$key) {
		$blocksize = 64;
		$hashfunc = 'sha1';
		if (strlen($key) > $blocksize) {
			$key = pack('H*', $hashfunc($key));
		}
		$key = str_pad($key, $blocksize, chr(0x00));
		$ipad = str_repeat(chr(0x36), $blocksize);
		$opad = str_repeat(chr(0x5c), $blocksize);
		$hmac = pack(
			'H*', $hashfunc(
				($key^$opad).pack(
					'H*', $hashfunc(
						($key^$ipad).$data
					)
				)
			)
		);
		//echo $hmac;
		echo("\n");
		return $hmac; 
}



function scabn_make_google_button($options,$shipoptions,$items) {
   
   $gc_merchantid= $options['gc_merchantid'];		
	$gc_merchantkey=$options['gc_merchantkey'];				

	$gc="<?xml version=\"1.0\" encoding=\"UTF-8\"?>
	<checkout-shopping-cart xmlns=\"http://checkout.google.com/schema/2\">";	
	$gc .= "<shopping-cart>\n\t<items>";

	foreach($items as $item) {		
		$gc .= "\n\t\t<item>";
		$gc .= "\n\t\t\t<item-name>".$item['name']."</item-name>";
		$gc .= "\n\t\t\t<item-description>".$item['name']."</item-description>";
		$gc .= "\n\t\t\t<unit-price currency=\"USD\">".$item['price']."</unit-price>";
		$gc .= "\n\t\t\t<quantity>".$item['qty']."</quantity>";
		$gc .= "\n\t\t</item>";
		}

	$gc .= "\n\t</items></shopping-cart>";
	$gc .= "\n<checkout-flow-support>
    <merchant-checkout-flow-support>
      <shipping-methods>";

	foreach($shipoptions as $soption) {
		$gc .= "\n\t<flat-rate-shipping name=\"". $soption['name'] . "\">";
		$gc .= "\n\t<price currency=\"USD\">".$soption['price']. "</price>";
		$gc .= "\n\t<shipping-restrictions>";
		$gc .= "\n\t\t<allowed-areas>";
		if ($soption['region'] == "USA" ) {
			$gc .= "\n\t\t<us-country-area country-area=\"ALL\"/>";
		} else {
			$gc .= "\n\t\t<world-area/>";
		}
		$gc .= "\n\t\t</allowed-areas>";
		$gc .= "\n\t\t<excluded-areas>";
		if ($soption['region'] == "NotUSA" ) {
			$gc .= "\n\t\t<us-country-area country-area=\"ALL\"/>";
		}
		$gc .= "\n\t\t</excluded-areas>";
		$gc .= "\n\t</shipping-restrictions>";
        	$gc .= "\n\t</flat-rate-shipping>";
	}
	//End Shipping for Google Checkout
	$gc .= "\n</shipping-methods></merchant-checkout-flow-support></checkout-flow-support>\n";
	//End Google Cart
	$gc .= "\n</checkout-shopping-cart>";

	$b64=base64_encode($gc);
	if ( $gc_merchantkey != "" ) $gcsig=base64_encode(CalcHmacSha1($gc,"$gc_merchantkey"));	
	
	$gout.= "<form method=\"POST\" action=\"https://checkout.google.com/api/checkout/v2/checkout/Merchant/".$gc_merchantid."/\">";
 	$gout .= "<input type=\"hidden\" name=\"cart\" value=\"". $b64."\">";

	if ( $gc_merchantkey != "" ) {
		$gout .= "<input type=\"hidden\" name=\"signature\" value=\"$gcsig\">";
	}

	$gout .= "<input type=\"image\" border=\"0\" name=\"submit\" src=\"https://checkout.google.com/buttons/checkout.gif?merchant_id=".$gc_merchantid."&w=160&h=43&style=trans&variant=text&loc=en_US\" alt=\"Make payments with Google Checkout\"></form>";
	return $gout;

	}	

?>
