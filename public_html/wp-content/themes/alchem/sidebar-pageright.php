<?php
global  $alchem_page_meta;
    $right_sidebar = (isset($alchem_page_meta['right_sidebar']) && $alchem_page_meta['right_sidebar']!="")?$alchem_page_meta['right_sidebar']:esc_attr(alchem_option('right_sidebar_pages',''));
	 if ( $right_sidebar && is_active_sidebar( $right_sidebar ) ){
	    dynamic_sidebar( $right_sidebar );
	 }
	 elseif( is_active_sidebar( 'default_sidebar' ) ) {
	    dynamic_sidebar('default_sidebar');
	 }