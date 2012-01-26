<?php
require_once("../../../../../../wp-config.php");
//require_once("../../../../../..//wp-admin/admin.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Simple Cart & Buy Now</title>
	<script type="text/javascript" src="js/tiny_mce_popup.js"></script>
	<script type="text/javascript" src="js/dialog.js"></script>
    <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>    
    <script type="text/javascript" src="../format/jquery.formatCurrency-1.0.0.min.js"></script>
    

    <style type="text/css">
	h2 {
		font-size: 12px;
		color: #000000;
		padding:10px 0;
	}
	.mceActionPanel {
		margin-top:20px;
	}
	.checkout_page{
		margin:5px 5px 0 10px;
	}
    </style>
    
</head>
<body>
<form onsubmit="WPCheckoutDialog.insert();return false;" action="#">
<?php
	    global $scabn_options;	    
	    $options = $scabn_options;		
        $currency = scabn_curr_symbol($options['currency']); 
?>    
    <p>
    <input name="checkout_page" type="checkbox" value="1" class="checkout_page"/>
    Make this page my <b>Checkout Page</b>
    </p>
  <h2 class="gray">Product Specification</h2></td>
  </tr>
  <table width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="right" class="gray dwl_gray"><strong>Name</strong><br />(valid if you are using more than one product in your post. The title of the post is the name by default)</td>
    <td valign="top"><input name="name" type="text" class="prod dwl" id="name" size="20" /></td>
  </tr>  
  <tr>
    <td align="right" class="gray dwl_gray"><strong>Price </strong><?php echo $currency ?></td>
    <td><input name="price" type="text" class="prod dwl" id="price" size="10" /></td>
  </tr>
  <tr>
    <td align="right" class="gray dwl_gray"><strong>Flat Shipping: </strong><?php echo $currency ?></td>
    <td>
    <input id="shipping" name="shipping" type="text" class="prod dwl" size="10"/>
    </td>
    <tr>
    <td align="right" class="gray dwl_gray"><strong>Options Name</strong><br />(size,color,type...)</td>
    <td class="gray"><input id="p_options_name" name="p_options_name" type="text" class="prod" size="20" /></td>
  </tr>    
    <tr>
    <td align="right" class="gray dwl_gray"><strong>Product Options</strong><br /> separated by comma<br />(large,medium,small...)</td>
    <td class="gray"><textarea name="p_options" id ="p_options" cols="30" rows="2" class="prod dwl"></textarea></td>
  </tr>
  <tr>
    <td align="right" class="gray"><strong>Button Text</strong></td>
    <td class="gray"><input id="b_title" name="b_title" type="text" class="prod" size="20" value="Add To Cart"/></td>
  </tr>
    <tr>
    <td colspan="2" class="gray">
      <input name="no_cart" type="checkbox" value="-1" class="no_cart prod" />
      Go directly to the checkout page without using the shopping cart (valid if you are selling just one product)
   </td>
   </tr> 
  <tr>
    <td colspan="2" class="gray dwl_gray">
      <input name="qty_field" type="checkbox" value="-1" class="qty_field dwl prod" />
      Include the <en>Quantity</em> field
   </td>
   </tr>
    <tr>
    <td colspan="2">
    <br />
    Shortcode
    <textarea name="shortcode" cols="72" rows="2" id="shortcode"></textarea>
    </td>
  </tr> 
    
</table>


	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="insert" name="insert" value="{#insert}" onclick="WPCheckoutDialog.insert();" />
		</div>

		<div style="float: right">
			<input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
		</div>
	</div>
</form>

</body>
</html>



<?php
function wpchkt_downloadbles_product() {
    
	global $wpdb;


   	    $table_name = $wpdb->prefix . "wpckt_downloadbles";
	
	    echo $table_name;
	    
        $products = "SELECT id, name FROM ". $table_name ." ORDER BY id DESC;";
      	if($results = $wpdb->get_results($products,"ARRAY_A")){
		
		return $results;

		} else {	  
			return "No downloadble products uploaded.";
		}
			
}
?>
