<?php
/**
 * Adding Menu
 */
function scabn_add_pages() {
	add_submenu_page('plugins.php', 'SCABN Settings', 'SCABN Settings', 'administrator', 'scabn_settings', 'scabn_settings');		   
	}
	

function scabn_admin_register_head() {
    $url_style = SCABN_PLUGIN_URL . '/admin/scabn_admin.css';
    echo "<link rel='stylesheet' type='text/css' href='$url_style' />\n";
}

/**
 * Tyny_mce Button
 */

function scabn_addbuttons() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "add_scabn_tinymce_plugin");
     add_filter('mce_buttons', 'register_scabn_button');
   }
}
 
function register_scabn_button($buttons) {
   array_push($buttons, "separator", "scabn");
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_scabn_tinymce_plugin($plugin_array) {
   $plugin_array['scabn'] = SCABN_PLUGIN_URL.'/includes/js/tinymce/editor_plugin.js';
   return $plugin_array;
}

/**
 * Retrieve list of templates.
 *
 */
function scabn_get_templates() {

	$templates = array();

	$dir = SCABN_PLUGIN_DIR."/templates/";

	$dh  = opendir($dir);
	while (false !== ($filename = readdir($dh))) {

                if (!(($filename == '.')||($filename == '..')))    $templates[] = $filename;
    }        
		return $templates;

}



/**
 * Admin settings.
 *
 */
function scabn_settings() {

	global $scabn_options;
	global $scabn_currency_codes;
	
	require_once SCABN_PLUGIN_DIR. '/includes/formvalidator.php';	
	
	$validator = new FormValidator();
	$validator->addValidation("cart_url","req","Checkout/Process Url");
	$validator->addValidation("paypal_url","req","Paypal Url");
	$validator->addValidation("paypal_return_url","req","Paypal Return IPN Url");
	$validator->addValidation("paypal_email","req","Paypal E-mail");
	$validator->addValidation("paypal_email","email","The input for Email should be a valid email value");	
	
			
	$options = $scabn_options;
	
	
	if( isset($_POST['Submit'])) {		
		
		$newoptions['cart_url'] = $_POST['cart_url'];
		$newoptions['cart_theme'] = $_POST['cart_theme'];
		$newoptions['currency'] = $_POST['currency'];
		$newoptions['paypal_url'] = $_POST['paypal_url'];
		$newoptions['paypal_email'] = $_POST['paypal_email'];

		$newoptions['openssl_command'] = $_POST['openssl_command'];
		$newoptions['paypal_my_cert_file'] = $_POST['paypal_my_cert_file'];
		$newoptions['paypal_key_file'] = $_POST['paypal_key_file'];
		$newoptions['paypal_paypal_cert_file'] = $_POST['paypal_paypal_cert_file'];
		$newoptions['paypal_cert_id'] = $_POST['paypal_cert_id'];

		$newoptions['paypal_return_url'] = $_POST['paypal_return_url'];
		$newoptions['paypal_cancel_url'] = $_POST['paypal_cancel_url'];
				
		$newoptions['google_url'] = $_POST['google_url'];
		$newoptions['gc_merchantid'] = $_POST['gc_merchantid'];		
		$newoptions['gc_merchantkey'] = $_POST['gc_merchantkey'];		
		
		
		
		$newoptions['cart_type'] = $options['cart_type'];
		$newoptions['cart_title'] = $options['cart_title'];	
		$newoptions['version'] = $options['version'];	
		
	 
		if ( $options != $newoptions ) {
			$scabn_options = $options = $newoptions;							
			update_option('scabn_options', $options);				 		
		}	
		
		if($validator->ValidateForm()) {	
			
			?>
			<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
			 
		<?php  } else {  $options = $newoptions; ?>

			<div class="error">
			
				<p><strong>Please fill out the required fields</strong></p>
				<?php
					foreach($validator->GetErrors() as $inpname => $inp_err)
					{
					  echo "<p>$inp_err</p>\n";
					}
				?>
			</div>	

        <?php  }
		
		}
		
		$cart_url = $options['cart_url'];
		$cart_theme = $options['cart_theme'];
		$currency = $options['currency'];
		$paypal_url = $options['paypal_url'];
		$paypal_email = $options['paypal_email'];	
		$google_url = $options['google_url'];
		$gc_merchantid = $options['gc_merchantid'];	
		$gc_merchantkey = $options['gc_merchantkey'];	


		$openssl_command=$options['openssl_command'];
		$paypal_my_cert_file=$options['paypal_my_cert_file'];
		$paypal_key_file=$options['paypal_key_file'];
		$paypal_paypal_cert_file = $options['paypal_paypal_cert_file'];
		$paypal_return_url = $options['paypal_return_url'];
		$paypal_cancel_url = $options['paypal_cancel_url'];
		$paypal_cert_id = $options['paypal_cert_id'];


		
		?>	 	         

<div class="wrap wpckt">   

<form method="post" name="options" target="_self">

<h2>SCABN Settings</h2>

<h3>Shopping Cart</h3>

<table width="100%" cellpadding="10" class="form-table">

  <tr valign="top">
    <td align="right" width="200" scope="row">Checkout/Process Page Url</td>
  	<td align="left">
  	  <input name="cart_url" type="text" value="<?php echo $cart_url ?>" size="100"/>
  	</td>  	
  </tr>
  <tr valign="top">
    <td align="right" width="200" scope="row">Currency</td>
  	<td align="left">
      <select name="currency">   
         
      <?php foreach ($scabn_currency_codes as $curr=>$code){ ?>
      	<option value="<?php echo $curr ?>" <?php if ($curr == $currency ) echo "selected" ?> ><?php echo $code[1] ?></option>  
	  <?php } ?>
	  
      </select>      
  	</td>  	
  </tr>
  <tr valign="top">
    <td align="right" width="200" scope="row">Template</td>
  	<td align="left">
      <select name="cart_theme">   
         
      <?php foreach (scabn_get_templates() as $theme){ ?>
      	<option value="<?php echo $theme ?>" <?php if ($theme == $cart_theme ) echo "selected" ?> ><?php echo $theme ?></option>  
	  <?php } ?>
	  
      </select>
  	</td>  	
  </tr>  

</table>


<h3 class="title">Paypal</h3>
<h4>Required Fields</h4>
<table width="100%" cellpadding="10" class="form-table">

  <tr valign="top">
    <td align="right" scope="row" width="200" ><p>Paypal Url</p></td>
  	<td align="left">
      <p><input name="paypal_url" type="radio" value="live" <?php if ($paypal_url == "live" ) echo "checked" ?>  /> <strong>Live</strong> (https://www.paypal.com/cgi-bin/webscr)</p>    
      <p><input name="paypal_url" type="radio" value="sandbox" <?php if ($paypal_url == "sandbox" ) echo "checked" ?> /> <strong>Sandbox</strong> (https://www.sandbox.paypal.com/cgi-bin/webscr)</p>
  	</td>  	
  </tr>
  <tr valign="top">
    <td align="right" scope="row" width="200" >Paypal E-mail</td>
  	<td align="left">
  	  <input name="paypal_email" type="text" value="<?php echo $paypal_email ?>" size="50" />
  	</td>  	
  </tr>
  </table><table width="100%" cellpadding="10" class="form-table">
<h4>Optional Settings for PayPal</h4>  
  <tr valign="top">
    <td align="right" scope="row" width="200" >Paypal Return URL after order completed</td>
  	<td align="left">
  	  <input name="paypal_return_url" type="text" value="<?php echo $paypal_return_url ?>" size="50" />
  	</td>  	
  </tr>
<tr valign="top">
    <td align="right" scope="row" width="200" >Paypal Return URL after order cancelled</td>
  	<td align="left">
  	  <input name="paypal_cancel_url" type="text" value="<?php echo $paypal_cancel_url ?>" size="50" />
  	</td>  	
      
  
  </table>
  <table width="100%" cellpadding="10" class="form-table">

  
<H4>Optional Settings for Encrypted Buttons with Paypal</H4>
<tr valign="top">
    <td align="right" scope="row" width="200" >Full filesystem path for openssl command (typical: /usr/bin/openssl)</td>
  	<td align="left">
  	  <input name="openssl_command" type="text" value="<?php echo $openssl_command ?>" size="50" />
  	</td>  	
  </tr>
<tr valign="top">
    <td align="right" scope="row" width="200" >Full filesystem path for your (Paypal) Certificate File</td>
  	<td align="left">
  	  <input name="paypal_my_cert_file" type="text" value="<?php echo $paypal_my_cert_file ?>" size="50" />
  	</td>  	
  </tr>

<tr valign="top">
    <td align="right" scope="row" width="200" >Full filesystem path for your (Paypal) Key File</td>
  	<td align="left">
  	  <input name="paypal_key_file" type="text" value="<?php echo $paypal_key_file ?>" size="50" />
  	</td>  	
  </tr>

<tr valign="top">
    <td align="right" scope="row" width="200" >Full filesystem path for Paypal's Certificate File</td>
  	<td align="left">
  	  <input name="paypal_paypal_cert_file" type="text" value="<?php echo $paypal_paypal_cert_file ?>" size="50" />
  	</td>  	
  </tr>

<tr valign="top">
    <td align="right" scope="row" width="200" >Certificate ID (see paypal website)</td>
  	<td align="left">
  	  <input name="paypal_cert_id" type="text" value="<?php echo $paypal_cert_id ?>" size="50" />
  	</td>  	
  </tr>

<table>





<br />

<h3 class="title">Google Checkout</h3>

<table width="100%" cellpadding="10" class="form-table">

  </tr>
  <tr valign="top">
    <td align="right" scope="row" width="200" >Merchant ID</td>
  	<td align="left">
  	  <input name="gc_merchantid" type="text" value="<?php echo $gc_merchantid ?>" size="50" />
  	</td>  	
  </tr>
</table><table width="100%" cellpadding="10" class="form-table">
<H4>Optional Settings for Encrypted Cart for Google Checkout</H4>	
	<tr valign="top">
   	 <td align="right" scope="row" width="200" >Merchant Key</td>
  		<td align="left">
  	  	<input name="gc_merchantkey" type="text" value="<?php echo $gc_merchantkey ?>" size="50" />
  		</td>  	
  </tr>



</table>

<br />


<p><a href="" target="_blank"> Not ready: Visit the plugin page for more information.</a></p>

<p class="submit">
<input type="submit" name="Submit" value="Update" />
</p>

<br />

</form>
</div>

<?php
}


	
?>