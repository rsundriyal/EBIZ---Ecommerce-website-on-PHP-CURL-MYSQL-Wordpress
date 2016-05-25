<?php
/**
 * Form to Request a quote
 *
 * @package YITH Woocommerce Request A Quote
 * @since   1.0.0
 * @version 1.0.0
 * @author  Yithemes
 */
$current_user = array();
if ( is_user_logged_in() ) {
    $current_user = get_user_by( 'id', get_current_user_id() );
}

$user_name = ( ! empty( $current_user ) ) ?  $current_user->display_name : '';
$user_email = ( ! empty( $current_user ) ) ?  $current_user->user_email : '';
?>
<div class="yith-ywraq-mail-form-wrapper">
    <h3><?php _e( 'Send the request', 'yith-woocommerce-request-a-quote' ) ?></h3>

    <form id="yith-ywraq-mail-form" name="yith-ywraq-mail-form" action="<?php echo esc_url( YITH_Request_Quote()->get_raq_page_url() ) ?>" method="post">

            <p class="form-row form-row-wide validate-required" id="rqa_name_row">
                <label for="rqa-name" class=""><?php _e( 'Name', 'yith-woocommerce-request-a-quote' ) ?>
                    <abbr class="required" title="required">*</abbr></label>
                <input type="text" class="input-text " name="rqa_name" id="rqa-name" placeholder="" value="<?php echo $user_name ?>" required>
            </p>

            <p class="form-row form-row-wide validate-required" id="rqa_email_row">
                <label for="rqa-email" class=""><?php _e( 'Email', 'yith-woocommerce-request-a-quote' ) ?>
                    <abbr class="required" title="required">*</abbr></label>
                <input type="email" class="input-text " name="rqa_email" id="rqa-email" placeholder="" value="<?php echo $user_email ?>" required>
            </p>

        <p class="form-row" id="rqa_message_row">
            <label for="rqa-message" class=""><?php _e( 'Message', 'yith-woocommerce-request-a-quote' ) ?></label>
            <textarea name="rqa_message" class="input-text " id="rqa-message" placeholder="<?php _e( 'Notes on your request...', 'yith-woocommerce-request-a-quote' ) ?>" rows="5" cols="5"></textarea>
        </p>

        <p class="form-row">
            <input type="hidden" id="raq-mail-wpnonce" name="raq_mail_wpnonce" value="<?php echo wp_create_nonce( 'send-request-quote' ) ?>">
            <input class="button raq-send-request" type="submit" value="<?php _e( 'Send Your Request', 'yith-woocommerce-request-a-quote' ) ?>">
        </p>

    </form>
</div>