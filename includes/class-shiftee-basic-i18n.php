<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://morgan.wpalchemists.com
 * @since      2.0.0
 *
 * @package    Shiftee Basic
 * @subpackage Shiftee Basic/includes
 */

if ( ! class_exists( 'Shiftee_Basic_I18n' ) ) {
	/**
	 * Define the internationalization functionality.
	 *
	 * Loads and defines the internationalization files for this plugin
	 * so that it is ready for translation.
	 *
	 * @since      2.0.0
	 * @package    Shiftee Basic
	 * @subpackage Shiftee Basic/includes
	 * @author     Range <support@shiftee.co>
	 */
	class Shiftee_Basic_I18n {


		/**
		 * Load the plugin text domain for translation.
		 *
		 * @since    2.0.0
		 */
		public function load_plugin_textdomain() {

			load_plugin_textdomain(
				'employee-scheduler',
				false,
				SHIFTEE_BASIC_DIR . '/languages/'
			);

		}


	}
}
