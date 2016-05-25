<?php
/**
 * Plugin Name: YITH WooCommerce Colors and Labels Variations
 * Plugin URI: http://yithemes.com/
 * Description: YITH WooCommerce Ajax Colors and Labels Variations replaces the dropdown select of your variable products with Colors and Labels
 * Version: 1.2.3
 * Author: Yithemes
 * Author URI: http://yithemes.com/
 * Text Domain: ywcl
 * Domain Path: /languages/
 *
 * @author Yithemes
 * @package YITH WooCommerce Colors and Labels Variations
 * @version 1.2.3
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
if ( !defined( 'ABSPATH' ) ) { exit; } // Exit if accessed directly

if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

if ( defined( 'YITH_WCCL_PREMIUM' ) ) {
	function yith_wccl_install_free_admin_notice() {
		?>
		<div class="error">
			<p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Colors and Labels Variations while you are using the premium one.', 'ywcl' ); ?></p>
		</div>
	<?php
	}

	add_action( 'admin_notices', 'yith_wccl_install_free_admin_notice' );

	deactivate_plugins( plugin_basename( __FILE__ ) );
	return;
}

if ( ! defined( 'YITH_WCCL_FREE_INIT' ) ) {
	define( 'YITH_WCCL_FREE_INIT', plugin_basename( __FILE__ ) );
}
if ( ! defined( 'YITH_WCCL' ) ) {
	define( 'YITH_WCCL', true );
}
if ( ! defined( 'YITH_WCCL_URL' ) ) {
	define( 'YITH_WCCL_URL', plugin_dir_url( __FILE__ ) );
}
if ( ! defined( 'YITH_WCCL_DIR' ) ) {
	define( 'YITH_WCCL_DIR', plugin_dir_path( __FILE__ ) );
}
if ( ! defined( 'YITH_WCCL_VERSION' ) ) {
	define( 'YITH_WCCL_VERSION', '1.2.3' );
}

function yith_wccl_constructor() {
    global $woocommerce;
    if ( ! isset( $woocommerce ) ) return;

    load_plugin_textdomain( 'ywcl', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );

    // Load required classes and functions
    require_once('functions.yith-wccl.php');
    require_once('class.yith-wccl-admin.php');
    require_once('class.yith-wccl-frontend.php');
    require_once('class.yith-wccl.php');

    // Let's start the game!
    global $yith_wccl;
    $yith_wccl = new YITH_WCCL();
}
add_action( 'plugins_loaded', 'yith_wccl_constructor' );
