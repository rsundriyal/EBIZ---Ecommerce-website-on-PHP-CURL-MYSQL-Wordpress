<?php
/**
 * Plugin Name: WooCommerce Extended Coupon Features
 * Plugin URI: http://www.soft79.nl
 * Description: Additional functionality for WooCommerce Coupons: Apply certain coupons automatically, allow applying coupons via an url, etc...
 * Version: 2.3.3
 * Author: Jos Koenis
 * License: GPL2
 */
 
// Change history: see readme.txt

 
defined('ABSPATH') or die();

if ( ! function_exists( 'wjecf_load_plugin_textdomain' ) ) {

	require_once( 'includes/wjecf-controller.php' );
	require_once( 'includes/abstract-wjecf-plugin.php' );
	require_once( 'includes/admin/wjecf-admin.php' );
	require_once( 'includes/admin/wjecf-admin-auto-upgrade.php' );
	//Optional
	@include_once( 'includes/wjecf-autocoupon.php' );
	@include_once( 'includes/wjecf-wpml.php' );
	//PRO
	@include_once( 'includes/wjecf-pro-controller.php' );
	@include_once( 'includes/wjecf-pro-free-products.php' );
	@include_once( 'includes/wjecf-pro-api.php' );		

	// Only Initiate the plugin if WooCommerce is active
	if ( WJECF_Controller::get_woocommerce_version() == false ) {
		add_action( 'admin_notices', 'wjecf_admin_notice' );
	    function wjecf_admin_notice() {
	        $msg = __( 'WooCommerce Extended Coupon Features is disabled because WooCommerce could not be detected.', 'woocommerce-jos-autocoupon' );
	        echo '<div class="error"><p>' . $msg . '</p></div>';
	    }
	} else {	
		function wjecf_load_plugin_textdomain() {
			load_plugin_textdomain('woocommerce-jos-autocoupon', false, basename(dirname(__FILE__)) . '/languages/' );
		}
		add_action('plugins_loaded', 'wjecf_load_plugin_textdomain');

		/**
		 * Get the instance if the WJECF_Controller
		 */
		function WJECF() {
			if ( class_exists( 'WJECF_Pro_Controller' ) ) { 
				return WJECF_Pro_Controller::instance();
			} else {
				return WJECF_Controller::instance();
			}
		}

		/**
		 * Get the instance if the WJECF_Admin plugin
		 */
		function WJECF_ADMIN() {
			return WJECF()->get_plugin('WJECF_Admin');
		}

		$wjecf_extended_coupon_features = WJECF();
		WJECF()->add_plugin('WJECF_Admin');
		WJECF()->add_plugin('WJECF_Admin_Auto_Upgrade');
		WJECF()->add_plugin('WJECF_AutoCoupon');
		WJECF()->add_plugin('WJECF_WPML');
		WJECF()->add_plugin('WJECF_Pro_Free_Products');
	}

}

/**
 * Add donate-link to plugin page
 */
if ( ! function_exists( 'wjecf_plugin_meta' ) ) {
	function wjecf_plugin_meta( $links, $file ) {
		if ( strpos( $file, 'woocommerce-jos-autocoupon.php' ) !== false ) {
			$links = array_merge( $links, array( '<a href="' . WJECF_Admin::get_donate_url() . '" title="Support the development" target="_blank">Donate</a>' ) );
		}
		return $links;
	}
	add_filter( 'plugin_row_meta', 'wjecf_plugin_meta', 10, 2 );
}



// =========================================================================================================
// Some snippets that might be useful
// =========================================================================================================

/* // HINT: Use this snippet in your theme if you use coupons with restricted emails and AJAX enabled one-page-checkout.

//Update the cart preview when the billing email is changed by the customer
add_filter( 'woocommerce_checkout_fields', function( $checkout_fields ) {
	$checkout_fields['billing']['billing_email']['class'][] = 'update_totals_on_change';
	return $checkout_fields;	
} );
 
// */ 
 

/* // HINT: Use this snippet in your theme if you want to update cart preview after changing payment method.
//Even better: In your theme add class "update_totals_on_change" to the container that contains the payment method radio buttons.
//Do this by overriding woocommerce/templates/checkout/payment.php

//Update the cart preview when payment method is changed by the customer
add_action( 'woocommerce_review_order_after_submit' , function () {
	?><script type="text/javascript">
		jQuery(document).ready(function($){
			$(document.body).on('change', 'input[name="payment_method"]', function() {
				$('body').trigger('update_checkout');
				//$.ajax( $fragment_refresh );
			});
		});
	</script><?php 
} );
// */
