<?php
/**
 * Plugin Name: YITH WooCommerce Mailchimp
 * Plugin URI: http://yithemes.com/themes/plugins/yith-woocommerce-mailchimp/
 * Description: YITH WooCommerce Mailchimp allows you to integrate the most popular newsletter campaign manager on your ecommerce.
 * Version: 1.0.7
 * Author: Yithemes
 * Author URI: http://yithemes.com/
 * Text Domain: yith-wcmc
 * Domain Path: /languages/
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Mailchimp
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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

if ( ! defined( 'YITH_WCMC' ) ) {
	define( 'YITH_WCMC', true );
}

if ( ! defined( 'YITH_WCMC_VERSION' ) ) {
	define( 'YITH_WCMC_VERSION', '1.0.7' );
}

if ( ! defined( 'YITH_WCMC_URL' ) ) {
	define( 'YITH_WCMC_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YITH_WCMC_DIR' ) ) {
	define( 'YITH_WCMC_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'YITH_WCMC_INC' ) ) {
	define( 'YITH_WCMC_INC', YITH_WCMC_DIR . 'includes/' );
}

if ( ! defined( 'YITH_WCMC_INIT' ) ) {
	define( 'YITH_WCMC_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_WCMC_FREE_INIT' ) ) {
	define( 'YITH_WCMC_FREE_INIT', plugin_basename( __FILE__ ) );
}

if( ! function_exists( 'yith_mailchimp_constructor' ) ) {
	function yith_mailchimp_constructor() {
		load_plugin_textdomain( 'yith-wcmc', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		if( ! class_exists( 'Mailchimp' ) ) {
			require_once( YITH_WCMC_INC . 'mailchimp/Mailchimp.php' );
		}
		require_once( YITH_WCMC_INC . 'functions.yith-wcmc.php' );
		require_once( YITH_WCMC_INC . 'class.yith-wcmc.php' );

		// Let's start the game
		YITH_WCMC();

		if( is_admin() ){
			require_once( YITH_WCMC_INC . 'class.yith-wcmc-admin.php' );

			YITH_WCMC_Admin();
		}
	}
}
add_action( 'yith_wcmc_init', 'yith_mailchimp_constructor' );

if( ! function_exists( 'yith_mailchimp_install' ) ) {
	function yith_mailchimp_install() {

		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		if ( ! function_exists( 'WC' ) ) {
			add_action( 'admin_notices', 'yith_wcmc_install_woocommerce_admin_notice' );
		}
		elseif( defined( 'YITH_WCMC_PREMIUM' ) ) {
			add_action( 'admin_notices', 'yith_wcmc_install_free_admin_notice' );
			deactivate_plugins( plugin_basename( __FILE__ ) );
		}
		else {
			do_action( 'yith_wcmc_init' );
		}
	}
}
add_action( 'plugins_loaded', 'yith_mailchimp_install', 11 );

if( ! function_exists( 'yith_wcmc_install_woocommerce_admin_notice' ) ) {
	function yith_wcmc_install_woocommerce_admin_notice() {
		?>
		<div class="error">
			<p><?php _e( 'YITH WooCommerce MailChimp is enabled but not effective. It requires WooCommerce in order to work.', 'yith-wcmc' ); ?></p>
		</div>
	<?php
	}
}

if( ! function_exists( 'yith_wcmc_install_free_admin_notice' ) ){
	function yith_wcmc_install_free_admin_notice() {
		?>
		<div class="error">
			<p><?php _e( 'You can\'t activate the free version of YITH WooCommerce MailChimp while you are using the premium one.', 'yith-wcmc' ); ?></p>
		</div>
	<?php
	}
}