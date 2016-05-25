<?php
    $left_sidebar_blog_posts = esc_attr(alchem_option('left_sidebar_search',''));

	 if ( $left_sidebar_blog_posts && is_active_sidebar( $left_sidebar_blog_posts ) ){
	 dynamic_sidebar( $left_sidebar_blog_posts );
	 }
	 elseif( is_active_sidebar( 'default_sidebar' ) ) {
	 dynamic_sidebar('default_sidebar');
	 }