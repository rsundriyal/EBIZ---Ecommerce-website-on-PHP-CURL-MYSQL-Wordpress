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
add_action( 'init', 'wccm_setup_plugin' );
// register filter hooks
add_filter( 'query_vars', 'wccm_register_endpoint_var' );

/**
 * Returns endpoint slug for compare page.
 *
 * @since 1.0.0
 *
 * @return string The endpoint slug.
 */
function wccm_get_endpoint() {
	return get_option( 'wccm_compare_endpoint', __( 'products', 'wccm' ) );
}

/**
 * Registers scripts, styles and page endpoint.
 *
 * @since 1.1.0
 * @action init
 *
 * @global boolean $is_IE Determines whether or not the current user agent is Internet Explorer.
 * @global boolean $is_opera Determines whether or not the current user agent is Opera.
 * @global boolean $is_gecko Determines whether or not the current user agent is Gecko based.
 */
function wccm_setup_plugin() {
	global $is_IE, $is_opera, $is_gecko;

	// register scripts and styles
	if ( !is_admin() ) {
		$base_path = plugins_url( '/', dirname( __FILE__ ) );
		wp_register_style( 'wccm-compare', $base_path . 'css/compare.css', array( 'dashicons' ), WCCM_VERISON );

		wp_register_script( 'wccm-compare', $base_path . 'js/compare.js', array( 'jquery' ), WCCM_VERISON );
		wp_localize_script( 'wccm-compare', 'wccm', array(
			'ie'      => $is_IE,
			'gecko'   => $is_gecko,
			'opera'   => $is_opera,
			'cursors' => $base_path . 'cursors/',
		) );
	}

	// setup endpoint
	add_rewrite_endpoint( wccm_get_endpoint(), EP_PAGES );
}

/**
 * Registers enpoint query var.
 *
 * @since 1.0.0
 * @filter query_vars
 *
 * @param array $query_vars The initial array of query vars.
 * @return array The extended array of query vars with compare page endpoint.
 */
function wccm_register_endpoint_var( $query_vars ) {
	$query_vars[] = wccm_get_endpoint();
	return $query_vars;
}

/**
 * Returns compare list.
 *
 * @sicne 1.0.0
 *
 * @global array $wccm_compare_list The array of product ids to compare.
 * @return array The array of product ids to compare.
 */
function wccm_get_compare_list() {
	global $wccm_compare_list;

	if ( is_null( $wccm_compare_list ) ) {
		$wccm_compare_list = !empty( $_COOKIE['compare-list'] ) ? $_COOKIE['compare-list'] : '';
		if ( empty( $wccm_compare_list ) ) {
			$wccm_compare_list = '';
		}

		$wccm_compare_list = explode( ':', $wccm_compare_list );
		$nonce = array_pop( $wccm_compare_list );
		if ( !wp_verify_nonce( $nonce, implode( $wccm_compare_list ) ) ) {
			$wccm_compare_list = array();
		}

		sort( $wccm_compare_list );
	}

	return $wccm_compare_list;
}

/**
 * Sets new list of products to compare.
 *
 * @since 1.0.0
 *
 * @global array $wccm_compare_list The array of product ids to compare.
 * @param array $list The new array of products to compare.
 */
function wccm_set_compare_list( $list ) {
	global $wccm_compare_list;

	$list = array_unique( array_filter( array_map( 'intval', $list ) ) );

	$wccm_compare_list = $list;
	sort( $wccm_compare_list );

	$nonce = wp_create_nonce( implode( $list ) );
	$value = implode( ':', array_merge( $list, array( $nonce ) ) );
	$path = parse_url( home_url(), PHP_URL_QUERY );
	if ( !$path ) {
		$path = '/';
	}

	setcookie( 'compare-list', $value, 0, $path );
}

/**
 * Returns link URL for compare button.
 *
 * @since 1.0.0
 *
 * @param int $product_id The product id to return compare link for.
 * @param string $action The action which has to be done against the product.
 * @return string The compare link URL.
 */
function wccm_get_compare_link( $product_id, $action = 'add-to-list' ) {
	$url = add_query_arg( array( 'wccm' => $action, 'pid' => $product_id ), $_SERVER['REQUEST_URI'] );
	$url = wp_nonce_url( $url, $action . $product_id, 'nonce' );
	return $url;
}

/**
 * Returns compare page link which contains products endpoint.
 *
 * @since 1.0.0
 *
 * @param array $items The array of product ids to compare.
 * @return string The compare pare link on success, otherwise FALSE.
 */
function wccm_get_compare_page_link( $items ) {
	$page_id = intval( get_option( 'wccm_compare_page' ) );
	if ( !$page_id ) {
		return false;
	}

	$page_link = get_permalink( $page_id );
	if ( !$page_link ) {
		return false;
	}

	return trailingslashit( $page_link ) . wccm_get_endpoint() . '/' . implode( '-', $items ) . '/';
}

/**
 * Determines whether or not to show compare stuff in the catalog.
 *
 * @since 1.0.0
 *
 * @staticvar boolean $show_in_catalog
 * @return boolean TRUE if show in catalog enabled, otherwise FALSE.
 */
function wccm_show_in_catalog() {
	static $show_in_catalog = null;

	if ( is_null( $show_in_catalog ) ) {
		$show_in_catalog = filter_var( get_option( 'wccm_show_in_catalog' ), FILTER_VALIDATE_BOOLEAN );
	}

	return $show_in_catalog;
}