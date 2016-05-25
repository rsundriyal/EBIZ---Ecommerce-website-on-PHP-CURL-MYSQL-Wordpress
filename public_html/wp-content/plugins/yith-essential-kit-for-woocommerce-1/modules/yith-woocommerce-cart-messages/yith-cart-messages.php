<?php
/*
Plugin Name: YITH WooCommerce Cart Messages
Plugin URI: http://yithemes.com/themes/plugins/yith-woocommerce-cart-messages
Description: WooCommerce plugin for add custom messages to your customers
Author: YITHEMES
Text Domain: yith-woocommerce-cart-messages
Version: 1.1.5
Author URI: http://yithemes.com/
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}


if ( ! defined( 'YITH_YWCM_DIR' ) ) {
    define( 'YITH_YWCM_DIR', plugin_dir_path( __FILE__ ) );
}

if ( defined( 'YITH_YWCM_PREMIUM' ) ) {
    function yith_ywcm_install_free_admin_notice() {
        ?>
        <div class="error">
            <p><?php _e( 'You can\'t activate the free version of YITH WooCommerce Cart Messages while you are using the premium one.', 'yith-woocommerce-cart-messages' ); ?></p>
        </div>
    <?php
    }

    add_action( 'admin_notices', 'yith_ywcm_install_free_admin_notice' );

    deactivate_plugins( plugin_basename( __FILE__ ) );
    return;
}

if ( !function_exists( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}

register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );


if ( defined( 'YITH_YWCM_VERSION' ) ) {
	return;
}else{
    define( 'YITH_YWCM_VERSION', '1.1.5' );
}

if ( ! defined( 'YITH_YWCM_FREE_INIT' ) ) {
    define( 'YITH_YWCM_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'YITH_YWCM_FILE' ) ) {
	define( 'YITH_YWCM_FILE', __FILE__ );
}


if ( ! defined( 'YITH_YWCM_URL' ) ) {
	define( 'YITH_YWCM_URL', plugins_url( '/', __FILE__ ) );
}

if ( ! defined( 'YITH_YWCM_ASSETS_URL' ) ) {
	define( 'YITH_YWCM_ASSETS_URL', YITH_YWCM_URL . 'assets' );
}

if ( ! defined( 'YITH_YWCM_TEMPLATE_PATH' ) ) {
	define( 'YITH_YWCM_TEMPLATE_PATH', YITH_YWCM_DIR . 'templates' );
}

// Load required classes and functions _________________________
function yith_ywcm_constructor(){
    // Woocommerce installation check _________________________
    if ( !function_exists( 'WC' ) ) {
        function yith_ywcm_install_woocommerce_admin_notice() {
            ?>
            <div class="error">
                <p><?php _e( 'YITH WooCommerce Cart Messages is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-cart-messages' ); ?></p>
            </div>
        <?php
        }

        add_action( 'admin_notices', 'yith_ywcm_install_woocommerce_admin_notice' );
        return;
    }

    /* Load YITH_YWCM text domain */
    load_plugin_textdomain( 'yith-woocommerce-cart-messages', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

    // Load required classes and functions
    require_once( YITH_YWCM_DIR . 'yith-cart-messages-functions.php' );
    require_once( YITH_YWCM_DIR . 'class.yith-woocommerce-cart-message.php' );
    require_once( YITH_YWCM_DIR . 'class.yith-woocommerce-cart-messages.php' );

    global $YWCM_Instance;
    $YWCM_Instance = new YWCM_Cart_Messages();
}
add_action( 'plugins_loaded', 'yith_ywcm_constructor' );