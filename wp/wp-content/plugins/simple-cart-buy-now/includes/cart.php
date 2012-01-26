<?php

/*
Based on Webforce Cart v.1.5
http://www.webforcecart.com/
*/


class wfCart {

	var $total = 0;
	var $itemcount = 0;
	var $items = array();
   var $itemprices = array();
	var $itemqtys = array();
   var $itemname = array();
	var $itemoptions = array();
	var $itemurl = array();
   var $cart_info = array();

	var $itemshipping = array();
	var $user_info = array();
	var $total_plus = 0;
	//var $total_shipping = 0;



	function cart() {} // constructor function
				
	function get_contents()
	{ // gets cart contents
		$items = array();
		foreach($this->items as $tmp_item)
		{
		        $item = FALSE;

			$item['id'] = $tmp_item;
            $item['qty'] = $this->itemqtys[$tmp_item];
			$item['price'] = $this->itemprices[$tmp_item];			
			$item['shipping'] = $this->itemshipping[$tmp_item];
			$item['name'] = $this->itemname[$tmp_item];
			$item['options'] = $this->itemoptions[$tmp_item];
			$item['url'] = $this->itemurl[$tmp_item];
			$item['subtotal'] = $item['qty'] * $item['price'];
			
            $items[] = $item;
		}
		return $items;
	} // end of get_contents




	function add_item($itemid,$qty=1,$price = FALSE, $name = FALSE, $options, $url = FALSE, $shipping = 0)
	{ // adds an item to cart	 	
		if($this->itemqtys[$itemid] > 0)
            { 
            // the item is already in the cart, so we'll just increase the quantity
		 	$this->itemqtys[$itemid] = $qty + $this->itemqtys[$itemid];
			//use getItemPricing to get the pricing, rather than using value input from user via website			
			$this->itemprices[$itemid]=getItemPricing($itemid,$this->itemqtys[$itemid],$price);						
		} else {						
			$this->items[]=$itemid;
			$this->itemqtys[$itemid] = $qty;
			$this->itemprices[$itemid] = getItemPricing($itemid,$this->itemqtys[$itemid],$price);
			$this->itemname[$itemid] = $name;
			$this->itemoptions[$itemid] = $options;
			$this->itemurl[$itemid] = $url;
			$this->itemshipping[$itemid] = $shipping;
		}
		$this->_update_total();
	} // end of add_item


	function edit_item($itemid,$qty)
	{ // changes an items quantity

		if($qty < 1) {
			$this->del_item($itemid);
		} else {
			$this->itemqtys[$itemid] = $qty;
			// uncomment this line if using 
			// the wf_get_price function
			$this->itemprices[$itemid] = getItemPricing($itemid,$this->itemqtys[$itemid],$this->itemprices[$itemid]);			
		}
		$this->_update_total();
	} // end of edit_item


	function del_item($itemid)
	{ // removes an item from cart
		$ti = array();
		$this->itemqtys[$itemid] = 0;
		foreach($this->items as $item)
		{
			if($item != $itemid)
			{
				$ti[] = $item;
			}
		}
		$this->items = $ti;
		$this->_update_total();
	} //end of del_item


    function empty_cart()
	{ // empties / resets the cart
		$this->total = 0;
		$this->itemcount = 0;
		$this->items = array();
		$this->itemprices = array();
		$this->itemqtys = array();
		$this->itemname = array();
		$this->itemurl = array();
		$this->itemshipping = array();
	} // end of empty cart


	function _update_total()
	{ // internal function to update the total in the cart
	        $this->itemcount = 0;
		$this->total = 0;
		$this->total_plus = 0;
		//$this->total_shipping = 0;
                if(sizeof($this->items > 0))
		{
                        foreach($this->items as $item) {
                                $this->total = $this->total + ($this->itemprices[$item] * $this->itemqtys[$item]);
								$this->total_plus = $this->total_plus + ($this->itemprices[$item] * $this->itemqtys[$item]) + ($this->itemshipping[$item] * $this->itemqtys[$item]);
								//$this->total_shipping = $this->total_shipping + ($this->itemshipping[$item] * $this->itemqtys[$item]);
				$this->itemcount++;
			}
		}
	} // end of update_total


  
	function c_info($c_type, $c_title, $c_url, $c_curr, $c_theme){
	
	        $this->cart_info['curr'] = $c_curr;
			$this->cart_info['type'] = $c_type;
			$this->cart_info['title'] = $c_title;
			$this->cart_info['url'] = $c_url;
			$this->cart_info['theme'] = $c_theme;	
	}
	
	
}
?>
