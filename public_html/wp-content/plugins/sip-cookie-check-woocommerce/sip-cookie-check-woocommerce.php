<?php
/**
 * Plugin Name: 	SIP Cookie Check for WooCommerce
 * Plugin URI: 		https://shopitpress.com/plugins/sip-cookie-check-woocommerce/?utm_source=wordpress.org&utm_medium=readme&utm_campaign=sip-cookie-check-woocommerce
 * Description: 	A plugin that displays a notice to users who have cookies disabled in WooCommerce and other pages so that they can enable them to make purchases.
 * Version: 		1.0.2
 * Author: 			Shopitpress
 * Author URI: 		https://www.shopitpress.com
 * License: 		GPL2
 */

/*
  Copyright 2015  Shopitpress  (email : hello@shopitpress.com)
*/

// exit if access directly
if ( !defined( 'ABSPATH' ) ) exit;

define( 'SIP_CCWC_PLUGIN_NAME', 'SIP Cookie Check for WooCommerce' );
define( 'SIP_CCWC_PLUGIN_SLUG', 'sip-cookie-check-woocommerce' );
define( 'SIP_CCWC_PLUGIN_VERSION', '1.0.2' );
define( 'SIP_CCWC_BASENAME', plugin_basename( __FILE__ ) );
define( 'SIP_CCWC_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'SIP_CCWC_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );


/**
 * SIP_Cookie_Check_Woocommerce
 */

class SIP_Cookie_Check_Woocommerce {

	/**
	 * Constructor - set and hook up the plugin
	 */
	public function __construct() {
		add_action( 'admin_init', array($this, 'sip_ccwc_register_admin_settings' ) );
	}

	// Register admin settings
	public function sip_ccwc_register_admin_settings() {

		register_setting( 'sip-ccwc-settings-group', 'sip_ccwc_message_editor' );
		register_setting( 'sip-ccwc-settings-group', 'display_sip_ccwc_message' );
		register_setting( 'sip-ccwc-settings-group', 'sip_ccwc_css_enable_desable' );
		register_setting( 'sip-ccwc-settings-group', 'sip_ccwc_customise_message_checkbox' );
		register_setting( 'sip-ccwc-affiliate-settings-group', 'sip-ccwc-affiliate-check-box' );
		register_setting( 'sip-ccwc-affiliate-settings-group', 'sip-ccwc-affiliate-radio' );
		register_setting( 'sip-ccwc-affiliate-settings-group', 'sip-ccwc-affiliate-affiliate-username' );
	}

} // end class SIP_Cookie_Check_Woocommerce

// Installation and uninstallation hooks
// register_activation_hook( __FILE__, array('SIP_Cookie_Check_Woocommerce', 'activate' ) );
register_activation_hook( __FILE__, 'sip_cookie_check_woocommerce_activate' );
function sip_cookie_check_woocommerce_activate(){
	$editor_content = '<strong>Cookies are disabled in your browser, you need to enable cookies to make purchases in this store</strong> - Please enable cookies. Learn how to do it by <a href="https://shopitpress.com/enable-cookies/" target="_blank">clicking here</a>. ';
  update_option( 'sip_ccwc_message_editor', $editor_content );
}

// instantiate the plugin class
if ( is_admin() )
	$sip_cookie_Check_woocommerce = new SIP_Cookie_Check_Woocommerce();

// add shortcode
require_once( SIP_CCWC_DIR . "includes/class-sip-cookie-check-woocommerce-shortcodes.php" );
// add admin panel
require_once( SIP_CCWC_DIR . "admin/sip-cookie-check-woocommerce.php" );
