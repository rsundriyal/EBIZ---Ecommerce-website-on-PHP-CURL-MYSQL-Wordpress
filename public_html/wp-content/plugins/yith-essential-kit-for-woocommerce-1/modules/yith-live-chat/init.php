<?php
/**
 * Plugin Name: YITH Live Chat
 * Plugin URI: http://yithemes.com/themes/plugins/yith-live-chat/
 * Description: Pre-sales question ? Needs support ? Chat with your customers!
 * Author: YITHEMES
 * Text Domain: yith-live-chat
 * Version: 1.1.5
 * Author URI: http://yithemes.com/
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( !function_exists( 'is_plugin_active' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

function ylc_install_free_admin_notice() {
    ?>
    <div class="error">
        <p><?php _e( 'You can\'t activate the free version of YITH Live Chat while you are using the premium one.', 'yith-live-chat' ); ?></p>
    </div>
<?php
}

if ( !defined( 'YLC_VERSION' ) ) {
    define( 'YLC_VERSION', '1.1.5' );
}

if ( !defined( 'YLC_FREE_INIT' ) ) {
    define( 'YLC_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( !defined( 'YLC_FILE' ) ) {
    define( 'YLC_FILE', __FILE__ );
}

if ( !defined( 'YLC_DIR' ) ) {
    define( 'YLC_DIR', plugin_dir_path( __FILE__ ) );
}

if ( !defined( 'YLC_URL' ) ) {
    define( 'YLC_URL', plugins_url( '/', __FILE__ ) );
}

if ( !defined( 'YLC_ASSETS_URL' ) ) {
    define( 'YLC_ASSETS_URL', YLC_URL . 'assets' );
}

if ( !defined( 'YLC_TEMPLATE_PATH' ) ) {
    define( 'YLC_TEMPLATE_PATH', YLC_DIR . 'templates' );
}


function ylc_free_init() {

    /* Load text domain */
    load_plugin_textdomain( 'yith-live-chat', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

    if ( !session_id() ) {
        session_start();
    }

    YITH_Live_Chat();

}

add_action( 'ylc_init', 'ylc_free_init' );

function ylc_install() {

    if ( defined( 'YLC_PREMIUM' ) ) {
        add_action( 'admin_notices', 'ylc_install_free_admin_notice' );
        deactivate_plugins( plugin_basename( __FILE__ ) );
    }
    else {
        do_action( 'ylc_init' );
    }
}

add_action( 'plugins_loaded', 'ylc_install', 11 );

/**
 * Init default plugin settings
 */
if ( !function_exists( 'yith_plugin_registration_hook' ) ) {
    require_once 'plugin-fw/yit-plugin-registration-hook.php';
}

register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );
register_activation_hook( __FILE__, 'ylc_roles' );

if ( !function_exists( 'YITH_Live_Chat' ) ) {

    /**
     * Unique access to instance of YIYH_Live_Chat
     *
     * @since   1.1.0
     * @return  YITH_Livechat|YITH_Livechat_Premium
     * @author  Alberto Ruggiero
     */
    function YITH_Live_Chat() {

        // Load required classes and functions
        require_once( YLC_DIR . 'class.yith-livechat.php' );

        if ( defined( 'YLC_PREMIUM' ) && file_exists( YLC_DIR . 'class.yith-livechat-premium.php' ) ) {

            require_once( YLC_DIR . 'class.yith-livechat-premium.php' );
            return YITH_Livechat_Premium::get_instance();
        }

        return YITH_Livechat::get_instance();

    }

}

if ( !function_exists( 'ylc_roles' ) ) {

    /**
     * Initialize Roles
     *
     * @since   1.0.0
     * @return  void
     * @author  Alberto Ruggiero
     */
    function ylc_roles() {

        YITH_Live_Chat()->ylc_operator_role( 'editor' );

        //Administration role
        $admin_role = get_role( 'administrator' );
        $admin_role->add_cap( 'answer_chat' );

        //Chat Operator role
        $op_role = get_role( 'ylc_chat_op' );
        $op_role->add_cap( 'answer_chat' );

    }

}

