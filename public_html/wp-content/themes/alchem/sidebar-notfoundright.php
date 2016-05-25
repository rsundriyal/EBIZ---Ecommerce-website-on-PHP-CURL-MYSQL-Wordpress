<?php
    $right_sidebar_404 = 'right_sidebar_404';
	 if ( $right_sidebar_404 && is_active_sidebar( $right_sidebar_404 ) ){
	    dynamic_sidebar( $right_sidebar_404 );
	 }
	 elseif( is_active_sidebar( 'default_sidebar' ) ) {
	    dynamic_sidebar('default_sidebar');
	 }