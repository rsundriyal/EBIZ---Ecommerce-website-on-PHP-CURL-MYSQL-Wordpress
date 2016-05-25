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
 * Implements Request Mail for YWRR plugin (Plain text)
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

$query_args  = array(
    'id'    => urlencode( base64_encode( !empty( $customer_id ) ? $customer_id : 0 ) ),
    'email' => urlencode( base64_encode( $billing_email ) )
);
$unsubscribe = get_option( 'ywrr_mail_unsubscribe_text' ) . ' - ' . esc_url( add_query_arg( $query_args, get_permalink( get_option( 'ywrr_unsubscribe_page_id' ) ) ) );

foreach ( $item_list as $item ) {
    $review_list .= $item['name'] . ' - ' . get_permalink( $item['id'] ) . "\n";
}

$find = array(
    '{customer_name}',
    '{customer_email}',
    '{site_title}',
    '{order_id}',
    '{order_date}',
    '{order_date_completed}',
    '{order_list}',
    '{days_ago}'
);

$replace = array(
    $billing_first_name,
    $billing_email,
    get_option( 'blogname' ),
    $order_id,
    $order_date,
    $modified_date,
    $review_list,
    $days_ago
);

$mail_body = str_replace( $find, $replace, get_option( 'ywrr_mail_body' ) );

echo $email_heading . "\n\n";

echo $mail_body . "\n\n\n" . $unsubscribe;

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );