<?php
/**
 * Main class
 *
 * @author Yithemes
 * @package YITH WooCommerce Recently Viewed Products
 * @version 1.0.0
 */


if ( ! defined( 'YITH_WRVP' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WRVP' ) ) {
	/**
	 * YITH WooCommerce Recently Viewed Products
	 *
	 * @since 1.0.0
	 */
	class YITH_WRVP {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WRVP
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = YITH_WRVP_VERSION;


		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WRVP
		 * @since 1.0.0
		 */
		public static function get_instance(){
			if( is_null( self::$instance ) ){
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @return mixed YITH_WRVP_Admin | YITH_WRVP_Frontend
		 * @since 1.0.0
		 */
		public function __construct() {

			if ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'frontend' ) ) {
				// Load Plugin Framework
				add_action( 'after_setup_theme', array( $this, 'plugin_fw_loader' ), 1 );
				// Class admin
				YITH_WRVP_Admin();
			}
			else {
				// Class frontend
				YITH_WRVP_Frontend();
			}

		}

		/**
		 * Load Plugin Framework
		 *
		 * @since  1.0
		 * @access public
		 * @return void
		 * @author Andrea Grillo <andrea.grillo@yithemes.com>
		 */
		public function plugin_fw_loader() {

			if ( ! defined( 'YIT' ) || ! defined( 'YIT_CORE_PLUGIN' ) ) {
				require_once( YITH_WRVP_DIR . '/plugin-fw/yit-plugin.php' );
			}

		}
	}
}

/**
 * Unique access to instance of YITH_WRVP class
 *
 * @return \YITH_WRVP
 * @since 1.0.0
 */
function YITH_WRVP(){
	return YITH_WRVP::get_instance();
}