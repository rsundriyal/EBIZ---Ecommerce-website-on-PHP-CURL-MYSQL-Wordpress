<?php
/**
 * Plugin Name: YITH WooCommerce Authorize.net Payment Gateway
 * Plugin URI: http://yithemes.com/themes/plugins/yith-woocommerce-authorize-net/
 * Description: YITH WooCommerce Authorize.net allows you to add Authorize.net payment gateway to WooCommerce
 * Version: 1.0.8
 * Author: Yithemes
 * Author URI: http://yithemes.com/
 * Text Domain: yith-wcauthnet
 * Domain Path: /languages/
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Authorize.net
 * @version 1.0.0
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

// Register WP_Pointer Handling
if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

if ( ! defined( 'YITH_WCAUTHNET' ) ) {
	define( 'YITH_WCAUTHNET', true );
}

if( ! defined( 'YITH_WCAUTHNET_VERSION' ) ){
	define( 'YITH_WCAUTHNET_VERSION', '1.0.8' );
}

if ( ! defined( 'YITH_WCAUTHNET_URL' ) ) {
	define( 'YITH_WCAUTHNET_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YITH_WCAUTHNET_DIR' ) ) {
	define( 'YITH_WCAUTHNET_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'YITH_WCAUTHNET_INIT' ) ) {
	define( 'YITH_WCAUTHNET_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_WCAUTHNET_FREE_INIT' ) ) {
	define( 'YITH_WCAUTHNET_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_WCAUTHNET_FILE' ) ) {
	define( 'YITH_WCAUTHNET_FILE', __FILE__ );
}

if ( ! defined( 'YITH_WCAUTHNET_INC' ) ) {
	define( 'YITH_WCAUTHNET_INC', YITH_WCAUTHNET_DIR . 'includes/' );
}

if( ! function_exists( 'yith_wcauthnet_constructor' ) ) {
	function yith_wcauthnet_constructor(){
		load_plugin_textdomain( 'yit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// Load required classes and functions
		require_once( YITH_WCAUTHNET_INC . 'class.yith-wcauthnet-credit-card-gateway.php' );
		require_once( YITH_WCAUTHNET_INC . 'class.yith-wcauthnet.php' );

		if( is_admin() ){
			require_once( YITH_WCAUTHNET_INC . 'class.yith-wcauthnet-admin.php' );

			YITH_WCAUTHNET_Admin();
		}
	}
}
add_action( 'yith_wcauthnet_init', 'yith_wcauthnet_constructor' );

if( ! function_exists( 'yith_wcauthnet_install' ) ) {
	function yith_wcauthnet_install() {

		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		if ( ! function_exists( 'WC' ) ) {
			add_action( 'admin_notices', 'yith_wcauthnet_install_woocommerce_admin_notice' );
		}
		else {
			do_action( 'yith_wcauthnet_init' );
		}
	}
}
add_action( 'plugins_loaded', 'yith_wcauthnet_install', 11 );

if( ! function_exists( 'yith_wcauthnet_install_woocommerce_admin_notice' ) ) {
	function yith_wcauthnet_install_woocommerce_admin_notice() {
		?>
		<div class="error">
			<p><?php _e( 'YITH WooCommerce Authorize.net Payment Gateway is enabled but not effective. It requires WooCommerce in order to work.', 'yith-wcauthnet' ); ?></p>
		</div>
	<?php
	}
}