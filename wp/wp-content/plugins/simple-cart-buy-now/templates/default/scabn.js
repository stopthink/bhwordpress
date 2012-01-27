jQuery(function($){
				
$(document).ready(function(){

	$(".preload_img").show();
	
	load_cart("");
	
   $(".us_only").hide();
	
	switch_state();

	$("#txtShippingCountry").change(function(){													 
		
		switch_state();
	
	});
		
		
	switch_address();
	
	$("#use_paypal_address").click(function(){											
							
		switch_address();									

	});
		
	$(".add").click(function() {
							 
			var id = $(this).attr("id");
			var name = $("form."+id+" .item_name").val();
			var url = $("form."+id+" .item_url").val();
			var qty = $("form."+id+" .item_qty").val();
			var price = $("form."+id+" .item_price").val();
			var item_options_name = $("form."+id+" .item_options_name").val();
			var item_options = $("form."+id+" .item_options").val();
			var shipping = $("form."+id+" .item_shipping").val();
			var itemValues = "item_id="+ id + "&item_name=" + name + "&item_options_name="+item_options_name+"&item_options="+item_options+"&item_url=" + escape(url) + "&item_qty=" + qty + "&item_price="+price+"&item_shipping=" +shipping+ "&action=add_item"; 
			load_cart(itemValues);
			
			return false; 
	
	});

    $('.item_options').change(function() {
        get_custom_quantities(this);
    });

    function get_custom_quantities(option) { 
        option_field = $(option);
        product_info = option_field.val().split('-');
        name = product_info[0].trim();
        price = product_info[1].replace('$', '').trim();
        /* set proper values in the dom */
        id = option_field.parent().parent().attr('class');
        $("form."+id+" .item_price").val(price); // set hidden field
        $("form."+id+" .product-price").html('$' + parseFloat(price).toFixed(2)); // set hidden field
        //$("form."+id+" .item_name").val($("form."+id+" .product-title").html() + " - " + name);
    }

    get_custom_quantities(".item_options");
});

function switch_address(){
	
	if($("#use_paypal_address").is(":checked")){
		
			$("table.AddressEntryTable .address_box").attr("disabled", "disabled");
			$("table.AddressEntryTable .label").css("color","gray");
			
	} else {
		
			$("table.AddressEntryTable .address_box").attr("disabled", "");
			var inicial_color = $("table.entryTable").css("color");
			$("table.AddressEntryTable .label").css("color",inicial_color);				
		
	}	
	
}

function switch_state(){

	if ($("#txtShippingCountry").val() == "US") {
		
	  $(".wpchkt_state").addClass("hidden");
	  $(".wpchkt_state_us").removeClass("hidden");
	  
	  $("#txtShippingState_all").val("");
		
	} else {
		
	  $(".wpchkt_state_us").addClass("hidden");
	  $(".wpchkt_state").removeClass("hidden");
		
	}
}
 
function load_cart(values){

	 $("#wpchkt_widget").load(scabn_c_url, values,function(){
			$(".preload_img").hide();
			 $("#wpchkt_widget .update_cart").hide();
			 buttons_events();									 
	 });

}
 
function buttons_events() {
	
	$("#wpchkt_widget .remove_item").click(function() {				 
									
		$(".preload_img").show();	
		var id = $(this).attr("name");
		var itemValues = "remove="+id;		
		load_cart(itemValues);		
		return false;
	
	});
	
	
	$("#wpchkt_widget input").change(function() {
	
		var id = $(this).attr("title");
		var qty = $(this).val();		
		var itemValues = "id="+id+"&qty="+qty+"&update_item=true";
		load_cart(itemValues);	
		return false;		
	});
	
	
	$(".empty_cart").click(function() { 
									
		var itemValues = "empty=true";		
		load_cart(itemValues);
		return false;
	
	});

}

}); 
