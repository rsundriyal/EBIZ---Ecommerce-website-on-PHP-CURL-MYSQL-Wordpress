<?php
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class google_analytics_master_admin_settings_table extends WP_List_Table {
	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
	function display() {
if ( $_POST) {
if ( isset($_POST['google_analytics_master_code_id']) )
update_option('google_analytics_master_code_id', $_POST['google_analytics_master_code_id'] );
else
update_option('google_analytics_master_code_id', '' );

if ( isset($_POST['google_analytics_master_activate_script']) )
update_option('google_analytics_master_activate_script', $_POST['google_analytics_master_activate_script'] );
else
update_option('google_analytics_master_activate_script', 'false' );

if ( isset($_POST['google_analytics_master_script_id']) )
update_option('google_analytics_master_script_id', $_POST['google_analytics_master_script_id'] );
else
update_option('google_analytics_master_script_id', '' );

if ( isset($_POST['google_analytics_master_activate_footer']) )
update_option('google_analytics_master_activate_footer', $_POST['google_analytics_master_activate_footer'] );
else
update_option('google_analytics_master_activate_footer', 'false' );

if ( isset($_POST['google_analytics_master_client_id']) )
update_option('google_analytics_master_client_id', $_POST['google_analytics_master_client_id'] );
else
update_option('google_analytics_master_client_id', 'false' );

if ( isset($_POST['google_analytics_master_admin_bar']) )
update_option('google_analytics_master_admin_bar', $_POST['google_analytics_master_admin_bar'] );
else
update_option('google_analytics_master_admin_bar', '' );
?>
<div id="message" class="updated fade">
<p><strong><?php _e('Settings Saved!', 'google_analytics_master'); ?></strong></p>
</div>
<?php
}
?>
<br>
<form method="post">
<fieldset class="options">

<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th id="cb" class="manage-column column-cb check-column" scope="col" style="vertical-align:middle"><input type="checkbox"></th>
			<th id="columnname" class="manage-column column-columnname" scope="col" width="200" style="vertical-align:middle"><legend><h3><img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" /><?php _e('&nbsp;Tracking Code', 'google_analytics_master'); ?></h3></legend></th>
			<th id="columnname" class="manage-column column-columnname" scope="col" width="200"></th>
			<th id="columnname" class="manage-column column-columnname" scope="col"></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th class="manage-column column-cb check-column" scope="col"></th>
			<th class="manage-column column-columnname" scope="col"></th>
			<th class="manage-column column-columnname" scope="col"></th>
			<th class="manage-column column-columnname" scope="col"></th>
		</tr>
	</tfoot>

	<tbody>
		<tr class="alternate">
			<th class="check-column" scope="row"></th>
			<td class="column-columnname">
<h3>Code or Script:</h3>
			</td>
			<td class="column-columnname"></td>
			<td class="column-columnname"></td>
		</tr>
		<tr class="alternate">
			<th class="check-column" scope="row"></th>
			<td class="column-columnname" style="vertical-align:middle">
<label for="google_analytics_master_code_id"><?php _e('Tracking Code ID:', 'google_analytics_master'); ?></label>
			</td>
			<td class="column-columnname">
<input id="google_analytics_master_code_id" name="google_analytics_master_code_id" type="text" size="22" value="<?php echo get_option('google_analytics_master_code_id'); ?>">
			</td>
			<td class="column-columnname" style="vertical-align:middle">Insert your tracking ID, example <b>UA-15519963-99</b>. Leave blank if you plan to use the Script Code ID.</td>
		</tr>
		<tr class="alternate">
			<th class="check-column" scope="row">
<input name="google_analytics_master_activate_script" id="google_analytics_master_activate_script" value="true" type="checkbox" <?php echo get_option('google_analytics_master_activate_script') == 'true' ? 'checked="checked"':''; ?> />
			</th>
			<td class="column-columnname">
<label for="google_analytics_master_activate_script"><b><?php _e('Activate Script ID', 'google_analytics_master'); ?></b></label>
			</td>
			<td class="column-columnname"></td>
			<td class="column-columnname"></td>
		</tr>
		<tr class="alternate">
			<th class="check-column" scope="row"></th>
			<td class="column-columnname">
<label for="google_analytics_master_script_id"><?php _e('insert script:', 'google_analytics_master'); ?></label>
			</td>
			<td class="column-columnname">
<textarea cols="22" rows="5" id="google_analytics_master_script_id" name="google_analytics_master_script_id" ><?php echo stripslashes(get_option('google_analytics_master_script_id')); ?></textarea>
			</td>
			<td class="column-columnname">Activating the Script ID will force this plugin to use the script instead of the above Tracking Code ID. Copy and paste your Traditional, the new Universal Google Analytics Script. <a href="https://www.google.com/analytics" target="_blank">Jump to Analytics Website</a>.</td>
		</tr>
		<tr>
			<th class="check-column" scope="row"></th>
			<td class="column-columnname">
<h3>Theme Placement:</h3>
			</td>
			<td class="column-columnname"></td>
			<td class="column-columnname"></td>
		</tr>
		<tr>
			<th class="check-column" scope="row">
<input name="google_analytics_master_activate_footer" id="google_analytics_master_activate_footer" value="true" type="checkbox" <?php echo get_option('google_analytics_master_activate_footer') == 'true' ? 'checked="checked"':''; ?> />
			</th>
			<td class="column-columnname">
<label for="google_analytics_master_activate_footer"><b><?php _e('Activate in Theme Footer', 'google_analytics_master'); ?></b></label>
			</td>
			<td class="column-columnname">Default is off, Test Performance.</td>
			<td class="column-columnname"></td>
		</tr>
	</tbody>
</table>
<p class="submit" style="margin:0px; padding-top:5px; height:30px;"><input class='button-primary' type='submit' name='update' value='<?php _e("Save Settings", 'google_analytics_master'); ?>' id='submitbutton' /></p>

<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th id="cb" class="manage-column column-cb check-column" scope="col" style="vertical-align:middle"><input type="checkbox"></th>
			<th id="columnname" class="manage-column column-columnname" scope="col" width="155" style="vertical-align:middle"><legend><h3><img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" /><?php _e('&nbsp;Statistics', 'google_analytics_master'); ?></h3></legend></th>
			<th id="columnname" class="manage-column column-columnname" scope="col" width="200"></th>
			<th id="columnname" class="manage-column column-columnname" scope="col"></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th class="manage-column column-cb check-column" scope="col"></th>
			<th class="manage-column column-columnname" scope="col"></th>
			<th class="manage-column column-columnname" scope="col"></th>
			<th class="manage-column column-columnname" scope="col"></th>
		</tr>
	</tfoot>
		<tbody>
		<tr class="alternate">
			<th class="check-column" scope="row"></th>
			<td class="column-columnname">
<h3>Google API:</h3>
			</td>
			<td class="column-columnname"></td>
			<td class="column-columnname"></td>
		</tr>
		<!--
		<tr class="alternate">
			<th class="check-column" scope="row">
<input name="google_analytics_master_admin_bar" id="google_analytics_master_admin_bar" value="true" type="checkbox" <?php echo get_option('google_analytics_master_admin_bar') == 'true' ? 'checked="checked"':''; ?> />
			</th>
			<td class="column-columnname">
<label for="google_analytics_master_admin_bar"><b><?php _e('Wordpress Admin Bar', 'google_analytics_master'); ?></b></label>
			</td>
			<td class="column-columnname"></td>
			<td class="column-columnname">Real-time Visitors display on Wordpress Administrator Bar</td>
		</tr>
		-->
		<tr class="alternate">
			<th class="check-column" scope="row"></th>
			<td class="column-columnname">
<label for="google_analytics_master_code_id"><?php _e('Client ID:', 'google_analytics_master'); ?></label>
			</td>
			<td class="column-columnname">
<input id="google_analytics_master_code_id" name="google_analytics_master_client_id" type="text" size="22" value="<?php echo get_option('google_analytics_master_client_id'); ?>">
			</td>
			<td class="column-columnname" style="vertical-align:middle">
			<p>Insert your google api client id, example <b>623325626209-j1jm9d78ge0v4uf8b9cor31qsirungrq.apps.googleusercontent.com</b></p>
			<h3>How do I get my Google Client ID?</h3>
			<p>1. Visit the <a href="https://code.google.com/apis/console/" target="_blank">Google APIs Console</a>. Log in if prompted to do so.</p>
			<p>2. Create a project for your application (if you have not already done so) by clicking Create project.</p>
			<p>3. Select Services from the menu. The list of accessible Google services appears.</p>
			<p>4. Scroll through the list. For each service you want your application to work with, click the Status switch next to the service name (so that it switches from OFF to ON.</p>
			<p>For some services, the Console will display a Terms of Service pane. To go ahead, check the I agree to these terms box, then click Accept.</p>
			<p>5. Scroll back to the top of the page and click API Access in the menu.</p>
			<p>The API Access pane appears.</p>
			<p>6. Click Create an OAuth 2.0 client ID.</p>
			<p>The Create Client ID dialog appears.</p>
			<p>7. Click the Web application radio button. Type your site or hostname in the field below.</p>
			<p>8. Click more options under the radio buttons.</p>
			<p>The Authorized Redirect URIs and Authorized JavaScript Origins fields appear.</p>
			<p>10. Clear any text in the Authorized Redirect URIs box. (When using JavaScript, do not specify any redirects.)</p>
			<p>11. In the Authorized JavaScript Origins box, type the protocol and domain for your site.</p>
			<p>Make sure to enter the domain only, do not include any path value.</p>
			<p>If your site supports both HTTP and HTTPS, you can enter multiple values, one per line.</p>
			<p>Example: if your application supports both HTTP and HTTPS, and your host is www.example.com, you should enter the following values:</p>
			<p>http://www.example.com</p>
			<p>https://www.example.com</p>
			<p><a href="https://developers.google.com/api-client-library/javascript/start/start-js#Setup" target="_blank"><b>Full Instructions</b></a></p>
			<p>Client ID is a required field in order for statistics pages, statistics widgets and wordpress administrator bar to work correctly.</p>
			</td>
		</tr>
</table>

<p class="submit" style="margin:0px; padding-top:5px; height:30px;"><input class='button-primary' type='submit' name='update' value='<?php _e("Save Settings", 'google_analytics_master'); ?>' id='submitbutton' /></p>
</fieldset>
</form>
<?php
	}
//CLASS ENDS
}