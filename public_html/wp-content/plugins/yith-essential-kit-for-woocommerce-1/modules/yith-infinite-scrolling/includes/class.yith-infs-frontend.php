<?php
/**
 * Frontend class
 *
 * @author Yithemes
 * @package YITH Infinite Scrolling
 * @version 1.0.0
 */

if ( ! defined( 'YITH_INFS' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_INFS_Frontend' ) ) {
	/**
	 * YITH Infinite Scrolling
	 *
	 * @since 1.0.0
	 */
	class YITH_INFS_Frontend {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_INFS_Frontend
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
		 * Returns single instance of the class
		 *
		 * @return \YITH_INFS_Frontend
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
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function __construct() {

			// enqueue scripts
			$enable = ( ! YITH_INFS_Admin::get_option( 'yith-infs-enable' ) ) ? 'yes' : YITH_INFS_Admin::get_option( 'yith-infs-enable' );
			if( $enable == 'yes' ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			}
		}

		/**
		 * Enqueue scripts
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function enqueue_scripts() {

			$min        = ( ! defined('SCRIPT_DEBUG') || ! SCRIPT_DEBUG ) ? '.min' : '';

			wp_enqueue_style( 'yith-infs-style', YITH_INFS_ASSETS_URL . '/css/frontend.css' );

			wp_enqueue_script( 'yith-infinitescroll', YITH_INFS_ASSETS_URL . '/js/yith.infinitescroll'.$min.'.js', array('jquery'), $this->version, true );
			wp_enqueue_script( 'yith-infs', YITH_INFS_ASSETS_URL . '/js/yith-infs'.$min.'.js', array('jquery', 'yith-infinitescroll'), $this->version, true );

			if( ! ( defined( 'YITH_INFS_PREMIUM' ) && YITH_INFS_PREMIUM ) ) {
				$this->options_to_script();
			}

		}

		/**
		 * Pass options to script
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function options_to_script(){

			// get options
			$navSelector        = ( ! YITH_INFS_Admin::get_option( 'yith-infs-navselector' ) ) ? 'nav.navigation' : YITH_INFS_Admin::get_option( 'yith-infs-navselector' );
			$nextSelector       = ( ! YITH_INFS_Admin::get_option( 'yith-infs-nextselector' ) ) ? 'nav.navigation a.next' : YITH_INFS_Admin::get_option( 'yith-infs-nextselector' );
			$itemSelector       = ( ! YITH_INFS_Admin::get_option( 'yith-infs-itemselector' ) ) ? 'article.post' : YITH_INFS_Admin::get_option( 'yith-infs-itemselector' );
			$contentSelector    = ( ! YITH_INFS_Admin::get_option( 'yith-infs-contentselector' ) ) ? '#main' : YITH_INFS_Admin::get_option( 'yith-infs-contentselector' );
			$loader             = ( ! YITH_INFS_Admin::get_option( 'yith-infs-loader-image' ) ) ? YITH_INFS_ASSETS_URL . '/images/loader.gif' : YITH_INFS_Admin::get_option( 'yith-infs-loader-image' );

			wp_localize_script( 'yith-infs', 'yith_infs', array (
				'navSelector'       => $navSelector,
				'nextSelector'      => $nextSelector,
				'itemSelector'      => $itemSelector,
				'contentSelector'   => $contentSelector,
				'loader'            => $loader,
				'shop'              => function_exists( 'WC' ) && ( is_shop() || is_product_category() || is_product_tag() ),
			));
		}
	}
}

/**
 * Unique access to instance of YITH_INFS_Frontend class
 *
 * @return \YITH_INFS_Frontend
 * @since 1.0.0
 */
function YITH_INFS_Frontend(){
	return YITH_INFS_Frontend::get_instance();
}