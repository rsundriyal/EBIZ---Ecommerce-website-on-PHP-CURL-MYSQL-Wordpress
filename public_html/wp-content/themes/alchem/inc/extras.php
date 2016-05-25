<?php

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * @param array $args Configuration arguments.
 * @return array
 */
function alchem_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'alchem_page_menu_args' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function alchem_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}
	if ( is_front_page() ){
		$classes[] = 'has-slider';
	}

	return $classes;
}
add_filter( 'body_class', 'alchem_body_classes' );



if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function alchem_slug_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'alchem_slug_render_title' );
}


  function alchem_title( $title ) {
  if ( $title == '' ) {
  return __('Untitled','alchem'); 
  } else {
  return $title;
  }
  }
  add_filter( 'the_title', 'alchem_title' );
  

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function alchem_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'alchem_setup_author' );
global $wp_embed;
add_filter( 'the_excerpt', array( $wp_embed, 'autoembed' ), 9 );

function alchem_add_pages_link( $content ){
	$pages = wp_link_pages( 
		array( 
			'before' => '<div>' . __( 'Page: ', 'alchem' ),
			'after' => '</div>',
			'echo' => false ) 
	);
	if ( $pages == '' ){
		return $content;
	}
	return $content . $pages;
}
add_filter( 'the_content', 'alchem_add_pages_link' );

add_filter( 'the_password_form', 'alchem_password_form' );
function alchem_password_form(){
    global $post;
    
    $form = '
    <form class="password-form" action="/wp-login.php?action=postpass" method="post">
    <p>' . __( 'This post is password protected. To read it please enter the password below.', 'alchem' ) . '</p>
    <input type="password" value="" name="post_password" id="password-' . $post->ID . '"/>
    </form>';
    return $form;
}

add_action( 'widgets_init', 'alchem_widgets' );
function alchem_widgets(){
	global $alchem_sidebars ;
	  $alchem_sidebars =   array(
            ''  => __( 'No Sidebar', 'alchem' ),
		    'default_sidebar'  => __( 'Default Sidebar', 'alchem' ),
			'sidebar-1'  => __( 'Sidebar 1', 'alchem' ),
			'sidebar-2'  => __( 'Sidebar 2', 'alchem' ),
			'sidebar-3'  => __( 'Sidebar 3', 'alchem' ),
			'sidebar-4'  => __( 'Sidebar 4', 'alchem' ),
			'sidebar-5'  => __( 'Sidebar 5', 'alchem' ),
			'sidebar-5'  => __( 'Sidebar 5', 'alchem' ),
			'sidebar-6'  => __( 'Sidebar 6', 'alchem' ),
			'footer_widget_1'  => __( 'Footer Widget 1', 'alchem' ),
			'footer_widget_2'  => __( 'Footer Widget 2', 'alchem' ),
			'footer_widget_3'  => __( 'Footer Widget 3', 'alchem' ),
			'footer_widget_4'  => __( 'Footer Widget 4', 'alchem' ),
			'left_sidebar_404'  => __( '404 Page Left Sidebar', 'alchem' ),
			'right_sidebar_404'  => __( '404 Page Right Sidebar', 'alchem' ),
          );
	  
	  foreach( $alchem_sidebars as $k => $v ){
		  if( $k !='' ){
		  register_sidebar(array(
			'name' => $v,
			'id'   => $k,
			'before_widget' => '<div id="%1$s" class="widget widget-box %2$s">', 
			'after_widget' => '<span class="seperator extralight-border"></span></div>', 
			'before_title' => '<h2 class="widget-title">', 
			'after_title' => '</h2>' 
			));
		  }
		  }
	    
	
		
}


/**
 * Convert Hex Code to RGB
 * @param  string $hex Color Hex Code
 * @return array       RGB values
 */
 
function alchem_hex2rgb( $hex ) {
		if ( strpos( $hex,'rgb' ) !== FALSE ) {

			$rgb_part = strstr( $hex, '(' );
			$rgb_part = trim($rgb_part, '(' );
			$rgb_part = rtrim($rgb_part, ')' );
			$rgb_part = explode( ',', $rgb_part );

			$rgb = array($rgb_part[0], $rgb_part[1], $rgb_part[2], $rgb_part[3]);

		} elseif( $hex == 'transparent' ) {
			$rgb = array( '255', '255', '255', '0' );
		} else {

			$hex = str_replace( '#', '', $hex );

			if( strlen( $hex ) == 3 ) {
				$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
				$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
				$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
			} else {
				$r = hexdec( substr( $hex, 0, 2 ) );
				$g = hexdec( substr( $hex, 2, 2 ) );
				$b = hexdec( substr( $hex, 4, 2 ) );
			}
			$rgb = array( $r, $g, $b );
		}

		return $rgb; // returns an array with the rgb values
	}


/**
 * Modifies WordPress's built-in comments_popup_link() function to return a string instead of echo comment results
 */
function alchem_get_comments_popup_link( $zero = false, $one = false, $more = false, $alchem_css_class = '', $none = false ) {
    global $wpcommentspopupfile, $wpcommentsjavascript;
 
    $id = get_the_ID();
 
    if ( false === $zero ) $zero = __( 'No Comments', 'alchem');
    if ( false === $one ) $one = __( '1 Comment', 'alchem');
    if ( false === $more ) $more = __( '% Comments', 'alchem');
    if ( false === $none ) $none = __( 'Comments Off', 'alchem');
 
    $number = get_comments_number( $id );
 
    $str = '';
 
    if ( 0 == $number && !comments_open() && !pings_open() ) {
        $str = '<span' . ((!empty($alchem_css_class)) ? ' class="' . esc_attr( $alchem_css_class ) . '"' : '') . '>' . $none . '</span>';
        return $str;
    }
	
 
    if ( post_password_required() ) {
     
        return '';
    }
 
    $str = '<a href="';
    if ( $wpcommentsjavascript ) {
        if ( empty( $wpcommentspopupfile ) )
            $home = home_url();
        else
            $home = get_option('siteurl');
        $str .= $home . '/' . $wpcommentspopupfile . '?comments_popup=' . $id;
        $str .= '" onclick="wpopen(this.href); return false"';
    } else {
        if ( 0 == $number )
            $str .= get_permalink() . '#respond';
        else
            $str .= get_comments_link();
        $str .= '"';
    }
 
    if ( !empty( $alchem_css_class ) ) {
        $str .= ' class="'.$alchem_css_class.'" ';
    }
    $title = the_title_attribute( array('echo' => 0 ) );
 
    $str .= apply_filters( 'comments_popup_link_attributes', '' );
 
    $str .= ' title="' . esc_attr( sprintf( __('Comment on %s', 'alchem'), $title ) ) . '">';
    $str .= alchem_get_comments_number_str( $zero, $one, $more );
    $str .= '</a>';
     
    return $str;
}

/**
 * Modifies WordPress's built-in comments_number() function to return string instead of echo
 */
function alchem_get_comments_number_str( $zero = false, $one = false, $more = false, $deprecated = '' ) {
    if ( !empty( $deprecated ) )
        _deprecated_argument( __FUNCTION__, '1.3' );
 
    $number = get_comments_number();
 
    if ( $number > 1 )
        $output = str_replace('%', number_format_i18n($number), ( false === $more ) ? __('% Comments', 'alchem') : $more);
    elseif ( $number == 0 )
        $output = ( false === $zero ) ? __('No Comments', 'alchem') : $zero;
    else // must be one
        $output = ( false === $one ) ? __('1 Comment', 'alchem') : $one;
 
    return apply_filters('comments_number', $output, $number);
}

// get summary

 function alchem_get_summary(){
	 
	 $excerpt_or_content        = alchem_option('excerpt_or_content','excerpt');
	 $excerpt_length            = alchem_option('excerpt_length');
	 if( $excerpt_or_content == 'full_content' ){
	 $output = get_the_content();
	 }
	 else{
	 $output = get_the_excerpt();
	 if( is_numeric($excerpt_length) && $excerpt_length !=0  )
	 $output = alchem_content_length($output, $excerpt_length );
	 }
	 return  $output;
	 }
	 
 function alchem_content_length($content, $limit) {
    $excerpt = explode(' ', trim($content), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
    }

// get post content css class
 function alchem_get_content_class( $sidebar = '' ){
	 
	 if( $sidebar == 'left' )
	 return 'left-aside';
	 if( $sidebar == 'right' )
	 return 'right-aside';
	 if( $sidebar == 'both' )
	 return 'both-aside';
	  if( $sidebar == 'none' )
	 return 'no-aside';
	 
	 return 'no-aside';
	 
	 }
	

 // get breadcrumbs
 function alchem_get_breadcrumb( $options = array()){
   global $post,$wp_query ;
    $postid = isset($post->ID)?$post->ID:"";
	
   $show_breadcrumb = "";
   if ( 'page' == get_option( 'show_on_front' ) && ( '' != get_option( 'page_for_posts' ) ) && $wp_query->get_queried_object_id() == get_option( 'page_for_posts' ) ) { 
    $postid = $wp_query->get_queried_object_id();
   }
  
   if(isset($postid) && is_numeric($postid)){
    $show_breadcrumb = get_post_meta( $postid, '_alchem_show_breadcrumb', true );
	}
	if($show_breadcrumb == 'yes' || $show_breadcrumb==""){

               alchem_breadcrumb_trail( $options);           
	}
	   
	}
	

// get social icon

function alchem_get_social( $position, $class = 'top-bar-sns',$placement='top',$target='_blank'){
	global $alchem_social_icons;
   $return = '';
   $rel    = '';
   
   $social_links_nofollow  = alchem_option( 'social_links_nofollow','no' ); 
   $social_new_window = alchem_option( 'social_new_window','yes' );  
   if( $social_new_window == 'no')
   $target = '_self';
   
   if( $social_links_nofollow == 'yes' )
   $rel    = 'nofollow';
   
   if(is_array($alchem_social_icons) && !empty($alchem_social_icons)):
   $return .= '<ul class="'.esc_attr($class).'">';
   $i = 1;
   foreach($alchem_social_icons as $sns_list_item){
	 
		 $icon = alchem_option( $position.'_social_icon_'.$i,'' );  
		 $title = alchem_option( $position.'_social_title_'.$i,'' );
		 $link = alchem_option( $position.'_social_link_'.$i,'' );  
	if(  $icon !="" ){
	 $return .= '<li><a target="'.esc_attr($target).'" rel="'.$rel.'" href="'.esc_url($link).'" data-placement="'.esc_attr($placement).'" data-toggle="tooltip" title="'.esc_attr( $title).'"><i class="fa fa-'.esc_attr( $icon).'"></i></a></li>';
	} 
	$i++;
	} 
	$return .= '</ul>';
	endif;
	return $return ;
	}
	

// get top bar content

 function alchem_get_topbar_content( $type =''){
     global $allowedposttags;
	 switch( $type ){
		 case "info":
		 echo '<div class="top-bar-info">';
		 echo wp_kses(alchem_option('top_bar_info_content'), $allowedposttags);
		 echo '</div>';
		 break;
		 case "sns":
		 $tooltip_position = alchem_option('top_social_tooltip_position','bottom'); 
		 echo alchem_get_social('header','top-bar-sns',$tooltip_position);
		 break;
		 case "menu":
		 echo '<nav class="top-bar-menu">';
		 wp_nav_menu(array('theme_location'=>'top_bar_menu','depth'=>1,'fallback_cb' =>false,'container'=>'','container_class'=>'','menu_id'=>'','menu_class'=>'','link_before' => '<span>', 'link_after' => '</span>','items_wrap'=> '<ul id="%1$s" class="%2$s">%3$s</ul>'));
		 echo '</nav>';
		 break;
		 case "none":
		
		 break;
		 }
	 }
	 
	// get related posts
	
 function alchem_get_related_posts($post_id, $number_posts = -1,$post_type = 'post') {
	$query = new WP_Query();

    $args = '';

	if($number_posts == 0) {
		return $query;
	}

	$args = wp_parse_args($args, array(
		'posts_per_page' => $number_posts,
		'post__not_in' => array($post_id),
		'ignore_sticky_posts' => 0,
        'meta_key' => '_thumbnail_id',
        'category__in' => wp_get_post_categories($post_id),
		'post_type' =>$post_type 
	));

	$query = new WP_Query($args);

  	return $query;
}


 
 // get nav memu search form
 function alchem_nav_searchform(){
	 echo get_search_form();
	 exit(0);
	 }
 add_action( 'wp_ajax_alchem_nav_searchform', 'alchem_nav_searchform' );
 add_action( 'wp_ajax_nopriv_alchem_nav_searchform', 'alchem_nav_searchform' );
 



// fix shortcodes

 function alchem_fix_shortcodes($content){   
			$replace_tags_from_to = array (
				'<p>[' => '[', 
				']</p>' => ']', 
				']<br />' => ']',
				']<br>' => ']',
				']\r\n' => ']',
				']\n' => ']',
				']\r' => ']',
				'\r\n[' => '[',
			);

			return strtr( $content, $replace_tags_from_to );
		}
		
 function alchem_the_content_filter($content) {
	  $content = alchem_fix_shortcodes($content);
	  return $content;
	}
	
 add_filter( 'the_content', 'alchem_the_content_filter' );
	

//get page top slider

 function alchem_get_page_slider($slider_type,$alchem_css_class=""){
	  global  $alchem_page_meta;
	
	  $return       = '';
	  switch($slider_type){
		  case "layer":
		  if(isset($alchem_page_meta['layer_slider']) && is_numeric($alchem_page_meta['layer_slider']) && $alchem_page_meta['layer_slider']>0 )
		  $return        .= do_shortcode('[layerslider id="'.$alchem_page_meta['layer_slider'].'"]');
		  break;
		  case "rev":
		 
		   if(isset($alchem_page_meta['rev_slider']) && $alchem_page_meta['rev_slider'] !="" )
		  $return        .= do_shortcode('[rev_slider '.$alchem_page_meta['rev_slider'].']');
		  break;
		   case "magee_slider":
		  if(isset($alchem_page_meta['magee_slider']) && is_numeric($alchem_page_meta['magee_slider']) && $alchem_page_meta['magee_slider']>0 )
		  $return .= do_shortcode('[ms_slider id="'.$alchem_page_meta['magee_slider'].'"]');	  
		  break;
		  default:
		  return;
		  break;
		  }
	 echo  '<div class="slider-wrap"><div class="page-top-slider '.$alchem_css_class.'">'.$return.'</div></div>';
	 }
	 
 
 
/**
 * Infinite Scroll
 */
function alchem_infinite_scroll_js() {
    if( ! is_singular() ) { ?>
    <script>
	if( alchem_params.portfolio_grid_pagination_type == 'infinite_scroll' && typeof infinitescroll !=='undefined'){
    var infinite_scroll = {
        loading: {
            img: "<?php echo get_template_directory_uri(); ?>/images/AjaxLoader.gif",
            msgText: "<?php _e( 'Loading the next set of posts...', 'alchem' ); ?>",
            finishedMsg: "<?php _e( 'All posts loaded.', 'alchem' ); ?>"
        },
        "nextSelector":"a.next",
        "navSelector":".post-pagination",
        "itemSelector":".portfolio-box-wrap",
        "contentSelector":".portfolio-list-items"
    };
	
	jQuery('.portfolio-list-wrap .post-pagination').hide();
    jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll,function(arrayOfNewElems){
			jQuery('.portfolio-box-wrap').css({ display: 'inline-block', opacity: 1});
			jQuery('#filters li span').removeClass('active');
			jQuery('#filters li:first span').addClass('active');
			jQuery("a[rel^='portfolio-image']").prettyPhoto();
			

      } );
	
	}
	if( alchem_params.blog_pagination_type == 'infinite_scroll' ){
		
		var infinite_scroll = {
        loading: {
            img: "<?php echo get_template_directory_uri(); ?>/images/AjaxLoader.gif",
            msgText: "<?php _e( 'Loading the next set of posts...', 'alchem' ); ?>",
            finishedMsg: "<?php _e( 'All posts loaded.', 'alchem' ); ?>"
        },
        "nextSelector":"a.next",
        "navSelector":".post-pagination",
        "itemSelector":".entry-box-wrap",
        "contentSelector":".blog-list-wrap"
    };
	
	jQuery('.blog-list-wrap .post-pagination').hide();
    jQuery( infinite_scroll.contentSelector ).infinitescroll( infinite_scroll );
		
		}
    </script>
    <?php
	
    }
}

add_action( 'wp_footer', 'alchem_infinite_scroll_js',100 );

function alchem_enqueue_less_styles($tag, $handle) {
		global $wp_styles;
		$match_pattern = '/\.less$/U';
		if ( preg_match( $match_pattern, $wp_styles->registered[$handle]->src ) ) {
			$handle = $wp_styles->registered[$handle]->handle;
			$media = $wp_styles->registered[$handle]->args;
			$href = $wp_styles->registered[$handle]->src . '?ver=' . $wp_styles->registered[$handle]->ver;
			$rel = isset($wp_styles->registered[$handle]->extra['alt']) && $wp_styles->registered[$handle]->extra['alt'] ? 'alternate stylesheet' : 'stylesheet';
			$title = isset($wp_styles->registered[$handle]->extra['title']) ? "title='" . esc_attr( $wp_styles->registered[$handle]->extra['title'] ) . "'" : '';
	
			$tag = "<link rel='stylesheet' id='".esc_attr($handle)."' $title href='".esc_url($href)."' type='text/less' media='".esc_attr($media)."' />\n";
		}
		return $tag;
	}
add_filter( 'style_loader_tag', 'alchem_enqueue_less_styles', 5, 2);
	

	
	
 function alchem_colourBrightness($hex, $percent) {
	// Work out if hash given
	$hash = '';
	if (stristr($hex,'#')) {
		$hex = str_replace('#','',$hex);
		$hash = '#';
	}
	/// HEX TO RGB
	$rgb = array(hexdec(substr($hex,0,2)), hexdec(substr($hex,2,2)), hexdec(substr($hex,4,2)));
	//// CALCULATE 
	for ($i=0; $i<3; $i++) {
		// See if brighter or darker
		if ($percent > 0) {
			// Lighter
			$rgb[$i] = round($rgb[$i] * $percent) + round(255 * (1-$percent));
		} else {
			// Darker
			$positivePercent = $percent - ($percent*2);
			$rgb[$i] = round($rgb[$i] * $positivePercent) + round(0 * (1-$positivePercent));
		}
		// In case rounding up causes us to go to 256
		if ($rgb[$i] > 255) {
			$rgb[$i] = 255;
		}
	}
	//// RBG to Hex
	$hex = '';
	for($i=0; $i < 3; $i++) {
		// Convert the decimal digit to hex
		$hexDigit = dechex($rgb[$i]);
		// Add a leading zero if necessary
		if(strlen($hexDigit) == 1) {
		$hexDigit = "0" . $hexDigit;
		}
		// Append to the hex string
		$hex .= $hexDigit;
	}
	return $hash.$hex;
}

function alchem_sanitize_allowedposttags(){
	global $allowedposttags;
    $allowedposttags['span'] = array (
                        'class' => array (),
                        'dir' => array (),
                        'align' => array (),
                        'lang' => array (),
                        'style' => array (),
                        'title' => array (),
						'data-accordion' => array (),
                        'xml:lang' => array()
						
						);

}
add_action( 'admin_init', 'alchem_sanitize_allowedposttags' );



	
function alchem_excerpt_length( $length ) {
	return 1000;
}
add_filter( 'excerpt_length', 'alchem_excerpt_length', 999 );

