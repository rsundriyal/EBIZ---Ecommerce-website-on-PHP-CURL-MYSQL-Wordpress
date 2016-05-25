<?php
/**
* Plugin Name: YITH WooCommerce Ajax Search
* Plugin URI: http://yithemes.com/
* Description: YITH WooCommerce Ajax Search allows your users to search products in real time.
* Version: 1.3.9
* Author: Yithemes
* Author URI: http://yithemes.com/
* Text Domain: yith-woocommerce-ajax-search
* Domain Path: /languages/
*
* @author Yithemes
* @package YITH WooCommerce Ajax Search
* @version 1.2.6
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

if ( ! defined( 'YITH_WCAS_DIR' ) ) {
    define( 'YITH_WCAS_DIR', plugin_dir_path( __FILE__ )  );
}

if ( defined( 'YITH_WCAS_PREMIUM' ) ) {
    function yith_wcas_install_free_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Ajax Search while you are using the premium one.', 'yith-woocommerce-ajax-search' ); ?></p>
        </div>
    <?php
    }

    add_action( 'admin_notices', 'yith_wcas_install_free_admin_notice' );

    deactivate_plugins( plugin_basename( __FILE__ ) );
    return;
}

if ( !function_exists( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}

register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );



if ( defined( 'YITH_WCAS_VERSION' ) ){
    return;
}else{
    define( 'YITH_WCAS_VERSION', '1.3.9' );
}

if ( ! defined( 'YITH_WCAS_FREE_INIT' ) ) {
    define( 'YITH_WCAS_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_WCAS' ) ) {
    define( 'YITH_WCAS', true );
}

if ( ! defined( 'YITH_WCAS_FILE' ) ) {
    define( 'YITH_WCAS_FILE', __FILE__ );
}

if ( ! defined( 'YITH_WCAS_URL' ) ) {
    define( 'YITH_WCAS_URL', plugin_dir_url( __FILE__ ) );
}



if ( ! defined( 'YITH_WCAS_TEMPLATE_PATH' ) ) {
    define( 'YITH_WCAS_TEMPLATE_PATH', YITH_WCAS_DIR . 'templates' );
}

if ( ! defined( 'YITH_WCAS_ASSETS_URL' ) ) {
    define( 'YITH_WCAS_ASSETS_URL', YITH_WCAS_URL . 'assets' );
}

if ( ! defined( 'YITH_WCAS_ASSETS_IMAGES_URL' ) ) {
    define( 'YITH_WCAS_ASSETS_IMAGES_URL', YITH_WCAS_ASSETS_URL . '/images/' );
}


function yith_ajax_search_constructor() {

    if ( !function_exists( 'WC' ) ) {
        function yith_wcas_install_woocommerce_admin_notice() {
            ?>
            <div class="error">
                <p><?php _e( 'YITH WooCommerce Ajax Search is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-ajax-search' ); ?></p>
            </div>
        <?php
        }

        add_action( 'admin_notices', 'yith_wcas_install_woocommerce_admin_notice' );
        return;
    }


    load_plugin_textdomain( 'yith-woocommerce-ajax-search', false, dirname( plugin_basename( __FILE__ ) ). '/languages/' );

    // Load required classes and functions
    require_once('functions.yith-wcas.php');
    require_once('class.yith-wcas-admin.php');
    require_once('class.yith-wcas-frontend.php');
    require_once('widgets/class.yith-wcas-ajax-search.php');
    require_once('class.yith-wcas.php');

    // Let's start the game!
    global $yith_wcas;
    $yith_wcas = new YITH_WCAS();
}
add_action( 'plugins_loaded', 'yith_ajax_search_constructor' );