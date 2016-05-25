<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Implements Request Mail for YWRR plugin (HTML)
 *
 * @class   YWRR_Request_Mail
 * @package Yithemes
 * @since   1.0.0
 * @author  Your Inspiration Themes
 */

if ( !$order ) {

    $current_user = wp_get_current_user();

    $billing_email      = $current_user->user_email;
    $order_date         = current_time( 'mysql' );
    $modified_date      = current_time( 'mysql' );
    $order_id           = '0';
    $customer_id        = $current_user->ID;
    $billing_first_name = $current_user->user_login;

}
else {

    $billing_email      = $order->billing_email;
    $order_date         = $order->order_date;
    $modified_date      = $order->modified_date;
    $order_id           = $order->id;
    $customer_id        = $order->__get( 'user_id' );
    $billing_first_name = $order->billing_first_name;

}

$query_args       = array(
    'id'    => urlencode( base64_encode( !empty( $customer_id ) ? $customer_id : 0 ) ),
    'email' => urlencode( base64_encode( $billing_email ) )
);
$unsubscribe      = esc_url( add_query_arg( $query_args, get_permalink( get_option( 'ywrr_unsubscribe_page_id' ) ) ) );
$unsubscribe_link = ( array_key_exists( $template, YITH_WRR()->_email_templates ) || defined( 'YITH_WCET_PREMIUM' ) && get_option( 'ywrr_mail_template_enable' ) == 'yes' ) ? '' : '<a href="' . $unsubscribe . '">' . get_option( 'ywrr_mail_unsubscribe_text' ) . '</a>';

$review_list = YITH_WRR()->ywrr_email_items_list( $item_list, $template );

$find = array(
    '{customer_name}',
    '{customer_email}',
    '{site_title}',
    '{order_id}',
    '{order_date}',
    '{order_date_completed}',
    '{order_list}',
    '{days_ago}',
    '{unsubscribe_link}'
);

$replace = array(
    '<b>' . $billing_first_name . '</b>',
    '<b>' . $billing_email . '</b>',
    '<b>' . get_option( 'blogname' ) . '</b>',
    '<b>' . $order_id . '</b>',
    '<b>' . $order_date . '</b>',
    '<b>' . $modified_date . '</b>',
    $review_list,
    '<b>' . $days_ago . '</b>',
    $unsubscribe_link
);

$lang      = get_post_meta( $order_id, 'wpml_language', true );
$mail_body = str_replace( $find, $replace, apply_filters( 'wpml_translate_single_string', get_option( 'ywrr_mail_body' ), 'admin_texts_ywrr_mail_body', 'ywrr_mail_body', $lang ) );


if ( defined( 'YITH_WCET_PREMIUM' ) && get_option( 'ywrr_mail_template_enable' ) == 'yes' ) {

    do_action( 'woocommerce_email_header', $email_heading, $email );

}
else {

    do_action( 'ywrr_email_header', $email_heading, $template );

}

?>

    <p><?php echo wpautop( $mail_body ); ?></p>

<?php

if ( defined( 'YITH_WCET_PREMIUM' ) && get_option( 'ywrr_mail_template_enable' ) == 'yes' ) {

    do_action( 'woocommerce_email_footer', $email, array( '<a class="ywrr-unsubscribe-link" href="' . $unsubscribe . '">' . get_option( 'ywrr_mail_unsubscribe_text' ) . '</a>' ) );

}
else {

    do_action( 'ywrr_email_footer', $unsubscribe, $template );

}

