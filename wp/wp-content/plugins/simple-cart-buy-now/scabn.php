<?php
/*
Plugin Name: Simple Cart & Buy Now
Plugin URI: http://web-argument.com/wordpress-checkout/
Description: Simple Cart and BuyNow for Wordpress
Version: 1.1.0
Author: Ben Luey
Author URI: http://iguanaworks.net
*/

/*
This plugin was once Wordpress-Checkout. Thanks to Alain Gonzalez for
that plugin -- I've forked it to remove features / complexity I don't
need and to add support for Google Checkout, signed carts, etc.

Simple Cart & Buy Now (SCABN) is designed to implement a basic shopping
cart system for wordpress e-commerce websites with two goals:
1) No storing of user information
2) Security: encrypted 'buynow' buttons and pricing, etc, not gotten  
   via data provided by the user's browser.

Paypal BuyNow & Google Checkout supported.
Optional encrypted buttons for both Google & Paypal 

Template system for customize look of the shopping cart
and to use optional db backend or other phph functions to get 
pricing, shipping, weight information, bulk discounts, etc

*/

/*
    Copyright (C) 2010 Alain Gonzalez (support@web-argument.com)
    Copyright (C) 2011 Ben Luey (bluey@iguanaworks.net)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

if ( ! defined( 'SCABN_PLUGIN_DIR' ) ) 	define( 'SCABN_PLUGIN_DIR', WP_PLUGIN_DIR . '/' . plugin_basename( dirname( __FILE__ ) ) );
if ( ! defined( 'SCABN_PLUGIN_URL' ) )  define( 'SCABN_PLUGIN_URL', WP_PLUGIN_URL . '/' . plugin_basename( dirname( __FILE__ ) ) );

require_once SCABN_PLUGIN_DIR. '/includes/cart.php';	
require_once SCABN_PLUGIN_DIR. '/includes/functions.php';
require_once SCABN_PLUGIN_DIR. '/includes/commun.php';
require_once SCABN_PLUGIN_DIR. '/includes/scabn_codes.php';
require_once SCABN_PLUGIN_DIR. '/admin/scabn_admin.php';

$scabn_options = get_scabn_options();

if (file_exists(SCABN_PLUGIN_DIR. '/templates/'.$scabn_options['cart_theme'].'/customize.php') ) { 
	require_once SCABN_PLUGIN_DIR. '/templates/'.$scabn_options['cart_theme'].'/customize.php';	
} else {	 	
	require_once SCABN_PLUGIN_DIR. '/templates/default/customize.php';	
}

//Apparently we don't need this 
//as I removed it and nothing 
//seems to have broken. 
//wp_enqueue_script('jquery');

add_action('init','scabn_ini');
add_action('wp_head', 'scabn_head');
add_action('admin_init','scabn_addbuttons');

add_shortcode('scabn', 'scabn_sc');
add_shortcode('scabn_customcart', 'scabn_customcart');

add_action('admin_menu', 'scabn_add_pages');
add_action('admin_head', 'scabn_admin_register_head');

?>
