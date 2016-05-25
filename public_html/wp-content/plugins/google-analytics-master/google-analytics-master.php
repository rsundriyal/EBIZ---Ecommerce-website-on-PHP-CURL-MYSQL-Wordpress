<?php
/**
Plugin Name: Google Analytics Master
Plugin URI: http://wordpress.techgasp.com/google-analytics-master/
Version: 4.4.1.6
Author: TechGasp
Author URI: http://wordpress.techgasp.com
Text Domain: google-analytics-master
Description: Google Analytics Master is the professional plugin to add Google Analytics tracking to your wordpress.
License: GPL2 or later
*/
/*
Copyright 2013 TechGasp  (email : info@techgasp.com)

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
if(!class_exists('google_analytics_master')) :
///////DEFINE DIR///////
define( 'GOOGLE_ANALYTICS_MASTER_DIR', plugin_dir_path( __FILE__ ) );
///////DEFINE URL///////
define( 'GOOGLE_ANALYTICS_MASTER_URL', plugin_dir_url( __FILE__ ) );
///////DEFINE ID//////
define( 'GOOGLE_ANALYTICS_MASTER_ID', 'google_analytics-master');
///////DEFINE VERSION///////
define( 'GOOGLE_ANALYTICS_MASTER_VERSION', '4.4.1.6' );
global $google_analytics_master_version, $google_analytics_master_name;
$google_analytics_master_version = "4.4.1.6"; //for other pages
$google_analytics_master_name = "Google Analytics Master"; //pretty name
if( is_multisite() ) {
update_site_option( 'google_analytics_master_installed_version', $google_analytics_master_version );
update_site_option( 'google_analytics_master_name', $google_analytics_master_name );
}
else{
update_option( 'google_analytics_master_installed_version', $google_analytics_master_version );
update_option( 'google_analytics_master_name', $google_analytics_master_name );
}
// HOOK ADMIN
require_once( dirname( __FILE__ ) . '/includes/google-analytics-master-admin.php');
// HOOK ADMIN SETTINGS
require_once( dirname( __FILE__ ) . '/includes/google-analytics-master-admin-settings.php');
// HOOK ADMIN STATISTICS QUICK
require_once( dirname( __FILE__ ) . '/includes/google-analytics-master-admin-statistics-quick.php');
// HOOK ADMIN STATISTICS INTERACTIVE
require_once( dirname( __FILE__ ) . '/includes/google-analytics-master-admin-statistics-interactive.php');
// HOOK ADMIN STATISTICS TODAY
require_once( dirname( __FILE__ ) . '/includes/google-analytics-master-admin-statistics-today.php');
// HOOK ADMIN UPDATER
require_once( dirname( __FILE__ ) . '/includes/google-analytics-master-admin-updater.php');
// HOOK ANALYTICS ACTIVE
require_once( dirname( __FILE__ ) . '/includes/google-analytics-master-active.php');
// HOOK DASHBOARD WIDGET SMALL
require_once( dirname( __FILE__ ) . '/includes/google-analytics-master-widget-dashboard-small.php');

class google_analytics_master{
//REGISTER PLUGIN
public static function google_analytics_master_register(){
register_activation_hook( __FILE__, array( __CLASS__, 'google_analytics_master_activate' ) );
}
public static function google_analytics_master_activate(){
register_uninstall_hook( __FILE__, array( __CLASS__, 'google_analytics_master_uninstall' ) );
}
public static function google_analytics_master_uninstall() {
delete_option( 'google_analytics_master_code_id' );
delete_option( 'google_analytics_master_activate_script' );
delete_option( 'google_analytics_master_script_id' );
delete_option( 'google_analytics_master_activate_footer' );
delete_option( 'google_analytics_master_client_id' );
delete_option( 'google_analytics_master_admin_bar' );
delete_site_option( 'google_analytics_master_code_id' );
delete_site_option( 'google_analytics_master_activate_script' );
delete_site_option( 'google_analytics_master_script_id' );
delete_site_option( 'google_analytics_master_activate_footer' );
delete_site_option( 'google_analytics_master_client_id' );
delete_site_option( 'google_analytics_master_admin_bar' );
}
public static function content_with_quote($content){
$quote = '<p>' . get_option('tsm_quote') . '</p>';
	return $content . $quote;
}
//SETTINGS LINK IN PLUGIN MANAGER
public static function google_analytics_master_links( $links, $file ) {
if ( $file == plugin_basename( dirname(__FILE__).'/google-analytics-master.php' ) ) {
		if( is_network_admin() ){
		$techgasp_plugin_url = network_admin_url( 'admin.php?page=google-analytics-master' );
		}
		else {
		$techgasp_plugin_url = admin_url( 'admin.php?page=google-analytics-master' );
		}
	$links[] = '<a href="' . $techgasp_plugin_url . '">'.__( 'Settings' ).'</a>';
	}
	return $links;
}

public static function google_analytics_master_updater_version_check(){
global $google_analytics_master_version;
//CHECK NEW VERSION
$google_analytics_master_slug = basename(dirname(__FILE__));
$current = get_site_transient( 'update_plugins' );
$google_analytics_plugin_slug = $google_analytics_master_slug.'/'.$google_analytics_master_slug.'.php';
@$r = $current->response[ $google_analytics_plugin_slug ];
if (empty($r)){
$r = false;
$google_analytics_plugin_slug = false;
if( is_multisite() ) {
update_site_option( 'google_analytics_master_newest_version', $google_analytics_master_version );
}
else{
update_option( 'google_analytics_master_newest_version', $google_analytics_master_version );
}
}
if (!empty($r)){
$google_analytics_plugin_slug = $google_analytics_master_slug.'/'.$google_analytics_master_slug.'.php';
@$r = $current->response[ $google_analytics_plugin_slug ];
if( is_multisite() ) {
update_site_option( 'google_analytics_master_newest_version', $r->new_version );
}
else{
update_option( 'google_analytics_master_newest_version', $r->new_version );
}
}
}
		// Advanced Updater
//Updater Label Message
public static function google_analytics_master_updater_message() {
$techgasp_updater_info1 = __( 'Important!', 'google_analytics_master' );
$techgasp_updater_info2 = __( ' Update to latest API.', 'google_analytics_master' );
$techgasp_updater_info3 = ' <a href="admin.php?page=google_analytics-master-admin-updater">Updater Page</a>';
$techgasp_updater_icon = plugins_url('images/techgasp-updater-icon.png', __FILE__);
echo '<br><div style="width:28px; vertical-align:middle; float:left;"><img src='.$techgasp_updater_icon.'></div><b>'.$techgasp_updater_info1.'</b>'.$techgasp_updater_info2.$techgasp_updater_info3;
}
//END CLASS
}
if ( is_admin() ){
	add_action('admin_init', array('google_analytics_master', 'google_analytics_master_register'));
	add_action('init', array('google_analytics_master', 'google_analytics_master_updater_version_check'));
	add_action( 'in_plugin_update_message-' . plugin_basename(__FILE__), array('google_analytics_master', 'google_analytics_master_updater_message' ));
}
add_filter( 'the_content', array('google_analytics_master', 'content_with_quote'));
add_filter( 'plugin_action_links', array('google_analytics_master', 'google_analytics_master_links'), 10, 2 );
endif;
