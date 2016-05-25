<?php
/**
 * Main class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Mailchimp
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCMC' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCMC' ) ) {
	/**
	 * WooCommerce Mailchimp
	 *
	 * @since 1.0.0
	 */
	class YITH_WCMC {
		/**
		 * Single instance of the class
		 *
		 * @var \YITH_WCMC
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Mailchimp API wrapper class
		 *
		 * @var \Mailchimp
		 * @since 1.0.0
		 */
		protected $mailchimp = null;

		/**
		 * Cachable requests
		 *
		 * @var array
		 * @since 1.0.0
		 */
		public $cachable_requests = array();

		/**
		 * Returns single instance of the class
		 *
		 * @return \YITH_WCMC
		 * @since 1.0.0
		 */
		public static function get_instance(){
			if( is_null( self::$instance ) ){
				self::$instance = new self;
			}

			return self::$instance;
		}

		/**
		 * Constructor.
		 *
		 * @param array $details
		 * @return \YITH_WCMC
		 * @since 1.0.0
		 */
		public function __construct() {
			// init cachable requests
			$this->cachable_requests = apply_filters( 'yith_wcmc_cachable_requests', array(
				'lists/list',
				'users/profile'
			) );

			// load plugin-fw
			add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );

			// init api key
			add_action( 'update_option_yith_wcmc_mailchimp_api_key', array( $this, 'init_api' ) );
			$this->init_api();

			// handle ajax requests
			add_action( 'wp_ajax_do_request_via_ajax', array( $this, 'do_request_via_ajax' ) );

			// update checkout page
			add_action( 'init', array( $this, 'add_subscription_checkbox' ) );

			// register subscription functions
			add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'adds_order_meta' ), 10, 1 );
			add_action( 'woocommerce_checkout_update_order_meta', array( $this, 'subscribe_on_checkout' ), 10, 1 );
			add_action( 'woocommerce_order_status_completed', array( $this, 'subscribe_on_completed' ), 15, 1 );
		}

		/* === PLUGIN FW LOADER === */

		/**
		 * Loads plugin fw, if not yet created
		 *
		 * @return void
		 * @since 2.0.0
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

		/* === HANDLE REQUEST TO MAILCHIMP === */

		/**
		 * Init Api class
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function init_api() {
			$api_key = get_option( 'yith_wcmc_mailchimp_api_key' );

			$init_options = array( 'ssl_verifypeer' => false );

			if( ! empty( $api_key ) ){
				$this->mailchimp = new Mailchimp( $api_key, $init_options );
			}
			else{
				$this->mailchimp = null;
			}
		}

		/**
		 * Retrieve lists registered for current API Key
		 *
		 * @return array Array of available list, in id -> name format
		 * @since 1.0.0
		 */
		public function retrieve_lists() {
			$lists = $this->do_request( 'lists/list', array( 'sort_field' => 'web' ) );

			$list_options = array();
			if( ! empty( $lists['data'] ) ){
				foreach( $lists['data'] as $list ){
					$list_options[ $list['id'] ] = $list['name'];
				}
			}

			return $list_options;
		}

		/**
		 * Retrieve interest groups registered for passed list
		 *
		 * @param string $list Id of the list, used to retrieve groups
		 *
		 * @return array Array of available groups, formatted as ( group_id - interest_name ) -> ( group_name - interest_name ) format
		 * @since 1.0.0
		 */
		public function retrieve_groups( $list ) {
			$groups_options = array();
			if( ! empty( $list ) ){
				$groups = YITH_WCMC()->do_request( 'lists/interest-groupings', array( 'id' => $list )  );

				if( ! empty( $groups ) ){
					foreach( $groups as $interest_group ){
						if( ! empty( $interest_group['groups'] ) ){
							foreach( $interest_group['groups'] as $group ){
								$groups_options[ $interest_group['id'] . '-' . $group['name'] ] = $interest_group['name'] . ' - '  .$group['name'];
							}
						}
					}
				}
			}

			return $groups_options;
		}

		/**
		 * Retrieve merge fields for passed list
		 *
		 * @param string $list Id of the list, used to retrieve groups
		 *
		 * @return array Array of available merge vars, formatted as tag -> name format
		 * @since 1.0.0
		 */
		public function retrieve_fields( $list ) {
			$fields = array();

			if( ! empty( $list ) ){
				$response = $this->do_request( 'lists/merge-vars', array( 'id' => array( $list ) ) );

				if( ! empty( $response['data'] ) ){
					$merge_fields_array = $response['data'];

					foreach( $merge_fields_array as $merge_fields ){
						if( ! empty( $merge_fields['merge_vars'] ) ){
							$merge_fields = $merge_fields['merge_vars'];

							foreach( $merge_fields as $field ){
								$fields[ $field['tag'] ] = $field['name'];
							}
						}
					}
				}
			}

			return $fields;
		}

		/**
		 * Send a request to mailchimp servers
		 *
		 * @param $request string API handle to call (e.g. 'lists/list')
		 * @param $args array Associative array of params to use in the request (default to empty array)
		 * @param $force_update boolean Whether or not to update cached data with a fresh request (applied only for requests in $cachable_requests, default to false)
		 *
		 * @return mixed API response (as an associative array)
		 * @since 1.0.0
		 */
		public function do_request( $request, $args = array(), $force_update = false ) {
			if( is_null( $this->mailchimp ) ){
				return false;
			}

			$api_key        = get_option( 'yith_wcmc_mailchimp_api_key' );
			$transient_name = 'yith_wcmc_' . md5( $api_key );
			$data           = get_transient( $transient_name );

			if( in_array( $request, $this->cachable_requests ) && ! $force_update && ! empty( $data ) && isset( $data[ $request ] ) ) {
				return $data[ $request ];
			}

			try {
				switch( $request ){
					case 'lists/list':
						// set max limit possible
						$args['limit'] = 100;

						// retrieve first result page
						$result = $this->mailchimp->call( $request, $args );

						// init loop to get all lists pages
						$i = 1;

						while( ! empty( $result['total'] ) && $result['total'] > count( $result['data'] ) ){
							$args['start'] = $i++;
							$current_page = $this->mailchimp->call( $request, $args );

							$result['data'] = array_merge( $result['data'], $current_page['data'] );
						}

						break;
					default:
						$result = $this->mailchimp->call( $request, $args );
						break;
				}

				if( in_array( $request, $this->cachable_requests ) ){
					$data[ $request ] = $result;
					set_transient( $transient_name, $data, apply_filters( 'yith_wcmc_transient_expiration', DAY_IN_SECONDS ) );
				}

				return $result;
			}
			catch( Exception $e ){
				return array(
					'status' => false,
					'code' => $e->getCode(),
					'message' => $this->maybe_translate( $e->getCode(), $e->getMessage() )
				);
			}
		}

		/**
		 * Handles AJAX request, used to call API handles
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function do_request_via_ajax() {
			// return if not ajax request
			if( ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ){
				wp_send_json( false );
			}

			// retrieve params for the request
			$request = isset( $_REQUEST['request'] ) ? trim( $_REQUEST['request'] ) : false;
			$args = isset( $_REQUEST['args'] ) ? $_REQUEST['args'] : array();
			$force_update = isset( $_REQUEST['force_update'] ) ? $_REQUEST['force_update'] : false;

			// return if required params are missing
			if( empty( $request ) || empty( $_REQUEST['yith_wcmc_ajax_request_nonce'] ) ){
				wp_send_json( false );
			}

			// return if non check fails
			if( ! wp_verify_nonce( $_REQUEST['yith_wcmc_ajax_request_nonce'], 'yith_wcmc_ajax_request' ) ){
				wp_send_json( false );
			}

			// do request
			$result = $this->do_request( $request, $args, $force_update );

			// send empty response, if there was an error
			if( isset( $result['status'] ) && ! $result['status'] ){
				wp_send_json( false );
			}

			// return json encoded result
			wp_send_json( $result );
		}

		/**
		 * Search for translated error messages; default API response, if no translation is found
		 *
		 * @param $code string Error code
		 * @param $default string Error message as returned by MailChimp server
		 * @return string Translated message or default server response
		 * @since 1.0.5
		 */
		public function maybe_translate( $code, $default ) {
			$translation = yith_wcmc_include_available_translations();

			if( isset( $translation[ $code ] ) ){
				return $translation[ $code ];
			}

			return $default;
		}

		/* === ADDS FRONTEND CHECKBOX === */

		/**
		 * Register action to print subscription checkbox
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function add_subscription_checkbox() {
			$trigger = get_option( 'yith_wcmc_checkout_trigger', 'never' );
			$show_checkbox = 'yes' == get_option( 'yith_wcmc_subscription_checkbox' );
			$checkbox_position = get_option( 'yith_wcmc_subscription_checkbox_position' );

			if( $trigger != 'never' && $show_checkbox ){
				$positions_hook_relation = apply_filters( 'yith_wcmc_checkbox_position_hook', array(
					'above_customer' => 'woocommerce_checkout_before_customer_details',
					'below_customer' => 'woocommerce_checkout_after_customer_details',
					'above_place_order' => 'woocommerce_review_order_before_submit',
					'below_place_order' => 'woocommerce_review_order_after_submit',
					'above_total' => 'woocommerce_review_order_before_order_total',
					'above_billing' => 'woocommerce_checkout_billing',
					'below_billing' => 'woocommerce_after_checkout_billing_form',
					'above_shipping' => 'woocommerce_checkout_shipping'
				));

				if( ! in_array( $checkbox_position, array_keys( $positions_hook_relation ) ) ){
					$checkbox_position = 'below_customer';
				}

				$hook = $positions_hook_relation[ $checkbox_position ];

				add_action( $hook, array( $this, 'print_subscription_checkbox' ) );
			}
		}

		/**
		 * Prints subscription checkbox
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function print_subscription_checkbox() {
			$checkbox_label = get_option( 'yith_wcmc_subscription_checkbox_label' );
			$checkbox_checked = 'yes' == get_option( 'yith_wcmc_subscription_checkbox_default' );

			$template_name = 'mailchimp-subscription-checkbox.php';
			$located = locate_template( array(
				trailingslashit( WC()->template_path() ) . 'wcmc/' . $template_name,
				trailingslashit( WC()->template_path() ) . $template_name,
				'wcmc/' . $template_name,
				$template_name
			) );

			if( ! $located ){
				$located = YITH_WCMC_DIR . 'templates/' . $template_name;
			}

			include_once( $located );
		}

		/* === HANDLES ORDER SUBSCRIPTION === */

		/**
		 * Adds metas to order post, saving mailchimp informations
		 *
		 * @param $order_id int Order id
		 *
		 * @return void
		 * @since 1.0.0
		 */
		public function adds_order_meta( $order_id ) {
			$show_checkbox = 'yes' == get_option( 'yith_wcmc_subscription_checkbox' );
			$submitted_value = isset( $_POST['yith_wcmc_subscribe_me'] ) ? 'yes' : 'no';

			update_post_meta( $order_id, '_yith_wcmc_show_checkbox', $show_checkbox );
			update_post_meta( $order_id, '_yith_wcmc_submitted_value', $submitted_value );
		}

		/**
		 * Subscribe user to newsletter (called on order placed)
		 *
		 * @param $order_id int Order id
		 *
		 * @return bool Status of the operation
		 * @since 1.0.0
		 */
		public function subscribe_on_checkout( $order_id ) {
			$trigger = get_option( 'yith_wcmc_checkout_trigger' );
			$show_checkbox = get_post_meta( $order_id, '_yith_wcmc_show_checkbox', true );
			$submitted_value = get_post_meta( $order_id, '_yith_wcmc_submitted_value', true );

			// return if admin don't want to subscribe users at this point
			if( $trigger != 'created' ){
				return false;
			}

			// return if subscription checkbox is printed, but not submitted
			if( $show_checkbox && $submitted_value == 'no' ){
				return false;
			}

			return $this->order_subscribe( $order_id );
		}

		/**
		 * Subscribe user to newsletter (called on order completed)
		 *
		 * @param $order_id int Order id
		 *
		 * @return bool Status of the operation
		 * @since 1.0.0
		 */
		public function subscribe_on_completed( $order_id ) {
			$trigger = get_option( 'yith_wcmc_checkout_trigger' );
			$show_checkbox = get_post_meta( $order_id, '_yith_wcmc_show_checkbox', true );
			$submitted_value = get_post_meta( $order_id, '_yith_wcmc_submitted_value', true );

			// return if admin don't want to subscribe users at this point
			if( $trigger != 'completed' ){
				return false;
			}

			// return if subscription checkbox is printed, but not submitted
			if( $show_checkbox && $submitted_value == 'no' ){
				return false;
			}

			return $this->order_subscribe( $order_id );
		}

		/**
		 * Call subscribe API handle, to register user to a specific list
		 *
		 * @param $order_id int Order id
		 *
		 * @return bool status of the operation
		 */
		public function order_subscribe( $order_id, $args = array() ){
			$order = wc_get_order( $order_id );

			$list_id = get_option( 'yith_wcmc_mailchimp_list' );
			$email_type = get_option( 'yith_wcmc_email_type' );
			$double_optin = 'yes' == get_option( 'yith_wcmc_double_optin' );
			$update_existing = 'yes' == get_option( 'yith_wcmc_update_existing' );
			$send_welcome = 'yes' == get_option( 'yith_wcmc_send_welcome' );

			if( empty( $list_id ) ){
				return false;
			}

			$args = array_merge( array(
				'id' => $list_id,
				'email' => array(
					'email' => $order->billing_email
				),
				'merge_vars' => apply_filters( 'yith_wcmc_subscribe_merge_vars', array(
					'FNAME' => $order->billing_first_name,
					'LNAME' => $order->billing_last_name
				) ),
				'email_type' => $email_type,
				'double_optin' => $double_optin,
				'update_existing' => $update_existing,
				'send_welcome' => $send_welcome
			), $args );

			do_action( 'yith_wcmc_user_subscribing', $order_id );

			$res = $this->do_request( 'lists/subscribe', apply_filters( 'yith_wcmc_subscribe_args', $args ) );

			if( isset( $res['status'] ) && ! $res['status'] ){
				$order->add_order_note( sprintf( __( 'MAILCHIMP ERROR: (%s) %s', 'yith-wcmc' ), $res['code'], $res['message'] ) );
				return $res;
			}

			do_action( 'yith_wcmc_user_subscribed', $order_id );

			return $res;
		}
	}
}

/**
 * Unique access to instance of YITH_WCMC class
 *
 * @return \YITH_WCMC
 * @since 1.0.0
 */
function YITH_WCMC(){
	return YITH_WCMC::get_instance();
}