<?php
/**
 * Main class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Stripe
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCSTRIPE' ) ) {
	exit;
} // Exit if accessed directly

if( ! class_exists( 'YITH_WCStripe' ) ){
	/**
	 * WooCommerce Stripe main class
	 *
	 * @since 1.0.0
	 */
	class YITH_WCStripe {
		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCStripe
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Stripe gateway id
		 *
		 * @var string Id of specific gateway
		 * @since 1.0
		 */
		public static $gateway_id = 'yith-stripe';

		/**
		 * The gateway object
		 *
		 * @var YITH_WCStripe_Gateway|YITH_WCStripe_Gateway_Advanced
		 * @since 1.0
		 */
		protected $gateway = null;

		/**
		 * Admin main class
		 *
		 * @var YITH_WCStripe_Admin
		 */
		public $admin = null;

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCStripe
		 * @since 1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self;
			}

			return self::$instance;
		}

		/* === PLUGIN FW LOADER === */

		/**
		 * Loads plugin fw, if not yet created
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function plugin_fw_loader() {
			if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
		        global $plugin_fw_data;
		        if( ! empty( $plugin_fw_data ) ){
		            $plugin_fw_file = array_shift( $plugin_fw_data );
		            require_once( $plugin_fw_file );
		        }
		    }
		}

		/**
		 * Constructor.
		 *
		 * @return \YITH_WCStripe
		 * @since 1.0.0
		 */
		public function __construct() {
			add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );

			// capture charge if completed, only if set the option
			add_action( 'woocommerce_order_status_processing_to_completed', array( $this, 'capture_charge' ) );
			add_action( 'woocommerce_payment_complete', array( $this, 'capture_charge' ) );

			// admin includes
			if ( is_admin() ) {
				include_once( 'class-yith-stripe-admin.php' );
				if ( ! defined( 'YITH_WCSTRIPE_PREMIUM' ) || ! YITH_WCSTRIPE_PREMIUM ) {
					$this->admin = new YITH_WCStripe_Admin();
				}
			}

			// add filter to append wallet as payment gateway
			add_filter( 'woocommerce_payment_gateways', array( $this, 'add_to_gateways' ) );
		}

		/**
		 * Adds Stripe Gateway to payment gateways available for woocommerce checkout
		 *
		 * @param $methods array Previously available gataways, to filter with the function
		 *
		 * @return array New list of available gateways
		 * @since 1.0.0
		 */
		public function add_to_gateways( $methods ) {
			include_once( 'class-yith-stripe-gateway.php' );
			$methods[] = 'YITH_WCStripe_Gateway';
			return $methods;
		}

		/**
		 * Get the gateway object
		 *
		 * @return YITH_WCStripe_Gateway|YITH_WCStripe_Gateway_Advanced|YITH_WCStripe_Gateway_Addons
		 * @since 1.0.0
		 */
		public function get_gateway() {
			if ( ! is_a( $this->gateway, 'YITH_WCStripe_Gateway' ) && ! is_a( $this->gateway, 'YITH_WCStripe_Gateway_Advanced' ) && ! is_a( $this->gateway, 'YITH_WCStripe_Gateway_Addons' ) ) {
				$gateways = WC()->payment_gateways()->get_available_payment_gateways();

				if ( ! isset( $gateways[ self::$gateway_id ] ) ) {
					return false;
				}

				$this->gateway = $gateways[ self::$gateway_id ];
			}

			return $this->gateway;
		}

		/**
		 * Capture charge if the payment is been only authorized
		 *
		 * @param integer $order_id
		 *
		 * @since 1.0.0
		 */
		public function capture_charge( $order_id ) {

			// get order data
			$order          = wc_get_order( $order_id );

			// check if payment method is Stripe
			if ( $order->payment_method != self::$gateway_id ) {
				return;
			}

			// exit if the order is in processing
			if ( $order->get_status() == 'processing' ) {
				return;
			}

			$transaction_id = $order->get_transaction_id();
			$captured = strcmp( $order->captured, 'yes' ) == 0;

			if ( $captured ) {
				return;
			}

			if ( ! $gateway = $this->get_gateway() ) {
				return;
			}

			try {

				// init Stripe api
				$gateway->init_stripe_sdk();

				if ( ! $transaction_id ) {
					throw new \Stripe\Error\Api( __( 'Stripe Credit Card Refund failed because the Transaction ID is missing.', 'yith-stripe' ) );
				}

				// capture
				$charge = $gateway->api->capture_charge( $transaction_id );

				// update post meta
				update_post_meta( $order_id, '_captured', 'yes' );

			} catch( \Stripe\Error\Api $e ) {
				$message = isset( $gateway->errors[ $e->getCode() ] ) ? $gateway->errors[ $e->getCode() ] : $e->getMessage();
				$order->add_order_note( __( 'Charge not captured.', 'yith-stripe' ) . '<br />' . $message );

				if ( is_admin() ) {
					wp_die( $message );
				}

				wc_add_notice( $message, 'error' );
			}
		}
	}
}