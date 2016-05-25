<?php
/*
Plugin Name: WooCommerce Compare List
Plugin URI: http://wordpress.org/plugins/woocommerce-compare-list/
Description: The plugin adds ability to compare some products of your WooCommerce driven shop.
Version: 1.1.1
Author: Themeisle
Author URI: http://themeisle.com
License: GPL v2.0 or later
License URI: http://www.opensource.org/licenses/gpl-license.php
*/

// prevent direct access
if ( !defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 404 Not Found', true, 404 );
	exit;
}

// add action hooks
add_action( 'plugins_loaded', 'wccm_launch' );
// activation and deactivation stuff
register_activation_hook( __FILE__, 'flush_rewrite_rules' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );

/**
 * Launches plugin if WooCommerce is active.
 *
 * @since 1.1.0
 * @action plugins_loaded
 *
 * @return boolean TRUE if launched successfully, otherwise FALSE.
 */
function wccm_launch() {
	if ( !class_exists( 'WooCommerce' ) || defined( 'WCCM_VERISON' ) ) {
		return false;
	}

	define( 'WCCM_VERISON', '1.1.0' );

	load_plugin_textdomain( 'wccm', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

	require_once 'includes/common.php';
	require_once 'includes/widget.php';
	if ( is_admin() ) {
		require_once 'includes/settings.php';
	} else {
		require_once 'includes/shortcode.php';
		if ( intval( get_option( 'wccm_compare_page' ) ) > 0 ) {
			require_once 'includes/buttons.php';
			require_once 'includes/compare-page.php';
			require_once 'includes/catalog.php';
		}
	}

	return true;
}