<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Unsubscribe page shortcode template
 *
 * @package Yithemes
 * @since 1.0.0
 * @author Your Inspiration Themes
 */

wc_print_notices();

if( isset( $_GET[ 'email' ] )) {
    ?>
    <p><?php printf( __( 'If you don\'t want to receive any more review reminders, please retype your email address: %s', 'yith-woocommerce-review-reminder' ), '<b>' . urldecode( base64_decode( $_GET[ 'email' ] ) ) . '</b>' ) ?></p>
    <form method="post" action="">
        <p class="form-row form-row-wide">
            <label for="account_email"><?php _e( 'Email address', 'yith-woocommerce-review-reminder' ); ?> <span class="required">*</span></label>
            <input type="email" class="input-text" name="account_email" id="account_email"/>
        </p>
        <p>
            <?php wp_nonce_field( 'unsubscribe_review_request' ); ?>
            <input type="submit" class="button" name="unsubscribe_review_request" value="<?php _e( 'Unsubscribe', 'yith-woocommerce-review-reminder' ); ?>"/>
            <input type="hidden" name="account_id" value="<?php echo urldecode( base64_decode( $_GET[ 'id' ] ) ); ?>"/>
            <input type="hidden" name="action" value="unsubscribe_review_request"/>
        </p>
    </form>
<?php
} else {
    ?>
    <p class="return-to-shop"><a class="button wc-backward" href="<?php echo get_home_url(); ?>"><?php _e( 'Return To Home Page', 'yith-woocommerce-review-reminder' ) ?></a></p>
<?php
}