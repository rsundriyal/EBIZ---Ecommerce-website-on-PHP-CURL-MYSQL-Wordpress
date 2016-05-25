<?php 

$src_image = SIP_CCWC_URL . 'admin/assets/images/';
$extensions = array(
  	'1' => (object) array(
      	'image_url' => $src_image . 'icon-social-proof.png',
      	'url'       => SIP_SPWC_PLUGIN_URL . '?utm_source=wordpress.org&utm_medium=SIP-panel&utm_content=v'. SIP_CCWC_PLUGIN_VERSION .'&utm_campaign=' .SIP_CCWC_UTM_CAMPAIGN,
      	'title'     => SIP_SPWC_PLUGIN,
      	'desc'      => __( 'Display real time proof of your sales and customers.<br>', 'sip-cookie-check' ),
  	),
  	'2' => (object) array(
      	'image_url' => $src_image . 'icon-front-end-bundler.png',
      	'url'       => SIP_FEBWC_PLUGIN_URL . '?utm_source=wordpress.org&utm_medium=SIP-panel&utm_content=v'. SIP_CCWC_PLUGIN_VERSION .'&utm_campaign=' .SIP_CCWC_UTM_CAMPAIGN,
      	'title'     => SIP_FEBWC_PLUGIN,
      	'desc'      => __( 'Bundle maker with real time offers.<br><br>', 'sip-cookie-check' ),
  	),
  	'3' => (object) array(
      	'image_url' => $src_image . 'icon-reviews-shortcode.png',
      	'url'       => SIP_RSWC_PLUGIN_URL . '?utm_source=wordpress.org&utm_medium=SIP-panel&utm_content=v'. SIP_CCWC_PLUGIN_VERSION .'&utm_campaign=' .SIP_CCWC_UTM_CAMPAIGN,
      	'title'     => SIP_RSWC_PLUGIN,
      	'desc'      => __( 'Display product reviews in any post/page with a shortcode.', 'sip-cookie-check' ),
  ),
  	'4' => (object) array(
		'image_url' => $src_image . 'icon-advanced-email.png',
		'url'       => SIP_AENWC_PLUGIN_URL . '?utm_source=wordpress.org&utm_medium=SIP-panel&utm_content=v'. SIP_CCWC_PLUGIN_VERSION .'&utm_campaign=' .SIP_CCWC_UTM_CAMPAIGN,
		'title'     => SIP_AENWC_PLUGIN,
		'desc'      => __( 'Powerful email automation.', 'sip-social-proof' ),
	),
    '5' => (object) array(
      'image_url' => $src_image . 'icon-cookie-check.png',
      'url'       => SIP_CCWC_PLUGIN_URL . '?utm_source=wordpress.org&utm_medium=SIP-panel&utm_content=v'. SIP_CCWC_PLUGIN_VERSION .'&utm_campaign=' .SIP_CCWC_UTM_CAMPAIGN,
      'title'     => SIP_CCWC_PLUGIN,
      'desc'      => __( 'Encourage visitors to enable cookies so you don’t lose sales.', 'sip-social-proof' ),
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