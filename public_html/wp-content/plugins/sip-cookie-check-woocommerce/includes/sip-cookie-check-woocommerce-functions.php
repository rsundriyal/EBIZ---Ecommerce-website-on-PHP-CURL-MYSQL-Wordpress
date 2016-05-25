<?php

	if( get_option('display_sip_ccwc_message', false) == true) {
		add_action( 'woocommerce_before_cart', array($this, 'sip_cookie_check_wc'), 10 );
	  add_action( 'woocommerce_before_my_account', array($this, 'sip_cookie_check_wc'), 10 );
	  add_action( 'woocommerce_shortcode_before_product_cat_loop', array($this, 'sip_cookie_check_wc'), 10 );
	  add_action( 'woocommerce_before_single_product', array($this, 'sip_cookie_check_wc'), 10 );
	  add_action( 'woocommerce_before_shop_loop', array($this, 'sip_cookie_check_wc'), 10 );
	  add_action( 'woocommerce_before_checkout_billing_form', array($this, 'sip_cookie_check_wc'), 10 );
	}

?>