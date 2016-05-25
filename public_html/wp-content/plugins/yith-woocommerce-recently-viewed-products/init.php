<?php
/**
 * Plugin Name: YITH WooCommerce Recently Viewed Products
 * Plugin URI: https://yithemes.com/themes/plugins/yith-woocommerce-recently-viewed-products/
 * Description: YITH WooCommerce Recently Viewed Products lets you to offer a rapid summary to your users, reminding them what they have recently seen and what they could be interested into.
 * Version: 1.0.2
 * Author: YITHEMES
 * Author URI: https://yithemes.com/
 * Text Domain: yith-woocommerce-recently-viewed-products
 * Domain Path: /languages/
 *
 * @author Yithemes
 * @package YITH WooCommerce Recently Viewed Products
 * @version 1.0.2
 */
/*  Copyright 2015  Your Inspiration Themes  (email : plugins@yithemes.com)

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

if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

function yith_wrvp_free_install_woocommerce_admin_notice() {
	?>
	<div class="error">
		<p><?php _e( 'YITH WooCommerce Recently Viewed Products is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-recently-viewed-products' ); ?></p>
	</div>
<?php
}


function yith_wrvp_install_free_admin_notice() {
	?>
	<div class="error">
		<p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Recently Viewed Products while you are using the premium one.', 'yith-woocommerce-recently-viewed-products' ); ?></p>
	</div>
	<?php
}

if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );


if ( ! defined( 'YITH_WRVP_VERSION' ) ){
	define( 'YITH_WRVP_VERSION', '1.0.2' );
}

if ( ! defined( 'YITH_WRVP_FREE_INIT' ) ) {
	define( 'YITH_WRVP_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_WRVP_INIT' ) ) {
	define( 'YITH_WRVP_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_WRVP' ) ) {
	define( 'YITH_WRVP', true );
}

if ( ! defined( 'YITH_WRVP_FILE' ) ) {
	define( 'YITH_WRVP_FILE', __FILE__ );
}

if ( ! defined( 'YITH_WRVP_URL' ) ) {
	define( 'YITH_WRVP_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YITH_WRVP_DIR' ) ) {
	define( 'YITH_WRVP_DIR', plugin_dir_path( __FILE__ )  );
}

if ( ! defined( 'YITH_WRVP_TEMPLATE_PATH' ) ) {
	define( 'YITH_WRVP_TEMPLATE_PATH', YITH_WRVP_DIR . 'templates' );
}

if ( ! defined( 'YITH_WRVP_ASSETS_URL' ) ) {
	define( 'YITH_WRVP_ASSETS_URL', YITH_WRVP_URL . 'assets' );
}


function yith_wrvp_free_init() {

	load_plugin_textdomain( 'yith-woocommerce-recently-viewed-products', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );

	// Load required classes and functions
	require_once('includes/class.yith-wrvp.php');
	require_once('includes/class.yith-wrvp-admin.php');
	require_once('includes/class.yith-wrvp-frontend.php');

	// Let's start the game!
	YITH_WRVP();
}
add_action( 'yith_wrvp_free_init', 'yith_wrvp_free_init' );


function yith_wrvp_free_install() {

	if ( ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'yith_wrvp_free_install_woocommerce_admin_notice' );
	}
	elseif ( defined( 'YITH_WRVP_PREMIUM' ) ) {
		add_action( 'admin_notices', 'yith_wrvp_install_free_admin_notice' );
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
	else {
		do_action( 'yith_wrvp_free_init' );
	}
}
add_action( 'plugins_loaded', 'yith_wrvp_free_install', 11 );