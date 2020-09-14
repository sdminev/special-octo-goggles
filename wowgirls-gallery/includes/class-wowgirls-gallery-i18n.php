<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://www.sdminev.com
 * @since      1.0.0
 *
 * @package    Checkout_Discount_Fstr
 * @subpackage Checkout_Discount_Fstr/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Checkout_Discount_Fstr
 * @subpackage Checkout_Discount_Fstr/includes
 * @author     Stefan Minev <stefanminev@gmail.com>
 */
class Checkout_Discount_Fstr_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'checkout-discount-fstr',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
