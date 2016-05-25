<?php
/**
 * Plugin Name: YITH WooCommerce Waiting List
 * Plugin URI: http://yithemes.com/
 * Description: YITH WooCommerce Waiting List allow users to request an email notification when an out-of-stock product comes back into stock.
 * Version: 1.0.5
 * Author: YITHEMES
 * Author URI: http://yithemes.com/
 * Text Domain: yith-woocommerce-waiting-list
 * Domain Path: /languages/
 *
 * @author Yithemes
 * @package YITH WooCommerce Waiting List
 * @version 1.0.5
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

function yith_wcwtl_install_woocommerce_admin_notice() {
	?>
	<div class="error">
		<p><?php _e( 'YITH WooCommerce Waiting List is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-waiting-list' ); ?></p>
	</div>
<?php
}


function yith_wcwtl_install_free_admin_notice() {
	?>
	<div class="error">
		<p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Waiting List while you are using the premium one.', 'yith-woocommerce-waiting-list' ); ?></p>
	</div>
<?php
}

if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );


if ( ! defined( 'YITH_WCWTL_VERSION' ) ){
	define( 'YITH_WCWTL_VERSION', '1.0.5' );
}

if ( ! defined( 'YITH_WCWTL_FREE_INIT' ) ) {
	define( 'YITH_WCWTL_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_WCWTL_INIT' ) ) {
	define( 'YITH_WCWTL_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_WCWTL' ) ) {
	define( 'YITH_WCWTL', true );
}

if ( ! defined( 'YITH_WCWTL_FILE' ) ) {
	define( 'YITH_WCWTL_FILE', __FILE__ );
}

if ( ! defined( 'YITH_WCWTL_URL' ) ) {
	define( 'YITH_WCWTL_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YITH_WCWTL_DIR' ) ) {
	define( 'YITH_WCWTL_DIR', plugin_dir_path( __FILE__ )  );
}

if ( ! defined( 'YITH_WCWTL_TEMPLATE_PATH' ) ) {
	define( 'YITH_WCWTL_TEMPLATE_PATH', YITH_WCWTL_DIR . 'templates' );
}

if ( ! defined( 'YITH_WCWTL_ASSETS_URL' ) ) {
	define( 'YITH_WCWTL_ASSETS_URL', YITH_WCWTL_URL . 'assets' );
}

if ( ! defined( 'YITH_WCWTL_META' ) ) {
	define( 'YITH_WCWTL_META', '_yith_wcwtl_users_list' );
}

function yith_wcwtl_init() {

	load_plugin_textdomain( 'yith-woocommerce-waiting-list', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );

	// Load required classes and functions
	require_once('includes/class.yith-wcwtl-admin.php');
	require_once('includes/class.yith-wcwtl-meta.php');
	require_once('includes/class.yith-wcwtl-frontend.php');
	require_once('includes/function.yith-wcwtl.php');
	require_once('includes/class.yith-wcwtl.php');

	// Let's start the game!
	YITH_WCWTL();
}
add_action( 'yith_wcwtl_init', 'yith_wcwtl_init' );


function yith_wcwtl_install() {

	if ( ! function_exists( 'WC' ) ) {
		add_action( 'admin_notices', 'yith_wcwtl_install_woocommerce_admin_notice' );
	}
	elseif ( defined( 'YITH_WCWTL_PREMIUM' ) ) {
		add_action( 'admin_notices', 'yith_wcwtl_install_free_admin_notice' );
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
	else {
		do_action( 'yith_wcwtl_init' );
	}
}
add_action( 'plugins_loaded', 'yith_wcwtl_install', 11 );