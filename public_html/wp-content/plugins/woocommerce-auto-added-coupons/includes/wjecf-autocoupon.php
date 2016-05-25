<?php

defined('ABSPATH') or die();

class WJECF_AutoCoupon extends Abstract_WJECF_Plugin {

	private $_autocoupons = null;
	
	private $_user_emails = null;
	
	protected $_executed_coupon_by_url = false;
	
	public function __construct() {	
		add_action('init', array( &$this, 'controller_init' ));
	}
	
	public function controller_init() {
		if ( ! class_exists('WC_Coupon') ) {
			return;
		}

		//Admin hooks
		add_action( 'admin_init', array( &$this, 'admin_init' ) );
		
		//Frontend hooks - logic
		if ( WJECF()->check_woocommerce_version('2.3.0')) {
			add_action( 'woocommerce_after_calculate_totals', array( &$this, 'update_matched_autocoupons' ) ); 
		} else {
			//WC Versions prior to 2.3.0 don't have after_calculate_totals hook, this is a fallback
			add_action( 'woocommerce_cart_updated',  array( &$this, 'update_matched_autocoupons' ) ); 
		}
		add_action( 'woocommerce_check_cart_items',  array( &$this, 'remove_unmatched_autocoupons' ) , 0, 0 ); //Remove coupon before WC does it and shows a message
		//Last check for coupons with restricted_emails
		add_action( 'woocommerce_checkout_update_order_review', array( &$this, 'fetch_billing_email' ), 10 ); // AJAX One page checkout 

		//Frontend hooks - visualisation
		add_filter('woocommerce_cart_totals_coupon_label', array( &$this, 'coupon_label' ), 10, 2 );
		add_filter('woocommerce_cart_totals_coupon_html', array( &$this, 'coupon_html' ), 10, 2 );		

		//Inhibit redirect to cart when apply_coupon supplied
		add_filter('option_woocommerce_cart_redirect_after_add', array ( &$this, 'option_woocommerce_cart_redirect_after_add') );

		if ( ! is_ajax() ) {
			add_action( 'init', array( &$this, 'coupon_by_url' ), 23); //Coupon through url
		}

	}

/* ADMIN HOOKS */
	public function admin_init() {
		add_action( 'wjecf_woocommerce_coupon_options_extended_features', array( $this, 'admin_coupon_options_extended_features' ), 20, 2 );
		add_action( 'woocommerce_process_shop_coupon_meta', array( $this, 'process_shop_coupon_meta' ), 10, 2 );

		//Inject columns
		if ( WJECF()->is_pro() ) {
			WJECF()->inject_coupon_column( 
				'_wjecf_auto_coupon', 
				__( 'Auto coupon', 'woocommerce-jos-autocoupon' ), 
				array( $this, 'admin_render_shop_coupon_columns' ), 'coupon_code'
			);	
			WJECF()->inject_coupon_column( 
				'_wjecf_individual_use', 
				__( 'Individual use', 'woocommerce-jos-autocoupon' ),
				array( $this, 'admin_render_shop_coupon_columns' ), 'coupon_code'
			);	
		}

		add_filter( 'views_edit-shop_coupon', array( $this, 'admin_views_edit_coupon' ) );
		add_filter( 'request', array( $this, 'admin_request_query' ) );
	}

	/**
	 * Output a coupon custom column value
	 *
	 * @param string $column
	 * @param WP_Post The coupon post object
	 */
	public function admin_render_shop_coupon_columns( $column, $post ) {

		switch ( $column ) {
			case '_wjecf_auto_coupon' :
				$is_auto_coupon = get_post_meta( $post->ID, '_wjecf_is_auto_coupon', true ) == 'yes';
				echo $is_auto_coupon ? __( 'Yes', 'woocommerce' ) : __( 'No', 'woocommerce' );
				if ( $is_auto_coupon ) {
					$prio = get_post_meta( $post->ID, '_wjecf_coupon_priority', true );
					if ( $prio ) echo " (" . intval( $prio ) . ")";
				}
				break;
			case '_wjecf_individual_use' :
				$individual = get_post_meta( $post->ID, 'individual_use', true ) == 'yes';
				echo $individual ? __( 'Yes', 'woocommerce' ) : __( 'No', 'woocommerce' );
				break;
		}
	}

	public function admin_views_edit_coupon( $views ) {
		global $post_type, $wp_query;

		$class			= ( isset( $wp_query->query['meta_key'] ) && $wp_query->query['meta_key'] == '_wjecf_is_auto_coupon' ) ? 'current' : '';
		$query_string	 = remove_query_arg(array( 'wjecf_is_auto_coupon' ));
		$query_string	 = add_query_arg( 'wjecf_is_auto_coupon', '1', $query_string );
		$views['wjecf_is_auto_coupon'] = '<a href="' . esc_url( $query_string ) . '" class="' . esc_attr( $class ) . '">' . __( 'Auto coupons', 'woocommerce' ) . '</a>';

		return $views;
	}

	/**
	 * Filters and sorting handler
	 *
	 * @param  array $vars
	 * @return array
	 */
	public function admin_request_query( $vars ) {
		global $typenow, $wp_query, $wp_post_statuses;

		if ( 'shop_coupon' === $typenow ) {
			if ( isset( $_GET['wjecf_is_auto_coupon'] ) ) {
				$vars['meta_key']   = '_wjecf_is_auto_coupon';
				$vars['meta_value'] = $_GET['wjecf_is_auto_coupon'] == '1' ? 'yes' : 'no';
			}
		}

		return $vars;
	}

	public function admin_coupon_options_extended_features( $thepostid, $post ) {
		
		//=============================
		//Title
		echo "<h3>" . esc_html( __( 'Auto coupon', 'woocommerce-jos-autocoupon' ) ). "</h3>\n";

		
		//=============================
		// Auto coupon checkbox
		woocommerce_wp_checkbox( array(
			'id'		  => '_wjecf_is_auto_coupon',
			'label'	   => __( 'Auto coupon', 'woocommerce-jos-autocoupon' ),
			'description' => __( "Automatically add the coupon to the cart if the restrictions are met. Please enter a description when you check this box, the description will be shown in the customer's cart if the coupon is applied.", 'woocommerce-jos-autocoupon' )
		) );

		echo '<div class="_wjecf_show_if_autocoupon">';
		if ( WJECF()->is_pro() ) {			
			// Maximum quantity of matching products (product/category)
			woocommerce_wp_text_input( array( 
				'id' => '_wjecf_coupon_priority', 
				'label' => __( 'Priority', 'woocommerce-jos-autocoupon' ), 
				'placeholder' => __( 'No priority', 'woocommerce' ), 
				'description' => __( 'When \'individual use\' is checked, auto coupons with a higher value will have priority over other auto coupons.', 'woocommerce-jos-autocoupon' ), 
				'data_type' => 'decimal', 
				'desc_tip' => true
			) );	
		}	

		//=============================
		// Apply without notice
		woocommerce_wp_checkbox( array(
			'id'		  => '_wjecf_apply_silently',
			'label'	   => __( 'Apply silently', 'woocommerce-jos-autocoupon' ),
			'description' => __( "Don't display a message when this coupon is automatically applied.", 'woocommerce-jos-autocoupon' ),
		) );
		echo '</div>';
		
		?>		
		<script type="text/javascript">
			//Hide/show when AUTO-COUPON value changes
			function update_wjecf_apply_silently_field( animation ) { 
					if ( animation === undefined ) animation = 'slow';
					
					if (jQuery("#_wjecf_is_auto_coupon").prop('checked')) {
						jQuery("._wjecf_show_if_autocoupon").show( animation );
					} else {
						jQuery("._wjecf_show_if_autocoupon").hide( animation );
					}
			}
			update_wjecf_apply_silently_field( 0 );	
			
			jQuery("#_wjecf_is_auto_coupon").click( update_wjecf_apply_silently_field );
		</script>
		<?php
		
	}
	
	public function process_shop_coupon_meta( $post_id, $post ) {
		$autocoupon = isset( $_POST['_wjecf_is_auto_coupon'] );

		update_post_meta( $post_id, '_wjecf_is_auto_coupon', $autocoupon ? 'yes' : 'no' );
		update_post_meta( $post_id, '_wjecf_apply_silently', isset( $_POST['_wjecf_apply_silently'] ) ? 'yes' : 'no' );
		if ( WJECF()->is_pro() ) {
			update_post_meta( $post_id, '_wjecf_coupon_priority', intval( $_POST['_wjecf_coupon_priority'] ) );
		}
	}	

/* FRONTEND HOOKS */

	/**
	 ** Inhibit redirect to cart when apply_coupon supplied
	 */
	public function option_woocommerce_cart_redirect_after_add ( $value ) {
		if ( ! $this->_executed_coupon_by_url  && isset( $_GET['apply_coupon'] ) ) {
			$value = 'no';
		}
		return $value;
	}

	/**
	 * Add coupon through url
	 */
	public function coupon_by_url() {
		$must_redirect = false;

		//Apply coupon by url
		if ( isset( $_GET['apply_coupon'] ) ) {
			$this->_executed_coupon_by_url = true;
			$split = explode( ",", wc_clean( $_GET['apply_coupon'] ) );
			//2.2.2 Make sure a session cookie is set
			if( ! WC()->session->has_session() )
			{
				WC()->session->set_customer_session_cookie( true );
			}			

			$cart = WC()->cart;
			foreach ( $split as $coupon_code ) {
				$coupon = WJECF()->get_coupon( $coupon_code );
				if ( ! $coupon->exists ) {
					wc_add_notice( $coupon->get_coupon_error( WC_Coupon::E_WC_COUPON_NOT_EXIST ), 'error' );
				} else {
					$valid = $coupon->is_valid();
					if ( $valid ) {
						$cart->add_discount( $coupon_code );
					}

					//2.3.3 Keep track of apply_coupon coupons and apply when they validate
					if ( WJECF()->is_pro() ) {
			   			$by_url_coupon_codes = $this->get_by_url_coupon_codes();
						if ( ! in_array( $coupon_code, $by_url_coupon_codes ) ) {
							$by_url_coupon_codes[] = $coupon_code;
							$this->set_by_url_coupon_codes( $by_url_coupon_codes );
						}
						if ( ! $valid ) {
							wc_add_notice( sprintf( __( 'Coupon \'%s\' will be applied when it\'s conditions are met.', 'woocommerce-jos-autocoupon' ), $coupon_code ) );
							$must_redirect = true;		
						}				
					}
				}
			}
		}

		//2.3.3 Keep track of apply_coupon coupons and apply when they validate
		if ( WJECF()->is_pro() ) {
			//Remove auto coupon codes from session
			if ( isset( $_GET['remove_coupon'] ) ) {
				$coupon_code = wc_clean( $_GET['remove_coupon'] );
	   			$by_url_coupon_codes = $this->get_by_url_coupon_codes();
				if( ( $key = array_search( $coupon_code, $by_url_coupon_codes ) ) !== false ) {
					unset( $by_url_coupon_codes[$key] );
					$this->set_by_url_coupon_codes( $by_url_coupon_codes );
				}
			}
		}

		//Redirect to page without autocoupon query args
		if ( $must_redirect ) {
			$requested_url  = is_ssl() ? 'https://' : 'http://';
			$requested_url .= $_SERVER['HTTP_HOST'];		   
			$requested_url .= $_SERVER['REQUEST_URI'];
			wp_safe_redirect( remove_query_arg( array( 'apply_coupon', 'add-to-cart' ), ( $requested_url ) ) );
			exit;
		}
	}
	
/**
 * Overwrite the html created by wc_cart_totals_coupon_label() so a descriptive text will be shown for the discount.
 * @param  string $originaltext The default text created by wc_cart_totals_coupon_label()
 * @param  WC_Coupon $coupon The coupon data
 * @return string The overwritten text
*/	
	function coupon_label( $originaltext, $coupon ) {
		
		if ( $this->is_auto_coupon($coupon) ) {
			
			return $this->coupon_excerpt($coupon); //__($this->autocoupons[$coupon->code], 'woocommerce-jos-autocoupon');
		} else {
			return $originaltext;
		}
	}
	
/**
 * Overwrite the html created by wc_cart_totals_coupon_html(). This function is required to remove the "Remove" link.
 * @param  string $originaltext The html created by wc_cart_totals_coupon_html()
 * @param  WC_Coupon $coupon The coupon data
 * @return string The overwritten html
*/
	function coupon_html( $originaltext, $coupon ) {
		if ( $this->is_auto_coupon($coupon) ) {
				$value  = array();

				if ( $amount = WC()->cart->get_coupon_discount_amount( $coupon->code, WC()->cart->display_cart_ex_tax ) ) {
					$discount_html = '-' . wc_price( $amount );
				} else {
					$discount_html = '';
				}

				$value[] = apply_filters( 'woocommerce_coupon_discount_amount_html', $discount_html, $coupon );

				if ( $coupon->enable_free_shipping() ) {
					$value[] = __( 'Free shipping coupon', 'woocommerce' );
				}

				return implode(', ', array_filter($value)); //Remove empty array elements
		} else {
			return $originaltext;
		}
	}	


	function remove_unmatched_autocoupons( $valid_coupon_codes = null ) {
		if ( $valid_coupon_codes === null ) {
			//Get the coupons that should be in the cart
			$valid_coupons = $this->get_valid_auto_coupons();
			$valid_coupons = $this->individual_use_filter( $valid_coupons );
			$valid_coupon_codes = array();	
			foreach ( $valid_coupons as $coupon ) {
				$valid_coupon_codes[] = $coupon->code;
			}
		}

		//Remove invalids
		$calc_needed = false;	
		foreach ( $this->get_all_auto_coupons() as $coupon ) {
			if ( WC()->cart->has_discount( $coupon->code ) && ! in_array( $coupon->code, $valid_coupon_codes ) ) {
				$this->log( sprintf( "Removing %s", $coupon->code ) );
				WC()->cart->remove_coupon( $coupon->code );  
				$calc_needed = true;
			}
		}
		return $calc_needed;
	}

	private $update_matched_autocoupons_executed = false;

/**
 * Apply matched autocoupons and remove unmatched autocoupons.
 * @return void
 */	
	function update_matched_autocoupons() {
		if ( $this->update_matched_autocoupons_executed ) {
			return;
		}
		$this->update_matched_autocoupons_executed = true;
		$this->log( "()" );

		//2.3.3 Keep track of apply_coupon coupons and apply when they validate
		$this->apply_valid_by_url_coupons();

		//Get the coupons that should be in the cart
		$valid_coupons = $this->get_valid_auto_coupons();
		$valid_coupons = $this->individual_use_filter( $valid_coupons );

		$valid_coupon_codes = array();	
		foreach ( $valid_coupons as $coupon ) {
			$valid_coupon_codes[] = $coupon->code;
		}

		//$this->log( sprintf( "Auto coupons that should be in cart: %s", implode( ', ', $valid_coupon_codes ) ) );

		$calc_needed = $this->remove_unmatched_autocoupons( $valid_coupon_codes );

		//Add valids
		foreach( $valid_coupons as $coupon ) {
			if ( ! WC()->cart->has_discount( $coupon->code )  ) {
				$this->log( sprintf( "Applying auto coupon %s", $coupon->code ) );
				WC()->cart->add_discount( $coupon->code ); //Causes calculation and will remove other coupons if it's a individual coupon
				$calc_needed = false; //Already done by adding the discount

				$apply_silently = get_post_meta( $coupon->id, '_wjecf_apply_silently', true ) == 'yes';
				if ( $apply_silently ) {
					$new_succss_msg = false; // no message
				} else {
					$coupon_excerpt = $this->coupon_excerpt($coupon);
					$new_succss_msg = sprintf(
						__("Discount applied: %s", 'woocommerce-jos-autocoupon'), 
						__( empty( $coupon_excerpt ) ? $coupon->code : $coupon_excerpt, 'woocommerce-jos-autocoupon')
					);
				}
				$this->overwrite_success_message( $coupon, $new_succss_msg );
			}
		}

		$this->log( 'Coupons in cart: ' . implode( ', ', WC()->cart->applied_coupons ) . ($calc_needed ? ". RECALC" : "") );

		if ( $calc_needed ) {
			WC()->cart->calculate_totals();
		}
		
	}

	/**
	 * Apply the valid by_url coupons
	 * @return void
	 */
	private function apply_valid_by_url_coupons( ) {
		//2.3.3 Keep track of apply_coupon coupons and apply when they validate
		if ( WJECF()->is_pro() ) {
			$this->log( "()" );
			$by_url_coupon_codes = $this->get_by_url_coupon_codes();
			$this->log( "By_url coupons: " . implode( ' ', $by_url_coupon_codes ) );
			foreach( $by_url_coupon_codes as $coupon_code ) {
				if ( ! WC()->cart->has_discount( $coupon_code )  ) {
					$coupon = new WC_Coupon( $coupon_code );
					if ( $coupon->is_valid() ) {
						$this->log( sprintf( "Applying by_url coupon %s", $coupon->code ) );
						WC()->cart->add_discount( $coupon->code ); //Causes calculation and will remove other coupons if it's a individual coupon
						//$calc_needed = false; //Already done by adding the discount
						$new_succss_msg = sprintf(
							__("Discount applied: %s", 'woocommerce-jos-autocoupon'), 
							__($coupon->code, 'woocommerce-jos-autocoupon')
						);
						$this->overwrite_success_message( $coupon, $new_succss_msg );
					} elseif ( ! $coupon->exists ) {
						//Remove non-existent
						if( ( $key = array_search($coupon_code, $by_url_coupon_codes ) ) !== false ) {
							unset( $by_url_coupon_codes[$key] );
							$this->set_by_url_coupon_codes( $by_url_coupon_codes );
						}
						//wc_add_notice( $coupon->get_coupon_error( WC_Coupon::E_WC_COUPON_NOT_EXIST ), 'error' );
					}
				}
			}
		}
	}

	/**
	 * Get the by_url coupon codes from the session
	 * @return array The coupon codes
	 */
	public function get_by_url_coupon_codes() {
		return WC()->session->get( 'wjecf_by_url_coupons' , array() );		
	}
	/**
	 * Save the by_url coupon codes in the session
	 * @param array $coupon_codes 
	 * @return void
	 */
	public function set_by_url_coupon_codes( $coupon_codes ) {
		WC()->session->set( 'wjecf_by_url_coupons' , array_unique( $coupon_codes ) );
	}

	private function get_valid_auto_coupons( ) {
		$valid_coupons = array();
		foreach ( $this->get_all_auto_coupons() as $coupon ) {
			if ( $this->coupon_can_be_applied( $coupon ) && $this->coupon_has_a_value( $coupon ) ) {
				$valid_coupons[] = $coupon;
			}
		}
		return $valid_coupons;
	}	

/**
 * Test whether the coupon is valid and has a discount > 0 
 * @return bool
 */
	function coupon_can_be_applied($coupon) {
		$can_be_applied = true;
		
		//Test validity
		if ( ! $coupon->is_valid() ) {
			$can_be_applied = false;
		}

		//Test restricted emails
		//See WooCommerce: class-wc-cart.php function check_customer_coupons
		else if ( $can_be_applied && is_array( $coupon->customer_email ) && sizeof( $coupon->customer_email ) > 0 ) {
			$user_emails = array_map( 'sanitize_email', array_map( 'strtolower', $this->get_user_emails() ) );
			$coupon_emails = array_map( 'sanitize_email', array_map( 'strtolower', $coupon->customer_email ) );
			
			if ( 0 == sizeof( array_intersect( $user_emails, $coupon_emails ) ) ) {
				$can_be_applied = false;
			}
		}
		return apply_filters( 'wjecf_coupon_can_be_applied', $can_be_applied, $coupon );
		
	}

	/**
	 * Does the coupon have a value? (autocoupon should not be applied if it has no value)
	 * @param  WC_Coupon $coupon The coupon data
	 * @return bool True if it has a value (discount, free shipping, whatever) otherwise false)
	 **/
	function coupon_has_a_value($coupon) {
		
		$has_a_value = false;
		
		if ( $coupon->enable_free_shipping() ) {
			$has_a_value = true;
		} else {
			//Test whether discount > 0
			//See WooCommerce: class-wc-cart.php function get_discounted_price
			global $woocommerce;
			foreach ( $woocommerce->cart->get_cart() as $cart_item) {
				if  ( $coupon->is_valid_for_cart() || $coupon->is_valid_for_product( $cart_item['data'], $cart_item ) ) {
					$has_a_value = true;
					break;
				}
			}
		}
		
		return apply_filters( 'wjecf_coupon_has_a_value', $has_a_value, $coupon );
		
	}
	
	
/**
 * Overwrite the default "Coupon added" notice with a more descriptive message.
 * @param  WC_Coupon $coupon The coupon data
 * @param  string|bool $new_succss_msg The message to display. If false (or empty string), no message will be shown
 * @return void
 */
	private function overwrite_success_message( $coupon, $new_succss_msg = false ) {
		$succss_msg = $coupon->get_coupon_message( WC_Coupon::WC_COUPON_SUCCESS );
		
		//If ajax, remove only
		$remove_message_only = empty( $new_succss_msg ) || ( defined('DOING_AJAX') && DOING_AJAX );
		
		//Compatibility woocommerce-2-1-notice-api
		if ( function_exists('wc_get_notices') ) {
			$all_notices = wc_get_notices();
			if ( ! isset( $all_notices['success'] ) ) {
				$all_notices['success'] = array();
			}
			$messages = $all_notices['success'];
		} else {
			$messages = $woocommerce->messages;
		}
		
		$sizeof_messages = sizeof($messages);
		for( $y=0; $y < $sizeof_messages; $y++ ) { 
			if ( $messages[$y] == $succss_msg ) {
				if ( isset($all_notices) ) {
					if ( $remove_message_only ) {
						unset ( $all_notices['success'][$y] );
					} else {
						$all_notices['success'][$y] = $new_succss_msg;
					}
					WC()->session->set( 'wc_notices', $all_notices );
				} else {
					if ( $remove_message_only ) {
						unset ( $messages[$y] );
					} else {
						$messages[$y] = $new_succss_msg;
					}
				}
				
				break;
			}
		}
	}
	
/**
 * Check wether the coupon is an "Auto coupon".
 * @param  WC_Coupon $coupon The coupon data
 * @return bool true if it is an "Auto coupon"
 */	
	private function is_auto_coupon($coupon) {
		return get_post_meta( $coupon->id, '_wjecf_is_auto_coupon', true ) == 'yes';
	}

	private function get_coupon_priority($coupon) {
		if ( WJECF()->is_pro() ) {			
			$prio = get_post_meta( $coupon->id, '_wjecf_coupon_priority', true );
			if ( ! empty( $prio ) ) {
				return intval( $prio );
			}
		}
		return 0;
	}	
	

/**
 * Get the coupon excerpt (description)
 * @param  WC_Coupon $coupon The coupon data
 * @return string The excerpt (translated)
 */	
	private function coupon_excerpt($coupon) {
		$my_post = get_post($coupon->id);
		return __($my_post->post_excerpt, 'woocommerce-jos-autocoupon');
	}	

/**
 * Get a list of the users' known email addresses
 *
 */
	private function get_user_emails() {
		if ( ! is_array($this->_user_emails) ) {
			$this->_user_emails = array();
			//Email of the logged in user
			if ( is_user_logged_in() ) {
				$current_user   = wp_get_current_user();
				$this->_user_emails[] = $current_user->user_email;
			}
			
			if ( isset( $_POST['billing_email'] ) )
				$this->_user_emails[] = $_POST['billing_email'];
		}
		//$this->log( "User emails: " . implode( ",", $this->_user_emails ) );
		return $this->_user_emails;		
	}

/**
 * Append a single or an array of email addresses.
 * @param  array|string $append_emails The email address(es) to be added
 * @return void
 */
	private function append_user_emails($append_emails) {
		//$append_emails must be an array
		if ( ! is_array( $append_emails ) ) {
			$append_emails = array( $append_emails );
		}
		$this->_user_emails = array_unique( array_merge( $this->get_user_emails(), $append_emails ) );
		//$this->log('Append emails: ' . implode( ',', $append_emails ) );
	}
	
	public function fetch_billing_email( $post_data ) {
		//post_data can be an array, or a query=string&like=this
		if ( ! is_array( $post_data ) ) {
			parse_str( $post_data, $posted );
		} else {
			$posted = $post_data;
		}
		
		if ( isset ( $posted['billing_email'] ) ) {
			$this->append_user_emails( $posted['billing_email'] );
		}
		
	}

	/**
	 * Return an array of WC_Coupons with coupons that shouldn't cause individual use conflicts
	 */
	private function individual_use_filter( $valid_auto_coupons ) {
		$filtered = array();

		//Any individual use non-autocoupons in the cart?
		foreach ( WC()->cart->get_applied_coupons() as $coupon_code ) {
			$coupon = new WC_Coupon( $coupon_code );
			if ( $coupon->individual_use == 'yes' && ! $this->is_auto_coupon( $coupon ) ) {
				return $filtered; //Don't allow any auto coupon
			}
		}
		foreach ( $valid_auto_coupons as $coupon ) {
			if ( $coupon->individual_use != 'yes' || empty( $filtered ) ) {
				$filtered[] = $coupon;
				if ( $coupon->individual_use == 'yes' ) {
					break;
				}
			}
		}
		return $filtered;
	}	
	
/**
 * Get a list of all auto coupon codes
 * @return array All auto coupon codes
 */		
	public function get_all_auto_coupons() {
		if ( ! is_array( $this->_autocoupons ) ) {
			$this->_autocoupons = array();
			
			$query_args = array(
				'posts_per_page' => -1,			
				'post_type'   => 'shop_coupon',
				'post_status' => 'publish',
				'orderby' => array( 'title' => 'ASC' ),
				'meta_query' => array(
					array(
						'key' => '_wjecf_is_auto_coupon',
						'compare' => '=',
						'value' => 'yes',
					),
				)
			);

			$query = new WP_Query($query_args);
			foreach ($query->posts as $post) {
				$coupon = new WC_Coupon($post->post_title);
				if ( $this->is_auto_coupon($coupon) ) {
					$this->_autocoupons[$coupon->code] = $coupon;
				}
			}

			//Sort by priority
			@uasort( $this->_autocoupons , array( $this, 'sort_auto_coupons' ) ); //Ignore error PHP Bug #50688

			$coupon_codes = array();
			foreach( $this->_autocoupons as $coupon ) {
				$coupon_codes[] = $coupon->code;
			}

			$this->log( "Autocoupons: " . implode(", ", $coupon_codes ) );
		}

		return $this->_autocoupons;
	}

	/**
	 * Compare function to sort coupons by priority
	 * @param type $a 
	 * @param type $b 
	 * @return type
	 */
	private function sort_auto_coupons( $coupon_a, $coupon_b ) {
		$prio_a = $this->get_coupon_priority( $coupon_a );
		$prio_b = $this->get_coupon_priority( $coupon_b );
		$this->log("A: $prio_a B: $prio_b ");
		if ( $prio_a == $prio_b ) {
			return $a->code < $b->code ? -1 : 1; //By title ASC
		} else {
			return $prio_a > $prio_b ? -1 : 1; //By prio DESC
		}
	}
}