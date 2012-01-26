tinyMCEPopup.requireLangPack();
	
var WPCheckoutDialog = {
	init : function() {
		var f = document.forms[0];
        var shortcode;
					
				jQuery('.checkout_page').click(function(){
				//checkout page selected
					var dis = jQuery('.prod').attr('disabled');
					
					if (dis) {					
					jQuery('.prod').attr('disabled', ''); 
					jQuery('.gray').css('color','black');					
						update_sc();	
					} else {					
					
					jQuery('.prod').attr('disabled', 'disabled');
					jQuery('.gray').css('color','gray');
                        jQuery('#shortcode').val('[scabn]');
					}
				
				});				

			
				
				jQuery('.qty_field').click(function(){
					 update_sc();
				});	
				
				jQuery('.no_cart').click(function(){
					 update_sc();
				});				
								
				
				jQuery('#price').blur(function()
				{
					jQuery('#price').formatCurrency({ symbol: '', digitGroupSymbol: '' });
					update_sc();
				});
				jQuery('#shipping').blur(function()
				{
					jQuery('#shipping').formatCurrency({ symbol: '', digitGroupSymbol: '' });
					update_sc();
				});	
		
				jQuery('#name').blur(function()
				{
					update_sc();
				});

				jQuery('#b_title').blur(function()
				{
					update_sc();
				});
				
				jQuery('#p_options_name').blur(function()
				{
					update_sc();
				});
				
				jQuery('#p_options').blur(function()
				{
					update_sc();
				});				
		
		
		
		function update_sc() {
			 shortcode = 'scabn';
			 
				 if ((jQuery('#name').val() !=0)&(jQuery('#name').val()) !=null){
					 shortcode = shortcode + '  name="'+jQuery('#name').val()+'"';
				 }			 
		 
				 if ((jQuery('#price').val() !=0)&(jQuery('#price').val()) !=null){
					 shortcode = shortcode + '  price="'+jQuery('#price').val()+'"';
				 }
				 if ((jQuery('#shipping').val() !=0)&(jQuery('#shipping').val() !=null)){
					 shortcode = shortcode + '  fshipping="'+jQuery('#shipping').val()+'"';
				 }
				 if ((jQuery('#weight').val() !=0)&(jQuery('#weight').val() !=null)){
					 shortcode = shortcode + '  weight="'+jQuery('#weight').val()+'"';
				 }
				 if ((jQuery('#p_options_name').val() !=0)&(jQuery('#p_options_name').val() !=null)){
					 shortcode = shortcode + '  options_name="'+jQuery('#p_options_name').val()+'"';
				 }
				 if ((jQuery('#p_options').val() !=0)&(jQuery('#p_options').val() !=null)){
					 shortcode = shortcode + '  options="'+jQuery('#p_options').val()+'"';
				 }				 
				 if ( $('.qty_field').is(':checked')) {
					 shortcode = shortcode + ' qty_field = "true"';
				 }
				 if ( $('.no_cart').is(':checked')) {
					 shortcode = shortcode + ' no_cart = "true"';
				 }					 
				 
				 jQuery('#shortcode').val('['+shortcode+'  b_title="'+jQuery('#b_title').val()+'"]');

		}
			
				
	},

	insert : function() {
		// Insert the contents from the input into the document

		tinyMCEPopup.editor.execCommand('mceInsertContent', false, jQuery('#shortcode').val());
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(WPCheckoutDialog.init, WPCheckoutDialog);

