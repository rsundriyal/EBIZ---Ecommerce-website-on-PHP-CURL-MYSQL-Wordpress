<?php
function google_analytics_master_active(){
//Prepare Usable Options
if ( get_option('google_analytics_master_activate_script') == 'true' ){
$google_analytics_master_active_create = stripslashes(get_option('google_analytics_master_script_id'));
}
else{
$google_analytics_spacer = "'";
$domain = get_option('home');
$look_for= array( 'http://', 'https://', 'www.' );
$replace_crap = '';
$domain = str_replace( $look_for, $replace_crap, $domain );
$google_analytics_master_active_create =
'<script>'.
'(function(i,s,o,g,r,a,m){i['.$google_analytics_spacer.'GoogleAnalyticsObject'.$google_analytics_spacer.']=r;i[r]=i[r]||function(){'.
'(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),'.
'm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)'.
'})(window,document,'.$google_analytics_spacer.'script'.$google_analytics_spacer.','.$google_analytics_spacer.'//www.google-analytics.com/analytics.js'.$google_analytics_spacer.','.$google_analytics_spacer.'ga'.$google_analytics_spacer.');'.
'ga('.$google_analytics_spacer.'create'.$google_analytics_spacer.', '.$google_analytics_spacer.''.get_option('google_analytics_master_code_id').''.$google_analytics_spacer.', '.$google_analytics_spacer.''.$domain.''.$google_analytics_spacer.');'.
'ga('.$google_analytics_spacer.'send'.$google_analytics_spacer.', '.$google_analytics_spacer.'pageview'.$google_analytics_spacer.');'.
'</script>';
}

echo $google_analytics_master_active_create;
}
//Prepare Location
if ( get_option('google_analytics_master_activate_footer') == 'true' ){
add_action('wp_footer', 'google_analytics_master_active');
}
else{
add_action('wp_head', 'google_analytics_master_active');
}
?>