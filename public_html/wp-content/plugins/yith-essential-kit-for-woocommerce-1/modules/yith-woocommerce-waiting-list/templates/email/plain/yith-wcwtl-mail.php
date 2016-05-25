<?php
/**
 * YITH WooCommerce Waiting List Mail Template Plain
 *
 * @author Yithemes
 * @package YITH WooCommerce Waiting List
 * @version 1.0.0
 */

if ( ! defined( 'YITH_WCWTL' ) ) exit; // Exit if accessed directly

echo $email_heading . "\n\n";

echo _x( "Hi there,", 'Email greetings', 'yith-woocommerce-waiting-list' ) . "\n\n";

echo sprintf( __( '%1$s is now back in stock at %2$s.', 'yith-woocommerce-waiting-list' ), $product_title, get_bloginfo( 'name' ) ) . " ";
echo __( 'You have been sent this email because your email address was registered in a waiting list for this product.', 'yith-woocommerce-waiting-list' ) . "\n\n";
echo sprintf( __( 'If you want to purchase %s, please visit the following link: %s', 'yith-woocommerce-waiting-list' ), $product_title, $product_link ) . "\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );