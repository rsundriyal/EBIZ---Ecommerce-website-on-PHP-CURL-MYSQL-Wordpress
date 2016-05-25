<?php
/**
 * Plugin Name: YITH WooCommerce Stripe
 * Plugin URI: http://yithemes.com/themes/plugins/yith-woocommerce-stripe/
 * Description: Allows you to add Stripe gateway payment to WooCommerce
 * Version: 1.2.7.1
 * Author: YIThemes
 * Author URI: http://yithemes.com/
 * Text Domain: yith-stripe
 * Domain Path: /languages
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Stripe
 * @version 1.2.7.1
 */
/*  Copyright 2013  Your Inspiration Themes  (email : plugins@yithemes.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if( ! defined( 'ABSPATH' ) ){
	exit;
}

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

// Prints an error message if WooCommerce is disabled, and return
if ( ! function_exists( 'WC' ) ) {
	function yith_stripe_premium_install_woocommerce_admin_notice() {
		?>
		<div class="error">
			<p><?php _e( 'YITH WooCommerce Stripe Payment Gateway is enabled but not effective. It requires Woocommerce in order to work.', 'yith-stripe' ); ?></p>
		</div>
	<?php
	}

	add_action( 'admin_notices', 'yith_stripe_premium_install_woocommerce_admin_notice' );
	return;
}

if ( defined( 'YITH_WCSTRIPE_PREMIUM' ) ) {
	function yith_wcstripe_install_free_admin_notice() {
		?>
		<div class="error">
			<p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Stripe while you are using the premium one.', 'yith-stripe' ); ?></p>
		</div>
	<?php
	}

	add_action( 'admin_notices', 'yith_wcstripe_install_free_admin_notice' );

	deactivate_plugins( plugin_basename( __FILE__ ) );
	return;
}

// Register WP_Pointer Handling
if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

if ( ! defined( 'YITH_WCSTRIPE' ) ) {
	define( 'YITH_WCSTRIPE', true );
}

if ( defined( 'YITH_WCSTRIPE_VERSION' ) ) {
	return;
}else{
	define( 'YITH_WCSTRIPE_VERSION', '1.2.7.1' );
}

if ( ! defined( 'YITH_WCSTRIPE_FILE' ) ) {
	define( 'YITH_WCSTRIPE_FILE', __FILE__ );
}

if ( ! defined( 'YITH_WCSTRIPE_FREE_INIT' ) ) {
	define( 'YITH_WCSTRIPE_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_WCSTRIPE_URL' ) ) {
	define( 'YITH_WCSTRIPE_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YITH_WCSTRIPE_DIR' ) ) {
	define( 'YITH_WCSTRIPE_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'YITH_WCSTRIPE_INC' ) ) {
	define( 'YITH_WCSTRIPE_INC', YITH_WCSTRIPE_DIR . 'includes/' );
}

if ( ! function_exists( 'YITH_WCStripe' ) ) {
	/**
	 * Unique access to instance of YITH_WCStripe class
	 *
	 * @return \YITH_WCStripe|YITH_WCStripe_Premium
	 * @since 1.0.0
	 */
	function YITH_WCStripe() {
		// Load required classes and functions
		require_once( YITH_WCSTRIPE_INC . 'class-yith-stripe.php' );

		if ( defined( 'YITH_WCSTRIPE_PREMIUM' ) && file_exists( YITH_WCSTRIPE_INC . 'class-yith-stripe-premium.php' ) ) {
			require_once( YITH_WCSTRIPE_INC . 'class-yith-stripe-premium.php' );
			return YITH_WCStripe_Premium::get_instance();
		}

		return YITH_WCStripe::get_instance();
	}
}

if ( ! function_exists( 'yith_stripe_constructor' ) ) {
	function yith_stripe_constructor() {
		load_plugin_textdomain( 'yith-stripe', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		YITH_WCStripe();
	}
}
add_action( 'plugins_loaded', 'yith_stripe_constructor' );