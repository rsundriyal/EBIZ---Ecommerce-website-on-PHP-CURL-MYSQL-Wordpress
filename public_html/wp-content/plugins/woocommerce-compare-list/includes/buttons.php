<?php

// +----------------------------------------------------------------------+
// | Copyright 2014  Madpixels  (email : contact@madpixels.net)           |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License, version 2, as  |
// | published by the Free Software Foundation.                           |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to the Free Software          |
// | Foundation, Inc., 51 Franklin St, Fifth Floor, Boston,               |
// | MA 02110-1301 USA                                                    |
// +----------------------------------------------------------------------+
// | Author: Eugene Manuilov <eugene.manuilov@gmail.com>                  |
// +----------------------------------------------------------------------+

// prevent direct access
if ( !defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 404 Not Found', true, 404 );
	exit;
}

// register action hooks
add_action( 'woocommerce_before_shop_loop', 'wccm_register_add_compare_button_hook' );
add_action( 'woocommerce_single_product_summary', 'wccm_add_single_product_compare_buttton', 35 );
add_action( 'template_redirect', 'wccm_process_button_action' );

/**
 * Regsiters hooks to render compare buttons for catalog products and to
 * deregister that hook after catalog products are renderd.
 *
 * @since 1.0.0
 * @action woocommerce_before_shop_loop
 */
function wccm_register_add_compare_button_hook() {
	if ( wccm_show_in_catalog() ) {
		add_action( 'woocommerce_after_shop_loop_item', 'wccm_add_button' );
		add_action( 'woocommerce_after_shop_loop', 'wccm_deregister_add_compare_button_hook' );
	}
}

/**
 * Deregisters hook to render compare button for catalog products after catalog
 * rendering is finished.
 *
 * @since 1.0.0
 * @action woocommerce_after_shop_loop
 */
function wccm_deregister_add_compare_button_hook() {
	remove_action( 'woocommerce_after_shop_loop_item', 'wccm_add_button' );
}

/**
 * Renders appropriate button for a product.
 *
 * @since 1.0.0
 * @action woocommerce_after_shop_loop_item
 */
function wccm_add_button() {
	$product_id = get_the_ID();
	$classes = array( 'button', 'compare' );

	if ( in_array( $product_id, wccm_get_compare_list() ) ) {
		$url = wccm_get_compare_link( $product_id, 'remove-from-list' );
		$text = get_option( 'wccm_remove_text', __( 'Remove compare', 'wccm' ) );
		echo '<a href="', esc_url( $url ), '" class="', implode( ' ', $classes ), '">', esc_html( $text ), '</a>';
		if ( is_single() ) {
			echo '<a href="', wccm_get_compare_page_link( wccm_get_compare_list() ), '" class="button alt">', __( 'View compare', 'wccm' ), '</a>';
		}
	} else {
		$url = wccm_get_compare_link( $product_id, 'add-to-list' );
		$text = get_option( 'wccm_compare_text', __( 'Compare', 'wccm' ) );
		echo '<a href="', esc_url( $url ), '" class="', implode( ' ', $classes ), '">', esc_html( $text ), '</a>';
	}
}

/**
 * Renders compare button at single product page in case it has been enabled in
 * the settings.
 *
 * @since 1.0.0
 * @action woocommerce_single_product_summary 35
 */
function wccm_add_single_product_compare_buttton() {
	if ( filter_var( get_option( 'wccm_show_in_single' ), FILTER_VALIDATE_BOOLEAN ) ) {
		echo '<p>';
			wccm_add_button();
		echo '</p>';
	}
}

/**
 * Processes buttons actions.
 *
 * @since 1.0.0
 * @action template_redirect
 */
function wccm_process_button_action() {
	$action = filter_input( INPUT_GET, 'wccm' );
	$product_id = filter_input( INPUT_GET, 'pid' );
	if ( !wp_verify_nonce( filter_input( INPUT_GET, 'nonce' ), $action . $product_id ) ) {
		return;
	}

	switch ( $action ) {
		case 'add-to-list': wccm_add_product_to_compare_list( $product_id ); break;
		case 'remove-from-list': wccm_remove_product_from_compare_list( $product_id ); break;
	}

	$redirect = get_option( 'wccm_compare_page' ) == get_queried_object_id()
		? wccm_get_compare_page_link( wccm_get_compare_list() )
		: add_query_arg( array( 'wccm' => false, 'pid' => false, 'nonce' => false ) );

	wp_redirect( $redirect );
	exit;
}

/**
 * Adds product to compare list.
 *
 * @since 1.0.0
 *
 * @param int $product_id The product id to add to the compare list.
 */
function wccm_add_product_to_compare_list( $product_id ) {
	$product = get_product( $product_id );
	if ( !$product ) {
		return;
	}

	$list = wccm_get_compare_list();
	$list[] = $product_id;

	wccm_set_compare_list( $list );
}

/**
 * Removes product from compare list.
 *
 * @since 1.0.0
 *
 * @param int $product_id The product id to remove from compare list.
 */
function wccm_remove_product_from_compare_list( $product_id ) {
	$list = wccm_get_compare_list();

	foreach ( wp_parse_id_list( $product_id ) as $product_id ) {
		$key = array_search( $product_id, $list );
		if ( $key !== false ) {
			unset( $list[$key] );
		}
	}

	wccm_set_compare_list( $list );
}