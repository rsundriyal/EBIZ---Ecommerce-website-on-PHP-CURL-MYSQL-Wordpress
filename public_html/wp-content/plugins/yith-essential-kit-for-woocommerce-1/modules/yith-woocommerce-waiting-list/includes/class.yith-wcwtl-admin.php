<?php
/**
 * Admin class
 *
 * @author Yithemes
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCWTL' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCWTL_Admin' ) ) {
	/**
	 * Admin class.
	 * The class manage all the admin behaviors.
	 *
	 * @since 1.0.0
	 */
	class YITH_WCWTL_Admin {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCWTL_Admin
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Plugin options
		 *
		 * @var array
		 * @access public
		 * @since 1.0.0
		 */
		public $options = array();

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = YITH_WCWTL_VERSION;

		/**
		 * @var $_panel Panel Object
		 */
		protected $_panel;

		/**
		 * @var $_premium string Premium tab template file name
		 */
		protected $_premium = 'premium.php';

		/**
		 * @var string Premium version landing link
		 */
		protected $_premium_landing = 'https://yithemes.com/themes/plugins/yith-woocommerce-waiting-list/';

		/**
		 * @var string Waiting List panel page
		 */
		protected $_panel_page = 'yith_wcwtl_panel';

		/**
		 * Various links
		 *
		 * @var string
		 * @access public
		 * @since 1.0.0
		 */
		public $doc_url = 'https://yithemes.com/docs-plugins/yith-woocommerce-waiting-list/';

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCWTL_Admin
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
		 * @access public
		 * @since 1.0.0
		 */
		public function __construct() {

			add_action( 'admin_menu', array( $this, 'register_panel' ), 5) ;

			//Add action links
			add_filter( 'plugin_action_links_' . plugin_basename( YITH_WCWTL_DIR . '/' . basename( YITH_WCWTL_FILE ) ), array( $this, 'action_links' ) );
			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

			if ( ! ( defined( 'YITH_WCWTL_PREMIUM' ) && YITH_WCWTL_PREMIUM ) ) {
				add_action( 'yith_waiting_list_premium', array( $this, 'premium_tab' ) );
			}

			// YITH WCWTL Loaded
			do_action( 'yith_wcwtl_loaded' );

		}

		/**
		 * Action Links
		 *
		 * add the action links to plugin admin page
		 *
		 * @param $links | links plugin array
		 *
		 * @return   mixed Array
		 * @since    1.0
		 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
		 * @return mixed
		 * @use plugin_action_links_{$plugin_file_name}
		 */
		public function action_links( $links ) {

			$links[] = '<a href="' . admin_url( "admin.php?page={$this->_panel_page}" ) . '">' . __( 'Settings', 'yith-woocommerce-waiting-list' ) . '</a>';
			if ( ! ( defined( 'YITH_WCWTL_PREMIUM' ) && YITH_WCWTL_PREMIUM ) ) {
				$links[] = '<a href="' . $this->get_premium_landing_uri() . '" target="_blank">' . __( 'Premium Version', 'yith-woocommerce-waiting-list' ) . '</a>';
			}
			return $links;
		}

		/**
		 * Add a panel under YITH Plugins tab
		 *
		 * @return   void
		 * @since    1.0
		 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
		 * @use     /Yit_Plugin_Panel class
		 * @see      plugin-fw/lib/yit-plugin-panel.php
		 */
		public function register_panel() {

			if ( ! empty( $this->_panel ) ) {
				return;
			}

			$admin_tabs = array(
				'general' => __( 'Settings', 'yith-woocommerce-waiting-list' )
			);

			if ( ! ( defined( 'YITH_WCWTL_PREMIUM' ) && YITH_WCWTL_PREMIUM ) ) {
				$admin_tabs['premium']  = __( 'Premium Version', 'yith-woocommerce-waiting-list' );
			}

			$args = array(
				'create_menu_page' => apply_filters( 'yith-wcwtl-register-panel-create-menu-page', true ),
				'parent_slug'      => '',
				'page_title'       => __( 'Waiting List', 'yith-woocommerce-waiting-list' ),
				'menu_title'       => __( 'Waiting List', 'yith-woocommerce-waiting-list' ),
				'capability'       => apply_filters( 'yith-wcwtl-register-panel-capabilities', 'manage_options' ),
				'parent'           => '',
				'parent_page'      => apply_filters( 'yith-wcwtl-register-panel-parent-page', 'yit_plugin_panel' ),
				'page'             => $this->_panel_page,
				'admin-tabs'       => apply_filters( 'yith-wcwtl-admin-tabs', $admin_tabs ),
				'options-path'     => YITH_WCWTL_DIR . '/plugin-options'
			);

			/* === Fixed: not updated theme  === */
			if( ! class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {
				require_once( YITH_WCWTL_DIR . '/plugin-fw/lib/yit-plugin-panel-wc.php' );
			}

			$this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
		}

		/**
		 * Premium Tab Template
		 *
		 * Load the premium tab template on admin page
		 *
		 * @return   void
		 * @since    1.0
		 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
		 * @return void
		 */
		public function premium_tab() {
			$premium_tab_template = YITH_WCWTL_TEMPLATE_PATH . '/admin/' . $this->_premium;
			if( file_exists( $premium_tab_template ) ) {
				include_once($premium_tab_template);
			}

		}

		/**
		 * plugin_row_meta
		 *
		 * add the action links to plugin admin page
		 *
		 * @param $plugin_meta
		 * @param $plugin_file
		 * @param $plugin_data
		 * @param $status
		 *
		 * @return   Array
		 * @since    1.0
		 * @author   Andrea Grillo <andrea.grillo@yithemes.com>
		 * @use plugin_row_meta
		 */
		public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {

			if( defined( 'YITH_WCWTL_INIT') && YITH_WCWTL_INIT == $plugin_file ) {
				$plugin_meta[] = '<a href="' . $this->doc_url . '" target="_blank">' . __( 'Plugin Documentation', 'yith-woocommerce-waiting-list' ) . '</a>';
			}

			return $plugin_meta;
		}

		/**
		 * Get the premium landing uri
		 *
		 * @since   1.0.0
		 * @author  Andrea Grillo <andrea.grillo@yithemes.com>
		 * @return  string The premium landing link
		 */
		public function get_premium_landing_uri(){
			return defined( 'YITH_REFER_ID' ) ? $this->_premium_landing . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing.'?refer_id=1030585';
		}

	}
}
/**
 * Unique access to instance of YITH_WCWTL_Admin class
 *
 * @return \YITH_WCWTL_Admin
 * @since 1.0.0
 */
function YITH_WCWTL_Admin(){
	return YITH_WCWTL_Admin::get_instance();
}