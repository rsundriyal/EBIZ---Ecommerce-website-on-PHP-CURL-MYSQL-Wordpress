<?php

if ( ! function_exists( "yith_is_checked_html" ) ) {
	function yith_is_checked_html( $options, $value ) {
		echo isset( $options[ $value ] ) ? checked( $options[ $value ] ) : '';
	}
}

if ( ! function_exists( "yith_is_option_selected_html" ) ) {
	function yith_is_option_selected_html( $id, $name ) {
		echo ( $id === $name ) ? selected( 1 ) : '';
	}
}

if ( ! function_exists( "ywev_get_tax_classes" ) ) {
	function ywev_get_tax_classes() {
		if ( version_compare( WOOCOMMERCE_VERSION, '2.3', '<' ) ) {
			return array_filter( array_map( 'trim', explode( "\n", get_option( 'woocommerce_tax_classes' ) ) ) );
		} else {
			return WC_Tax::get_tax_classes();
		}
	}
}