<?php
/*****
Plugin Name: Checkout Free Gift Fester
Plugin URI: http://sdminev.com
Description: Add free gift in checkout page
Version: 1.0
Author: Stefan Minev
Author URI: http://sdminev.com
*****/

function cfgf_init()
{
    load_plugin_textdomain('checkout-free-gift-fstr', false, dirname(plugin_basename(__FILE__)));
}
add_action('init', 'cfgf_init');

// General page UI
add_filter('admin_init', 'fstr_inputs');

function fstr_inputs()
{
    register_setting('general', 'fstr_homegym', 'esc_attr');
    add_settings_field('fstr_homegym', '<label for="fstr_homegym">' . __('HomeGym ID', 'fstr_homegym') . '</label>', 'fstr_homegym_html', 'general');
    
    register_setting('general', 'fstr_food', 'esc_attr');
    add_settings_field('fstr_food', '<label for="fstr_food">' . __('Food Plan ID', 'fstr_food') . '</label>', 'fstr_food_html', 'general');
    
    register_setting('general', 'fstr_yoga', 'esc_attr');
    add_settings_field('fstr_yoga', '<label for="fstr_yoga">' . __('Yoga Plan ID', 'fstr_yoga') . '</label>', 'fstr_yoga_html', 'general');
    
}


function fstr_homegym_html()
{
    $value = get_option('fstr_homegym', '');
    echo '';
    echo '<input type="text" id="fstr_homegym" name="fstr_homegym" placeholder="HomeGym ID (ex. 1,5,25)" value="' . $value . '" />';
    echo '<p class="description" id="timezone-description">Choose the ID of the Home Gym product</p>';
}

function fstr_food_html()
{
    $value = get_option('fstr_food', '');
    echo '<input type="text" id="fstr_food" name="fstr_food" placeholder="Food Plan ID (ex. 1,5,25)" value="' . $value . '" />';
    echo '<p class="description" id="timezone-description">Choose the ID of the Food Plan product</p>';
}

function fstr_yoga_html()
{
    $value = get_option('fstr_yoga', '');
    echo '<input type="text" id="fstr_yoga" name="fstr_yoga" placeholder="Yoga Plan ID (ex. 1,5,25)" value="' . $value . '" />';
    echo '<p class="description" id="timezone-description">Choose the ID of the Yoga Plan product</p>';
}

// get range price for free delivery
if (!function_exists('get_free_delivery_price')) {
    function get_free_delivery_price()
    {
        switch (get_current_blog_id()) {
            default:
            case '1':
                $free = get_option('woocommerce_free_shipping_6_settings');
                $free = $free['min_amount'];
                break;
            
            case '5':
                $free = get_option('woocommerce_free_shipping_4_settings');
                $free = $free['min_amount'];
                break;
            
            case '6':
                $free = get_option('woocommerce_free_shipping_4_settings');
                $free = $free['min_amount'];
                break;
            
            case '7':
                $free = get_option('woocommerce_free_shipping_4_settings');
                $free = $free['min_amount'];
                break;
            
            case '11':
                $free = get_option('woocommerce_free_shipping_4_settings');
                $free = $free['min_amount'];
                break;
            
            case '22':
                $free = get_option('woocommerce_free_shipping_4_settings');
                $free = $free['min_amount'];
                break;
            
            case '23':
                $free = get_option('woocommerce_free_shipping_4_settings');
                $free = $free['min_amount'];
                break;
            
            case '21':
                $free = get_option('woocommerce_free_shipping_4_settings');
                $free = $free['min_amount'];
                break;
            
            case '26':
                $free = get_option('woocommerce_free_shipping_4_settings');
                $free = $free['min_amount'];
                break;
            
            case '28':
                $free = get_option('woocommerce_free_shipping_4_settings');
                $free = $free['min_amount'];
                break;
            
            case '29':
                $free = get_option('woocommerce_free_shipping_4_settings');
                $free = $free['min_amount'];
                break;
            
            case '9':
                $free = get_option('woocommerce_free_shipping_9_settings');
                $free = $free['min_amount'];
                break;
        }
        
        return $free;
    }
}
add_action('template_redirect', 'fester_add_free_gift');
function fester_add_free_gift()
{
    $freefood                  = 0;
    $freegym                   = 0;
    $freeyoga                  = 0;
    $cart_items_id             = array();
    $cart_items                = WC()->cart->get_cart();
    $fstr_subtotal             = WC()->cart->get_subtotal();
    $fstr_free_delivery_price  = get_free_delivery_price();
    $freegym                   = get_option('fstr_homegym');
    $freefood                  = get_option('fstr_food');
    $freeyoga                  = get_option('fstr_yoga');
    $fstr_product_cart_id_gym  = WC()->cart->generate_cart_id($freegym);
    $fstr_product_cart_id_food = WC()->cart->generate_cart_id($freefood);
    $fstr_product_cart_id_yoga = WC()->cart->generate_cart_id($freeyoga);
    
    if (!WC()->cart->find_product_in_cart($fstr_product_cart_id_food)) {
        if ($fstr_subtotal > 0) {
            WC()->cart->add_to_cart($freefood);
        }      
    }
    if (!WC()->cart->find_product_in_cart($fstr_product_cart_id_yoga)) {
        
        foreach (WC()->cart->get_cart() as $cart_item_fstr) {
            //$iswell = get_post_meta($cart_item_fstr['product_id'], 'iswell', true);
			$iswell = get_post_meta( $cart_item_fstr['product_id'], '_sku', true );
			$iswell2 = get_post_meta( $cart_item_fstr['variation_id'], '_sku', true );
			
			//echo '<p>'.$iswell.$iswell2.'</p>';
			//$iswell = $product_fstr;
	if ($iswell=="WOW-P-DTXWNS" || $iswell=="WOW-T-WNS" || $iswell=="WOW-P-DTXWNSBTP" || $iswell=="WOW-P-SFWNSBTB" || $iswell=="WOW-P-WNSBTP" || $iswell=="WOW-P-WNSBTB" || $iswell2=="WOW-P-DTXWNS" || $iswell2=="WOW-T-WNS" || $iswell2=="WOW-P-DTXWNSBTP" || $iswell2=="WOW-P-SFWNSBTB" || $iswell2=="WOW-P-WNSBTP" || $iswell2=="WOW-P-WNSBTB") {
                WC()->cart->add_to_cart($freeyoga);
            }
            
        }
    }
    
    if (!WC()->cart->find_product_in_cart($fstr_product_cart_id_gym)) {
        if ($fstr_subtotal >= $fstr_free_delivery_price) {
            WC()->cart->add_to_cart($freegym);
        } else {
            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                if ($cart_item['product_id'] == $freegym) {
                    WC()->cart->remove_cart_item($freegym);
                }
            }
        }
        
    }
}

add_action('template_redirect', 'fester_remove_free_gift');
function fester_remove_free_gift()
{
    $freegym                   = get_option('fstr_homegym');
    $freefood                  = get_option('fstr_food');
    $freeyoga                  = get_option('fstr_yoga');
    $fstr_subtotal             = WC()->cart->get_subtotal();
    $fstr_free_delivery_price  = get_free_delivery_price();
    $fstr_product_cart_id_gym  = WC()->cart->generate_cart_id($freegym);
    $fstr_product_cart_id_food = WC()->cart->generate_cart_id($freefood);
    $fstr_product_cart_id_yoga = WC()->cart->generate_cart_id($freeyoga);
    if ($fstr_subtotal == 0) {
        WC()->cart->remove_cart_item($freefood);
        WC()->cart->remove_cart_item($fstr_product_cart_id_food);
    }
    if ($fstr_subtotal < $fstr_free_delivery_price) {
        WC()->cart->remove_cart_item($freegym);
        WC()->cart->remove_cart_item($fstr_product_cart_id_gym);
    }
    $thereisnowell = 1;
    foreach (WC()->cart->get_cart() as $cart_item_fstr) {
        //if (get_post_meta($cart_item_fstr['product_id'], 'iswell', true)) {
		//$iswell = $cart_item_fstr->get_sku();
			$iswell = get_post_meta( $cart_item_fstr['product_id'], '_sku', true );
			$iswell2 = get_post_meta( $cart_item_fstr['variation_id'], '_sku', true );		
	if ($iswell=="WOW-P-DTXWNS" || $iswell=="WOW-T-WNS" || $iswell=="WOW-P-DTXWNSBTP" || $iswell=="WOW-P-SFWNSBTB" || $iswell=="WOW-P-WNSBTP" || $iswell=="WOW-P-WNSBTB" || $iswell2=="WOW-P-DTXWNS" || $iswell2=="WOW-T-WNS" || $iswell2=="WOW-P-DTXWNSBTP" || $iswell2=="WOW-P-SFWNSBTB" || $iswell2=="WOW-P-WNSBTP" || $iswell2=="WOW-P-WNSBTB") {
            $thereisnowell = 0;
        }
    }
    if ($thereisnowell) {
        WC()->cart->remove_cart_item($freeyoga);
        WC()->cart->remove_cart_item($fstr_product_cart_id_yoga);
    }
}