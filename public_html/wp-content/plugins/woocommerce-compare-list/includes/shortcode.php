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

// add action hooks
add_action( 'wp_enqueue_scripts', 'wccm_enqueue_shortcode_scripts' );
// add shortcode hooks
add_shortcode( 'products-compare', 'wccm_compare_shortcode' );

/**
 * Enqueues scripts and styles for shortcode.
 *
 * @since 1.1.0
 * @action wp_enqueue_scripts
 */
function wccm_enqueue_shortcode_scripts() {
	if ( is_single() || is_page() ) {
		$post = get_queried_object();
		if ( is_a( $post, 'WP_Post' ) && preg_match( '/\[products-compare.*?\]/is', $post->post_content ) ) {
			wp_enqueue_style( 'wccm-compare' );
			wp_enqueue_script( 'wccm-compare' );
		}
	}
}

/**
 * Renders compare list shortcode.
 *
 * @since 1.1.0
 * @shortcode products-compare
 *
 * @param array $atts The array of shortcode attributes.
 * @param string $content The shortcode content.
 */
function wccm_compare_shortcode( $atts, $content = '' ) {
	$atts = shortcode_atts( array( 'ids' => '', 'atts' => '' ), $atts, 'products-compare' );

	$list = wp_parse_id_list( $atts['ids'] );
	if ( !empty( $list ) ) {
		$attributes = array_filter( array_map( 'trim', explode( ',', $atts['atts'] ) ) );
		return wccm_compare_list_render( $list, $attributes );
	}

	return $content;
}

/**
 * Renders compare list table.
 *
 * @since 1.1.0
 *
 * @param array $list The array of compare products.
 * @param array $attributes The array of attributes to show in the table.
 * @return string Compare table HTML.
 */
function wccm_compare_list_render( $list, $attributes = array() ) {
	$products = array();
	foreach ( $list as $product_id ) {
		$product = get_product( $product_id );
		if ( $product ) {
			$products[$product_id] = $product;
		}
	}

	$content = '';
	if ( !empty( $products ) ) {
		ob_start();
			echo '<div class="wccm-compare-table">';
				wccm_compare_list_render_header( $products );
				wccm_compare_list_render_attributes( $products, $attributes );
			echo '</div>';
			$content = ob_get_contents();
		ob_end_clean();
	}

	return $content;
}

/**
 * Renders compare table header.
 *
 * @since 1.1.0
 *
 * @param array $products The compare items list.
 */
function wccm_compare_list_render_header( $products ) {
	echo '<div class="wccm-thead">';
		echo '<div class="wccm-tr">';
			echo '<div class="wccm-th">';
			echo '</div>';
			echo '<div class="wccm-table-wrapper">';
				echo '<table class="wccm-table" cellspacing="0" cellpadding="0" border="0">';
					echo '<tr>';
						foreach ( $products as $product_id => $product ) {
							echo '<td class="wccm-td">';
								echo '<div class="wccm-thumb">';
									echo '<a class="dashicons dashicons-no" href="', wccm_get_compare_link( $product_id, 'remove-from-list' ), '"></a>';
									echo get_the_post_thumbnail( $product_id, 'thumbnail' );
								echo '</div>';
								echo '<div>';
									echo '<a href="', get_permalink( $product_id ), '">', $product->get_title(), '</a>';
								echo '</div>';
								echo '<div class="price">';
									echo $product->get_price_html();
								echo '</div>';
							echo '</td>';
						}
					echo '<tr>';
				echo '</table>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
}

/**
 * Renders compare table attributes.
 *
 * @since 1.1.0
 *
 * @param array $products The compare items list.
 * @param array $selected_attributes The array of attributes to show in the table.
 */
function wccm_compare_list_render_attributes( $products, $selected_attributes = array() ) {
	$attributes = array();
	$empty_selected = empty( $selected_attributes );
	foreach ( $products as $product ) {
		foreach ( $product->get_attributes() as $attribute_id => $attribute ) {
			if ( $empty_selected || in_array( substr( $attribute['name'], 3 ), $selected_attributes ) ) {
				if ( !isset( $attributes[$attribute_id] ) ) {
					$attributes[$attribute_id] = array(
						'name'     => $attribute['name'],
						'products' => array(),
					);
				}

				$attributes[$attribute_id]['products'][$product->id] = $attribute['is_taxonomy']
					? wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) )
					: array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
			}
		}
	}

	echo '<div class="wccm-tbody">';
		foreach ( $attributes as $attribute ) {
			echo '<div class="wccm-tr">';
				echo '<div class="wccm-th">';
					echo wc_attribute_label( $attribute['name'] );
				echo '</div>';
				echo '<div class="wccm-table-wrapper">';
					echo '<table class="wccm-table" cellspacing="0" cellpadding="0" border="0">';
						echo '<tr>';
							foreach ( $products as $product ) {
								echo '<td class="wccm-td">';
									$values = !empty( $attribute['products'][$product->id] ) ? $attribute['products'][$product->id] : array( '&#8212;' );
									echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
								echo '</td>';
							}
						echo '</tr>';
					echo '</table>';
				echo '</div>';
			echo '</div>';
		}
	echo '</div>';
}