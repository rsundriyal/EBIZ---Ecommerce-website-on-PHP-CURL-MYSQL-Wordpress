<?php
/**
 * Main class
 *
 * @author Yithemes
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */


if ( ! defined( 'YITH_WCWTL' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCWTL' ) ) {
	/**
	 * YITH WooCommerce Waiting List
	 *
	 * @since 1.0.0
	 */
	class YITH_WCWTL {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCWTL
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = YITH_WCWTL_VERSION;


		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCWTL
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
		 * @return mixed| YITH_WCWTL_Admin | YITH_WCWTL_Frontend
		 * @since 1.0.0
		 */
		public function __construct() {

			$enable = get_option( 'yith-wcwtl-enable' ) == 'yes';

			// Class admin
			if ( is_admin() ) {

				// Load Plugin Framework
				add_action( 'after_setup_theme', array( $this, 'plugin_fw_loader' ), 1 );
				
				YITH_WCWTL_Admin();
				// add meta in product edit page
				if( $enable ) {
					YITH_WCWTL_Meta();
				}
			}
			// Class frontend
			if( get_option('yith-wcwtl-enable') == 'yes' ) {
				YITH_WCWTL_Frontend();
			}

			// Email actions
			add_filter( 'woocommerce_email_classes', array( $this, 'add_woocommerce_emails' ) );
			add_action( 'woocommerce_init', array( $this, 'load_wc_mailer' ) );
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
				require_once( YITH_WCWTL_DIR . '/plugin-fw/yit-plugin.php' );
				}
		}

		/**
		 * Filters woocommerce available mails, to add waitlist related ones
		 *
		 * @param $emails array
		 *
		 * @return array
		 * @since 1.0
		 */
		public function add_woocommerce_emails( $emails ) {
			$emails['YITH_WCWTL_Email'] = include( 'class.yith-wcwtl-email.php' );
			return $emails;
		}

		/**
		 * Loads WC Mailer when needed
		 *
		 * @return void
		 * @since 1.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.it>
		 */
		public function load_wc_mailer() {
			add_action( 'send_yith_waitlist_mailout', array( 'WC_Emails', 'send_transactional_email' ), 10, 2 );
		}
	}
}

/**
 * Unique access to instance of YITH_WCWTL class
 *
 * @return \YITH_WCWTL
 * @since 1.0.0
 */
function YITH_WCWTL(){
	return YITH_WCWTL::get_instance();
}