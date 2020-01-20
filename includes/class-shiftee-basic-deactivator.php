<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://morgan.wpalchemists.com
 * @since      2.0.0
 *
 * @package    Shiftee Basic
 * @subpackage Shiftee Basic/includes
 */

if ( ! class_exists( 'Shiftee_Basic_Deactivator' ) ) {
	/**
	 * Fired during plugin deactivation.
	 *
	 * This class defines all code necessary to run during the plugin's deactivation.
	 *
	 * @since      2.0.0
	 * @package    Shiftee Basic
	 * @subpackage Shiftee Basic/includes
	 * @author     Range <support@shiftee.co>
	 */
	class Shiftee_Basic_Deactivator {

		/**
		 * If we ever need any deactivation functions, they can go here.
		 *
		 * @since    2.0.0
		 */
		public static function deactivate() {
			// no deactivation functions yet.
		}

	}
}
