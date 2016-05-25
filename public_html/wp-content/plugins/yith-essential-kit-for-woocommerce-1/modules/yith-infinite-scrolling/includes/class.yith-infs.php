<?php
/**
 * Main class
 *
 * @author Yithemes
 * @package YITH Infinite Scrolling
 * @version 1.0.0
 */


if ( ! defined( 'YITH_INFS' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_INFS' ) ) {
	/**
	 * YITH Infinite Scrolling
	 *
	 * @since 1.0.0
	 */
	class YITH_INFS {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_INFS
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = YITH_INFS_VERSION;

		/**
		 * Plugin object
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $obj = null;

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_INFS
		 * @since 1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @return mixed YITH_INFS_Admin | YITH_INFS_Frontend
		 * @since 1.0.0
		 */
		public function __construct() {
			// Class admin
			if ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) )  {
				// Load Plugin Framework
				add_action( 'after_setup_theme', array( $this, 'plugin_fw_loader' ), 1 );

				YITH_INFS_Admin();
			}
			else {
				// Frontend class
				YITH_INFS_Frontend();
			}
		}

		/**
		 * Load Plugin Framework
		 *
		 * @since  1.0.0
		 * @access public
		 * @return void
		 * @author Andrea Grillo <andrea.grillo@yithemes.com>
		 */
		public function plugin_fw_loader() {
			if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
				require_once( YITH_INFS_DIR . '/plugin-fw/yit-plugin.php' );
			}
		}
	}
}

/**
 * Unique access to instance of YITH_INFS class
 *
 * @return \YITH_INFS
 * @since 1.0.0
 */
function YITH_INFS(){
	return YITH_INFS::get_instance();
}