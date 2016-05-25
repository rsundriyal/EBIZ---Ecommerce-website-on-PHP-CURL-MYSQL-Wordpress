<?php
/**
 * Plugin Name: YITH WooCommerce EU VAT
 * Plugin URI: http://yithemes.com/themes/plugins/yith-woocommerce-eu-vat/
 * Description: YITH WooCommerce EU VAT allows you to be fully compliance with EU VAT laws, storing chceckout data and
 * filling the EU VAT MOSS report for digital goods.
 * Version: 1.2.6
 * Author: YITHEMES
 * Author URI: http://yithemes.com/
 * Text Domain: yith-woocommerce-eu-vat
 * Domain Path: /languages/
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce EU VAT
 * @version 1.2.6
 */
/*  Copyright 2013-2015  Your Inspiration Themes  (email : plugins@yithemes.com)

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


if ( ! defined ( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! function_exists ( 'is_plugin_active' ) ) {
    require_once ( ABSPATH . 'wp-admin/includes/plugin.php' );
}


function yith_ywev_install_woocommerce_admin_notice () {
    ?>
    <div class="error">
        <p><?php _e ( 'YITH WooCommerce EU VAT is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-eu-vat' ); ?></p>
    </div>
    <?php
}


function yith_ywev_install_free_admin_notice () {
    ?>
    <div class="error">
        <p><?php _e ( 'You can\'t activate the free version of YITH WooCommerce EU VAT while you are using the premium one.', 'yith-woocommerce-eu-vat' ); ?></p>
    </div>
    <?php
}

if ( ! function_exists ( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook ( __FILE__, 'yith_plugin_registration_hook' );

//region    ****    Define constants
if ( ! defined ( 'YITH_YWEV_FREE_INIT' ) ) {
    define ( 'YITH_YWEV_FREE_INIT', plugin_basename ( __FILE__ ) );
}

if ( ! defined ( 'YITH_YWEV_VERSION' ) ) {
    define ( 'YITH_YWEV_VERSION', '1.2.6' );
}

if ( ! defined ( 'YITH_YWEV_FILE' ) ) {
    define ( 'YITH_YWEV_FILE', __FILE__ );
}

if ( ! defined ( 'YITH_YWEV_DIR' ) ) {
    define ( 'YITH_YWEV_DIR', plugin_dir_path ( __FILE__ ) );
}

if ( ! defined ( 'YITH_YWEV_URL' ) ) {
    define ( 'YITH_YWEV_URL', plugins_url ( '/', __FILE__ ) );
}

if ( ! defined ( 'YITH_YWEV_ASSETS_URL' ) ) {
    define ( 'YITH_YWEV_ASSETS_URL', YITH_YWEV_URL . 'assets' );
}

if ( ! defined ( 'YITH_YWEV_TEMPLATE_DIR' ) ) {
    define ( 'YITH_YWEV_TEMPLATE_DIR', YITH_YWEV_DIR . 'templates' );
}

if ( ! defined ( 'YITH_YWEV_ASSETS_IMAGES_URL' ) ) {
    define ( 'YITH_YWEV_ASSETS_IMAGES_URL', YITH_YWEV_ASSETS_URL . '/images/' );
}

if ( ! defined ( 'YITH_YWEV_LIB_DIR' ) ) {
    define ( 'YITH_YWEV_LIB_DIR', YITH_YWEV_DIR . 'lib/' );
}
//endregion

function yith_ywev_init () {

    /**
     * Load text domain and start plugin
     */
    load_plugin_textdomain ( 'yith-woocommerce-eu-vat', false, dirname ( plugin_basename ( __FILE__ ) ) . '/languages/' );

    // Load required classes and functions
    require_once ( YITH_YWEV_LIB_DIR . 'class.yith-ywev-plugin-fw-loader.php' );
    require_once ( YITH_YWEV_LIB_DIR . 'class.yith-ywev-custom-types.php' );
    require_once ( YITH_YWEV_LIB_DIR . 'class.yith-woocommerce-eu-vat.php' );
    require_once ( YITH_YWEV_LIB_DIR . 'class.yith-tax-rates.php' );

    require_once ( 'functions.php' );

    YITH_YWEV_Plugin_FW_Loader::get_instance ();

    // Let's start the game!
    YITH_WooCommerce_EU_VAT::get_instance ();
}

add_action ( 'yith_ywev_init', 'yith_ywev_init' );


function yith_ywev_install () {


    if ( ! function_exists ( 'WC' ) ) {
        add_action ( 'admin_notices', 'yith_ywev_install_woocommerce_admin_notice' );
    } elseif ( defined ( 'YITH_YWEV_PREMIUM' ) ) {
        add_action ( 'admin_notices', 'yith_ywev_install_free_admin_notice' );
        deactivate_plugins ( plugin_basename ( __FILE__ ) );
    } else {
        do_action ( 'yith_ywev_init' );
    }
}

add_action ( 'plugins_loaded', 'yith_ywev_install', 11 );