<?php
/*
Plugin Name: WP AppTouch
Plugin URI: http://mobilypress.com/
Author: Gino Cote
Author URI: http://mobilypress.com/
Description: WP-appTouch - Web application for Wordpress who look like native applications.
Version: 0.8.2
*/

//include('mps_datas.php');
// Activate theme switching.
add_filter('template', 'waptTheme');
add_filter('option_template', 'waptTheme');
add_filter('option_stylesheet', 'waptTheme');
add_action( 'init', 'wapt_add_image_size' );
/**
 * This is the main function of the plug-in which switches to another
 * theme based on the user agent.
 */

//Plugin version
function wapt_get_version() {
    $plugin_data = get_plugin_data( __FILE__ );
    $plugin_version = $plugin_data['Version'];
    return $plugin_version;
}

function wapt_image_plugin_detail_image_size() {
	return array(
		'name' => 'wp_small',
		'size' => array( 80, 60, true )
		);
}

function wapt_add_image_size() {
	$detail = wapt_image_plugin_detail_image_size();
	add_image_size(
		$detail['name'],
		$detail['size'][0],
		$detail['size'][1],
		$detail['size'][2]
		);
} 
 
function waptTheme($originalTheme) {
	// Check if we have a valid theme.
	$alternativeTheme = get_option("wapt_current_theme","");
	$found = false;
	foreach(get_themes() as $theme)
		if($theme["Template"] == $alternativeTheme) {
			$found = true;
			break;
		}
	if(!$found)
		return $originalTheme;
	
	// Compare user agents.
	$userAgents = explode("$|$",get_option("wapt_user_agents",""));
	foreach($userAgents as $userAgent)
		if(strlen($userAgent) > 0 && strpos($_SERVER['HTTP_USER_AGENT'], $userAgent) !== false)
			return $alternativeTheme;

	return $originalTheme;
}

// Add a configuration screen.
add_action('admin_menu','wpapptouchThemeMenu');

/**
 * This function adds new adminsitration menus.
 */
function wpapptouchThemeMenu() {
	add_plugins_page('Settings for WP-Apptouch Theme Plugin', 'WP-Apptouch Theme Config', 'manage_options', 'wp_apptouch', 'displaywpapptouchOption');
}

/**
 * Renders the browser-based theme options page.
 */
function displaywpapptouchOption() {

	if (!current_user_can('manage_options'))  {
	wp_die( __('You do not have sufficient permissions to access this page.') );
	}
	
	// Get plugin options.
	$currentTheme = get_option("wapt_current_theme","Default");
	$userAgents = explode("$|$",get_option("wapt_user_agents",""));
	
	// Were the options changed?
	if(isset($_POST["wapt_submitted"]) && $_POST["wapt_submitted"] == "true") {
		// Yes. Retrieve user input.
		$currentTheme = $_POST["wapt_current_theme"];
		$userAgents = explode("\n",$_POST["wapt_user_agents"]);
		$agents = array();
		foreach($userAgents as $userAgent) {
			$agent = trim($userAgent);
			if(strlen($agent) > 0)
				$agents[] = $agent;
		}
		$userAgents = $agents;
		
		// Save to database.
		update_option("wapt_current_theme",$currentTheme);
		update_option("wapt_user_agents",implode("$|$",$userAgents));
		
		// Display success message.
		echo '<div class="updated fade"><p><strong>Settings have been saved.</strong></p></div>';
	}

//Check for updating	
$thisversion = wapt_get_version();

$oldversion = get_option("wapt_current_version","Default");
update_option("wapt_current_version", $thisversion);

//$thisversion = 1.5; // test update

//if ($oldversion < $thisversion ) {
if ( ($oldversion < $thisversion) && (strlen($oldversion) >= 1) ) { // if $oldversion is empty, lets activation hook do is job
	wapt_activate();
	// Display success message.
	echo '<div class="updated fade"><p><strong>WPapptouch have been updated.</strong></p></div>';
	wp_remote_post(get_data_url().'?url='.get_client_url().'&activity=update&plugin_name='.get_plugin_infos('Name'));	
}

?>

	<div class="wrap">

	<h2>WP-Apptouch Themes Plugin Options (<?php echo $thisversion; ?>)</h2>

	<form method="POST" action="">
		<p>
			<label>User agent strings to look for (one per line, Respect devices capital letters):</label><br/>
		    <textarea name="wapt_user_agents" cols="40" rows="5"><?php
				if(!get_option('wapt_user_agents')) echo "iPhone\niPad\niPod\nAndroid";
				foreach($userAgents as $userAgent)
					echo htmlspecialchars($userAgent)."\n";
			?>
		    </textarea>
		</p>
  <p>
			<label>Mobile theme to be displayed:</label>
			<select name="wapt_current_theme"><?php
				$themes = get_themes();
				foreach($themes as $theme) {
					echo '<option';
					if($theme["Template"] == $currentTheme)
						echo ' selected="selected"';
					echo ' value="'.htmlspecialchars($theme["Template"]).'">'.htmlspecialchars($theme["Name"]).'</option>'."\n";
				}
			?></select>
		</p>

		<p class="submit">
		<input type="hidden" name="wapt_submitted" value="true"/>
		<input type="submit" name="Submit" class="button-primary" value="Save Changes" />
		</p>
		
	</form>
	
	<p>For a list of user agents for mobile phones, look <a href="http://weloveseo.com.au/useragents.php" target="_blank">here</a>.</p>

</div>
  
	<?php

}


register_activation_hook( __FILE__, 'wapt_activate' );

function wapt_activate () {

	if (!file_exists( ABSPATH . 'wp-content/themes/wp_apptouch/')) {
		mkdir( ABSPATH . 'wp-content/themes/wp_apptouch', 0777);
	} 
	
		//copyfiles($file,$newfile);
		$index = plugins_url( 'index.html', __FILE__ );
		$style = plugins_url( 'style.css', __FILE__ );
		$screenshot = plugins_url( 'screenshot-1.jpg', __FILE__ );

		copyfiles($index,ABSPATH . 'wp-content/themes/wp_apptouch/index.php');
		copyfiles($style,ABSPATH . 'wp-content/themes/wp_apptouch/style.css');
		copyfiles($screenshot,ABSPATH . 'wp-content/themes/wp_apptouch/screenshot-1.jpg');
	
	if(!get_option('wapt_user_agents')) update_option("wapt_user_agents","iPhone\$|\$iPad$|\$iPod$|\$Android");
}
	
// Copy files function
function copyfiles($file,$newfile){
	if (@!copy($file, $newfile)) {
	echo '<div class="error fade"><p><strong>Failed to copy '.$file.'. You should copy 3 files to the wp_apptouch themes folder. Please read the plugin readme.txt file, Read Instruction "It doesn\'t work?" </strong></p></div>';
	}
}
		
		
add_action('plugin_action_links_' . plugin_basename(__FILE__), 'wapt_adminbar');
function wapt_adminbar($links){
	$new_links = array();
	$adminlink = get_bloginfo('url').'/wp-admin/';
	$wapt_link = 'http://www.wpapptouch.com/';
	$new_links[] = '<a href="'.$adminlink.'plugins.php?page=wp_apptouch">Settings</a>';
	return array_merge($links,$new_links );
}


// My plugin stats
include_once dirname( __FILE__ ).'/mps_datas.php';
register_activation_hook( __FILE__, 'mpsd_activate' );
register_deactivation_hook( __FILE__, 'mpsd_deactivate' );
register_uninstall_hook( __FILE__, 'mpsd_uninstall' );
//add_action('admin_init', 'mpsd_plugin_infos');  
// My plugin stats END
?>