<?php
/*
Plugin Name: YITH WooCommerce Advanced Reviews
Plugin URI: http://yithemes.com/themes/plugins/yith-woocommerce-advanced-reviews/
Description: Extends the basic functionality of woocommerce reviews and add a histogram table to the reviews of your products, as well as you see in most trendy e-commerce sites.
Author: YITHEMES
Text Domain: yith-woocommerce-advanced-reviews
Version: 1.2.2
Author URI: http://yithemes.com/
*/

if ( ! defined ( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! function_exists ( 'is_plugin_active' ) ) {
    require_once ( ABSPATH . 'wp-admin/includes/plugin.php' );
}
if ( ! function_exists ( 'yith_ywar_install_woocommerce_admin_notice' ) ) {

    function yith_ywar_install_woocommerce_admin_notice () {
        ?>
        <div class="error">
            <p><?php _e ( 'YITH WooCommerce Advanced Reviews is enabled but not effective. It requires WooCommerce in order to work.', 'yit' ); ?></p>
        </div>
        <?php
    }
}

if ( ! function_exists ( 'yith_ywar_install_free_admin_notice' ) ) {
    function yith_ywar_install_free_admin_notice () {
        ?>
        <div class="error">
            <p><?php _e ( 'You can\'t activate the free version of YITH WooCommerce Advanced Reviews while you are using the premium one.', 'yit' ); ?></p>
        </div>
        <?php
    }
}

if ( ! function_exists ( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook ( __FILE__, 'yith_plugin_registration_hook' );


require_once ( plugin_dir_path ( __FILE__ ) . 'functions.php' );
yith_define ( 'YITH_YWAR_FREE_INIT', plugin_basename ( __FILE__ ) );
yith_define ( 'YITH_YWAR_VERSION', '1.2.2' );
yith_define ( 'YITH_YWAR_FILE', __FILE__ );
yith_define ( 'YITH_YWAR_DIR', plugin_dir_path ( __FILE__ ) );
yith_define ( 'YITH_YWAR_URL', plugins_url ( '/', __FILE__ ) );
yith_define ( 'YITH_YWAR_ASSETS_URL', YITH_YWAR_URL . 'assets' );
yith_define ( 'YITH_YWAR_TEMPLATE_PATH', YITH_YWAR_DIR . 'templates' );
yith_define ( 'YITH_YWAR_TEMPLATES_DIR', YITH_YWAR_DIR . '/templates/' );
yith_define ( 'YITH_YWAR_ASSETS_IMAGES_URL', YITH_YWAR_ASSETS_URL . '/images/' );

function yith_ywar_init () {
    
    /**
     * Load text domain and start plugin
     */
    load_plugin_textdomain ( 'yith-woocommerce-advanced-reviews', false, dirname ( plugin_basename ( __FILE__ ) ) . '/languages/' );
    
    require_once ( YITH_YWAR_DIR . 'class.yith-woocommerce-advanced-reviews.php' );
    
    global $YWAR_AdvancedReview;
    $YWAR_AdvancedReview = YITH_WooCommerce_Advanced_Reviews::get_instance ();
}

add_action ( 'yith_ywar_init', 'yith_ywar_init' );

function yith_ywar_install () {
    
    if ( ! function_exists ( 'WC' ) ) {
        add_action ( 'admin_notices', 'yith_ywar_install_woocommerce_admin_notice' );
    } elseif ( defined ( 'YITH_YWAR_PREMIUM' ) ) {
        add_action ( 'admin_notices', 'yith_ywar_install_free_admin_notice' );
        deactivate_plugins ( plugin_basename ( __FILE__ ) );
    } else {
        do_action ( 'yith_ywar_init' );
    }
}

add_action ( 'plugins_loaded', 'yith_ywar_install', 11 );



