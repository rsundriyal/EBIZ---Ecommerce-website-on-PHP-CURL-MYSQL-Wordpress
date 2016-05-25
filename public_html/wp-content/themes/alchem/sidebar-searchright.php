<?php
    $right_sidebar_blog_posts = esc_attr(alchem_option('right_sidebar_search',''));

	 if ( $right_sidebar_blog_posts && is_active_sidebar( $right_sidebar_blog_posts ) ){
	    dynamic_sidebar( $right_sidebar_blog_posts );
	 }
	 elseif( is_active_sidebar( 'default_sidebar' ) ) {
	    dynamic_sidebar('default_sidebar');
	 }