<?php

defined('ABSPATH') or die();

if ( class_exists('WJECF_Admin') ) {
	return;
}

class WJECF_Admin extends Abstract_WJECF_Plugin {
	
	public function __construct() {    
        add_action( 'admin_init', array( $this, 'admin_init' ) );
	}

/* ADMIN HOOKS */
	public function admin_init() {
		if ( ! WJECF()->check_woocommerce_version('2.3.0') ) {
			$this->enqueue_notice( '<p>' . 
				__( '<strong>WooCommerce Extended Coupon Features:</strong> You are using a WooCommerce version prior to 2.3.0. Updating of WooCommerce is recommended as using an outdated version might cause unexpected behaviour in combination with modern plugins.' ) 
				. '</p>', 'notice-warning' );
		}
		//Admin hooks
        add_action( 'admin_notices', array( $this, 'admin_notices'));

		add_filter( 'woocommerce_coupon_data_tabs', array( $this, 'admin_coupon_options_tabs' ), 10, 1);
		add_action( 'woocommerce_coupon_data_panels', array( $this, 'admin_coupon_options_panels' ), 10, 0 );
		add_action( 'woocommerce_process_shop_coupon_meta', array( $this, 'process_shop_coupon_meta' ), 10, 2 );		
		
		add_action( 'wjecf_coupon_metabox_products', array( $this, 'admin_coupon_metabox_products' ), 10, 2 );
		add_action( 'wjecf_coupon_metabox_checkout', array( $this, 'admin_coupon_metabox_checkout' ), 10, 2 );
		add_action( 'wjecf_coupon_metabox_customer', array( $this, 'admin_coupon_metabox_customer' ), 10, 2 );
		add_action( 'wjecf_coupon_metabox_misc', array( $this, 'admin_coupon_metabox_misc' ), 10, 2 );
	}

// ===========================================================================
// START - ADMIN NOTICES
// Allows notices to be displayed on the admin pages
// ===========================================================================

	private $notices = array();
	
	/**
	 * Enqueue a notice to display on the admin page
	 * @param stirng $html Please embed in <p> tags
	 * @param string $class 
	 */
	public function enqueue_notice( $html, $class = 'notice-info' ) {
		$this->notices[] = array( 'class' => $class, 'html' => $html );
	}

	public function admin_notices() {
		foreach( $this->notices as $notice ) {
			echo '<div class="notice ' . $notice['class'] . '">';
			echo $notice['html'];
			echo '</div>';
		}
	}	

// ===========================================================================
// END - ADMIN NOTICES
// ===========================================================================

	
	//Add tabs to the coupon option page
	public function admin_coupon_options_tabs( $tabs ) {
		
		$tabs['extended_features_products'] = array(
			'label'  => __( 'Products', 'woocommerce-jos-autocoupon' ),
			'target' => 'wjecf_coupondata_products',
			'class'  => 'wjecf_coupondata_products',
		);

		$tabs['extended_features_checkout'] = array(
			'label'  => __( 'Checkout', 'woocommerce-jos-autocoupon' ),
			'target' => 'wjecf_coupondata_checkout',
			'class'  => 'wjecf_coupondata_checkout',
		);

		$tabs['extended_features_misc'] = array(
			'label'  => __( 'Miscellaneous', 'woocommerce-jos-autocoupon' ),
			'target' => 'wjecf_coupondata_misc',
			'class'  => 'wjecf_coupondata_misc',
		);

		return $tabs;
	}	

	//Add panels to the coupon option page
	public function admin_coupon_options_panels() {
		global $thepostid, $post;
		$thepostid = empty( $thepostid ) ? $post->ID : $thepostid;
		?>
			<div id="wjecf_coupondata_products" class="panel woocommerce_options_panel">
				<?php
					//Feed the panel with options
					do_action( 'wjecf_coupon_metabox_products', $thepostid, $post );
					$this->admin_coupon_data_footer();
				?>
			</div>
			<div id="wjecf_coupondata_checkout" class="panel woocommerce_options_panel">
				<?php
					do_action( 'wjecf_coupon_metabox_checkout', $thepostid, $post );
					do_action( 'wjecf_coupon_metabox_customer', $thepostid, $post );
					$this->admin_coupon_data_footer();
				?>
			</div>
			<div id="wjecf_coupondata_misc" class="panel woocommerce_options_panel">
				<?php
					//Allow other classes to inject options
					do_action( 'wjecf_woocommerce_coupon_options_extended_features', $thepostid, $post );
					do_action( 'wjecf_coupon_metabox_misc', $thepostid, $post );
					$this->admin_coupon_data_footer();
				?>
			</div>
		<?php		
	}

	public function admin_coupon_data_footer() {
		$documentation_url = plugins_url( 'docs/index.html', dirname( __FILE__ ) );
		if ( ! WJECF()->is_pro() ) {
			$documentation_url = 'http://www.soft79.nl/documentation/wjecf';
			?>			
			<h3><?php _e( 'Do you find WooCommerce Extended Coupon Features useful?', 'woocommerce-jos-autocoupon'); ?></h3>
			<p class="form-field"><label for="wjecf_donate_button"><?php
				echo esc_html( __('Express your gratitude', 'woocommerce-jos-autocoupon' ) );	
			?></label>
			<a id="wjecf_donate_button" href="<?php echo $this->get_donate_url(); ?>" target="_blank" class="button button-primary">
			<?php
				echo esc_html( __('Donate to the developer', 'woocommerce-jos-autocoupon' ) );	
			?></a><br>
			Or get the PRO version at <a href="http://www.soft79.nl" target="_blank">www.soft79.nl</a>.
			</p>
			<?php
		}
		//Documentation link
		echo '<h3>' . __( 'Documentation', 'woocommerce-jos-autocoupon' ) . '</h3>';
		echo '<p><a href="' . $documentation_url . '" target="_blank">' . 
		 	__( 'WooCommerce Extended Coupon Features Documentation', 'woocommerce-jos-autocoupon' ) . '</a></p>';

	}

	//Tab 'extended features'
	public function admin_coupon_metabox_products( $thepostid, $post ) {
		//See WooCommerce class-wc-meta-box-coupon-data.php function ouput
		
		echo "<h3>" . esc_html( __( 'Matching products', 'woocommerce-jos-autocoupon' ) ). "</h3>\n";
		//=============================
		// AND instead of OR the products
		woocommerce_wp_checkbox( array( 
			'id' => '_wjecf_products_and', 
			'label' => __( 'AND Products (not OR)', 'woocommerce-jos-autocoupon' ), 
			'description' => __( 'Check this box if ALL of the products (see tab \'usage restriction\') must be in the cart to use this coupon (instead of only one of the products).', 'woocommerce-jos-autocoupon' )
		) );

		//=============================
		// 2.2.3.1 AND instead of OR the categories
		woocommerce_wp_checkbox( array( 
			'id' => '_wjecf_categories_and', 
			'label' => __( 'AND Categories (not OR)', 'woocommerce-jos-autocoupon' ), 
			'description' => __( 'Check this box if products from ALL of the categories (see tab \'usage restriction\') must be in the cart to use this coupon (instead of only one from one of the categories).', 'woocommerce-jos-autocoupon' )
		) );

		//=============================
		//Trick to show AND or OR next to the product_ids field 		
		$label_and = __( '(AND)', 'woocommerce-jos-autocoupon' );
		$label_or  = __( '(OR)',  'woocommerce-jos-autocoupon' );
		$label_prods = get_post_meta( $thepostid, '_wjecf_products_and', true ) == 'yes' ? $label_and : $label_or;
		$label_cats = get_post_meta( $thepostid, '_wjecf_categories_and', true ) == 'yes' ? $label_and : $label_or;
		?>		
		<script type="text/javascript">
			//Update AND or OR in product_ids label when checkbox value changes
			jQuery("#_wjecf_products_and").click( 
				function() { 
					jQuery("#wjecf_products_and_label").html( 
						jQuery("#_wjecf_products_and").attr('checked') ? '<?php echo esc_js( $label_and ); ?>' : '<?php echo esc_js( $label_or ); ?>'
					);
			} );
			//Append AND/OR to the product_ids label
			jQuery(".form-field:has('[name=\"product_ids\"]') label").append( ' <strong><span id="wjecf_products_and_label"><?php echo esc_html( $label_prods ); ?></span></strong>' );

			jQuery("#_wjecf_categories_and").click( 
				function() { 
					jQuery("#wjecf_categories_and_label").html( 
						jQuery("#_wjecf_categories_and").attr('checked') ? '<?php echo esc_js( $label_and ); ?>' : '<?php echo esc_js( $label_or ); ?>'
					);
			} );
			//Append AND/OR to the product_ids label
			jQuery(".form-field:has('[name=\"product_categories[]\"]') label").append( ' <strong><span id="wjecf_categories_and_label"><?php echo esc_html( $label_cats ); ?></span></strong>' );
		</script>
		<?php //End of the AND/OR trick		

		// Minimum quantity of matching products (product/category)
		woocommerce_wp_text_input( array( 
			'id' => '_wjecf_min_matching_product_qty', 
			'label' => __( 'Minimum quantity of matching products', 'woocommerce-jos-autocoupon' ), 
			'placeholder' => __( 'No minimum', 'woocommerce' ), 
			'description' => __( 'Minimum quantity of the products that match the given product or category restrictions (see tab \'usage restriction\'). If no product or category restrictions are specified, the total number of products is used.', 'woocommerce-jos-autocoupon' ), 
			'data_type' => 'decimal', 
			'desc_tip' => true
		) );
		
		// Maximum quantity of matching products (product/category)
		woocommerce_wp_text_input( array( 
			'id' => '_wjecf_max_matching_product_qty', 
			'label' => __( 'Maximum quantity of matching products', 'woocommerce-jos-autocoupon' ), 
			'placeholder' => __( 'No maximum', 'woocommerce' ), 
			'description' => __( 'Maximum quantity of the products that match the given product or category restrictions (see tab \'usage restriction\'). If no product or category restrictions are specified, the total number of products is used.', 'woocommerce-jos-autocoupon' ), 
			'data_type' => 'decimal', 
			'desc_tip' => true
		) );		

		// Minimum subtotal of matching products (product/category)
		woocommerce_wp_text_input( array( 
			'id' => '_wjecf_min_matching_product_subtotal', 
			'label' => __( 'Minimum subtotal of matching products', 'woocommerce-jos-autocoupon' ), 
			'placeholder' => __( 'No minimum', 'woocommerce' ), 
			'description' => __( 'Minimum price subtotal of the products that match the given product or category restrictions (see tab \'usage restriction\').', 'woocommerce-jos-autocoupon' ), 
			'data_type' => 'price', 
			'desc_tip' => true
		) );

		// Maximum subtotal of matching products (product/category)
		woocommerce_wp_text_input( array( 
			'id' => '_wjecf_max_matching_product_subtotal', 
			'label' => __( 'Maximum subtotal of matching products', 'woocommerce-jos-autocoupon' ), 
			'placeholder' => __( 'No maximum', 'woocommerce' ), 
			'description' => __( 'Maximum price subtotal of the products that match the given product or category restrictions (see tab \'usage restriction\').', 'woocommerce-jos-autocoupon' ), 
			'data_type' => 'price', 
			'desc_tip' => true
		) );
	}

	public function admin_coupon_metabox_checkout( $thepostid, $post ) {

		echo "<h3>" . esc_html( __( 'Checkout', 'woocommerce-jos-autocoupon' ) ). "</h3>\n";

		//=============================
		// Shipping methods
		?>
		<p class="form-field"><label for="wjecf_shipping_methods"><?php _e( 'Shipping methods', 'woocommerce-jos-autocoupon' ); ?></label>
		<select id="wjecf_shipping_methods" name="wjecf_shipping_methods[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php _e( 'Any shipping method', 'woocommerce-jos-autocoupon' ); ?>">
			<?php
				$coupon_shipping_method_ids = WJECF()->get_coupon_shipping_method_ids( $thepostid );
				$shipping_methods = WC()->shipping->load_shipping_methods();

				if ( $shipping_methods ) foreach ( $shipping_methods as $shipping_method ) {
					echo '<option value="' . esc_attr( $shipping_method->id ) . '"' . selected( in_array( $shipping_method->id, $coupon_shipping_method_ids ), true, false ) . '>' . esc_html( $shipping_method->method_title ) . '</option>';
				}
			?>
		</select> <img class="help_tip" data-tip='<?php _e( 'One of these shipping methods must be selected in order for this coupon to be valid.', 'woocommerce-jos-autocoupon' ); ?>' src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" /></p>
		<?php		
		
		//=============================
		// Payment methods
		?>
		<p class="form-field"><label for="wjecf_payment_methods"><?php _e( 'Payment methods', 'woocommerce-jos-autocoupon' ); ?></label>
		<select id="wjecf_payment_methods" name="wjecf_payment_methods[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php _e( 'Any payment method', 'woocommerce-jos-autocoupon' ); ?>">
			<?php
				$coupon_payment_method_ids = WJECF()->get_coupon_payment_method_ids( $thepostid );
				//DONT USE WC()->payment_gateways->available_payment_gateways() AS IT CAN CRASH IN UNKNOWN OCCASIONS
				$payment_methods = WC()->payment_gateways->payment_gateways();
				if ( $payment_methods ) foreach ( $payment_methods as $payment_method ) {
					if ('yes' === $payment_method->enabled) {
						echo '<option value="' . esc_attr( $payment_method->id ) . '"' . selected( in_array( $payment_method->id, $coupon_payment_method_ids ), true, false ) . '>' . esc_html( $payment_method->title ) . '</option>';
					}
				}
			?>
		</select> <img class="help_tip" data-tip='<?php _e( 'One of these payment methods must be selected in order for this coupon to be valid.', 'woocommerce-jos-autocoupon' ); ?>' src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" /></p>
		<?php		
	}

	public function admin_coupon_metabox_customer( $thepostid, $post ) {

		//=============================
		//Title: "CUSTOMER RESTRICTIONS"
		echo "<h3>" . esc_html( __( 'Customer restrictions', 'woocommerce-jos-autocoupon' ) ). "</h3>\n";
		echo "<p><span class='description'>" . __( 'If both a customer and a role restriction are supplied, matching either one of them will suffice.' , 'woocommerce-jos-autocoupon' ) . "</span></p>\n";
		
		//=============================
		// User ids
		?>
		<p class="form-field"><label><?php _e( 'Allowed Customers', 'woocommerce-jos-autocoupon' ); ?></label>
		<input type="hidden" class="wc-customer-search" data-multiple="true" style="width: 50%;" name="wjecf_customer_ids" data-placeholder="<?php _e( 'Any customer', 'woocommerce-jos-autocoupon' ); ?>" data-action="woocommerce_json_search_customers" data-selected="<?php
			$coupon_customer_ids = WJECF()->get_coupon_customer_ids( $thepostid );
			$json_ids    = array();
			
			foreach ( $coupon_customer_ids as $customer_id ) {
				$customer = get_userdata( $customer_id );
				if ( is_object( $customer ) ) {
					$json_ids[ $customer_id ] = $customer->display_name . ' (#' . $customer->ID . ' &ndash; ' . sanitize_email( $customer->user_email ) . ')';
				}
			}

			echo esc_attr( json_encode( $json_ids ) );
		?>" value="<?php echo implode( ',', array_keys( $json_ids ) ); ?>" /> <img class="help_tip" data-tip='<?php 
			_e( 'Only these customers may use this coupon.', 'woocommerce-jos-autocoupon' ); 
		?>' src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" /></p>
		<?php

		//=============================
		// User roles
		?>
		<p class="form-field"><label for="wjecf_customer_roles"><?php _e( 'Allowed User Roles', 'woocommerce-jos-autocoupon' ); ?></label>
		<select id="wjecf_customer_roles" name="wjecf_customer_roles[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php _e( 'Any role', 'woocommerce-jos-autocoupon' ); ?>">
			<?php			
				$coupon_customer_roles = WJECF()->get_coupon_customer_roles( $thepostid );

				$available_customer_roles = array_reverse( get_editable_roles() );
				foreach ( $available_customer_roles as $role_id => $role ) {
					$role_name = translate_user_role($role['name'] );
	
					echo '<option value="' . esc_attr( $role_id ) . '"'
					. selected( in_array( $role_id, $coupon_customer_roles ), true, false ) . '>'
					. esc_html( $role_name ) . '</option>';
				}
			?>
		</select> <img class="help_tip" data-tip='<?php 
			_e( 'Only these User Roles may use this coupon.', 'woocommerce-jos-autocoupon' ); 
		?>' src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" /></p>
		<?php	

		//=============================
		// Excluded user roles
		?>
		<p class="form-field"><label for="wjecf_excluded_customer_roles"><?php _e( 'Disallowed User Roles', 'woocommerce-jos-autocoupon' ); ?></label>
		<select id="wjecf_customer_roles" name="wjecf_excluded_customer_roles[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php _e( 'Any role', 'woocommerce-jos-autocoupon' ); ?>">
			<?php			
				$coupon_excluded_customer_roles = WJECF()->get_coupon_excluded_customer_roles( $thepostid );

				foreach ( $available_customer_roles as $role_id => $role ) {
					$role_name = translate_user_role($role['name'] );
	
					echo '<option value="' . esc_attr( $role_id ) . '"'
					. selected( in_array( $role_id, $coupon_excluded_customer_roles ), true, false ) . '>'
					. esc_html( $role_name ) . '</option>';
				}
			?>
		</select> <img class="help_tip" data-tip='<?php 
			_e( 'These User Roles will be specifically excluded from using this coupon.', 'woocommerce-jos-autocoupon' ); 
		?>' src="<?php echo WC()->plugin_url(); ?>/assets/images/help.png" height="16" width="16" /></p>
		<?php	
	}

	public function admin_coupon_metabox_misc( $thepostid, $post ) {
		echo "<h3>" . esc_html( __( 'Miscellaneous', 'woocommerce-jos-autocoupon' ) ). "</h3>\n";
		//=============================
		//2.2.2 Allow if minimum spend not met
		woocommerce_wp_checkbox( array(
			'id'          => '_wjecf_allow_below_minimum_spend',
			'label'       => __( 'Allow when minimum spend not reached', 'woocommerce-jos-autocoupon' ),
			'description' => '<b>' . __( 'EXPERIMENTAL: ', 'woocommerce-jos-autocoupon' ) . '</b>' . __( 'Check this box to allow the coupon to be in the cart even when minimum spend (see tab \'usage restriction\') is not reached. Value of the discount will be 0 until minimum spend is reached.', 'woocommerce-jos-autocoupon' ),
		) );
	}

	public function process_shop_coupon_meta( $post_id, $post ) {
		$wjecf_min_matching_product_qty = isset( $_POST['_wjecf_min_matching_product_qty'] ) ? $_POST['_wjecf_min_matching_product_qty'] : '';
		update_post_meta( $post_id, '_wjecf_min_matching_product_qty', $wjecf_min_matching_product_qty );
				
		$wjecf_max_matching_product_qty = isset( $_POST['_wjecf_max_matching_product_qty'] ) ? $_POST['_wjecf_max_matching_product_qty'] : '';
		update_post_meta( $post_id, '_wjecf_max_matching_product_qty', $wjecf_max_matching_product_qty );

		//2.2.2
		$wjecf_min_matching_product_subtotal = isset( $_POST['_wjecf_min_matching_product_subtotal'] ) ? $_POST['_wjecf_min_matching_product_subtotal'] : '';
		update_post_meta( $post_id, '_wjecf_min_matching_product_subtotal', $wjecf_min_matching_product_subtotal );
				
		$wjecf_max_matching_product_subtotal = isset( $_POST['_wjecf_max_matching_product_subtotal'] ) ? $_POST['_wjecf_max_matching_product_subtotal'] : '';
		update_post_meta( $post_id, '_wjecf_max_matching_product_subtotal', $wjecf_max_matching_product_subtotal );

		$wjecf_products_and = isset( $_POST['_wjecf_products_and'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_wjecf_products_and', $wjecf_products_and );

		//2.2.3.1
		$wjecf_categories_and = isset( $_POST['_wjecf_categories_and'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_wjecf_categories_and', $wjecf_categories_and );
		
		//2.2.2
		$wjecf_allow_below_minimum_spend = isset( $_POST['_wjecf_allow_below_minimum_spend'] ) ? 'yes' : 'no';
		update_post_meta( $post_id, '_wjecf_allow_below_minimum_spend', $wjecf_allow_below_minimum_spend );
		
		$wjecf_shipping_methods = isset( $_POST['wjecf_shipping_methods'] ) ? $_POST['wjecf_shipping_methods'] : '';
		update_post_meta( $post_id, '_wjecf_shipping_methods', $wjecf_shipping_methods );		
		
		$wjecf_payment_methods = isset( $_POST['wjecf_payment_methods'] ) ? $_POST['wjecf_payment_methods'] : '';
		update_post_meta( $post_id, '_wjecf_payment_methods', $wjecf_payment_methods );		
		
		$wjecf_customer_ids    = implode(",", array_filter( array_map( 'intval', explode(",", $_POST['wjecf_customer_ids']) ) ) );
		update_post_meta( $post_id, '_wjecf_customer_ids', $wjecf_customer_ids );	

		$wjecf_customer_roles    = isset( $_POST['wjecf_customer_roles'] ) ? $_POST['wjecf_customer_roles'] : '';
		update_post_meta( $post_id, '_wjecf_customer_roles', $wjecf_customer_roles );	

		$wjecf_excluded_customer_roles    = isset( $_POST['wjecf_excluded_customer_roles'] ) ? $_POST['wjecf_excluded_customer_roles'] : '';
		update_post_meta( $post_id, '_wjecf_excluded_customer_roles', $wjecf_excluded_customer_roles );	
		
	}

	public function render_admin_cat_selector( $dom_id, $field_name, $selected_ids, $placeholder = null ) {
		if ( $placeholder === null ) $placeholder = __( 'Search for a product…', 'woocommerce' );

		// Categories
		?>				
		<select id="<?php esc_attr_e( $dom_id ) ?>" name="<?php esc_attr_e( $field_name ) ?>[]" style="width: 50%;"  class="wc-enhanced-select" multiple="multiple" data-placeholder="<?php esc_attr_e( $placeholder ); ?>">
			<?php
				$categories   = get_terms( 'product_cat', 'orderby=name&hide_empty=0' );

				if ( $categories ) foreach ( $categories as $cat ) {
					echo '<option value="' . esc_attr( $cat->term_id ) . '"' . selected( in_array( $cat->term_id, $selected_ids ), true, false ) . '>' . esc_html( $cat->name ) . '</option>';
				}
			?>
		</select>
		<?php	
	}

	public function render_admin_product_selector( $dom_id, $field_name, $selected_ids, $placeholder = null ) {
        $product_key_values = array();
        foreach ( $selected_ids as $product_id ) {
            $product = wc_get_product( $product_id );
            if ( is_object( $product ) ) {
                $product_key_values[ esc_attr( $product_id ) ] = wp_kses_post( $product->get_formatted_name() );
            }
        }

		if ( $placeholder === null ) $placeholder = __( 'Search for a product…', 'woocommerce' );

		//In WooCommerce version 2.3.0 chosen was replaced by select2
		$use_select2 = WJECF()->check_woocommerce_version('2.3.0');
    	if ($use_select2) {
			$this->render_admin_select2_product_selector( $dom_id, $field_name, $product_key_values, $placeholder );
		} else {
			$this->render_admin_chosen_product_selector( $dom_id, $field_name, $product_key_values, $placeholder );
		}

	}

	private function render_admin_chosen_product_selector( $dom_id, $field_name, $selected_keys_and_values, $placeholder ) {
		// $selected_keys_and_values must be an array of [ id => name ]

		echo '<select id="' . esc_attr( $dom_id ) . '" name="' . esc_attr( $field_name ) . '" class="ajax_chosen_select_products_and_variations" multiple="multiple" data-placeholder="' . esc_attr( $placeholder ) . '">';
		foreach ( $selected_keys_and_values as $product_id => $product_name ) {
			echo '<option value="' . $product_id . '" selected="selected">' . $product_name . '</option>';
		}
		echo '</select>';
	}

	private function render_admin_select2_product_selector( $dom_id, $field_name, $selected_keys_and_values, $placeholder ) {
		// $selected_keys_and_values must be an array of [ id => name ]

		$json_encoded = esc_attr( json_encode( $selected_keys_and_values ) );
	    echo '<input type="hidden" class="wc-product-search" data-multiple="true" style="width: 50%;" name="' 
	    . esc_attr( $field_name ) . '" data-placeholder="' 
	    . esc_attr( $placeholder ) . '" data-action="woocommerce_json_search_products_and_variations" data-selected="' 
	    . $json_encoded . '" value="' . implode( ',', array_keys( $selected_keys_and_values ) ) . '" />';

	}		

	public static function get_donate_url() {
		return "https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=5T9XQBCS2QHRY&lc=NL&item_name=Jos%20Koenis&item_number=wordpress%2dplugin&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHosted";
	}
}
