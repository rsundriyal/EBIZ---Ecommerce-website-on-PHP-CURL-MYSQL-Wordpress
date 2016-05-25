<?php 
function get_data_url() {
// ADD your own url ex: http://www.your-URL.com/wp-content/plugins/mypluginstats/get_data.php
return 'http://www.wpapptouch.com/wp-content/plugins/mypluginstats/get_data.php'; 
}

function get_client_url() {
	$user_url = get_bloginfo('wpurl');
	$user_url = str_replace("http://", "", $user_url); // Problem with host not accepting http:// in post & get
	$user_url = str_replace("https://", "", $user_url); // Problem with host not accepting http:// in post & get
	return $user_url; 
}

function get_plugin_infos($plug_infos) {
	
	$plugin_dir_path = dirname(__FILE__).'/';
  	$dir =  '/'.basename(dirname(__FILE__)); //get only the directory
  	$all_plugins = get_plugins($dir);
  
  	$keys = array_keys($all_plugins);
	$main_plugin_url = $plugin_dir_path . $keys[0] ;
	
	$plugin_data = get_plugin_data($main_plugin_url);
	
	$plugin_data_result = $plugin_data[$plug_infos]; // Ex: //$plugin_Name = $plugin_data['Name'];
	$plugin_data_result = urlencode($plugin_data_result);		
	
	return $plugin_data_result;
}

function mpsd_activate () {	
	wp_remote_post(get_data_url().'?url='.get_client_url().'&activity=activation&plugin_name='.get_plugin_infos('Name'));	
	//$store_mpsd_infos = array("plugin_Name"=>get_plugin_infos('Name'), "plugin_version"=>get_plugin_infos('Version'));	
	update_option("mpsd_current_version",get_plugin_infos('Version'));
}

function mpsd_deactivate () {	
	wp_remote_post(get_data_url().'?url='.get_client_url().'&activity=deactivation&plugin_name='.get_plugin_infos('Name'));	
}

function mpsd_uninstall () {
	wp_remote_post(get_data_url().'?url='.get_client_url().'&activity=unistallation&plugin_name='.get_plugin_infos('Name'));	
	delete_option("store_mpsd_infos");
}
?>