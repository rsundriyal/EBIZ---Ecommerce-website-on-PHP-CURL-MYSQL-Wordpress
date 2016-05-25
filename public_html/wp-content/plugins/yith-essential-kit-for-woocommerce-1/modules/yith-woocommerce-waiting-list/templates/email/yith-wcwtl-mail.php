<?php
/**
 * YITH WooCommerce Waiting List Mail Template
 *
 * @author Yithemes
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCWTL' ) ) exit; // Exit if accessed directly

do_action('woocommerce_email_header', $email_heading );
?>

<p>
	<?php _ex( "Hi There,", 'Email salutation', 'yith-woocommerce-waiting-list' ); ?>
</p>

<p>
	<?php
	echo sprintf( __( '%1$s is now back in stock at %2$s.', 'yith-woocommerce-waiting-list' ), $product_title, get_bloginfo( 'name' ) ) . " ";
	_e( 'You have been sent this email because your email address was registered on a waiting list for this product.', 'yith-woocommerce-waiting-list' );
	?>
</p>
<p>
	<?php echo sprintf( __( 'If you would like to purchase %s, please visit the following <a href="%s">link</a>', 'yith-woocommerce-waiting-list' ), $product_title, $product_link );?>
</p>

<?php do_action('woocommerce_email_footer'); ?>