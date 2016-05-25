<?php
/**
 * Main class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Stripe
 * @version 1.0.0
 */

use \Stripe\Error;

if ( ! defined( 'YITH_WCSTRIPE' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCStripe_Gateway' ) ) {
	/**
	 * WooCommerce Stripe gateway class
	 *
	 * @since 1.0.0
	 */
	class YITH_WCStripe_Gateway extends WC_Payment_Gateway {

		/**
		 * @var YITH_Stripe_API API Library
		 */
		public $api = null;

		/**
		 * @var array List of standard localized message errors of Stripe SDK
		 */
		public $errors = array();

		/**
		 * @var string The domain of this site used to identifier the website from Stripe
		 */
		public $instance = '';

		/**
		 * @var array Zero decimals currencies
		 */
		protected $zero_decimals = array(
			'BIF',
			'CLP',
			'DJF',
			'GNF',
			'JPY',
			'KMF',
			'KRW',
			'MGA',
			'PYG',
			'RWF',
			'VND',
			'VUV',
			'XAF',
			'XOF',
			'XPF'
		);

		/**
		 * @var array List cards
		 */
		public $cards = array(
			'visa' => 'Visa',
			'mastercard' => 'MasterCard',
			'discover' => 'Discover',
			'amex' => 'American Express',
			'diners' => 'Diners Club',
			'jcb' => 'JCB',
		);

		/** @var WC_Order */
		protected $_current_order = null;

		/**
		 * Constructor.
		 *
		 * @return \YITH_WCStripe_Gateway
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->id         = YITH_WCStripe::$gateway_id;
			$this->has_fields = true;
			$this->method_title       = apply_filters( 'yith_stripe_method_title', __( 'Stripe', 'yith-stripe' ) );
			$this->method_description = apply_filters( 'yith_stripe_method_description', __( 'Take payments via Stripe - uses stripe.js to create card tokens and the Stripe SDK. Requires SSL when sandbox is disabled.', 'yith-stripe' ) );
			$this->supports           = array(
				'products'
			);
			$this->instance = preg_replace( '/http(s)?:\/\//', '', site_url() );

			// Load the settings.
			$this->init_form_fields();
			$this->init_settings();

			// Define user set variables
			$this->title       = $this->get_option( 'title' );
			$this->description = $this->get_option( 'description' );
			$this->env         = $this->get_option( 'enabled_test_mode' ) == 'yes' ? 'test' : 'live';
			$this->private_key = $this->get_option( $this->env . '_secrect_key' );
			$this->public_key  = $this->get_option( $this->env . '_publishable_key' );
			$this->modal_image = $this->get_option( 'modal_image' );
			$this->mode        = 'hosted';

			// post data
			$this->token = isset( $_POST['stripe_token'] ) ? wc_clean( $_POST['stripe_token'] ) : '';

			// save
			add_action( 'woocommerce_update_options_payment_gateways_' . $this->id, array( $this, 'process_admin_options' ) );

			// others
			add_action( 'admin_notices', array( $this, 'admin_notices' ) );
			add_action( 'woocommerce_receipt_' . $this->id, array( $this, 'receipt_page' ) );
			add_action( 'woocommerce_api_' . strtolower( get_class( $this ) ), array( $this, 'return_handler' ) );
		}

		/**
		 * Init Simplify SDK.
		 *
		 * @return void
		 */
		public function init_stripe_sdk() {
			if ( is_a( $this->api, 'YITH_Stripe_Api' ) ) {
				return;
			}

			// Include lib
			require_once( 'class-yith-stripe-api.php' );

			$this->api = new YITH_Stripe_API( $this->private_key );
		}

		/**
		 * Initialize and localize error messages
		 *
		 * @since 1.0.0
		 */
		protected function errors() {
			$this->errors = array(
				// Codes
				'incorrect_number'      => __( 'The card number is incorrect.', 'yith-stripe' ),
				'invalid_number'        => __( 'The card number is not a valid credit card number.', 'yith-stripe' ),
				'invalid_expiry_month'  => __( 'The card\'s expiration month is invalid.', 'yith-stripe' ),
				'invalid_expiry_year'   => __( 'The card\'s expiration year is invalid.', 'yith-stripe' ),
				'invalid_cvc'           => __( 'The card\'s security code is invalid.', 'yith-stripe' ),
				'expired_card'          => __( 'The card has expired.', 'yith-stripe' ),
				'incorrect_cvc'         => __( 'The card\'s security code is incorrect.', 'yith-stripe' ),
				'incorrect_zip'         => __( 'The card\'s zip code failed validation.', 'yith-stripe' ),
				'card_declined'         => __( 'The card was declined.', 'yith-stripe' ),
				'missing'               => __( 'There is no card on a customer that is being charged.', 'yith-stripe' ),
				'processing_error'      => __( 'An error occurred while processing the card.', 'yith-stripe' ),
				'rate_limit'            => __( 'An error occurred due to requests hitting the API too quickly. Please let us know if you\'re consistently running into this error.', 'yith-stripe' )
			);
		}

		/**
		 * Advise if the plugin cannot be performed
		 *
		 * @since 1.0.0
		 */
		public function admin_notices() {
			if ( $this->enabled == 'no' ) {
				return;
			}

			if ( ! function_exists( 'curl_init' ) ) {
				echo '<div class="error"><p>' . __( 'Stripe needs the CURL PHP extension.', 'yith-stripe' ) . '</p></div>';
			}

			if ( ! function_exists( 'json_decode' ) ) {
				echo '<div class="error"><p>' . __( 'Stripe needs the JSON PHP extension.', 'yith-stripe' ) . '</p></div>';
			}

			if ( ! function_exists( 'mb_detect_encoding' ) ) {
				echo '<div class="error"><p>' . __( 'Stripe needs the Multibyte String PHP extension.', 'yith-stripe' ) . '</p></div>';
			}

			if ( ! $this->public_key || ! $this->private_key ) {
				echo '<div class="error"><p>' . __( 'Please enter the public and private keys for Stripe gateway.', 'yith-stripe' ) . '</p></div>';
			}

			if ( 'standard' == $this->mode && $this->env != 'test' && 'no' == get_option( 'woocommerce_force_ssl_checkout' ) && ! class_exists( 'WordPressHTTPS' ) ) {
				echo '<div class="error"><p>' . sprintf( __( 'Stripe sandbox testing is disabled and can performe live transactions but the <a href="%s">force SSL option</a> is disabled; your checkout is not secure! Please enable SSL and ensure your server has a valid SSL certificate. <a href="%">Learn more</a>.', 'woothemes' ), admin_url( 'admin.php?page=settings' ), 'https://stripe.com/help/ssl' ) . '</p></div>';
			}
		}

		/**
		 * Check if this gateway is enabled
		 *
		 * @since 1.0.0
		 */
		public function is_available() {
			if ( 'yes' != $this->enabled ) {
				return false;
			}

			if ( 'standard' == $this->mode && ! is_ssl() && 'test' != $this->env ) {
				return false;
			}

			if ( ! $this->public_key || ! $this->private_key ) {
				return false;
			}

			if ( WC()->cart && 0 < $this->get_order_total() && 0 < $this->max_amount && $this->max_amount < $this->get_order_total() ) {
				return false;
			}

			if ( $this->is_blocked() ) {
				return false;
			}

			return true;
		}

		/**
		 * Method to check blacklist (only for premium)
		 *
		 * @since 1.1.3
		 */
		public function is_blocked() {
			return false;
		}

		/**
		 * Initialize form fields for the admin
		 *
		 * @since 1.0.0
		 */
		public function init_form_fields() {
			$this->form_fields = array(
				'enabled'              => array(
					'title'   => __( 'Enable/Disable', 'yith-stripe' ),
					'type'    => 'checkbox',
					'label'   => __( 'Enable Stripe Payment', 'yith-stripe' ),
					'default' => 'yes'
				),
				'title' => array(
					'title'       => __( 'Title', 'yith-stripe' ),
					'type'        => 'text',
					'description' => __( 'This controls the title which the user sees during checkout.', 'yith-stripe' ),
					'default'     => __( 'Credit Card', 'yith-stripe' ),
					'desc_tip'    => true,
				),
				'description' => array(
					'title'       => __( 'Description', 'yith-stripe' ),
					'type'        => 'text',
					'desc_tip'    => true,
					'description' => __( 'This controls the description which the user sees during checkout.', 'yith-stripe' ),
					'default'     => __( 'Pay with a credit card.', 'yith-stripe' )
				),
				'customization'   => array(
					'title'       => __( 'Customization', 'yith-stripe' ),
					'type'        => 'title',
					'description' => __( 'Customize the payment gateway on frontend', 'yith-stripe' ),
				),
				'modal_image' => array(
					'title'       => __( 'Modal image', 'yith-stripe' ),
					'type'        => 'text',
					'desc_tip'    => true,
					'description' => __( 'Define the URL of image to show on Stripe checkout modal.', 'yith-stripe' ),
					'default'     => ''
				),
				'testing'         => array(
					'title'       => __( 'Testing & Debug', 'yith-stripe' ),
					'type'        => 'title',
					'description' => __( 'Enable here the testing mode, to debug the payment system before going into production', 'yith-stripe' ),
				),
				'enabled_test_mode'    => array(
					'title'   => __( 'Enable Test Mode', 'yith-stripe' ),
					'type'    => 'checkbox',
					'label'   => __( 'Check this option if you want to test the gateway before going into production', 'yith-stripe' ),
					'default' => 'yes'
				),
				'keys'                 => array(
					'title'       => __( 'API Keys', 'yith-stripe' ),
					'type'        => 'title',
					'description' => sprintf( __( 'You can find it in <a href="%s">your stripe dashboard</a>', 'yith-stripe' ), 'https://dashboard.stripe.com/account/apikeys' ),
				),
				'test_secrect_key'     => array(
					'title'       => __( 'Test Secret Key', 'yith-stripe' ),
					'type'        => 'text',
					'description' => __( 'Set the secret API key for test', 'yith-stripe' ),
					'default'     => '',
					'desc_tip'    => true,
				),
				'test_publishable_key' => array(
					'title'       => __( 'Test Publishable Key', 'yith-stripe' ),
					'type'        => 'text',
					'description' => __( 'Set the published API key for test', 'yith-stripe' ),
					'default'     => '',
					'desc_tip'    => true,
				),
				'live_secrect_key'     => array(
					'title'       => __( 'Live Secret Key', 'yith-stripe' ),
					'type'        => 'text',
					'description' => __( 'Set the secret API key for live production', 'yith-stripe' ),
					'default'     => '',
					'desc_tip'    => true,
				),
				'live_publishable_key' => array(
					'title'       => __( 'Live Publishable Key', 'yith-stripe' ),
					'type'        => 'text',
					'description' => __( 'Set the published API key for live production', 'yith-stripe' ),
					'default'     => '',
					'desc_tip'    => true,
				),
			);
		}

		/**
		 * Handling payment and processing the order.
		 *
		 * @param int $order_id
		 *
		 * @return array
		 * @throws Simplify_ApiException
		 * @since 1.0.0
		 */
		public function process_payment( $order_id ) {
			$order = wc_get_order( $order_id );
			$this->_current_order = $order;

			return $this->process_hosted_payment();
		}

		/**
		 * Process standard payments
		 *
		 * @param WC_Order $order
		 * @return array
		 */
		protected function process_hosted_payment( $order = null ) {
			if ( empty( $order ) ) {
				$order = $this->_current_order;
			}

			return array(
				'result'   => 'success',
				'redirect' => $order->get_checkout_payment_url( true )
			);
		}

		/**
		 * Performs the payment on Stripe
		 *
		 * @param $order  WC_Order
		 *
		 * @return array
		 * @since 1.0.0
		 */
		protected function pay( $order = null ) {
			// Initializate SDK and set private key
			$this->init_stripe_sdk();

			if ( empty( $order ) ) {
				$order = $this->_current_order;
			}

			$params = array(
				'amount'      => $this->get_amount( $order->order_total, $order->get_order_currency() ), // Amount in cents!
				'currency'    => strtolower( $order->get_order_currency() ? $order->get_order_currency() : get_woocommerce_currency() ),
				'source'      => $this->token,
				'description' => sprintf( __( '%s - Order %s', 'yith-stripe' ), esc_html( get_bloginfo( 'name' ) ), $order->get_order_number() ),
				'metadata'    => array(
					'order_id' => $order->id,
					'instance' => $this->instance
				)
			);

			$charge = $this->api->charge( $params );

			// save if bitcoin
			if ( isset( $charge->inbound_address ) && isset( $charge->bitcoin_uri ) ) {
				update_post_meta( $order->id, '_bitcoin_inbound_address', $charge->inbound_address );
				update_post_meta( $order->id, '_bitcoin_uri', $charge->bitcoin_uri );
			}

			// Payment complete
			$order->payment_complete( $charge->id );

			// Add order note
			$order->add_order_note( sprintf( __( 'Stripe payment approved (ID: %s)', 'yith-stripe' ), $charge->id ) );

			// Remove cart
			WC()->cart->empty_cart();

			// update post meta
			update_post_meta( $order->id, '_captured', ( $charge->captured ? 'yes' : 'no' ) );

			// Return thank you page redirect
			return array(
				'result'   => 'success',
				'redirect' => $this->get_return_url( $order )
			);
		}

		/**
		 * Hosted payment args.
		 *
		 * @param  WC_Order $order
		 *
		 * @return array
		 */
		protected function get_hosted_payments_args( $order ) {
			$args = apply_filters( 'woocommerce_stripe_hosted_args', array(
				'key'          => $this->public_key,
				'amount'       => $this->get_amount( $order->order_total, $order->get_order_currency() ),
				'currency'     => strtolower( $order->get_order_currency() ? $order->get_order_currency() : get_woocommerce_currency() ),
				'name'         => esc_html( get_bloginfo( 'name' ) ),
				'description'  => sprintf( __( 'Order #%s', 'yith-stripe' ), $order->get_order_number() ),
				'zip-code'     => $order->billing_postcode,
				'label'        => __( 'Proceed to payment', 'yith-stripe' ),
				'email'        => $order->billing_email,
				'image'        => $this->modal_image,
				'capture'      => 'true',
				'locale'       => $order->billing_country
			), $order->id );

			return $args;
		}

		/**
		 * Receipt page
		 *
		 * @param  int $order_id
		 */
		public function receipt_page( $order_id ) {
			if ( 'standard' == $this->mode ) {
				return;
			}

			$order = wc_get_order( $order_id );

			echo '<p>' . __( 'Thank you for your order, please click the button below to pay with credit card using Stripe.', 'yith-stripe' ) . '</p>';

			$args        = $this->get_hosted_payments_args( $order );
			$button_args = array();
			foreach ( $args as $key => $value ) {
				$button_args[] = 'data-' . esc_attr( $key ) . '="' . esc_attr( $value ) . '"';
			}

			?>
			<form action="<?php echo WC()->api_request_url( get_class( $this ) ) ?>">
				<script src="https://checkout.stripe.com/checkout.js" class="stripe-button" <?php echo implode( ' ', $button_args ) ?>></script>
				<input type="hidden" name="reference" value="<?php echo $order_id ?>" />
				<input type="hidden" name="amount" value="<?php echo $this->get_order_total() ?>" />
				<input type="hidden" name="signature" value="<?php echo strtoupper( md5( $this->get_order_total() . $order_id . $this->private_key ) ) ?>" />
			</form>
			<?php
		}

		/**
		 * Return handler for Hosted Payments
		 */
		public function return_handler() {
			if ( 'standard' == $this->mode ) {
				return;
			}

			@ob_clean();
			status_header( 200 );

			if ( isset( $_REQUEST['reference'] ) && isset( $_REQUEST['signature'] ) && isset( $_REQUEST['stripeToken'] ) ) {

				$signature            = strtoupper( md5( $_REQUEST['amount'] . $_REQUEST['reference'] . $this->private_key ) );
				$order_id             = absint( $_REQUEST['reference'] );
				$order                = wc_get_order( $order_id );
				$this->_current_order = $order;

				if ( $signature === $_REQUEST['signature'] ) {

					try {
						$this->token = $_REQUEST['stripeToken'];
						$response    = $this->pay( $order );
					}

					catch ( Error\Card $e ) {
						$body    = $e->getJsonBody();
						$err     = $body['error'];
						$message = isset( $this->errors[ $err['code'] ] ) ? $this->errors[ $err['code'] ] : $err['message'];

						// add order note
						$order->add_order_note( 'Stripe Error: ' . $e->getHttpStatus() . ' - ' . $e->getMessage() );

						wc_add_notice( $message, 'error' );
						wp_redirect( get_permalink( wc_get_page_id( 'checkout' ) ) );
						exit();
					}

					catch ( Exception $e ) {
						wc_add_notice( $e->getMessage(), 'error' );
						wp_redirect( get_permalink( wc_get_page_id( 'checkout' ) ) );
						exit();
					}

					if ( $response['result'] == 'fail' ) {
						$order->update_status( 'failed', __( 'Payment was declined by Stripe.', 'yith-stripe' ) . ' ' . $response['error'] );
					}

					wp_redirect( $this->get_return_url( $order ) );
					exit();
				}
			}

			wp_redirect( get_permalink( wc_get_page_id( 'cart' ) ) );
			exit();
		}

		/**
		 * Payment form on checkout page
		 *
		 * @since 1.0.0
		 */
		public function payment_fields() {
			$description = $this->get_description();

			if ( 'test' == $this->env ) {
				$description .= ' ' . sprintf( __( 'TEST MODE ENABLED. Use a test card: %s', 'yith-stripe' ), '<a href="https://stripe.com/docs/testing">https://stripe.com/docs/testing</a>' );
			}

			if ( $description ) {
				echo wpautop( wptexturize( trim( $description ) ) );
			}
		}

		/**
		 * Get Stripe amount to pay
		 *
		 * @param $total
		 * @param string $currency
		 *
		 * @return float
		 * @since 1.0.0
		 */
		public function get_amount( $total, $currency = '' ) {
			if ( empty( $currency ) ) {
				$currency = get_woocommerce_currency();
			}

			if ( ! in_array( $currency, $this->zero_decimals ) ) {
				$total *= 100;
			}

			return absint( $total );
		}

		/**
		 * Get original amount
		 *
		 * @param $total
		 * @param string $currency
		 *
		 * @return float
		 * @since 1.0.0
		 */
		public function get_original_amount( $total, $currency = '' ) {
			if ( empty( $currency ) ) {
				$currency = get_woocommerce_currency();
			}

			if ( in_array( $currency, $this->zero_decimals ) ) {
				$total = absint( $total );
			} else {
				$total /= 100;
			}

			return $total;
		}

		/**
		 * get_icon function.
		 *
		 * @access public
		 * @return string
		 */
		public function get_icon() {
			switch ( WC()->countries->get_base_country() ) {

				case 'US' :
					$allowed = array( 'visa', 'mastercard', 'amex', 'discover', 'diners', 'jcb' );
					break;

				default :
					$allowed = array( 'visa', 'mastercard', 'amex' );
					break;
			}

			$icon = '';
			foreach ( $allowed as $name ) {
				$icon .= '<img src="' . WC_HTTPS::force_https_url(  WC()->plugin_url() . '/assets/images/icons/credit-cards/' . $name . '.png' ) . '" alt="' . $this->cards[ $name ] . '" style="width:40px;" />';
			}

			return apply_filters( 'woocommerce_gateway_icon', $icon, $this->id );
		}
	}
}