<?php

/*
 * Loads the Options Panel
 *
 */
  
// Helper library for the theme customizer.
load_template( trailingslashit( get_template_directory() ) . 'admin/customizer-library/customizer-library.php');
// Define options for the theme customizer.
load_template( trailingslashit( get_template_directory() ) . 'admin/customizer-options.php');
// Output inline styles based on theme customizer selections.
load_template( trailingslashit( get_template_directory() ) . 'admin/styles.php');
// Additional filters and actions based on theme customizer selections.
load_template( trailingslashit( get_template_directory() ) . 'admin/mods.php');
// Import theme options data to customize
load_template( trailingslashit( get_template_directory() ) . 'admin/alchem-customizer.php');

define('ALCHEM_THEME_URI' ,trailingslashit( get_template_directory_uri()));
define('ALCHEM_THEME_DIR' ,trailingslashit( get_template_directory()));
/**
 * Set the content width based on the theme's design and stylesheet.
 */

if ( ! function_exists( 'alchem_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function alchem_setup() {
	global $content_width, $alchem_options,$alchem_upgrade_from_options;
    $alchem_options = get_theme_mods();
	$alchem_upgrade_from_options  = get_theme_mod( 'alchem_upgrade_from_options','0');
	if ( ! isset( $content_width ) ) {
		$content_width = str_replace('px','',alchem_option('site_width',1170)); /* pixels */
	}
	
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on alchem, use a find and replace
	 * to change '_s' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'alchem', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_editor_style("editor-style.css");
	add_image_size( 'alchem-related-post', 400, 300, true ); //(cropped)
	add_image_size( 'alchem-portfolio', 1920, 1080, true ); //(cropped)
	add_image_size( 'alchem-portfolio-thumb', 640, 360, true ); //(cropped)
	add_theme_support( 'infinite-scroll', array(
		'type'           => 'scroll',
		'footer_widgets' => array( 'col-aside-right', 'col-aside-left' ),
		'container'      => 'alchem-infinite-scroll',
		'wrapper'        => true,
		'render'         => false,
		'posts_per_page' => false,
		'footer' => false,
		
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'alchem' ),
		'top_bar_menu' => __( 'Top Bar Menu', 'alchem' ),
		'footer_menu' => __( 'Footer Menu', 'alchem' ),
		'custom_menu_1' => __( 'Custom Menu 1', 'alchem' ),
		'custom_menu_2' => __( 'Custom Menu 2', 'alchem' ),
		'custom_menu_3' => __( 'Custom Menu 3', 'alchem' ),
		'custom_menu_4' => __( 'Custom Menu 4', 'alchem' ),
		'custom_menu_5' => __( 'Custom Menu 5', 'alchem' ),
		'custom_menu_6' => __( 'Custom Menu 6', 'alchem' ),
	) );
	

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );
	
	// Setup the WordPress core custom header feature.
	add_theme_support( 'custom-header', array(
        'default-image'          => '',
        'random-default'         => false,
        'width'                  => '1920',
        'height'                 => '120',
        'flex-height'            => true,
        'flex-width'             => true,
        'default-text-color'     => 'ffffff',
        'header-text'            => true,
        'uploads'                => true,
        'wp-head-callback'       => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => ''
)); 

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'alchem_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );


}
endif; // alchem_setup
add_action( 'after_setup_theme', 'alchem_setup' );
	
	

/**
 * get theme textdomain.
 */

function alchem_get_textdomain(){
	
	$themename = get_option( 'stylesheet' );
	$themename = preg_replace("/\W/", "_", strtolower($themename) );
	return $themename;
	
	}
	



function alchem_option( $name, $default = false ) {
	   global $alchem_options,$alchem_default_options;
	   
	   $name = 'alchem_'.$name;
	   if( $default == false )
	   $default = isset($alchem_default_options[$name])?$alchem_default_options[$name]:$default;
	   
		if ( isset( $alchem_options[$name] ) ) {
				return apply_filters( "theme_mod_{$name}", $alchem_options[$name] );
		}

		if ( is_string( $default ) )
				$default = sprintf( $default, get_template_directory_uri(), get_stylesheet_directory_uri() );
		return apply_filters( "theme_mod_{$name}", $default );
}


/**
 * Enqueue scripts and styles.
 */

function alchem_scripts() {
	global $content_width,$alchem_page_meta,$post;
	if($post){
	$alchem_page_meta = get_post_meta( $post->ID ,'_alchem_post_meta');
	}
	
	if( isset($alchem_page_meta[0]) && $alchem_page_meta[0]!='' )
	$alchem_page_meta = @json_decode( $alchem_page_meta[0],true );
	
	$detect = new Mobile_Detect;
	$post_type =  get_post_type( get_the_ID() );
	   // body font
    $theme_info = wp_get_theme();
   
   $body_font              = str_replace('&#039;','\'', esc_attr(alchem_option('body_font')));
   $standard_body_font     = str_replace('&#039;','\'',esc_attr(alchem_option('standard_body_font')));
   $menu_font              = str_replace('&#039;','\'',esc_attr(alchem_option('menu_font')));
   $standard_menu_font     = str_replace('&#039;','\'',esc_attr(alchem_option('standard_menu_font')));
   $headings_font          = str_replace('&#039;','\'',esc_attr(alchem_option('headings_font')));
   $standard_headings_font = str_replace('&#039;','\'',esc_attr(alchem_option('standard_headings_font')));
   $footer_headings_font          = str_replace('&#039;','\'',esc_attr(alchem_option('headings_font')));
   $standard_footer_headings_font = str_replace('&#039;','\'',esc_attr(alchem_option('standard_footer_headings_font')));
   $button_font            = str_replace('&#039;','\'',esc_attr(alchem_option('button_font')));
   $standard_button_font   = str_replace('&#039;','\'',esc_attr(alchem_option('standard_button_font')));

   
   if( $body_font ){
	wp_enqueue_style( 'google-fonts-'.sanitize_title($body_font), 'http' . ( ( is_ssl() ) ? 's' : '' ) . '://fonts.googleapis.com/css?family=' . str_replace(' ','+',$body_font), array(), '' );
   }
   if( $menu_font ){
	wp_enqueue_style( 'google-fonts-'.sanitize_title($menu_font), 'http' . ( ( is_ssl() ) ? 's' : '' ) . '://fonts.googleapis.com/css?family=' . str_replace(' ','+',$menu_font), array(), '' );
   }
   if( $headings_font ){
	wp_enqueue_style( 'google-fonts-'.sanitize_title($headings_font), 'http' . ( ( is_ssl() ) ? 's' : '' ) . '://fonts.googleapis.com/css?family=' . str_replace(' ','+',$headings_font), array(), '' );
   }
    if( $footer_headings_font ){
	wp_enqueue_style( 'google-fonts-'.sanitize_title($footer_headings_font), 'http' . ( ( is_ssl() ) ? 's' : '' ) . '://fonts.googleapis.com/css?family=' . str_replace(' ','+',$footer_headings_font), array(), '' );
   }
   if( $button_font ){
	wp_enqueue_style( 'google-fonts-'.sanitize_title($button_font), 'http' . ( ( is_ssl() ) ? 's' : '' ) . '://fonts.googleapis.com/css?family=' . str_replace(' ','+',$button_font), array(), '' );
   }
					
	$google_fonts = alchem_option('google_fonts');
    if( trim($google_fonts) !='' ){
	$google_fonts = str_replace(' ','+',trim($google_fonts));
	wp_enqueue_style('alchem-google-fonts', esc_url('//fonts.googleapis.com/css?family='.$google_fonts), false, '', false );
	}
	
	$home_style = absint(alchem_option('home_style',0));
	if( $home_style == '1' ){
		wp_enqueue_style('alchem-google-fonts-cuprum-Playfair-Display-Dancing-Script', esc_url('//fonts.googleapis.com/css?family=Cuprum|Playfair+Display|Dancing+Script'), false, '', false );
		}
	if( $home_style == '2' ){
		wp_enqueue_style('alchem-google-fonts-poiret-one-Dancing-Script', esc_url('//fonts.googleapis.com/css?family=Poiret+One|Dancing+Script'), false, '', false );
   }
    wp_enqueue_style( 'alchem-Open-Sans', esc_url('//fonts.googleapis.com/css?family=Open+Sans:300,400,700'), false, '', false );
    wp_enqueue_style( 'alchem-bootstrap',  get_template_directory_uri() .'/plugins/bootstrap/css/bootstrap.css', false, '', false );
	wp_enqueue_style( 'alchem-font-awesome',  get_template_directory_uri() .'/plugins/font-awesome/css/font-awesome.min.css', false, '4.3.0', false );
    wp_enqueue_style( 'alchem-animate',  get_template_directory_uri() .'/plugins/animate.css', false, '', false );
	
	wp_enqueue_style( 'alchem-prettyPhoto',  get_template_directory_uri() .'/css/prettyPhoto.css', false, '', false );
	wp_enqueue_style( 'alchem-owl.carousel',  get_template_directory_uri() .'/plugins/owl-carousel/assets/owl.carousel.css', false, '2.0.0', false );
	wp_enqueue_style( 'alchem-custom',  get_template_directory_uri() .'/css/custom.css', false, '', false );
	wp_enqueue_style( 'alchem-shortcode',  get_template_directory_uri() .'/css/shortcode.css', false, $theme_info->get( 'Version' ), false );
    wp_enqueue_style( 'alchem-style', get_stylesheet_uri() );
	wp_enqueue_style('alchem-schemesss',  get_template_directory_uri() .'/css/scheme.less', false,$theme_info->get( 'Version' ), false);
	
	//wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/plugins/bootstrap/js/bootstrap.js' , array( 'jquery' ), null, true);

	wp_enqueue_script( 'alchem-prettyPhoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'alchem-parallax', get_template_directory_uri() . '/js/parallax.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'alchem-owl.carousel', get_template_directory_uri() . '/plugins/owl-carousel/owl.carousel.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'alchem-masonry', get_template_directory_uri() . '/plugins/jquery-masonry/jquery.masonry.min.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'alchem-easing', get_template_directory_uri() . '/js/jquery.easing.min.js' , array( 'jquery' ), null, true);
	wp_enqueue_script( 'alchem-less', get_template_directory_uri().'/plugins/less.min.js', array( 'jquery' ), '2.5.1', false );
    wp_register_script( 'alchem-maps-api', esc_url('//maps.google.com/maps/api/js?sensor=false'), array( 'jquery' ), '', false  );
	wp_enqueue_script( 'alchem-respond',  get_template_directory_uri() .'/js/respond.min.js', false, '2.0.0', false );
	wp_enqueue_script( 'alchem-nav',  get_template_directory_uri() .'/js/jquery.nav.js', false, '3.0.0', false );
	//wp_enqueue_script( 'alchem-smoothscroll',  get_template_directory_uri() .'/js/smoothscroll.js', false, '0.9.9', false );
	wp_enqueue_script('magee-waypoints', get_stylesheet_directory_uri() . '/js/jquery.waypoints.js', array(), '2.0.5', true);
	wp_enqueue_script( 'alchem-main', get_template_directory_uri() . '/js/main.js', array( 'jquery' ), null, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	
	wp_enqueue_script( 'alchem-infinitescroll', get_template_directory_uri() . '/js/jquery.infinitescroll.js', 'jquery', null, true );
	
	$responsive       = esc_attr(alchem_option('responsive','yes'));
	$site_width       = esc_attr(alchem_option('site_width',$content_width));
	$sticky_header    = esc_attr(alchem_option('enable_sticky_header','yes'));
	$show_search_icon = esc_attr(alchem_option('show_search_icon_in_main_nav','yes'));
	
	//slider
	$slider_autoplay  = esc_attr(alchem_option('slider_autoplay','yes'));
	$slideshow_speed  = absint(alchem_option('slideshow_speed','yes'));
	$display_slider_pagination  = esc_attr(alchem_option('display_slider_pagination','yes'));
	$caption_font_color  = esc_attr(alchem_option('caption_font_color','#333333'));
	$caption_heading_color  = esc_attr(alchem_option('caption_heading_color','#333333'));
	$caption_font_size  = esc_attr(alchem_option('caption_font_size','14px'));
	$caption_alignment  = esc_attr(alchem_option('caption_alignment','left'));
	
	//pagination type
	$portfolio_grid_pagination_type  = esc_attr(alchem_option('portfolio_grid_pagination_type','pagination'));
	$blog_pagination_type            = esc_attr(alchem_option('blog_pagination_type','pagination'));
	
	$isMobile = 0;
	if( $detect->isMobile() && !$detect->isTablet() ){
		$isMobile = 1;
		}
		
	//scheme
	$global_color           = esc_attr(alchem_option('scheme'));
	$footer_special_effects = alchem_option('footer_special_effects','');
	$footer_sticky          =  $footer_special_effects == 'footer_sticky'? '1':'0';
	
	wp_localize_script( 'alchem-main', 'alchem_params', array(
			'ajaxurl'    => admin_url('admin-ajax.php'),
			'themeurl'   => get_template_directory_uri(),
			'responsive' => $responsive,
			'site_width' => $site_width,
			'sticky_header' => $sticky_header,
			'show_search_icon' => $show_search_icon,
			'slider_autoplay'=>$slider_autoplay,
			'slideshow_speed'=>$slideshow_speed,
			'portfolio_grid_pagination_type' => $portfolio_grid_pagination_type,
			'blog_pagination_type' => $blog_pagination_type,
			'global_color' => $global_color,
			'admin_ajax_nonce' => wp_create_nonce( 'alchem_admin_ajax' ),
			'admin_ajax' => admin_url( 'admin-ajax.php' ),
			'isMobile' =>$isMobile,
			'footer_sticky'=>$footer_sticky
		)  );
	
	
   $body_font_size                  = absint(alchem_option('body_font_size',14));
   $main_menu_font_size             = absint(alchem_option('main_menu_font_size',14));
   $secondary_menu_font_size        = absint(alchem_option('secondary_menu_font_size',14));
   $breadcrumb_font_size            = absint(alchem_option('breadcrumb_font_size',14));
   $sidebar_widget_heading_font_size = absint(alchem_option('sidebar_widget_heading_font_size',16));
   $footer_widget_heading_font_size = absint(alchem_option('footer_widget_heading_font_size',16));
   
   $h1_font_size   = absint(alchem_option('h1_font_size',36));
   $h2_font_size   = absint(alchem_option('h2_font_size',30));
   $h3_font_size   = absint(alchem_option('h3_font_size',24));
   $h4_font_size   = absint(alchem_option('h4_font_size',20));
   $h5_font_size   = absint(alchem_option('h5_font_size',18));
   $h6_font_size   = absint(alchem_option('h6_font_size',16));
   
   $tagline_font_size    = absint(alchem_option('h6_font_size',14));
   $meta_data_font_size  = absint(alchem_option('meta_data_font_size',14));
   $page_title_font_size = absint(alchem_option('page_title_font_size',30));
   $page_title_subheader_font_size    = absint(alchem_option('page_title_subheader_font_size',14));
   $pagination_font_size    = absint(alchem_option('pagination_font_size',14));
   $woocommerce_icon_font_size    = absint(alchem_option('woocommerce_icon_font_size',14));
   
	$alchem_custom_css  = '';
	
	$alchem_custom_css  .= "body{ font-size:". $body_font_size ."px}";
	$alchem_custom_css  .= "#menu-main > li > a > span{ font-size:". $main_menu_font_size ."px}";
	$alchem_custom_css  .= "#menu-main li li a span{ font-size:". $secondary_menu_font_size ."px}";
	$alchem_custom_css  .= ".breadcrumb-nav span,.breadcrumb-nav a{ font-size:". $breadcrumb_font_size ."px}";
	$alchem_custom_css  .= ".widget-area .widget-title{ font-size:". $sidebar_widget_heading_font_size ."px}";
	$alchem_custom_css  .= ".footer-widget-area .widget-title{ font-size:". $footer_widget_heading_font_size ."px}";
	
	$alchem_custom_css  .= "h1{ font-size:". $h1_font_size ."px}";
	$alchem_custom_css  .= "h2{ font-size:". $h2_font_size ."px}";
	$alchem_custom_css  .= "h3{ font-size:". $h3_font_size ."px}";
	$alchem_custom_css  .= "h4{ font-size:". $h4_font_size ."px}";
	$alchem_custom_css  .= "h5{ font-size:". $h5_font_size ."px}";
	$alchem_custom_css  .= "h6{ font-size:". $h6_font_size ."px}";
	
	$alchem_custom_css  .= ".site-tagline{ font-size:". $tagline_font_size ."px}";
	$alchem_custom_css  .= ".entry-meta li,.entry-meta li a,.entry-meta span{ font-size:". $meta_data_font_size ."px}";
	$alchem_custom_css  .= ".page-title h1{ font-size:". $page_title_font_size ."px}";
	$alchem_custom_css  .= ".page-title h3{ font-size:". $page_title_subheader_font_size ."px}";
	$alchem_custom_css  .= ".post-pagination li a{ font-size:". $pagination_font_size ."px}";
	
	$sticky_header_background_color    = esc_attr(alchem_option('sticky_header_background_color','#ffffff'));
    $sticky_header_background_opacity  = esc_attr(alchem_option('sticky_header_background_opacity','0.7')); 
	$header_background_color           = esc_attr(alchem_option('header_background_color',''));
    $header_background_opacity         = esc_attr(alchem_option('header_background_opacity','1')); 
	$header_border_color               = esc_attr(alchem_option('header_border_color','')); 
	$menu_background_color             = esc_attr(alchem_option('menu_background_color',''));
	$menu_background_opacity           = esc_attr(alchem_option('menu_background_opacity','1'));
	$page_title_bar_background_color   = esc_attr(alchem_option('page_title_bar_background_color','')); 
	$page_title_bar_borders_color      = esc_attr(alchem_option('page_title_bar_borders_color','')); 
	$content_background_color          = esc_attr(alchem_option('content_background_color',''));
	$sidebar_background_color          = esc_attr(alchem_option('sidebar_background_color',''));
	
	$footer_background_color           = esc_attr(alchem_option('footer_background_color',''));
	$footer_border_color               = esc_attr(alchem_option('footer_border_color',''));
	$copyright_background_color        = esc_attr(alchem_option('copyright_background_color',''));
	$copyright_border_color            = esc_attr(alchem_option('copyright_border_color',''));
	
	$footer_widget_divider_color       = esc_attr(alchem_option('footer_widget_divider_color',''));
	$form_background_color             = esc_attr(alchem_option('form_background_color',''));
	$form_text_color                   = esc_attr(alchem_option('form_text_color',''));
	$form_border_color                 = esc_attr(alchem_option('form_border_color',''));
	
	$page_content_top_padding          = esc_attr(alchem_option('page_content_top_padding',''));
	$page_content_bottom_padding       = esc_attr(alchem_option('page_content_bottom_padding',''));
	$hundredp_padding                  = esc_attr(alchem_option('hundredp_padding',''));
	$sidebar_padding                   = esc_attr(alchem_option('sidebar_padding',''));
	$column_top_margin                 = esc_attr(alchem_option('column_top_margin',''));
	$column_bottom_margin              = esc_attr(alchem_option('column_bottom_margin',''));
	
	//fonts color
	$header_tagline_color              = esc_attr(alchem_option('header_tagline_color',''));
	$page_title_color                  = esc_attr(alchem_option('page_title_color',''));
	$h1_color                          = esc_attr(alchem_option('h1_color',''));
	$h2_color                          = esc_attr(alchem_option('h2_color',''));
	$h3_color                          = esc_attr(alchem_option('h3_color',''));
	$h4_color                          = esc_attr(alchem_option('h4_color',''));
	$h5_color                          = esc_attr(alchem_option('h5_color',''));
	$h6_color                          = esc_attr(alchem_option('h6_color',''));
	$body_text_color                   = esc_attr(alchem_option('body_text_color',''));
	$link_color                        = esc_attr(alchem_option('link_color',''));
	$breadcrumbs_text_color            = esc_attr(alchem_option('breadcrumbs_text_color',''));
	$sidebar_widget_headings_color     = esc_attr(alchem_option('sidebar_widget_headings_color',''));
	$footer_headings_color             = esc_attr(alchem_option('footer_headings_color',''));
	$footer_text_color                 = esc_attr(alchem_option('footer_text_color',''));
	$footer_link_color                 = esc_attr(alchem_option('footer_link_color',''));
	
 
	 
   // body font
	if( $body_font ){
	$alchem_custom_css  .= "body{
		font-family:'".$body_font."';
		}\r\n";
	}else{
		if( $standard_body_font ){
			$alchem_custom_css  .= "body{
			font-family:".$standard_body_font.";
			}\r\n";
			
			}
		}
	
	  // menu font
	if( $menu_font ){

	$alchem_custom_css  .= "#menu-main li a span{
		font-family:'".$menu_font."';
		}\r\n";
	}else{
		if( $standard_menu_font ){
			$alchem_custom_css  .= "#menu-main li a span{
			font-family:".$standard_menu_font.";
			}\r\n";
			
			}
		}
	
	// headings font
	
	if( $headings_font ){

	$alchem_custom_css  .= "h1,h2,h3,h4,h5,h6{
		font-family:'".$headings_font."';
		}\r\n";
	}else{
		if( $standard_headings_font ){
			$alchem_custom_css  .= "h1,h2,h3,h4,h5,h6{
			font-family:".$standard_headings_font.";
			}\r\n";
			
			}
		}
		
	// footer headings font
	
	if( $headings_font ){

	$alchem_custom_css  .= "footer h1,footer h2,footer h3,footer h4,footer h5,footer h6{
		font-family:'".$headings_font."';
		}\r\n";
	}else{
		if( $standard_headings_font ){
			$alchem_custom_css  .= "footer h1,footer h2,footer h3,footer h4,footer h5,footer h6{
			font-family:".$standard_headings_font.";
			}\r\n";
			
			}
		}
		
	// button font
	
	if( $button_font ){

	$alchem_custom_css  .= "a.btn-normal{
		font-family:'".$button_font."';
		}\r\n";
	}else{
		if( $standard_button_font ){
			$alchem_custom_css  .= "a.btn-normal{
			font-family:".$standard_button_font.";
			}\r\n";
			
			}
		}
	
	// sticky header background
	if($sticky_header_background_color){
		$rgb = alchem_hex2rgb( $sticky_header_background_color );
	    $alchem_custom_css .= ".fxd-header {
		background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",".$sticky_header_background_opacity.");
		}";
		
		}
		
		// main header background
	if( $header_background_color ){
		$rgb = alchem_hex2rgb( $header_background_color );
	    $alchem_custom_css .= ".main-header {
		background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",".$header_background_opacity.");
		}";
		
		}
		


	//
	
	if( $site_width ){
		$alchem_custom_css .= "@media (min-width: 1200px){
			.container {
			  width: ".$site_width.";
			  }
			}\r\n";
		}
		
	// top bar
	$display_top_bar             = alchem_option('display_top_bar','yes');
	$top_bar_background_color    = alchem_option('top_bar_background_color','');
	$top_bar_info_color          = alchem_option('top_bar_info_color','');
	$top_bar_menu_color          = alchem_option('top_bar_menu_color','');
	
	if( $top_bar_background_color )
	$alchem_custom_css .= ".top-bar{background-color:".$top_bar_background_color.";}";
	
	if( $display_top_bar == 'yes' )
	$alchem_custom_css .= ".top-bar{display:block;}";
	if( $top_bar_info_color  )
	$alchem_custom_css .= ".top-bar-info{color:".$top_bar_info_color.";}";
	if( $top_bar_menu_color  )
	$alchem_custom_css .= ".top-bar ul li a{color:".$top_bar_menu_color.";}";
	
	
	// Header 
	if(get_header_textcolor()=='blank'){
		    $alchem_custom_css .= ".site-name,.site-tagline{display: none;}";
		}else{
			$alchem_custom_css .= ".site-name,.site-tagline{color:#".get_header_textcolor().";}";
			}

    
    $header_background_image     = alchem_option('header_background_image','');
	$header_background_full      = alchem_option('header_background_full','');
	$header_background_repeat    = alchem_option('header_background_repeat','');
	$header_background_parallax  = alchem_option('header_background_parallax','');
	
	$header_background       = '';
	if( $header_background_image ){
		$header_background  .= "header .main-header{\r\n";
		
	    $header_background  .= "background-image: url(".esc_url($header_background_image).");\r\n";
		if( $header_background_full == 'yes' )
		$header_background  .= "-webkit-background-size: cover;
								-moz-background-size: cover;
								-o-background-size: cover;
								background-size: cover;\r\n";
	   if( $header_background_parallax  == 'no' )		
	   $header_background  .=  "background-repeat:".$header_background_repeat.";";
	   if( $header_background_parallax  == 'yes' )
	   $header_background  .= "background-attachment: fixed;
		                       background-position:top center;
							   background-repeat: no-repeat;";
	   
								
        $header_background  .= "}\r\n";	
	}
	
	
	$alchem_custom_css .= $header_background;
	
	 if( $header_border_color )
		$alchem_custom_css  .= "header .main-header{\r\nborder-color:".$header_border_color.";}\r\n";
	
	if( $page_title_bar_background_color )
		$alchem_custom_css  .= ".page-title-bar{\r\nbackground-color:".$page_title_bar_background_color.";}\r\n";
		
	if( $page_title_bar_borders_color )
		$alchem_custom_css  .= ".page-title-bar{{\r\nborder-color:".$page_title_bar_borders_color.";}\r\n";
		
	// content backgroud color
		
    if( $content_background_color )
	 $alchem_custom_css  .= ".col-main {background-color:".$content_background_color.";}";
	 
	if( $sidebar_background_color )
	$alchem_custom_css  .= ".col-aside-left,.col-aside-right {background-color:".$sidebar_background_color.";}";
	
	//footer background
	if( $footer_background_color )
	 $alchem_custom_css  .= "footer .footer-widget-area{background-color:".$footer_background_color.";}";
	 
	 if( $footer_border_color )
	  $alchem_custom_css  .= "footer .footer-widget-area{\r\nborder-color:".$footer_border_color.";}\r\n";
	 
	 if( $copyright_background_color )
	 $alchem_custom_css  .= "footer .footer-info-area{background-color:".$copyright_background_color."}";
	 
	 if( $copyright_border_color )
		$alchem_custom_css  .= "footer .footer-info-area{\r\nborder-color:".$copyright_border_color.";}\r\n";
	
	// Element Colors
	
	if( $footer_widget_divider_color )
	$alchem_custom_css  .= ".footer-widget-area .widget-box li{\r\nborder-color:".$footer_widget_divider_color.";}";
	
	if( $form_background_color )
	$alchem_custom_css  .= "footer input,footer textarea{background-color:".$form_background_color.";}";
	
	if( $form_text_color )
	$alchem_custom_css  .= "footer input,footer textarea{color:".$form_text_color.";}";
	
	if( $form_border_color )
	$alchem_custom_css  .= "footer input,footer textarea{border-color:".$form_border_color.";}";
	
	
	//Layout Options
	if( $page_content_top_padding )
	$alchem_custom_css  .= ".post-inner,.page-inner{padding-top:".$page_content_top_padding.";}";
	if( $page_content_bottom_padding )
	$alchem_custom_css  .= ".post-inner,.page-inner{padding-bottom:".$page_content_bottom_padding.";}";
	
	if( isset($alchem_page_meta['padding_top']) && $alchem_page_meta['padding_top'] !='' )
	$alchem_custom_css  .= ".post-inner,.page-inner{padding-top:".esc_attr($alchem_page_meta['padding_top']).";}";
	if( isset($alchem_page_meta['padding_bottom']) && $alchem_page_meta['padding_bottom'] !='' )
	$alchem_custom_css  .= ".post-inner,.page-inner{padding-bottom:".esc_attr($alchem_page_meta['padding_bottom']).";}";
	
	
	
	if( $sidebar_padding )
	$alchem_custom_css  .= ".col-aside-left,.col-aside-right{padding:".$sidebar_padding.";}";
	if( $column_top_margin )
	$alchem_custom_css  .= ".col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9{margin-top:".$column_top_margin.";}";
	
	if( $column_bottom_margin )
	$alchem_custom_css  .= ".col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9{margin-bottom:".$column_bottom_margin.";}";
	
	
	//fonts coor
	
	if( $header_tagline_color )
	$alchem_custom_css  .= ".site-tagline{color:".$header_tagline_color.";}";
	if( $page_title_color )
	$alchem_custom_css  .= ".page-title h1{color:".$page_title_color.";}";
	if( $h1_color )
	$alchem_custom_css  .= "h1{color:".$h1_color.";}";
	if( $h2_color )
	$alchem_custom_css  .= "h2{color:".$h2_color.";}";
	if( $h3_color )
	$alchem_custom_css  .= "h3{color:".$h3_color.";}";
	if( $h4_color )
	$alchem_custom_css  .= "h4{color:".$h4_color.";}";
	if( $h5_color )
	$alchem_custom_css  .= "h5{color:".$h5_color.";}";
	if( $h6_color )
	$alchem_custom_css  .= "h6{color:".$h6_color.";}";
	if( $body_text_color )
	$alchem_custom_css  .= ".entry-content,.entry-content p{color:".$body_text_color.";}";
	if( $link_color )
	$alchem_custom_css  .= ".entry-summary a, .entry-content a{color:".$link_color.";}";
	if( $breadcrumbs_text_color )
	$alchem_custom_css  .= ".breadcrumb-nav span,.breadcrumb-nav a{color:".$breadcrumbs_text_color.";}";
	if( $sidebar_widget_headings_color )
	$alchem_custom_css  .= ".col-aside-left .widget-title,.col-aside-right .widget-title{color:".$sidebar_widget_headings_color.";}";
	if( $footer_headings_color )
	$alchem_custom_css  .= ".footer-widget-area .widget-title{color:".$footer_headings_color.";}";
	if( $footer_text_color )
	$alchem_custom_css  .= ".footer-widget-area,.footer-widget-area p,.footer-widget-area span{color:".$footer_text_color.";}";
	if( $footer_link_color )
	$alchem_custom_css  .= ".footer-widget-area a{color:".$footer_link_color.";}";
	
	//Main Menu Colors 
	$main_menu_background_color_1   = esc_attr(alchem_option('main_menu_background_color_1',''));
	$main_menu_font_color_1         = esc_attr(alchem_option('main_menu_font_color_1',''));
	$main_menu_font_hover_color_1   = esc_attr(alchem_option('main_menu_font_hover_color_1',''));
	$main_menu_background_color_2   = esc_attr(alchem_option('main_menu_background_color_2',''));
	$main_menu_font_color_2         = esc_attr(alchem_option('main_menu_font_color_2',''));
	$main_menu_font_hover_color_2   = esc_attr(alchem_option('main_menu_font_hover_color_2',''));
	$main_menu_separator_color_2    = esc_attr(alchem_option('main_menu_separator_color_2',''));
	$woo_cart_menu_background_color = esc_attr(alchem_option('woo_cart_menu_background_color',''));
	if( $main_menu_background_color_1 )
	$alchem_custom_css  .= ".header-style-1 .main-header,.header-style-2 .main-header-bottom{background-color:".$main_menu_background_color_1.";}";
	
	if( $main_menu_font_color_1 )
	$alchem_custom_css  .= "#menu-main > li > a {color:".$main_menu_font_color_1.";}";
	if( $main_menu_font_hover_color_1 )
	$alchem_custom_css  .= "#menu-main > li > a:hover{color:".$main_menu_font_hover_color_1.";}";
	if( $main_menu_background_color_2 )
	$alchem_custom_css  .= ".main-header .sub-menu{background-color:".$main_menu_background_color_2.";}";
	if( $main_menu_font_color_2 )
	$alchem_custom_css  .= "#menu-main  li li a{color:".$main_menu_font_color_2.";}";
	if( $main_menu_font_hover_color_2 )
	$alchem_custom_css  .= "#menu-main  li li a:hover{color:".$main_menu_font_hover_color_2.";}";
	if( $main_menu_separator_color_2 )
	$alchem_custom_css  .= ".site-nav  ul li li a{border-color:".$main_menu_separator_color_2." !important;}";
	
	// boxed mode background
	$layout            = esc_attr(alchem_option('layout','wide'));
    $bg_image_upload   = alchem_option('bg_image_upload','');
	$bg_color          = alchem_option('bg_color','');
	$bg_repeat         = alchem_option('bg_repeat','');
	$bg_full           = alchem_option('bg_full','');
	
	
    if( $layout == 'boxed' ){

		$alchem_custom_css  .= "body{ ";
	 if(  $bg_color )
	 $alchem_custom_css  .= "background-color: ".esc_attr($bg_color).";\r\n";
	 if( $bg_image_upload )
	 $alchem_custom_css  .= "background-image: url(".esc_url($bg_image_upload).");\r\n";
	  if(  $bg_repeat )
	 $alchem_custom_css  .= "background-repeat: ".esc_attr($bg_repeat).";\r\n";
	 
	 if( $bg_full == 'yes' )
		$alchem_custom_css  .= "background-attachment: fixed;
		                       -webkit-background-size: cover;
								-moz-background-size: cover;
								-o-background-size: cover;
								background-size: cover;\r\n";
		$alchem_custom_css  .= "}\r\n";	
	
	 
	}
	//Background Image For Main Content Area
	$content_bg_image        = alchem_option('content_bg_image','');
	$content_bg_full         = alchem_option('content_bg_full','');
	$content_bg_repeat       = alchem_option('content_bg_repeat','');
	
	if( $content_bg_image ){
		$alchem_custom_css  .= ".post-inner,.page-inner{ ";
	 if( $content_bg_full )
	 $alchem_custom_css  .= "background-image: url(".esc_url($content_bg_image).");\r\n";
	  if(  $content_bg_repeat )
	 $alchem_custom_css  .= "background-repeat: ".esc_attr($content_bg_repeat).";\r\n";
	  if( $content_bg_full == 'yes' )
		$alchem_custom_css  .= "
		                       -webkit-background-size: cover;
								-moz-background-size: cover;
								-o-background-size: cover;
								background-size: cover;\r\n";
	 
	    $alchem_custom_css  .= "}\r\n";	
		}
	
	
	
	// Header  Padding
	$header_top_padding     = alchem_option('header_top_padding','');
	$header_bottom_padding  = alchem_option('header_bottom_padding','');
	
	if( $header_top_padding )
	$alchem_custom_css .= "@media (min-width: 920px) {
							  .main-header .site-nav > ul > li > a {
								padding-top: ".$header_top_padding.";
							  }
							  }";

	
	if( $header_bottom_padding )
	$alchem_custom_css .= "@media (min-width: 920px) {
							  .main-header .site-nav > ul > li > a{
								  padding-bottom:".$header_bottom_padding.";
								  } 
								  }";
  
  // sticky header
  
	$sticky_header_opacity               =  alchem_option('sticky_header_background_opacity','0.7');
	$sticky_header_menu_item_padding     =  alchem_option('sticky_header_menu_item_padding','');
	$sticky_header_navigation_font_size  =  alchem_option('sticky_header_navigation_font_size','');
	$sticky_header_logo_width            =  alchem_option('sticky_header_logo_width','');
	$logo_left_margin                    =  alchem_option('logo_left_margin','');
	$logo_right_margin                   =  alchem_option('logo_right_margin','');
	$logo_top_margin                     =  alchem_option('logo_top_margin','');
	$logo_bottom_margin                  =  alchem_option('logo_bottom_margin','');
		
	if( $sticky_header_background_color ){
		$rgb = alchem_hex2rgb( $sticky_header_background_color );
	    $alchem_custom_css .= ".fxd-header{background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",".esc_attr($sticky_header_opacity).");}\r\n";
	}
    if( $sticky_header_menu_item_padding )
	$alchem_custom_css .= ".fxd-header .site-nav > ul > li > a {padding:".absint($sticky_header_menu_item_padding)."px;}\r\n";
	if( $sticky_header_navigation_font_size )
	$alchem_custom_css .= ".fxd-header .site-nav > ul > li > a {font-size:".absint($sticky_header_navigation_font_size)."px;}\r\n";
	if( $sticky_header_logo_width )
	$alchem_custom_css .= ".fxd-header img.site-logo{ width:".absint($sticky_header_logo_width)."px;}\r\n";
	
	if( $logo_left_margin )
	$alchem_custom_css .= ".fxd-header img.site-logo{ margin-left:".absint($logo_left_margin)."px;}\r\n";
	if( $logo_right_margin )
	$alchem_custom_css .= ".fxd-header img.site-logo{ margin-right:".absint($logo_right_margin)."px;}\r\n";
	if( $logo_top_margin )
	$alchem_custom_css .= ".fxd-header img.site-logo{ margin-top:".absint($logo_top_margin)."px;}\r\n";
	if( $logo_bottom_margin )
	$alchem_custom_css .= ".fxd-header img.site-logo{ margin-bottom:".absint($logo_bottom_margin)."px;}\r\n";
	
	
	// menu options
	$main_nav_height    = alchem_option('main_nav_height','70');
	$highlight_bar_size = alchem_option('main_menu_highlight_bar_size','2');
	$main_menu_dropdown_width  = alchem_option('main_menu_dropdown_width','150px');

	$alchem_custom_css .= ".site-nav li ul{width:".esc_attr($main_menu_dropdown_width)."}";
	
    $navigation_drawer_breakpoint = alchem_option('navigation_drawer_breakpoint','919');
	
	$alchem_custom_css .= "@media screen and (min-width: ".$navigation_drawer_breakpoint."px){
		.main-header .site-nav > ul > li > a{line-height:".absint($main_nav_height)."px;}\r\n
		.site-nav > ul > li a{ border-bottom:".absint($highlight_bar_size)."px solid transparent; }\r\n
		}";
    $alchem_custom_css .= "@media screen and (max-width: ".$navigation_drawer_breakpoint."px){
	.site-nav-toggle {
		display: block;
	}
	.site-nav {
		display: none;
		width: 100%;
		margin-top: 0;
		background-color: #fff;
	}
	.site-nav > ul > li {
		float: none;
		overflow: hidden;
	}
	.site-nav > ul > li + li {
		margin-left: 0;
	}
	.site-nav > ul > li a {
		line-height: 50px;
	}
	.site-nav > ul > li i {
	line-height: 50px;
    } 
	.site-nav li > ul {
		position: static;
		margin-left: 20px;
		z-index: 999;
		width: auto;
		background-color: transparent;
	}
	.site-nav li ul li > a {
		color: #555;
	}
	.site-nav li ul li:hover > a {
		color: #19cbcf;
	}
	.search-form {
		display: none;
		margin: 25px 0 15px;
	}
	header {
		min-height: 65px;
	}
	.site-logo {
		height: 50px;
	}
	.site-name {
		margin: 0;
		font-size: 24px;
		font-weight: normal;
	}
}";

// page title bar

	$page_title_bar_top_padding           = esc_attr(alchem_option('page_title_bar_top_padding','210px'));
	$page_title_bar_bottom_padding        = esc_attr(alchem_option('page_title_bar_bottom_padding','160px'));
	$page_title_bar_mobile_top_padding    = esc_attr(alchem_option('page_title_bar_mobile_top_padding','70px'));
	$page_title_bar_mobile_bottom_padding = esc_attr(alchem_option('page_title_bar_mobile_bottom_padding','50px'));
	
	$page_title_bar_background_img        = esc_url(alchem_option('page_title_bar_background',''));
	$page_title_bar_retina_background     = esc_url(alchem_option('page_title_bar_retina_background',''));
	$page_title_bg_full                   = esc_attr(alchem_option('page_title_bg_full','no'));
	$page_title_bg_parallax               = esc_attr(alchem_option('page_title_bg_parallax','no'));
	
	
	$page_title_bar_background  = '';
	if( $page_title_bar_background_img ){
		$page_title_bar_background  .= ".page-title-bar{\r\n";
		
	    $page_title_bar_background  .= "background-image: url(".esc_url($page_title_bar_background_img).");\r\n";
		if( $page_title_bg_full == 'yes' )
		$page_title_bar_background  .= "-webkit-background-size: cover;
								-moz-background-size: cover;
								-o-background-size: cover;
								background-size: cover;\r\n";
	   if( $header_background_parallax  == 'no' )		
	   $page_title_bar_background  .=  "background-repeat:".$header_background_repeat.";";
	   if( $page_title_bg_parallax  == 'yes' )
	   $page_title_bar_background  .= "background-attachment: fixed;
		                       background-position:top center;
							   background-repeat: no-repeat;";
								
        $page_title_bar_background  .= "}\r\n";	
	}
	
	$alchem_custom_css .=  $page_title_bar_background ;
	
	
	$page_title_bar_background  = '';
	if( $page_title_bar_retina_background ){
		$page_title_bar_background  .= ".page-title-bar-retina{\r\n";
		
	    $page_title_bar_background  .= "background-image: url(".esc_url($page_title_bar_retina_background).") !important;\r\n";
		if( $page_title_bg_full == 'yes' )
		$page_title_bar_background  .= "-webkit-background-size: cover;
								-moz-background-size: cover;
								-o-background-size: cover;
								background-size: cover;\r\n";
	   if( $header_background_parallax  == 'no' )		
	   $page_title_bar_background  .=  "background-repeat:".$header_background_repeat.";";
	   if( $page_title_bg_parallax  == 'yes' )
	   $page_title_bar_background  .= "background-attachment: fixed;
		                       background-position:top center;
							   background-repeat: no-repeat;";
		  
        $page_title_bar_background  .= "}\r\n";	
	}
	
	
	$alchem_custom_css .=  $page_title_bar_background ;
	
	
	if( $detect->isMobile() ){
		
	$alchem_custom_css .= ".page-title-bar{
		padding-top:".$page_title_bar_mobile_top_padding .";
		padding-bottom:".$page_title_bar_mobile_bottom_padding .";
		}";
		
	}else{
	
	$alchem_custom_css .= ".page-title-bar{
		padding-top:".$page_title_bar_top_padding .";
		padding-bottom:".$page_title_bar_bottom_padding .";
		}";
	}
	
	

    // content width

	$content_width_1  = alchem_option('content_width_1','');
	$sidebar_width    = alchem_option('sidebar_width','');
		
	$content_width_2  = alchem_option('content_width_2','');
	$sidebar_width_1  = alchem_option('sidebar_width_1','');
	$sidebar_width_2  = alchem_option('sidebar_width_2','');
	
	if( $content_width_1 && $sidebar_width ){
		
		 $alchem_custom_css .= "@media (min-width: 992px) {
			 .left-aside .col-main,
		.right-aside .col-main {
			width: ".$content_width_1.";
			 }\r\n";
		$alchem_custom_css .= ".left-aside .col-main {
			left: ".$sidebar_width."; 
		}\r\n";
		
		$alchem_custom_css .= ".left-aside .col-aside-left {
			right: ".$content_width_1."; 
		}\r\n";
			 
		$alchem_custom_css .= ".left-aside .col-aside-left,
		.right-aside .col-aside-right {
			width: ".$sidebar_width.";
		   }\r\n
		 }";
	
		}
		
	if( $content_width_2 && $sidebar_width_1 && $sidebar_width_2 ){
		$alchem_custom_css .= "@media (min-width: 992px) {
			.both-aside .col-main {
		width: ".$content_width_2.";
	    }\r\n";
	
		$alchem_custom_css .= ".both-aside .col-aside-left {
			width: ".$sidebar_width_1.";
		}\r\n";
		
		$alchem_custom_css .= ".both-aside .col-aside-left {
			right: ".$content_width_2.";
		}\r\n";
		
		$alchem_custom_css .= ".both-aside .col-aside-right {
			width: ".$sidebar_width_2.";
		}\r\n";
		$alchem_custom_css .= ".both-aside .col-main {
			left: ".$sidebar_width_1."; 
		}\r\n";
		
		$alchem_custom_css .= ".both-aside .col-aside-right {
			width: ".$sidebar_width_2.";
		}\r\n
			}";
	
	}
	
	// footer
	
	$footer_background_image          = alchem_option('footer_background_image',''); 
	$footer_bg_full                   = alchem_option('footer_bg_full','yes'); 
	$footer_background_repeat         = alchem_option('footer_background_repeat',''); 
	$footer_background_position       = alchem_option('footer_background_position',''); 
	$footer_top_padding               = alchem_option('footer_top_padding',''); 
	$footer_bottom_padding            = alchem_option('footer_bottom_padding',''); 
	
	$copyright_top_padding            = alchem_option('copyright_top_padding',''); 
	$copyright_bottom_padding         = alchem_option('copyright_bottom_padding',''); 
	
    $footer_social_icons_boxed        = alchem_option('footer_social_icons_boxed','no'); 
	$footer_social_icons_color        = alchem_option('footer_social_icons_color',''); 
	$footer_social_icons_box_color    = alchem_option('footer_social_icons_box_color',''); 
	$footer_social_icons_boxed_radius = alchem_option('footer_social_icons_boxed_radius',''); 
	
	   
    $footer_background = "";
	
	if( $footer_background_image ){
		$footer_background  .= ".footer-widget-area{\r\n";
		
	    $footer_background  .= "background-image: url(".esc_url($footer_background_image).");\r\n";
		if( $page_title_bg_full == 'yes' )
		$footer_background  .= "-webkit-background-size: cover;
								-moz-background-size: cover;
								-o-background-size: cover;
								background-size: cover;\r\n";
		
	   $footer_background  .=  "background-repeat:".esc_attr($footer_background_repeat).";";
	   $footer_background  .=  "background-position:".esc_attr($footer_background_position).";";

		  
        $footer_background  .= "}\r\n";	
	}
	
	$alchem_custom_css      .= $footer_background ;
	
	$alchem_custom_css      .= ".footer-widget-area{\r\n
	                           padding-top:".$footer_top_padding.";\r\n
							   padding-bottom:".$footer_bottom_padding.";\r\n
							   }" ;
	$alchem_custom_css      .= ".footer-info-area{\r\n
	                           padding-top:".$copyright_top_padding.";\r\n
							   padding-bottom:".$copyright_bottom_padding.";\r\n
							   }" ;
	
	if( $footer_social_icons_boxed == 'yes' ){
	$alchem_custom_css      .= ".footer-sns i {
									width: 40px;
									height: 40px;
									line-height: 40px;
									margin: 0 5px;
									}";
									
	if( $footer_social_icons_box_color ){
		$rgb = alchem_hex2rgb($footer_social_icons_box_color);
	$mageewp_custom_css      .= ".footer-sns a {
		background-color: rgba(".$rgb[0].",".$rgb[1].",".$rgb[2].",.1);
		}";
	}
									
	}
	if( $footer_social_icons_color )
	$alchem_custom_css      .= ".footer-sns i {
		color:".$footer_social_icons_color."
		}";
	
	if( $footer_social_icons_boxed_radius )
	$alchem_custom_css      .= ".footer-sns a {
		border-radius: ".$footer_social_icons_boxed_radius.";
        -moz-border-radius: ".$footer_social_icons_boxed_radius.";
        -webkit-border-radius: ".$footer_social_icons_boxed_radius.";
		}";
		
	// Social Share Box 
	
	$top_social_color     = alchem_option('top_social_color',''); 
	$footer_social_color  = alchem_option('footer_social_color',''); 
	if( $top_social_color )
	$alchem_custom_css  .= ".top-bar-sns i{color:".$top_social_color.";}";
	if( $footer_social_color )
	$alchem_custom_css  .= ".footer-sns i{color:".$footer_social_color.";}";
	
	// slider

	
	if( $caption_font_color )
	$alchem_custom_css  .= ".carousel-caption,.carousel-caption p{color:".$caption_font_color.";}";
	if( $caption_heading_color )
	$alchem_custom_css  .= ".carousel-caption h1,
	.carousel-caption h2,
	.carousel-caption h3,
	.carousel-caption h4,
	.carousel-caption h5,
	.carousel-caption h6{color:".$caption_heading_color.";}";
	if( $caption_font_size )
	$alchem_custom_css  .= ".carousel-caption p{font-size:".$caption_font_size.";}";
	if( $caption_alignment )
	$alchem_custom_css  .= ".carousel-caption p{text-align:".$caption_alignment.";}";
	if($display_slider_pagination == 'no')
	$alchem_custom_css  .= ".carousel-indicators{display:none;}";
	
	// home page sections
	for( $i=0;$i<=10;$i++ ){
		$section_hide     = alchem_option('section_'.$i.'_hide');
		$section_id       = alchem_option('section_'.$i.'_id','section-'.$i);
		$background_color = alchem_option('section_'.$i.'_background_color');
		$background_image = alchem_option('section_'.$i.'_background_image');
		$padding_top      = alchem_option('section_'.$i.'_top_padding');
		$padding_bottom   = alchem_option('section_'.$i.'_bottom_padding');
		
		if( $section_hide != '1' ){
			
			$alchem_custom_css  .= "#alchem-home-sections .alchem-home-section-".$i."{
				
				background-color:".$background_color.";
				background-image:url(".$background_image.");
				padding-top:".$padding_top.";
				padding-bottom:".$padding_bottom.";
				
				}";
			
			
			}
		
		}
	
	//## home page sections
	
	
	$custom_css              = wp_filter_nohtml_kses(alchem_option('custom_css'));
	$alchem_custom_css      .=  $custom_css;
	

	wp_add_inline_style( 'alchem-style', $alchem_custom_css );

}
add_action( 'wp_enqueue_scripts', 'alchem_scripts' );


function alchem_admin_scripts() {
    global $pagenow ;
	$theme_info = wp_get_theme();
	
	$screen = get_current_screen();
    $post_type = $screen->id;

	if( $post_type && $post_type == "alchem_slider" ){
	 wp_enqueue_script('thickbox');
	 wp_enqueue_style('thickbox');
	wp_enqueue_style('alchem-admin',  get_template_directory_uri() .'/css/admin.css', false, $theme_info->get( 'Version' ), false);
	
	}
	
	if( isset($_GET['page']) && $_GET['page'] == "alchem-options" ){
	wp_enqueue_style('alchem-admin',  get_template_directory_uri() .'/css/admin.css', array('optionsframework'), $theme_info->get( 'Version' ), false);
	wp_enqueue_style( 'alchem-font-awesome',  get_template_directory_uri() .'/plugins/font-awesome/css/font-awesome.css', false, '4.2.0', false ); 
	}
	

	
	if( $pagenow == "nav-menus.php"){
	wp_enqueue_script( 'alchem-menu', get_template_directory_uri() . '/js/menu.js' );
	}	
		
	if( $pagenow == "post.php" || $pagenow == "post-new.php" || (isset($_GET['page']) && $_GET['page'] == "alchem-options")){
	wp_enqueue_script( 'alchem-admin', get_template_directory_uri() . '/js/admin.js' );
	wp_enqueue_style('thickbox');
	wp_localize_script( 'alchem-admin', 'alchem_params', array(
			'ajaxurl'        => admin_url('admin-ajax.php'),
			'themeurl' => get_template_directory_uri(),
		)  );
		}
		
}
add_action( 'admin_enqueue_scripts', 'alchem_admin_scripts' );


/**
 * Mobile Detect Library
 **/
 if(!class_exists("Mobile_Detect")){
   load_template( trailingslashit( get_template_directory() ) . 'inc/Mobile_Detect.php' );
 }

/**
 * Theme breadcrumb
 */
load_template( trailingslashit( get_template_directory() ) . 'inc/breadcrumb-trail.php');


load_template( trailingslashit( get_template_directory() ) . 'inc/metabox-options.php' );


load_template( trailingslashit( get_template_directory() ) . '/inc/template-tags.php');
load_template( trailingslashit( get_template_directory() ) . 'inc/custom-header.php');

/**
 * Custom functions that act independently of the theme templates.
 */
load_template( trailingslashit( get_template_directory() ) . 'inc/extras.php');

/**
 * Customizer additions.
 */
load_template( trailingslashit( get_template_directory() ) . 'inc/customizer.php');

/**
 * Include the TGM_Plugin_Activation class.
 */
load_template( trailingslashit( get_template_directory() ) . 'inc/class-tgm-plugin-activation.php' );


add_action( 'tgmpa_register', 'alchem_theme_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function alchem_theme_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(
		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     				=> __('Magee Shortcodes','alchem'), // The plugin name
			'slug'     				=> 'magee-shortcodes', // The plugin slug (typically the folder name)
			'source'   				=> esc_url('https://downloads.wordpress.org/plugin/magee-shortcodes.zip'), // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.2.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		
	);

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'id'           => 'alchem',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'alchem-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Required Plugins', 'alchem' ),
            'menu_title'                      => __( 'Install Plugins', 'alchem' ),
            'installing'                      => __( 'Installing Plugin: %s', 'alchem' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'alchem' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'alchem' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'alchem' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'alchem' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'alchem' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'alchem' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'alchem' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'alchem' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'alchem' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'alchem' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins', 'alchem' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'alchem' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'alchem' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'alchem' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}


