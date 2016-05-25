<?php
/**
 * ShopIsle setup functions
 *
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

/**
 * Assign the ShopIsle version to a var
 */
$theme 					= wp_get_theme();
$shop_isle_version 	= $theme['Version'];

if ( ! function_exists( 'shop_isle_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function shop_isle_setup() {

		/*
		 * Load Localisation files.
		 *
		 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
		 */

		// wp-content/languages/themes/shop-isle-it_IT.mo
		load_theme_textdomain( 'shop-isle', trailingslashit( WP_LANG_DIR ) . 'themes/' );

		// wp-content/themes/child-theme-name/languages/it_IT.mo
		load_theme_textdomain( 'shop-isle', get_stylesheet_directory() . '/languages' );

		// wp-content/themes/theme-name/languages/it_IT.mo
		load_theme_textdomain( 'shop-isle', get_template_directory() . '/languages' );

		/**
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary'		=> __( 'Primary Menu', 'shop-isle' )
		) );

		/*
		 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'widgets',
		) );

		// Setup the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'shop_isle_custom_background_args', array(
			'default-color' => apply_filters( 'shop_isle_default_background_color', 'fcfcfc' ),
			'default-image' => '',
		) ) );

		// Add support for the Site Logo plugin and the site logo functionality in JetPack
		// https://github.com/automattic/site-logo
		// http://jetpack.me/
		add_theme_support( 'site-logo', array( 'size' => 'full' ) );

		// Declare WooCommerce support
		add_theme_support( 'woocommerce' );

		// Declare support for title theme feature
		add_theme_support( 'title-tag' );
		
		/* Custom header */
		add_theme_support( 'custom-header', array( 'default-image' => get_template_directory_uri().'/assets/images/header.jpg' ));
		
		/* tgm-plugin-activation */
		require_once get_template_directory() . '/class-tgm-plugin-activation.php';
	}
endif; // shop_isle_setup

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function shop_isle_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Sidebar', 'shop-isle' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer area 1', 'shop-isle' ),
		'id'            => 'sidebar-footer-area-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer area 2', 'shop-isle' ),
		'id'            => 'sidebar-footer-area-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer area 3', 'shop-isle' ),
		'id'            => 'sidebar-footer-area-3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer area 4', 'shop-isle' ),
		'id'            => 'sidebar-footer-area-4',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Sidebar Shop Page', 'shop-isle' ),
		'id'            => 'shop-isle-sidebar-shop-archive',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

}

/**
 * Enqueue scripts and styles.
 * @since  1.0.0
 */
function shop_isle_scripts() {
	global $shop_isle_version;
	
	wp_enqueue_style( 'shop-isle-bootstrap', get_template_directory_uri() . '/assets/bootstrap/css/bootstrap.min.css', array(), '20120206', "all"  );
		
	wp_enqueue_style( 'shop-isle-magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css', array(), '20120206', "all"  );
	
	wp_enqueue_style( 'shop-isle-flexslider', get_template_directory_uri() . '/assets/css/flexslider.css', array('shop-isle-magnific-popup'), '20120206', "all"  );

	wp_enqueue_style( 'shop-isle-owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css', array('shop-isle-flexslider'), '20120206', "all"  );

	wp_enqueue_style( 'shop-isle-animate', get_template_directory_uri() . '/assets/css/animate.css', array('shop-isle-owl-carousel'), '20120206', "all"  );

	wp_enqueue_style( 'shop-isle-main-style', get_template_directory_uri() . '/assets/css/style.css', array('shop-isle-bootstrap'), '20120206', "all" );
	
	wp_enqueue_style( 'shop-isle-style', get_stylesheet_uri(), '', $shop_isle_version );
	
	wp_enqueue_script( 'jquery' );
	
	wp_enqueue_script( 'shop-isle-bootstrap-js', get_template_directory_uri() . '/assets/bootstrap/js/bootstrap.min.js', array('jquery'), '20120206', true );
	
	wp_enqueue_script( 'shop-isle-jquery-mb-YTPlayer', get_template_directory_uri() . '/assets/js/jquery.mb.YTPlayer.min.js', array('jquery'), '20120206', true );
	
	wp_enqueue_script( 'shop-isle-jqBootstrapValidation', get_template_directory_uri() . '/assets/js/jqBootstrapValidation.js', array('jquery'), '20120206', true );
	
	wp_enqueue_script( 'shop-isle-flexslider', get_template_directory_uri() . '/assets/js/jquery.flexslider-min.js', array('jquery'), '20120206', true );
	
	wp_enqueue_script( 'shop-isle-magnific-popup', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), '20120206', true );
	
	wp_enqueue_script( 'shop-isle-fitvids', get_template_directory_uri() . '/assets/js/jquery.fitvids.js', array('jquery'), '20120206', true );
	
	wp_enqueue_script( 'shop-isle-smoothscroll', get_template_directory_uri() . '/assets/js/smoothscroll.js', array('jquery'), '20120206', true );
	
	wp_enqueue_script( 'shop-isle-owl', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array('jquery'), '20120206', true );
	
	wp_enqueue_script( 'shop-isle-custom', get_template_directory_uri() . '/assets/js/custom.js', array('jquery','shop-isle-flexslider','shop-isle-jquery-mb-YTPlayer'), '20120206', true );

	wp_enqueue_script( 'shop-isle-navigation', get_template_directory_uri() . '/js/navigation.min.js', array(), '20120206', true );

	wp_enqueue_script( 'shop-isle-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.min.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

function shop_isle_admin_styles() {
	wp_enqueue_media();
    wp_enqueue_style( 'shop_isle_admin_stylesheet', get_template_directory_uri() . '/assets/css/admin-style.css' );
}

add_action('tgmpa_register', 'shop_isle_register_required_plugins');

function shop_isle_register_required_plugins() {	
	
	$plugins = array(
				array(
					'name'      => 'WooCommerce',
					'slug'      => 'woocommerce',
					'required'  => false,
				)
			);
	
    $config = array(
        'default_path' => '',
        'menu' => 'tgmpa-install-plugins',
        'has_notices' => true,
        'dismissable' => true,
        'dismiss_msg' => '',
        'is_automatic' => false,
        'message' => '',
        'strings' => array(
            'page_title' => __('Install Required Plugins', 'shop-isle'),
            'menu_title' => __('Install Plugins', 'shop-isle'),
            'installing' => __('Installing Plugin: %s', 'shop-isle'),
            'oops' => __('Something went wrong with the plugin API.', 'shop-isle'),
            'notice_can_install_required' => _n_noop('This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.','shop-isle'),
            'notice_can_install_recommended' => _n_noop('This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.','shop-isle'),
            'notice_cannot_install' => _n_noop('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.','shop-isle'),
            'notice_can_activate_required' => _n_noop('The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.','shop-isle'),
            'notice_can_activate_recommended' => _n_noop('The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.','shop-isle'),
            'notice_cannot_activate' => _n_noop('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.','shop-isle'),
            'notice_ask_to_update' => _n_noop('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.','shop-isle'),
            'notice_cannot_update' => _n_noop('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.','shop-isle'),
            'install_link' => _n_noop('Begin installing plugin', 'Begin installing plugins','shop-isle'),
            'activate_link' => _n_noop('Begin activating plugin', 'Begin activating plugins','shop-isle'),
            'return' => __('Return to Required Plugins Installer', 'shop-isle'),
            'plugin_activated' => __('Plugin activated successfully.', 'shop-isle'),
            'complete' => __('All plugins installed and activated successfully. %s', 'shop-isle'),
            'nag_type' => 'updated'
        )
    );
    tgmpa($plugins, $config);
}

function shop_isle_add_id() {
	
	$migrate = get_option( 'shop_isle_migrate_translation' );
	
	if( isset($migrate) && $migrate == false ) {
		
		/* Slider section */
		$shop_isle_slider = get_theme_mod('shop_isle_slider', json_encode(
							array( array('image_url' => get_template_directory_uri().'/assets/images/slide1.jpg' ,'link' => '#', 'text' => __('ShopIsle','shop-isle'), 'subtext' => __('WooCommerce Theme','shop-isle'), 'label' => __('FIND OUT MORE','shop-isle') ), array('image_url' => get_template_directory_uri().'/assets/images/slide2.jpg' ,'link' => '#', 'text' => __('ShopIsle','shop-isle'), 'subtext' => __('Hight quality store','shop-isle') , 'label' => __('FIND OUT MORE','shop-isle')), array('image_url' => get_template_directory_uri().'/assets/images/slide3.jpg' ,'link' => '#', 'text' => __('ShopIsle','shop-isle'), 'subtext' => __('Responsive Theme','shop-isle') , 'label' => __('FIND OUT MORE','shop-isle') ))
		));
		
		if(!empty($shop_isle_slider)){
			
			$shop_isle_slider_decoded = json_decode($shop_isle_slider);
			foreach($shop_isle_slider_decoded as &$it){
				if(!array_key_exists ( "id" , $it ) || !($it->id) ){
					$it = (object) array_merge( (array)$it, array( 'id' => 'shop_isle_'.uniqid() ) );
				}
			}
			
			$shop_isle_slider = json_encode($shop_isle_slider_decoded);
			set_theme_mod( 'shop_isle_slider', $shop_isle_slider );
		}
		
		/* Banners section */
		$shop_isle_banners = get_theme_mod('shop_isle_banners', json_encode(
							array( array('image_url' => get_template_directory_uri().'/assets/images/banner1.jpg' ,'link' => '#' ),array('image_url' => get_template_directory_uri().'/assets/images/banner2.jpg' ,'link' => '#'),array('image_url' => get_template_directory_uri().'/assets/images/banner3.jpg' ,'link' => '#') )
		));
		
		if(!empty($shop_isle_banners)){
			
			$shop_isle_banners_decoded = json_decode($shop_isle_banners);
			foreach($shop_isle_banners_decoded as &$it){
				if(!array_key_exists ( "id" , $it ) || !($it->id) ){
					$it = (object) array_merge( (array)$it, array( 'id' => 'shop_isle_'.uniqid() ) );
				}
			}
			
			$shop_isle_banners = json_encode($shop_isle_banners_decoded);
			set_theme_mod( 'shop_isle_banners', $shop_isle_banners );
		}
		
		/* Footer socials */
		$shop_isle_socials = get_theme_mod('shop_isle_socials', json_encode(
							array( array('icon_value' => 'social_facebook' ,'link' => '#' ),array('icon_value' => 'social_twitter' ,'link' => '#'), array('icon_value' => 'social_dribbble' ,'link' => '#'), array('icon_value' => 'social_skype' ,'link' => '#') )
		));
		
		if(!empty($shop_isle_socials)){
			
			$shop_isle_socials_decoded = json_decode($shop_isle_socials);
			foreach($shop_isle_socials_decoded as &$it){
				if(!array_key_exists ( "id" , $it ) || !($it->id) ){
					$it = (object) array_merge( (array)$it, array( 'id' => 'shop_isle_'.uniqid() ) );
				}
			}
			
			$shop_isle_socials = json_encode($shop_isle_socials_decoded);
			set_theme_mod( 'shop_isle_socials', $shop_isle_socials );
		}
		
		/* Our team */
		$shop_isle_team_members = get_theme_mod('shop_isle_team_members', json_encode(
							array( array('image_url' => get_template_directory_uri().'/assets/images/team1.jpg' , 'text' => 'Eva Bean', 'subtext' => 'Developer', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.' ),array('image_url' => get_template_directory_uri().'/assets/images/team2.jpg' ,'text' => 'Maria Woods', 'subtext' => 'Designer', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.' ), array('image_url' => get_template_directory_uri().'/assets/images/team3.jpg' , 'text' => 'Booby Stone', 'subtext' => 'Director', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.'), array('image_url' => get_template_directory_uri().'/assets/images/team4.jpg' , 'text' => 'Anna Neaga', 'subtext' => 'Art Director', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.') )
		));
		
		if(!empty($shop_isle_team_members)){
			
			$shop_isle_team_members_decoded = json_decode($shop_isle_team_members);
			foreach($shop_isle_team_members_decoded as &$it){
				if(!array_key_exists ( "id" , $it ) || !($it->id) ){
					$it = (object) array_merge( (array)$it, array( 'id' => 'shop_isle_'.uniqid() ) );
				}
			}
			
			$shop_isle_team_members = json_encode($shop_isle_team_members_decoded);
			set_theme_mod( 'shop_isle_team_members', $shop_isle_team_members );
		}
		
		/* Our advantages */
		$shop_isle_advantages = get_theme_mod('shop_isle_advantages', json_encode(
							array( array('icon_value' => 'icon_lightbulb' , 'text' => __('Ideas and concepts','shop-isle'), 'subtext' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','shop-isle')), array('icon_value' => 'icon_tools' , 'text' => __('Designs & interfaces','shop-isle'), 'subtext' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','shop-isle')), array('icon_value' => 'icon_cogs' , 'text' => __('Highly customizable','shop-isle'), 'subtext' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','shop-isle')), array('icon_value' => 'icon_like', 'text' => __('Easy to use','shop-isle'), 'subtext' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','shop-isle')))
		));
		
		if(!empty($shop_isle_advantages)){
			
			$shop_isle_advantages_decoded = json_decode($shop_isle_advantages);
			foreach($shop_isle_advantages_decoded as &$it){
				if(!array_key_exists ( "id" , $it ) || !($it->id) ){
					$it = (object) array_merge( (array)$it, array( 'id' => 'shop_isle_'.uniqid() ) );
				}
			}
			
			$shop_isle_advantages = json_encode($shop_isle_advantages_decoded);
			set_theme_mod( 'shop_isle_advantages', $shop_isle_advantages );
		}
		
		
		update_option( 'shop_isle_migrate_translation', true );
	}
}
add_action( 'shutdown', 'shop_isle_add_id' );



/* Polylang repeater translate */

if(function_exists('icl_unregister_string') && function_exists('icl_register_string')){
	
	/* Slider section */
	
	$shop_isle_slider_pl = get_theme_mod('shop_isle_slider');
	
	if( !empty($shop_isle_slider_pl) ) {
		
		$shop_isle_slider_pl_decoded = json_decode($shop_isle_slider_pl);
		
		if ( !empty($shop_isle_slider_pl_decoded) ) {
		
			foreach($shop_isle_slider_pl_decoded as $shop_isle_slider){
				
				if( !empty($shop_isle_slider->id) ) {
					$id = $shop_isle_slider->id;
				}
				$text = $shop_isle_slider->text;
				$subtext = $shop_isle_slider->subtext;
				$image_url = $shop_isle_slider->image_url;
				$link = $shop_isle_slider->link;
				$label = $shop_isle_slider->label;
				
				if(!empty($id)) {

					if(!empty($image_url)){
						icl_unregister_string( 'Slide '.$id, 'Slide image' );
						icl_register_string( 'Slide '.$id, 'Slide image', $image_url );
					} else {
						icl_unregister_string( 'Slide '.$id, 'Slide image' );
					}

					if(!empty($text)){
						icl_unregister_string( 'Slide '. $id, 'Slide text' );
						icl_register_string( 'Slide '. $id, 'Slide text', $text );
					} else {
						icl_unregister_string( 'Slide '. $id, 'Slide text' );
					}

					if(!empty($subtext)){
						icl_unregister_string( 'Slide '.$id, 'Slide subtext' );
						icl_register_string( 'Slide '.$id, 'Slide subtext',$subtext );
					} else {
						icl_unregister_string( 'Slide '.$id, 'Slide subtext' );
					}

					if(!empty($link)){
						icl_unregister_string( 'Slide '.$id, 'Slide button link' );
						icl_register_string( 'Slide '.$id, 'Slide button link', $link );
					} else {
						icl_unregister_string( 'Slide '.$id, 'Slide button link' );
					}

					if(!empty($label)){
						icl_unregister_string( 'Slide '.$id, 'Slide button label' );
						icl_register_string( 'Slide '.$id, 'Slide button label', $label );
					} else {
						icl_unregister_string( 'Slide '.$id, 'Slide button label' );
					}
				}
			}
		}	
	}
	
	/* Banners section */
	
	$shop_isle_banners_pl = get_theme_mod('shop_isle_banners');
	
	if( !empty($shop_isle_banners_pl) ) {
		
		$shop_isle_banners_pl_decoded = json_decode($shop_isle_banners_pl);
		
		if ( !empty($shop_isle_banners_pl_decoded) ) {
		
			foreach($shop_isle_banners_pl_decoded as $shop_isle_banners){
				
				if( !empty($shop_isle_banners->id) ) {
					$id = $shop_isle_banners->id;
				}

				$image_url = $shop_isle_banners->image_url;
				$link = $shop_isle_banners->link;

				if(!empty($id)) {

					if(!empty($link)){
						icl_unregister_string( 'Banner '.$id, 'Banner link' );
						icl_register_string( 'Banner '.$id, 'Banner link', $link );
					} else {
						icl_unregister_string( 'Banner '.$id, 'Banner link' );
					}

					if(!empty($image_url)){
						icl_unregister_string( 'Banner '.$id, 'Banner image' );
						icl_register_string( 'Banner '.$id, 'Banner image', $image_url );
					} else {
						icl_unregister_string( 'Banner '.$id, 'Banner image' );
					}
					
				}
			}
		}	
	}
	
	/*Footer socials */
	
	$shop_isle_socials_pl = get_theme_mod('shop_isle_socials');
	
	if( !empty($shop_isle_socials_pl) ) {
		
		$shop_isle_socials_pl_decoded = json_decode($shop_isle_socials_pl);
		
		if ( !empty($shop_isle_socials_pl_decoded) ) {
		
			foreach($shop_isle_socials_pl_decoded as $shop_isle_socials){
				
				if( !empty($shop_isle_socials->id) ) {
					$id = $shop_isle_socials->id;
				}
				$icon_value = $shop_isle_socials->icon_value;
				$link = $shop_isle_socials->link;

				if(!empty($id)) {
					if(!empty($icon_value)){
						icl_unregister_string( 'Social '.$id, 'Social icon' );
						icl_register_string( 'Social '.$id, 'Social icon', $icon_value );
					} else {
						icl_unregister_string( 'Social '.$id, 'Social icon' );
					}
					if(!empty($link)){
						icl_unregister_string( 'Social '.$id, 'Social link' );
						icl_register_string( 'Social '.$id, 'Social link', $link );
					} else {
						icl_unregister_string( 'Social '.$id, 'Social link' );
					}
				}
			}
		}	
	}
	
	/*************************/
    /***	About us page  ***/
	/*************************/
	
	
	/* Our team */
	$shop_isle_team_members_pl = get_theme_mod('shop_isle_team_members');
	
	if( !empty($shop_isle_team_members_pl) ) {
		
		$shop_isle_team_members_pl_decoded = json_decode($shop_isle_team_members_pl);
		
		if ( !empty($shop_isle_team_members_pl_decoded) ) {
		
			foreach($shop_isle_team_members_pl_decoded as $shop_isle_team_members){
				
				if( !empty($shop_isle_team_members->id) ) {
					$id = $shop_isle_team_members->id;
				}
				$image_url = $shop_isle_team_members->image_url;
				$text = $shop_isle_team_members->text;
				$subtext = $shop_isle_team_members->subtext;
				$description = $shop_isle_team_members->description;

				if(!empty($id)) {
					if(!empty($image_url)){
						icl_unregister_string( 'Team member '.$id, 'Team member image' );
						icl_register_string( 'Team member '.$id, 'Team member image', $image_url );
					} else {
						icl_unregister_string( 'Team member '.$id, 'Team member image' );
					}

					if(!empty($text)){
						icl_unregister_string( 'Team member '.$id, 'Team member name' );
						icl_register_string( 'Team member '.$id, 'Team member name', $text );
					} else {
						icl_unregister_string( 'Team member '.$id, 'Team member name' );
					}

					if(!empty($subtext)){
						icl_unregister_string( 'Team member '.$id, 'Team member job' );
						icl_register_string( 'Team member '.$id, 'Team member job', $subtext );
					} else {
						icl_unregister_string( 'Team member '.$id, 'Team member job' );
					}

					if(!empty($description)){
						icl_unregister_string( 'Team member '.$id, 'Team member description' );
						icl_register_string( 'Team member '.$id, 'Team member description', $description );
					} else {
						icl_unregister_string( 'Team member '.$id, 'Team member description' );
					}
					
				}
			}
		}	
	}
	
	// /* Our advantages */
	$shop_isle_advantages_pl = get_theme_mod('shop_isle_advantages');
	
	if( !empty($shop_isle_advantages_pl) ) {
		
		$shop_isle_advantages_pl_decoded = json_decode($shop_isle_advantages_pl);
		
		if ( !empty($shop_isle_advantages_pl_decoded) ) {
		
			foreach($shop_isle_advantages_pl_decoded as $shop_isle_advantages){
				
				if( !empty($shop_isle_advantages->id) ) {
					$id = $shop_isle_advantages->id;
				}
				$icon_value = $shop_isle_advantages->icon_value;
				$text = $shop_isle_advantages->text;
				$subtext = $shop_isle_advantages->subtext;
				
				if(!empty($id)) {
					if(!empty($icon_value)){
						icl_unregister_string( 'Advantage '.$id, 'Advantage icon' );
						icl_register_string( 'Advantage '.$id, 'Advantage icon',$icon_value );
					} else {
						icl_unregister_string( 'Advantage '.$id, 'Advantage icon' );
					}

					if(!empty($text)){
						icl_unregister_string( 'Advantage '.$id, 'Advantage text' );
						icl_register_string( 'Advantage '.$id, 'Advantage text', $text );
					} else {
						icl_unregister_string( 'Advantage '.$id, 'Advantage text' );
					}

					if(!empty($subtext)){
						icl_unregister_string( 'Advantage '.$id ,'Advantage subtext' );
						icl_register_string( 'Advantage '.$id ,'Advantage subtext', $subtext );
					} else {
						icl_unregister_string( 'Advantage '.$id ,'Advantage subtext' );
					}
					
				}
			}
		}	
	}
	
	
	
}
