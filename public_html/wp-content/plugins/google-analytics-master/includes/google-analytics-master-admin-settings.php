<?php
// Create menu
function menu_single_google_analytics_admin_settings(){
	if ( is_admin() )
	add_submenu_page( 'google-analytics-master', 'Settings', 'Settings', 'manage_options', 'google-analytics-master-admin-settings', 'google_analytics_master_admin_settings' );
}

function google_analytics_master_admin_settings(){
?>
<div class="wrap">
<div style="width:40px; vertical-align:middle; float:left;"><img src="<?php echo plugins_url('../images/techgasp-minilogo.png', __FILE__); ?>" alt="' . esc_attr__( 'TechGasp Plugins') . '" /></div>
<h2><b>&nbsp;Settings</b></h2>

<?php
if(!class_exists('google_analytics_master_admin_settings_table')){
	require_once( dirname( __FILE__ ) . '/google-analytics-master-admin-settings-table.php');
}
//Prepare Table of elements
$wp_list_table = new google_analytics_master_admin_settings_table();
//Table of elements
$wp_list_table->display();
?>
</br>
<h2>IMPORTANT: Makes no use of Javascript or Ajax to keep your website fast and conflicts free</h2>

<div style="background: url(<?php echo plugins_url('../images/techgasp-hr.png', __FILE__); ?>) repeat-x; height: 10px"></div>

<br>

<p>
<a class="button-secondary" href="http://wordpress.techgasp.com" target="_blank" title="Visit Website">More TechGasp Plugins</a>
<a class="button-secondary" href="http://wordpress.techgasp.com/support/" target="_blank" title="Facebook Page">TechGasp Support</a>
<a class="button-primary" href="http://wordpress.techgasp.com/google-analytics-master/" target="_blank" title="Visit Website"><?php echo get_option('google_analytics_master_name'); ?> Info</a>
<a class="button-primary" href="http://wordpress.techgasp.com/google-analytics-master-documentation/" target="_blank" title="Visit Website"><?php echo get_option('google_analytics_master_name'); ?> Documentation</a>
<a class="button-primary" href="http://wordpress.org/plugins/google-analytics-master/" target="_blank" title="Visit Website">RATE US *****</a>
</p>
<?php
}

if( is_multisite() ) {
add_action( 'admin_menu', 'menu_single_google_analytics_admin_settings' );
}
else {
add_action( 'admin_menu', 'menu_single_google_analytics_admin_settings' );
}
?>