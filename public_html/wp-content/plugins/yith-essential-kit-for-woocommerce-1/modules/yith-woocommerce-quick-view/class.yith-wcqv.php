<?php
/**
 * Main class
 *
 * @author Yithemes
 * @package YITH WooCommerce Quick View
 * @version 1.0.0
 */


if ( ! defined( 'YITH_WCQV' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCQV' ) ) {
	/**
	 * YITH WooCommerce Quick View
	 *
	 * @since 1.0.0
	 */
	class YITH_WCQV {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCQV
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = YITH_WCQV_VERSION;

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
		 * @return \YITH_WCQV
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
		 * @return mixed| YITH_WCQV_Admin | YITH_WCQV_Frontend
		 * @since 1.0.0
		 */
		public function __construct() {

			$action = array(
				'woocommerce_get_refreshed_fragments',
				'woocommerce_apply_coupon',
				'woocommerce_remove_coupon',
				'woocommerce_update_shipping_method',
				'woocommerce_update_order_review',
				'woocommerce_add_to_cart',
				'woocommerce_checkout'
			);

			// Exit if is woocommerce ajax
			if( defined( 'DOING_AJAX') && DOING_AJAX && isset( $_REQUEST['action'] ) && in_array( $_REQUEST['action'], $action ) ) {
				return;
			}

			if ( is_admin() && ! ( defined( 'DOING_AJAX') && DOING_AJAX && isset( $_REQUEST['context'] ) && $_REQUEST['context'] == 'frontend' ) ) {
				//Load Plugin Framework
				add_action( 'after_setup_theme', array( $this, 'plugin_fw_loader' ), 1 );

				YITH_WCQV_Admin();
			}
			// Class frontend
			$enable             = get_option( 'yith-wcqv-enable' ) == 'yes' ? true : false;
			$enable_on_mobile   = get_option( 'yith-wcqv-enable-mobile' ) ==  'yes' ? true : false;

			if( ( ! wp_is_mobile() && $enable ) || ( wp_is_mobile() && $enable_on_mobile && $enable ) ) {
				YITH_WCQV_Frontend();
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

			if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
				require_once( 'plugin-fw/yit-plugin.php' );
				}
		}
	}
}

/**
 * Unique access to instance of YITH_WCQV class
 *
 * @return \YITH_WCQV
 * @since 1.0.0
 */
function YITH_WCQV(){
	return YITH_WCQV::get_instance();
}