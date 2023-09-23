<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://profiles.wordpress.org/sumanbiswas013/
 * @since      1.0.0
 *
 * @package    Custom_Login_Sso
 * @subpackage Custom_Login_Sso/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Custom_Login_Sso
 * @subpackage Custom_Login_Sso/includes
 * @author     Suman Biswas <sumanbiswas013@gmail.com>
 */
class Custom_Login_Sso_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'custom-login-sso',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
