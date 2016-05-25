<div class="sip-tab-content">
	<form method="post" action="options.php">
    <?php settings_fields( 'sip-ccwc-settings-group' ); ?>
    <table class="form-table">
      <tr valign="top">
        <td><label><input type="checkbox" id="sip-ccwc-display-text-editor-checkbox" name="display_sip_ccwc_message" value="true" <?php echo esc_attr( get_option('display_sip_ccwc_message', false))?' checked="checked"':''; ?> /> Enable in WooCommerce pages</label></td>
      </tr>
			<tr valign="top">
        <td><label><input type="checkbox" name="sip_ccwc_css_enable_desable" value="true" <?php echo esc_attr( get_option('sip_ccwc_css_enable_desable', false))?' checked="checked"':''; ?> /> Disable styling (CSS)</label></td>
      </tr>
      <tr valign="top">
        <td><label><input type="checkbox" id="sip-ccwc-customise-message-checkbox" name="sip_ccwc_customise_message_checkbox" value="true" <?php echo esc_attr( get_option('sip_ccwc_customise_message_checkbox', false))?' checked="checked"':''; ?> /> Customise message</label></td>
      </tr>
      <tr>
        <td>
          <div id="sip-ccwc-display-text-editor">
            <?php
              if( ( get_option('sip_ccwc_message_editor') == "" ) || ( get_option('sip_ccwc_customise_message_checkbox', false) == false) ){
                $editor_content = '<strong>Cookies are disabled in your browser, you need to enable cookies to make purchases in this store</strong> - Please enable cookies. Learn how to do it by <a href="https://shopitpress.com/enable-cookies/" target="_blank">clicking here</a>. ';
                update_option( 'sip_ccwc_message_editor', $editor_content );
              }

              $settings       = array('teeny' => false, 'tinymce' => true, 'textarea_rows' => 12, 'tabindex' => 1 );
              $editor_id      = "sip_ccwc_message_editor";
              $editor_content = get_option('sip_ccwc_message_editor');
              wp_editor( $editor_content, $editor_id, $settings );
            ?>
          </div>
        </td>
      </tr>
    </table>
    <?php submit_button(); ?>
	</form>
</div>

<script type="text/javascript">
  jQuery(document).ready(function(){

    jQuery("#sip-ccwc-display-text-editor").hide();

    if (jQuery('#sip-ccwc-customise-message-checkbox').is(":checked"))
    {
      jQuery("#sip-ccwc-display-text-editor").show('slow');
    }

    jQuery('#sip-ccwc-customise-message-checkbox').click(function() {
      jQuery('#sip-ccwc-display-text-editor').toggle('slow');
    })

  });
</script>
