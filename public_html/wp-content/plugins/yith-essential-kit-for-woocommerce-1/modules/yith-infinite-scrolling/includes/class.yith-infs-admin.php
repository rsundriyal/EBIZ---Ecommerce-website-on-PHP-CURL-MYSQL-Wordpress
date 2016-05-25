<?php
/*  Copyright 2013  Your Inspiration Themes  (email : plugins@yithemes.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/**
 * Admin class
 *
 * @author Yithemes
 * @package YITH Infinite Scrolling
 * @version 1.0.0
 */

if ( ! defined( 'YITH_INFS' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_INFS_Admin' ) ) {
	/**
	 * Admin class.
	 * The class manage all the admin behaviors.
	 *
	 * @since 1.0.0
	 */
	class YITH_INFS_Admin {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_INFS_Admin
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
		public $version = YITH_INFS_VERSION;

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
		protected $_premium_landing = 'http://yithemes.com/themes/plugins/yith-infinite-scrolling/';

		/**
		 * @var string Infinite Scrolling panel page
		 */
		protected $_panel_page = 'yith_infs_panel';

		/**
		 * Various links
		 *
		 * @var string
		 * @access public
		 * @since 1.0.0
		 */
		public $doc_url = 'http://yithemes.com/docs-plugins/yith-infinite-scrolling/';

		/**
		 * The name for the plugin options
		 *
		 * @access public
		 * @var string $testimonial_post_type
		 * @since 1.0.0
		 */
		protected static $_plugin_options = 'yit_infs_options';


		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_INFS_Admin
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

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_style' ) );

			//Add action links
			add_filter( 'plugin_action_links_' . plugin_basename( YITH_INFS_DIR . '/' . basename( YITH_INFS_FILE ) ), array( $this, 'action_links') );
			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

			if ( ! ( defined( 'YITH_INFS_PREMIUM' ) && YITH_INFS_PREMIUM ) ) {
				add_action( 'yith_infinite_scrolling_premium', array( $this, 'premium_tab' ) );
			}

			// YITH INFS Loaded
			do_action( 'yith_infs_loaded' );
		}

		/**
		 * Enqueue style
		 *
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithems.com>
		 * @access public
		 */
		public function enqueue_style() {
			if ( isset( $_GET['page'] ) && $_GET['page'] == 'yith_infs_panel' ) {
				wp_enqueue_style( 'yith-infs-admin', YITH_INFS_ASSETS_URL . '/css/admin.css' );
			}
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

			$links[] = '<a href="' . admin_url( "admin.php?page={$this->_panel_page}" ) . '">' . __( 'Settings', 'yith-infinite-scrolling' ) . '</a>';
			if ( ! ( defined( 'YITH_INFS_PREMIUM' ) && YITH_INFS_PREMIUM ) ) {
				$links[] = '<a href="' . $this->get_premium_landing_uri() . '" target="_blank">' . __( 'Premium Version', 'yith-infinite-scrolling' ) . '</a>';
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
				'general' => __( 'Settings', 'yith-infinite-scrolling' )
			);

			if ( ! ( defined( 'YITH_INFS_PREMIUM' ) && YITH_INFS_PREMIUM ) ) {
				$admin_tabs['premium']  = __( 'Premium Version', 'yith-infinite-scrolling' );
			}

			$args = array(
				'create_menu_page' => true,
				'parent_slug'      => '',
				'page_title'       => __( 'Infinite Scrolling', 'yith-infinite-scrolling' ),
				'menu_title'       => __( 'Infinite Scrolling', 'yith-infinite-scrolling' ),
				'parent'           => 'infs',
				'parent_page'      => 'yit_plugin_panel',
				'plugin-url'       => YITH_INFS_URL,
				'page'             => $this->_panel_page,
				'admin-tabs'       => $admin_tabs,
				'options-path'     => YITH_INFS_DIR . 'plugin-options',
			);

			/* === Fixed: not updated theme  === */
			if( ! class_exists( 'YIT_Plugin_Panel' ) ) {
				require_once( YITH_INFS_DIR . '/plugin-fw/lib/yit-plugin-panel.php' );
			}

			$this->_panel = new Yit_Plugin_Panel( $args );
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
			$premium_tab_template = YITH_INFS_TEMPLATE_PATH . '/admin/' . $this->_premium;
			if( file_exists( $premium_tab_template ) ) {
				include_once( $premium_tab_template );
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

			if ( defined( 'YITH_INFS_FREE_INIT' ) && YITH_INFS_FREE_INIT == $plugin_file ||
				 defined( 'YITH_INFS_INIT') && YITH_INFS_INIT == $plugin_file ) {
				$plugin_meta[] = '<a href="' . $this->doc_url . '" target="_blank">' . __( 'Plugin Documentation', 'yith-infinite-scrolling' ) . '</a>';
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

		/**
		 * Get options from db
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 * @param $option string
		 * @return mixed
		 */
		public static function get_option( $option ) {
			// get all options
			$options = get_option( self::$_plugin_options );

			if( isset( $options[ $option ] ) ) {
				return $options[ $option ];
			}

			return false;
		}



	}
}
/**
 * Unique access to instance of YITH_WCQV_Admin class
 *
 * @return \YITH_INFS_Admin
 * @since 1.0.0
 */
function YITH_INFS_Admin(){
	return YITH_INFS_Admin::get_instance();
}