<div class="sip-credit-affiliate-link-warp">
	<h2>Be awesome</h2>
  <p>Do you like this plugin? Would you like to see even more great features? Please be awesome and help us maintain and develop free plugins by checking the option below</p>
	<form method="post" action="options.php">
	  <?php settings_fields( 'sip-ccwc-affiliate-settings-group' ); ?>
	  <?php $options = get_option('sip-ccwc-affiliate-radio'); ?>
			<label><input id="sip-ccwc-affiliate-checkbox" type="checkbox" name="sip-ccwc-affiliate-check-box" value="true" <?php echo esc_attr( get_option('sip-ccwc-affiliate-check-box', false))?' checked="checked"':''; ?> /> I want to help development of this plugin</label><br />
			<div id="sip-ccwc-diplay-affiliate-toggle">

				<label><input id="sip-ccwc-discreet-credit" type="radio" name="sip-ccwc-affiliate-radio[option_three]" value="value1"<?php checked( 'value1' == $options['option_three'] ); ?> checked/> Add a credit</label><br >
				<label><input id="sip-ccwc-affiliate-link" 	type="radio" name="sip-ccwc-affiliate-radio[option_three]" value="value2"<?php checked( 'value2' == $options['option_three'] ); ?> /> Add my affiliate link</label><br />
				<div id="sip-ccwc-affiliate-link-box">
					<label><input type="text" name="sip-ccwc-affiliate-affiliate-username" value="<?php echo esc_attr( get_option('sip-ccwc-affiliate-affiliate-username')) ?>" /> Input affiliate username/ID</label><br />			
				</div>
				<p class="sip-text">Make money recommending our plugins. Register for an affiliate account at <a href="https://shopitpress.com/?affiliate-area/utm_source=wordpress.org&amp;utm_medium=affiliate&amp;utm_campaign=sip-cookie-check-woocommerce" target="_blank">Shopitpress</a>.</p>
				
			</div>	
		<?php submit_button(); ?>
	</form>
</div>
<script type="text/javascript">
	jQuery(document).ready(function(){

		jQuery("#sip-ccwc-diplay-affiliate-toggle").hide();
		jQuery("#sip-ccwc-affiliate-link-box").hide();

		if (jQuery('#sip-ccwc-affiliate-checkbox').is(":checked"))
		{
		  jQuery("#sip-ccwc-diplay-affiliate-toggle").show('slow');
		}

		jQuery('#sip-ccwc-affiliate-checkbox').click(function() {
		  jQuery('#sip-ccwc-diplay-affiliate-toggle').toggle('slow');
		})

		if (jQuery('#sip-ccwc-affiliate-link').is(":checked"))
		{
		  jQuery("#sip-ccwc-affiliate-link-box").show('slow');
		}

		jQuery('#sip-ccwc-affiliate-link').click(function() {
		  jQuery('#sip-ccwc-affiliate-link-box').show('slow');
		})

		jQuery('#sip-ccwc-discreet-credit').click(function() {
		  jQuery('#sip-ccwc-affiliate-link-box').hide('slow');
		})

	});
</script>