<?php 

$src_image = SIP_CCWC_URL . 'admin/assets/images/';
$extensions = array(
    '1' => (object) array(
        'image_url' => $src_image . 'icon-wpgumby.png',
        'url'       => SIP_WPGUMBY_THEME_URL . '?utm_source=wordpress.org&utm_medium=SIP-panel&utm_content=v'. SIP_CCWC_PLUGIN_VERSION .'&utm_campaign=' .SIP_CCWC_UTM_CAMPAIGN,
        'title'     => SIP_WPGUMBY_THEME,
        'desc'      => __( 'Flat and responsive WooCommerce theme.<br>', 'sip-cookie-check' ),
    ),
	);
?>


<div id="sip-wraper">
	<?php 
  $i = 0;
  foreach ( (array) $extensions as $i => $extension ) {
    // Attempt to get the plugin basename if it is installed or active.
    $image_url   = $extension->image_url ;
    $url 		 = $extension->url ;
    $title		 = $extension->title ;
    $description = $extension->desc ; 
		?>
		<div class="sip-addon">
      <h1><?php echo $title ?></h1>
      <p><?php echo $description ?></p>
			<img class="sip-addon-thumb" src="<?php echo $image_url; ?>" width="300px" height="250px" alt="<?php echo $title; ?>">
			<div class="sip-addon-action">
				<a class="active-addon sip button button-primary " title="<?php echo $title; ?>" href="<?php echo $url; ?>" target="_blank">Learn more</a>
			</div>
		</div> <!-- .sip-addon -->
	<?php $i++; 
	} 
	?>
	<div class="sip-version">
	  <?php $get_optio_version = get_option( 'sip_version_value' ); echo "SIP Version " . $get_optio_version; ?>
	</div>
</div><!-- .shopitpress -->