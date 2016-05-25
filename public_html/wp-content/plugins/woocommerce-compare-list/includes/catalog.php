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

// register action hook
add_action( 'woocommerce_before_shop_loop', 'wccm_render_catalog_compare_info' );
add_action( 'wp_enqueue_scripts', 'wccm_enqueue_catalog_scripts' );

/**
 * Enqueues catalog scripts and styles.
 *
 * @since 1.0.0
 * @action wp_enqueue_scripts
 */
function wccm_enqueue_catalog_scripts() {
	if ( is_post_type_archive( 'product' ) || is_tax( 'product_cat' ) ) {
		if ( wccm_show_in_catalog() ) {
			$base_path = plugins_url( '/', dirname( __FILE__ ) );
			wp_enqueue_style( 'wccm-catalog', $base_path . 'css/catalog.css', array( 'dashicons' ), WCCM_VERISON );
		}
	}
}

/**
 * Renders catalog compare list info.
 *
 * @since 1.0.0
 * @action woocommerce_before_shop_loop
 */
function wccm_render_catalog_compare_info() {
	if ( !wccm_show_in_catalog() ) {
		return;
	}

	$list = wccm_get_compare_list();
	if ( empty( $list ) ) {
		return;
	}

	echo '<div class="wccm-catalog-items">';
		foreach ( $list as $product_id ) {
			$product = get_product( $product_id );
			if ( $product ) {
				echo '<div class="wccm-catalog-item">';
					echo $product->get_image();
					echo '<a class="dashicons dashicons-no" href="', esc_url( wccm_get_compare_link( $product_id, 'remove-from-list' ) ), '"></a>';
				echo '</div>';
			}
		}

		$compare_link = wccm_get_compare_page_link( $list );
		echo '<div class="wccm-catalog-item">';
			echo '<a class="button" href="', esc_url( $compare_link ), '">', esc_html__( 'Compare', 'wccm' ), '</a>';
		echo '</div>';

		echo '<div class="wccm-catalog-item">';
			echo '<a class="button alt" href="', esc_url( wccm_get_compare_link( implode( ',', $list ), 'remove-from-list' ) ), '">', esc_html__( 'Cancel', 'wccm' ), '</a>';
		echo '</div>';

		echo '<div style="clear:both"></div>';
	echo '</div>';
}