<?php
/**
 * Plugin Name: YITH Infinite Scrolling
 * Plugin URI: https://yithemes.com/themes/plugins/yith-infinite-scrolling/
 * Description: YITH Infinite Scrolling add infinite scroll to your page.
 * Version: 1.0.6
 * Author: YITHEMES
 * Author URI: https://yithemes.com/
 * Text Domain: yith-infinite-scrolling
 * Domain Path: /languages/
 *
 * @author Yithemes
 * @package YITH Infinite Scrolling
 * @version 1.0.6
 */
/*  Copyright 2015  Your Inspiration Themes  ( email: plugins@yithemes.com )

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

function yith_infs_install_free_admin_notice() {
	?>
	<div class="error">
		<p><?php _e( 'You can\'t activate the free version of YITH Infinite Scrolling while you are using the premium one.', 'yith-infinite-scrolling' ); ?></p>
	</div>
<?php
}

if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );


if ( ! defined( 'YITH_INFS_VERSION' ) ){
	define( 'YITH_INFS_VERSION', '1.0.6' );
}

if ( ! defined( 'YITH_INFS_FREE_INIT' ) ) {
	define( 'YITH_INFS_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_INFS' ) ) {
	define( 'YITH_INFS', true );
}

if ( ! defined( 'YITH_INFS_FILE' ) ) {
	define( 'YITH_INFS_FILE', __FILE__ );
}

if ( ! defined( 'YITH_INFS_URL' ) ) {
	define( 'YITH_INFS_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'YITH_INFS_DIR' ) ) {
	define( 'YITH_INFS_DIR', plugin_dir_path( __FILE__ )  );
}

if ( ! defined( 'YITH_INFS_TEMPLATE_PATH' ) ) {
	define( 'YITH_INFS_TEMPLATE_PATH', YITH_INFS_DIR . 'templates' );
}

if ( ! defined( 'YITH_INFS_ASSETS_URL' ) ) {
	define( 'YITH_INFS_ASSETS_URL', YITH_INFS_URL . 'assets' );
}

function yith_infs_init() {

	load_plugin_textdomain( 'yith-infinite-scrolling', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );

	// Load required classes and functions
	require_once( 'includes/class.yith-infs-admin.php' );
	require_once( 'includes/class.yith-infs-frontend.php' );
	require_once( 'includes/class.yith-infs.php' );

	// Let's start the game!
	YITH_INFS();
}
add_action( 'yith_infs_init', 'yith_infs_init' );


function yith_infs_install() {

	if ( defined( 'YITH_INFS_PREMIUM' ) ) {
		add_action( 'admin_notices', 'yith_infs_install_free_admin_notice' );
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}
	else {
		do_action( 'yith_infs_init' );
	}
}
add_action( 'plugins_loaded', 'yith_infs_install', 11 );