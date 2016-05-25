<?php
/**
 * Subscription checkbox template
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Mailchimp
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCMC' ) ) {
	exit;
} // Exit if accessed directly

?>

<label>
	<input type="checkbox" name="yith_wcmc_subscribe_me" id="yith_wcmc_subscribe_me" value="yes" <?php checked( $checkbox_checked ) ?>/>
	<?php echo esc_html( $checkbox_label )?>
</label>