<?php
    global  $alchem_page_meta;

	$left_sidebar = (isset($alchem_page_meta['left_sidebar']) && $alchem_page_meta['left_sidebar']!="")?$alchem_page_meta['left_sidebar']:esc_attr(alchem_option('left_sidebar_pages',''));
	 if ( $left_sidebar && is_active_sidebar( $left_sidebar ) ){
	 dynamic_sidebar( $left_sidebar );
	 }
	 elseif( is_active_sidebar( 'default_sidebar' ) ) {
	 dynamic_sidebar('default_sidebar');
	 }