<?php
/**
 * Frontend class
 *
 * @author Yithemes
 * @package YITH WooCommerce Waiting List
 * @version 1.1.1
 */

if ( ! defined( 'YITH_WCWTL' ) ) {
	exit;
} // Exit if accessed directly

if( ! class_exists( 'YITH_WCWTL_Frontend' ) ) {
	/**
	 * Frontend class.
	 * The class manage all the Frontend behaviors.
	 *
	 * @since 1.0.0
	 */
	class YITH_WCWTL_Frontend {

		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCWTL_Frontend
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Current object product
		 *
		 * @var object
		 * @since 1.0.0
		 */
		protected $current_product = false;

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
		 * @return \YITH_WCWTL_Frontend
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

			// add form
			add_action( 'woocommerce_before_single_product', array( $this, 'add_form' ) );

			add_action( 'template_redirect', array( $this, 'yith_waiting_submit' ), 100 );

			// enqueue frontend js
			add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		}

		/**
		 * Register scripts frontend
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function register_scripts(){
			$min = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min';
			wp_register_script( 'yith-wcwtl-frontend', YITH_WCWTL_ASSETS_URL . '/js/frontend'.$min.'.js', array( 'jquery'), YITH_WCWTL_VERSION, true );
		}

		/**
		 * Enqueue scripts and style
		 *
		 * @since 1.0.8
		 * @access public
		 * @author Francesco Licandro
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( 'yith-wcwtl-frontend' );
		}

        /**
		 * Init and add action form to products
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function add_form(){
			global $post;

			if( get_post_type( $post->ID ) == 'product' && is_product() ) {

				$this->current_product = wc_get_product( $post->ID );

				if ( $this->current_product->product_type == 'grouped' ) {
					return;
				}

				// first enqueue scripts
				$this->enqueue_scripts();

				if( $this->current_product->product_type == 'variable' ){
					add_action( 'woocommerce_stock_html', array( $this, 'output_form' ), 20, 3 );
				}
				else {
					add_action( 'woocommerce_stock_html', array( $this, 'output_form' ), 20, 2 );
				}
			}
		}

		/**
		 * Add form to stock html
		 *
		 * @access public
		 * @since 1.0.0
		 * @param string $html
		 * @param int $availability
		 * @param object | boolean $product
		 * @return string
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function output_form( $html, $availability, $product = false ) {

			if( ! $product ) {
				$product = $this->current_product;
			}

			return $html . $this->the_form( $product );
		}

		/**
		 * Output the form according to product type and user
		 *
		 * @access public
		 * @since 1.0.0
		 * @param $product
		 * @return string
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function the_form( $product ) {

			$html = '';

			// control if variation is in excluded list
			if( $product->is_in_stock() ) {
				return $html;
			}

			$user           = wp_get_current_user();
			$product_type   = $product->product_type;
			$product_id     = ( $product_type == 'simple' ) ? $product->id : $product->variation_id;
			$waitlist       = yith_waitlist_get( $product_id );
			$url            = ( $product_type == 'simple' ) ? get_permalink( $product->id ) : get_permalink( $product->parent->id );

			// set query
			$url = add_query_arg( YITH_WCWTL_META , $product_id, $url );
			$url = wp_nonce_url( $url, 'action_waitlist' );
			$url = add_query_arg( YITH_WCWTL_META . '-action', 'register', $url );

			//add message
			$html .= '<div id="yith-wcwtl-output"><p class="yith-wcwtl-msg">' . get_option( 'yith-wcwtl-form-message' ) . '</p>';

			// get buttons label from options
			$label_button_add   = get_option( 'yith-wcwtl-button-add-label' );
			$label_button_leave = get_option( 'yith-wcwtl-button-leave-label' );

			if( $product_type != 'variation' && ! $user->exists() ) {

				$html .= '<form method="post" action="' . esc_url( $url ) . '">';
				$html .= '<label for="yith-wcwtl-email">' . __( 'Email Address', 'yith-woocommerce-waiting-list' ) . '<input type="email" name="yith-wcwtl-email" id="yith-wcwtl-email" /></label>';
				$html .= '<input type="submit" value="' . $label_button_add . '" class="button alt" />';
				$html .= '</form>';

			}
			elseif( $product_type == 'variation' && ! $user->exists() ) {

				$html .= '<input type="email" name="yith-wcwtl-email" id="yith-wcwtl-email" class="wcwtl-variation" />';
				$html .= '<a href="' . esc_url( $url ) . '" class="button alt">' . $label_button_add . '</a>';
			}
			elseif( is_array( $waitlist ) && yith_waitlist_user_is_register( $user->user_email, $waitlist ) ) {
				$url   = add_query_arg( YITH_WCWTL_META . '-action', 'leave', $url );
				$html .= '<a href="' . esc_url( $url ) . '" class="button button-leave alt">' . $label_button_leave . '</a>';
			}
			else {
				$html .= '<a href="' . esc_url( $url ) . '" class="button alt">' . $label_button_add . '</a>';
			}

			$html .= '</div>';

			return $html;
		}

		/**
		 * Add user to waitlist
		 *
		 * @access public
		 * @since 1.0.0
		 * @author Francesco Licandro <francesco.licandro@yithemes.com>
		 */
		public function yith_waiting_submit() {

			$user = wp_get_current_user();

			if( ! ( isset( $_REQUEST[ YITH_WCWTL_META ] ) && is_numeric( $_REQUEST[ YITH_WCWTL_META ] ) && isset( $_REQUEST[ YITH_WCWTL_META . '-action' ] ) ) ) {
				return;
			}
			
			$action = $_REQUEST[ YITH_WCWTL_META . '-action' ];

			$user_email = ( isset( $_REQUEST[ 'yith-wcwtl-email' ] ) ) ? $_REQUEST[ 'yith-wcwtl-email' ] : $user->user_email;
			$product_id = $_REQUEST[ YITH_WCWTL_META ];
			$product = wc_get_product( $product_id );

			if( ! $user->exists() && empty( $_REQUEST[ 'yith-wcwtl-email' ] ) ) {
				wc_add_notice( __( 'You must provide a valid email address to join the waiting list of this product', 'yith-woocommerce-waiting-list' ), 'error' );
				wp_redirect( $product->get_permalink() );
				exit();
			}
			
			// set standard msg and type
			$msg        = get_option( 'yith-wcwtl-button-success-msg' );
			$msg_type   = 'success';

			// start user session and set cookies
			if( ! isset( $_COOKIE['woocommerce_items_in_cart'] ) ) {
				do_action( 'woocommerce_set_cart_cookies', true );
			}

			if( $action == 'register' ) {
				// register user;
				$res = yith_waitlist_register_user( $user_email, $product_id );

				if( ! $res ) {
					$msg = __( 'You have already registered for this waiting list', 'yith-woocommerce-waiting-list' );
					$msg_type = 'error';
				}
			}
			elseif( $action == 'leave' ) {
				// unregister user
				yith_waitlist_unregister_user( $user_email, $product_id );
				$msg = __( 'You have been removed from the waiting list for this product', 'yith-woocommerce-waiting-list' );
			}
			else {
				$msg = __( 'An error has occurred. Please try again.', 'yith-woocommerce-waiting-list' );
				$msg_type = 'error';
			}

			//redirect to product page
			$dest = remove_query_arg( array( YITH_WCWTL_META, YITH_WCWTL_META . '-action', '_wpnonce', 'yith-wcwtl-email' ) );
			wc_add_notice( $msg, $msg_type );
			wp_redirect( esc_url( $dest ) );
			exit;
		}

	}
}
/**
 * Unique access to instance of YITH_WCWT_Frontend class
 *
 * @return \YITH_WCWTL_Frontend
 * @since 1.0.0
 */
function YITH_WCWTL_Frontend(){
	return YITH_WCWTL_Frontend::get_instance();
}
