<?php
if(!class_exists('WP_List_Table')){
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class google_analytics_master_admin_updater_version_table extends WP_List_Table {
	/**
	 * Display the rows of records in the table
	 * @return string, echo the markup of the rows
	 */
function display() {
global $google_analytics_plugin_slug;
?>
<table class="widefat fixed" cellspacing="0">
	<thead>
		<tr>
			<th id="columnname" class="manage-column column-columnname" scope="col" width="350"><legend><h3><img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" /><?php _e('&nbsp;Plugin', 'google_analytics_master'); ?></h3></legend></th>
			<th id="columnname" class="manage-column column-columnname" scope="col"><legend><h3><img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" /><?php _e('&nbsp;Installed Version', 'google_analytics_master'); ?></h3></legend></th>
			<th id="columnname" class="manage-column column-columnname" scope="col"><legend><h3><img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" /><?php _e('&nbsp;Newest Version', 'google_analytics_master'); ?></h3></legend></th>
			<th id="columnname" class="manage-column column-columnname" scope="col"><legend><h3><img src="<?php echo plugins_url('../images/techgasp-minilogo-16.png', __FILE__); ?>" style="float:left; height:16px; vertical-align:middle;" /><?php _e('&nbsp;Up-to-date', 'google_analytics_master'); ?></h3></legend></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th class="manage-column column-columnname" scope="col" width="350"></th>
			<th class="manage-column column-columnname" scope="col">
			</th>
			<th class="manage-column column-columnname" scope="col"></th>
			<th class="manage-column column-columnname" scope="col">
			<?php
if(get_site_option( 'google_analytics_master_installed_version')  == get_site_option( 'google_analytics_master_newest_version' )){
	echo '</td>';
}
else{
$google_analytics_plugin_slug = 'google-analytics-master/google-analytics-master.php';
	echo '<a class="button-primary" href="'.wp_nonce_url( self_admin_url('update.php?action=upgrade-plugin&plugin=') . $google_analytics_plugin_slug, 'upgrade-plugin_' . $google_analytics_plugin_slug) .'" title="Update">Update</a></td>';
}
?>
			</th>
		</tr>
	</tfoot>

	<tbody>
		<tr class="alternate">
			<td class="column-columnname" width="350" style="vertical-align:middle"><h2><b>
<?php
if( is_multisite() ) {
echo get_site_option( 'google_analytics_master_name' );
}
else{
echo get_option( 'google_analytics_master_name' );
}
?>
			</b></h2></td>
			<td class="column-columnname" style="vertical-align:middle">
<?php
if( is_multisite() ) {
echo '<h3>Version '.get_site_option( 'google_analytics_master_installed_version' ).'</h3>';
}
else{
echo '<h3>Version '.get_option( 'google_analytics_master_installed_version' ).'</h3>';
}
?>
		</td>
			<td class="column-columnname" style="vertical-align:middle">
<?php
if( is_multisite() ) {
echo '<h3>Version '.get_site_option('google_analytics_master_newest_version').'</h3>';
}
else{
echo '<h3>Version '.get_option('google_analytics_master_newest_version').'</h3>';
}
?>
			</td>
			<td class="column-columnname" style="vertical-align:middle">
<?php

if(get_site_option( 'google_analytics_master_installed_version')  == get_site_option( 'google_analytics_master_newest_version' )){
	echo '<img src="'.plugins_url('../images/techgasp-check-yes.png', __FILE__).'" alt="'.get_option('google_analytics_master_name').'" width="90px" style="vertical-align:bottom" /></td>';
}
else{
	echo '<img src="'.plugins_url('../images/techgasp-check-no.png', __FILE__).'" alt="'.get_option('google_analytics_master_name').'" width="90px" style="vertical-align:bottom" /></td>';
}
?>
		</tr>
	</tbody>
</table>
<?php
	}
}