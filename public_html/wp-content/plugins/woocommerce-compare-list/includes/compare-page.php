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
add_action( 'wp_enqueue_scripts', 'wccm_enqueue_compare_scripts' );
add_action( 'template_redirect', 'wccm_set_compare_page_cookie' );
// register filter hooks
add_filter( 'the_content', 'wccm_render_compare_page' );

/**
 * Enqueues scripts and styles for compare page.
 *
 * @since 1.0.0
 * @action wp_enqueue_scripts
 */
function wccm_enqueue_compare_scripts() {
	if ( is_page() && get_option( 'wccm_compare_page' ) == get_queried_object_id() ) {
		wp_enqueue_style( 'wccm-compare' );
		wp_enqueue_script( 'wccm-compare' );
	}
}

/**
 * Remembers compare page to show in the widget.
 *
 * @since 1.1.0
 * @action template_redirect
 */
function wccm_set_compare_page_cookie() {
	if ( is_page() && get_option( 'wccm_compare_page' ) == get_queried_object_id() ) {
		$list = get_query_var( wccm_get_endpoint(), false );
		if ( $list ) {
			$parsed_list = array_filter( array_map( 'intval', explode( '-', $list ) ) );
			if ( !empty( $parsed_list ) ) {
				$cookie = isset( $_COOKIE['compare-lists'] ) ? explode( ',', $_COOKIE['compare-lists'] ) : array();
				if ( in_array( $list, $cookie ) ) {
					unset( $cookie[array_search( $list, $cookie )] );
				}

				array_unshift( $cookie, $list );
				$value = implode( ',', array_slice( $cookie, 0, 5 ) );
				$expire = current_time( 'timestamp', 1 ) + 30 * DAY_IN_SECONDS;
				$path = parse_url( home_url(), PHP_URL_QUERY );
				if ( !$path ) {
					$path = '/';
				}

				setcookie( 'compare-lists', $value, $expire, $path );
			}
		}
	}
}

/**
 * Renders compare page.
 *
 * @since 1.0.0
 * @filter the_content
 *
 * @param string $content The initial page content.
 * @return string The updated page content.
 */
function wccm_render_compare_page( $content ) {
	if ( !is_page() || get_option( 'wccm_compare_page' ) != get_the_ID() ) {
		return $content;
	}

	$list = get_query_var( wccm_get_endpoint(), false );
	if ( $list ) {
		$list = array_filter( array_map( 'intval', explode( '-', $list ) ) );
	}

	if ( empty( $list ) ) {
		$list = wccm_get_compare_list();
		if ( empty( $list ) ) {
			return $content . '<p class="wccm-empty-compare">' . esc_html__( 'No products found to compare.', 'wccm' ) . '</p>';
		}
	}

	return $content . wccm_compare_list_render( $list );
}