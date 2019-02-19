<?php
/**
 * Plugin Name:     Easy Digital Downloads - Store Hours
 * Description:     Easily handle store hours of operation on your Easy Digital Downloads-powered site
 * Version:         1.1.0
 * Author:          Easy Digital Downloads, LLC
 * Author URI:      https://easydigitaldownloads.com
 * Text Domain:     edd-store-hours
 *
 * @package         EDD\StoreHours
 * @author          Easy Digital Downloads, LLC (support@easydigitaldownloads.com)
 */


// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) {
	exit;
}


if( ! class_exists( 'EDD_Store_Hours' ) ) {


	/**
	 * Main EDD_Store_Hours class
	 *
	 * @since       1.0.0
	 */
	class EDD_Store_Hours {


		/**
		 * @var         EDD_Store_Hours $instance The one true EDD_Store_Hours
		 * @since       1.0.0
		 */
		private static $instance;


		/**
		 * Get active instance
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      self::$instance The one true EDD_Store_Hours
		 */
		public static function instance() {
			if( ! self::$instance ) {
				self::$instance = new EDD_Store_Hours();
				self::$instance->setup_constants();
				self::$instance->includes();
				self::$instance->load_textdomain();
			}

			return self::$instance;
		}


		/**
		 * Setup plugin constants
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function setup_constants() {
			// Plugin version
			define( 'EDD_STORE_HOURS_VER', '1.1.0' );

			// Plugin path
			define( 'EDD_STORE_HOURS_DIR', plugin_dir_path( __FILE__ ) );

			// Plugin URL
			define( 'EDD_STORE_HOURS_URL', plugin_dir_url( __FILE__ ) );
		}


		/**
		 * Include necessary files
		 *
		 * @access      private
		 * @since       1.0.0
		 * @return      void
		 */
		private function includes() {
			require_once EDD_STORE_HOURS_DIR . 'includes/functions.php';
			require_once EDD_STORE_HOURS_DIR . 'includes/scripts.php';
			require_once EDD_STORE_HOURS_DIR . 'includes/widgets.php';
			require_once EDD_STORE_HOURS_DIR . 'includes/filters.php';

			if( is_admin() ) {
				require_once EDD_STORE_HOURS_DIR . 'includes/admin/settings/register.php';
				require_once EDD_STORE_HOURS_DIR . 'includes/admin/admin-bar.php';
			}
		}


		/**
		 * Internationalization
		 *
		 * @access      public
		 * @since       1.0.0
		 * @return      void
		 */
		public function load_textdomain() {
			// Set filter for language directory
			$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			$lang_dir = apply_filters( 'edd_store_hours_language_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale = apply_filters( 'plugin_locale', get_locale(), '' );
			$mofile = sprintf( '%1$s-%2$s.mo', 'edd-store-hours', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/edd-store-hours/' . $mofile;

			if( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/edd-store-hours/ folder
				load_textdomain( 'edd-store-hours', $mofile_global );
			} elseif( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/edd-store-hours/languages/ folder
				load_textdomain( 'edd-store-hours', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'edd-store-hours', false, $lang_dir );
			}
		}
	}
}


/**
 * The main function responsible for returning the one true EDD_Store_Hours
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      EDD_Store_Hours The one true EDD_Store_Hours
 */
function edd_store_hours() {
	if( ! class_exists( 'Easy_Digital_Downloads' ) ) {
		if( ! class_exists( 'S214_EDD_Activation' ) ) {
			require_once 'includes/libraries/class.s214-edd-activation.php';
		}

		$activation = new S214_EDD_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation = $activation->run();
	} else {
		return EDD_Store_Hours::instance();
	}
}
add_action( 'plugins_loaded', 'edd_store_hours' );