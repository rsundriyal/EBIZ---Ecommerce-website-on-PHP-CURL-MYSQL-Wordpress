<?php
    $left_sidebar_404 =  'left_sidebar_404';

	 if ( $left_sidebar_404 && is_active_sidebar( $left_sidebar_404 ) ){
	 dynamic_sidebar( $left_sidebar_404 );
	 }
	 elseif( is_active_sidebar( 'default_sidebar' ) ) {
	 dynamic_sidebar('default_sidebar');
	 }