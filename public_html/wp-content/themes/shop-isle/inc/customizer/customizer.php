<?php

/**
 *
 * Customizer
 *
 */

/**
 * Register settings and controls for customize
 *
 * @since  1.0.0
 */ 
function shop_isle_customize_register( $wp_customize ) {
	
	class ShopIsle_Contact_Page_Instructions extends WP_Customize_Control {
		public function render_content() {
			echo __( 'To customize the Contact Page you need to first select the template "Contact page" for the page you want to use for this purpose. Then open that page in the browser and press "Customize" in the top bar.','shop-isle' ).'<br><br>'. __( 'Need further assistance? Check out this','shop-isle' ).' <a href="http://docs.themeisle.com/article/211-shopisle-customizing-the-contact-and-about-us-page" target="_blank">'.__( 'doc','shop-isle' ).'</a>';
		}
	}
	
	class ShopIsle_Aboutus_Page_Instructions extends WP_Customize_Control {
		public function render_content() {
			echo __( 'To customize the About us Page you need to first select the template "About us page" for the page you want to use for this purpose. Then open that page in the browser and press "Customize" in the top bar.','shop-isle' ).'<br><br>'. __( 'Need further assistance? Check out this','shop-isle' ).' <a href="http://docs.themeisle.com/article/211-shopisle-customizing-the-contact-and-about-us-page" target="_blank">'.__( 'doc','shop-isle' ).'</a>';
		}
	}

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';

	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/******************************/
	/**********  Header ***********/
	/******************************/
	
	$wp_customize->add_section( 'shop_isle_header_section', array(
        'title'    => __( 'Header', 'shop-isle' ),
        'priority' => 40
    ) );
	
	/* Logo */
	$wp_customize->add_setting( 'shop_isle_logo', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'esc_url'
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'shop_isle_logo', array(
		'label'    => __( 'Logo', 'shop-isle' ),
		'section'  => 'shop_isle_header_section',
		'priority'    => 1,
	)));
	
	/*******************************/
	/******    Slider section ******/
	/*******************************/
	
	$wp_customize->add_section( 'shop_isle_slider_section' , array(
		'title'       => __( 'Slider section', 'shop-isle' ),
		'priority'    => 41
	));
	
	/* Hide slider */
	$wp_customize->add_setting( 'shop_isle_slider_hide', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_text'
	));

	$wp_customize->add_control(
		'shop_isle_slider_hide',
		array(
			'type' => 'checkbox',
			'label' => __('Hide slider section?','shop-isle'),
			'description' => __('If you check this box, the Slider section will disappear from homepage.','shop-isle'),
			'section' => 'shop_isle_slider_section',
			'priority'    => 1,
		)
	);
	
	/* Slider */
	$wp_customize->add_setting( 'shop_isle_slider', array(
		'sanitize_callback' => 'shop_isle_sanitize_repeater',
		'default' => json_encode(array( array('image_url' => get_template_directory_uri().'/assets/images/slide1.jpg' ,'link' => '#', 'text' => __('ShopIsle','shop-isle'), 'subtext' => __('WooCommerce Theme','shop-isle'), 'label' => __('FIND OUT MORE','shop-isle') ), array('image_url' => get_template_directory_uri().'/assets/images/slide2.jpg' ,'link' => '#', 'text' => __('ShopIsle','shop-isle'), 'subtext' => __('Hight quality store','shop-isle') , 'label' => __('FIND OUT MORE','shop-isle')), array('image_url' => get_template_directory_uri().'/assets/images/slide3.jpg' ,'link' => '#', 'text' => __('ShopIsle','shop-isle'), 'subtext' => __('Responsive Theme','shop-isle') , 'label' => __('FIND OUT MORE','shop-isle') ))))
	);
	
	$wp_customize->add_control( new Shop_Isle_Repeater_Controler( $wp_customize, 'shop_isle_slider', array(
		'label'   => __('Add new slide','shop-isle'),
		'section' => 'shop_isle_slider_section',
		'active_callback' => 'is_front_page',
		'priority' => 2,
        'shop_isle_image_control' => true,
        'shop_isle_text_control' => true,
        'shop_isle_link_control' => true,
		'shop_isle_subtext_control' => true,
		'shop_isle_label_control' => true,
		'shop_isle_icon_control' => false,
		'shop_isle_box_label' => __('Slide','shop-isle'),
		'shop_isle_box_add_label' => __('Add new slide','shop-isle')
	) ) );
	
	/********************************/
    /*********	Banners section *****/
	/********************************/
	
	$wp_customize->add_section( 'shop_isle_banners_section' , array(
		'title'       => __( 'Banners section', 'shop-isle' ),
		'priority'    => 42
	));
	
	/* Hide banner */
	$wp_customize->add_setting( 'shop_isle_banners_hide', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_text'
	));

	$wp_customize->add_control(
		'shop_isle_banners_hide',
		array(
			'type' => 'checkbox',
			'label' => __('Hide banners section?','shop-isle'),
			'description' => __('If you check this box, the Banners section will disappear from homepage.','shop-isle'),
			'section' => 'shop_isle_banners_section',
			'priority'    => 1,
		)
	);
	
	/* Banner */
	$wp_customize->add_setting( 'shop_isle_banners', array(
		'sanitize_callback' => 'shop_isle_sanitize_repeater',
		'default' => json_encode(array( array('image_url' => get_template_directory_uri().'/assets/images/banner1.jpg' ,'link' => '#' ),array('image_url' => get_template_directory_uri().'/assets/images/banner2.jpg' ,'link' => '#'),array('image_url' => get_template_directory_uri().'/assets/images/banner3.jpg' ,'link' => '#') ))
	));
	$wp_customize->add_control( new Shop_Isle_Repeater_Controler( $wp_customize, 'shop_isle_banners', array(
		'label'   => __('Add new banner','shop-isle'),
		'section' => 'shop_isle_banners_section',
		'active_callback' => 'is_front_page',
		'priority' => 2,
        'shop_isle_image_control' => true,
        'shop_isle_link_control' => true,
        'shop_isle_text_control' => false,
		'shop_isle_subtext_control' => false,
		'shop_isle_label_control' => false,
		'shop_isle_icon_control' => false,
		'shop_isle_description_control' => false,
		'shop_isle_box_label' => __('Banner','shop-isle'),
		'shop_isle_box_add_label' => __('Add new banner','shop-isle')
	) ) );
	
	
	/*********************************/
    /*******  Products section *******/
	/********************************/
	
	$wp_customize->add_section( 'shop_isle_products_section' , array(
		'title'       => __( 'Products section', 'shop-isle' ),
		'description' => __( 'If no shortcode or no category is selected , WooCommerce latest products are displaying.', 'shop-isle' ),
		'priority'    => 43
	));
	
	/* Hide products */
	$wp_customize->add_setting( 'shop_isle_products_hide', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_text'
	));

	$wp_customize->add_control( 'shop_isle_products_hide', array(
		'type' => 'checkbox',
		'label' => __('Hide products section?','shop-isle'),
		'description' => __('If you check this box, the Products section will disappear from homepage.','shop-isle'),
		'section' => 'shop_isle_products_section',
		'priority'    => 1,
	));
	
	/* Title */
	$wp_customize->add_setting( 'shop_isle_products_title', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'default' => __( 'Latest products', 'shop-isle' )
	));

	$wp_customize->add_control( 'shop_isle_products_title', array(
		'label'    => __( 'Section title', 'shop-isle' ),
		'section'  => 'shop_isle_products_section',
		'priority'    => 2,
	));
	
	/* Shortcode */
	$wp_customize->add_setting( 'shop_isle_products_shortcode', array(
		'sanitize_callback' => 'shop_isle_sanitize_text'
	));

	$wp_customize->add_control( 'shop_isle_products_shortcode', array(
		'label'    => __( 'WooCommerce shortcode', 'shop-isle' ),
		'section'  => 'shop_isle_products_section',
		'description'  => __( 'Insert a WooCommerce shortcode', 'shop-isle' ),
		'priority'    => 3,
	));
	
	$shop_isle_prod_categories_array = array('-' => __('Select category','shop-isle'));

	$shop_isle_prod_categories = get_categories( array('taxonomy' => 'product_cat', 'hide_empty' => 0, 'title_li' => '') );

	if( !empty($shop_isle_prod_categories) ):
		foreach ($shop_isle_prod_categories as $shop_isle_prod_cat):
		
			if( !empty($shop_isle_prod_cat->term_id) && !empty($shop_isle_prod_cat->name) ):
				$shop_isle_prod_categories_array[$shop_isle_prod_cat->term_id] = $shop_isle_prod_cat->name;
			endif;	
				
		endforeach;
	endif;
	
	/* Category */	
	$wp_customize->add_setting( 'shop_isle_products_category', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_text'
	));
	$wp_customize->add_control( 'shop_isle_products_category', array(
		'type' 		   => 'select',
		'label' 	   => __( 'Products category', 'shop-isle' ),
		'description'  => __( 'OR pick a product category', 'shop-isle' ),
		'section' 	   => 'shop_isle_products_section',
		'choices'      => $shop_isle_prod_categories_array,
		'priority' 	   => 4,
	));
	
	/****************************************/
	/*********** Video section **************/
	/****************************************/
	
	$wp_customize->add_section( 'shop_isle_video_section' , array(
		'title'       => __( 'Video section', 'shop-isle' ),
		'priority'    => 44
	));
	
	/* Hide video */
	$wp_customize->add_setting( 'shop_isle_video_hide', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_text'
	));

	$wp_customize->add_control( 'shop_isle_video_hide', array(
		'type' => 'checkbox',
		'label' => __('Hide video section?','shop-isle'),
		'description' => __('If you check this box, the Video section will disappear from homepage.','shop-isle'),
		'section' => 'shop_isle_video_section',
		'priority'    => 1,
	));
	
	/* Title */
	$wp_customize->add_setting( 'shop_isle_video_title', array(
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'transport' => 'postMessage'
	));

	$wp_customize->add_control( 'shop_isle_video_title', array(
		'label'    => __( 'Title', 'shop-isle' ),
		'section'  => 'shop_isle_video_section',
		'priority'    => 2,
	));
	
	/* Youtube link */
	$wp_customize->add_setting( 'shop_isle_yt_link', array(
		'sanitize_callback' => 'esc_url'
	));

	$wp_customize->add_control( 'shop_isle_yt_link', array(
		'label'    => __( 'Youtube link', 'shop-isle' ),
		'section'  => 'shop_isle_video_section',
		'priority'    => 3,
	));
	
	/****************************************/
    /*******  Products slider section *******/
	/****************************************/
	
	$wp_customize->add_section( 'shop_isle_products_slider_section' , array(
		'title'       => __( 'Products slider section', 'shop-isle' ),
		'description' => __( 'If no category is selected , WooCommerce products from the first category found are displaying.', 'shop-isle' ),
		'priority'    => 45
	));
	
	/* Hide products slider on frontpage */
	$wp_customize->add_setting( 'shop_isle_products_slider_hide', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_text'
	));

	$wp_customize->add_control(
		'shop_isle_products_slider_hide',
		array(
			'type' => 'checkbox',
			'label' => __('Hide products slider section on frontpage?','shop-isle'),
			'description' => __('If you check this box, the Products slider section will disappear from homepage.','shop-isle'),
			'section' => 'shop_isle_products_slider_section',
			'priority'    => 1,
		)
	);

	/* Hide products slider on single product page */
	$wp_customize->add_setting( 'shop_isle_products_slider_single_hide', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_text'
	));

	$wp_customize->add_control(
		'shop_isle_products_slider_single_hide',
		array(
			'type' => 'checkbox',
			'label' => __('Hide products slider section on single product page?','shop-isle'),
			'description' => __('If you check this box, the Products slider section will disappear from each single product page.','shop-isle'),
			'section' => 'shop_isle_products_slider_section',
			'priority'    => 2,
		)
	);
	
	/* Title */
	$wp_customize->add_setting( 'shop_isle_products_slider_title', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'default' => __( 'Exclusive products', 'shop-isle' )
		)
	);

	$wp_customize->add_control( 'shop_isle_products_slider_title', array(
		'label'    => __( 'Section title', 'shop-isle' ),
		'section'  => 'shop_isle_products_slider_section',
		'priority'    => 3,
	));
	
	/* Subtitle */
	$wp_customize->add_setting( 'shop_isle_products_slider_subtitle', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'default' => __( 'Special category of products', 'shop-isle' )
	));

	$wp_customize->add_control( 'shop_isle_products_slider_subtitle', array(
		'label'    => __( 'Section subtitle', 'shop-isle' ),
		'section'  => 'shop_isle_products_slider_section',
		'priority'    => 4,
	));
	
	/* Category */
	$wp_customize->add_setting( 'shop_isle_products_slider_category', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_text'
	));
	$wp_customize->add_control(
		'shop_isle_products_slider_category',
		array(
			'type' 		   => 'select',
			'label' 	   => __( 'Products category', 'shop-isle' ),
			'section' 	   => 'shop_isle_products_slider_section',
			'choices'      => $shop_isle_prod_categories_array,
			'priority' 	   => 5,
		)
	);
	
	/*******************************/
    /***********  Footer ***********/
	/*******************************/
	
	$wp_customize->add_section( 'shop_isle_footer_section', array(
        'title'    => __( 'Footer', 'shop-isle' ),
        'priority' => 50
    ) );
	
	/* Copyright */
	$wp_customize->add_setting( 'shop_isle_copyright', array(
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'default' => __( '&copy; Themeisle, All rights reserved', 'shop-isle'),
		'transport' => 'postMessage'
	));

	$wp_customize->add_control( 'shop_isle_copyright', array(
		'label'    => __( 'Copyright', 'shop-isle' ),
		'section'  => 'shop_isle_footer_section',
		'priority'    => 1,
	));

	/* Hide site info */
	$wp_customize->add_setting( 'shop_isle_site_info_hide', array(
		'transport' => 'postMessage',
		'sanitize_callback' => 'shop_isle_sanitize_text'
	));

	$wp_customize->add_control(
		'shop_isle_site_info_hide',
		array(
			'type' => 'checkbox',
			'label' => __('Hide site info?','shop-isle'),
			'description' => __('If you check this box, the Site info will disappear from footer.','shop-isle'),
			'section' => 'shop_isle_footer_section',
			'priority' => 2,
		)
	);
	
	/* socials */
	$wp_customize->add_setting( 'shop_isle_socials', array(
		'sanitize_callback' => 'shop_isle_sanitize_repeater',
		'default' => json_encode(array( array('icon_value' => 'social_facebook' ,'link' => '#' ),array('icon_value' => 'social_twitter' ,'link' => '#'), array('icon_value' => 'social_dribbble' ,'link' => '#'), array('icon_value' => 'social_skype' ,'link' => '#') )),
	));
	$wp_customize->add_control( new Shop_Isle_Repeater_Controler( $wp_customize, 'shop_isle_socials', array(
		'label'   => __('Add new social','shop-isle'),
		'section' => 'shop_isle_footer_section',
		'active_callback' => 'is_front_page',
		'priority' => 3,
        'shop_isle_image_control' => false,
        'shop_isle_link_control' => true,
        'shop_isle_text_control' => false,
		'shop_isle_subtext_control' => false,
		'shop_isle_label_control' => false,
		'shop_isle_icon_control' => true,
		'shop_isle_description_control' => false,
		'shop_isle_box_label' => __('Social','shop-isle'),
		'shop_isle_box_add_label' => __('Add new social','shop-isle')
	) ) );
	
	/*********************************/
	/******  Contact page  ***********/
	/*********************************/
	
	$wp_customize->add_section( 'shop_isle_contact_page_section', array(
        'title'    => __( 'Contact page', 'shop-isle' ),
        'priority' => 51
    ) );
	
	/* Contact Form  */
	$wp_customize->add_setting( 'shop_isle_contact_page_form_shortcode', array( 
		'sanitize_callback' => 'shop_isle_sanitize_text', 
	));
	
	$wp_customize->add_control( 'shop_isle_contact_page_form_shortcode', array(
		'label'    => __( 'Contact form shortcode', 'shop-isle' ),
		'description' => __('Create a form, copy the shortcode generated and paste it here. We recommend <a href="https://wordpress.org/plugins/contact-form-7/">Contact Form 7</a> but you can use any plugin you like.','shop-isle'),
		'section'  => 'shop_isle_contact_page_section',
		'active_callback' => 'shop_isle_is_contact_page',
		'priority'    => 1
	));
	
	/* Map ShortCode  */
	$wp_customize->add_setting( 'shop_isle_contact_page_map_shortcode', array( 
		'sanitize_callback' => 'shop_isle_sanitize_text',
	));
	
	$wp_customize->add_control( 'shop_isle_contact_page_map_shortcode', array(
		'label'    => __( 'Map shortcode', 'shop-isle' ),
		'description' => __('To use this section please install <a href="https://wordpress.org/plugins/intergeo-maps/">Intergeo Maps</a> plugin then use it to create a map and paste here the shortcode generated','shop-isle'),
		'section'  => 'shop_isle_contact_page_section',
		'active_callback' => 'shop_isle_is_contact_page',
		'priority'    => 2
	));
	
	/***********************************************************************************/
	/******  Contact page - instructions for users when not on Contact page  ***********/
	/***********************************************************************************/
	
	$wp_customize->add_section( 'shop_isle_contact_page_instructions', array(
        'title'    => __( 'Contact page', 'shop-isle' ),
        'priority' => 51
    ) );
	
	$wp_customize->add_setting( 'shop_isle_contact_page_instructions' );
	
	$wp_customize->add_control( new ShopIsle_Contact_Page_Instructions( $wp_customize, 'shop_isle_contact_page_instructions', array(
	    'section' => 'shop_isle_contact_page_instructions',
		'active_callback' => 'shop_isle_is_not_contact_page',
	)));
	
	
	
	/*********************************/
	/******  About us page  **********/
	/*********************************/
	
	if ( class_exists( 'WP_Customize_Panel' ) ):
	
		$wp_customize->add_panel( 'panel_team', array(
			'priority' => 52,
			'capability' => 'edit_theme_options',
			'theme_supports' => '',
			'title' => __( 'About us page', 'shop-isle' )
		) );
	
		$wp_customize->add_section( 'shop_isle_about_page_section', array(
			'title'    => __( 'Our team', 'shop-isle' ),
			'priority' => 1,
			'panel' => 'panel_team'
		) );
		
	else:
	
		$wp_customize->add_section( 'shop_isle_about_page_section', array(
			'title'    => __( 'About us page - our team', 'shop-isle' ),
			'priority' => 52
		) );

	endif;
	
	/* Our team title */
	$wp_customize->add_setting( 'shop_isle_our_team_title', array(
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'default' => __( 'Meet our team', 'shop-isle'), 
		'transport' => 'postMessage' 
	));

	$wp_customize->add_control( 'shop_isle_our_team_title', array(
		'label'    => __( 'Title', 'shop-isle' ),
		'section'  => 'shop_isle_about_page_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'    => 1,
	));
	
	/* Our team subtitle */
	$wp_customize->add_setting( 'shop_isle_our_team_subtitle', array(
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'default' => __( 'An awesome way to introduce the members of your team.', 'shop-isle'), 
		'transport' => 'postMessage'
	));

	$wp_customize->add_control( 'shop_isle_our_team_subtitle', array(
		'label'    => __( 'Subtitle', 'shop-isle' ),
		'section'  => 'shop_isle_about_page_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'    => 2,
	));
	
	/* Team members */
	$wp_customize->add_setting( 'shop_isle_team_members', array(
		'sanitize_callback' => 'shop_isle_sanitize_repeater',
		'default' => json_encode(array( array('image_url' => get_template_directory_uri().'/assets/images/team1.jpg' , 'text' => 'Eva Bean', 'subtext' => 'Developer', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.' ),array('image_url' => get_template_directory_uri().'/assets/images/team2.jpg' ,'text' => 'Maria Woods', 'subtext' => 'Designer', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.' ), array('image_url' => get_template_directory_uri().'/assets/images/team3.jpg' , 'text' => 'Booby Stone', 'subtext' => 'Director', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.'), array('image_url' => get_template_directory_uri().'/assets/images/team4.jpg' , 'text' => 'Anna Neaga', 'subtext' => 'Art Director', 'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit lacus, a iaculis diam.') )),
	));
	$wp_customize->add_control( new Shop_Isle_Repeater_Controler( $wp_customize, 'shop_isle_team_members', array(
		'label'   => __('Add new team member','shop-isle'),
		'section' => 'shop_isle_about_page_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority' => 3,
        'shop_isle_image_control' => true,
        'shop_isle_link_control' => false,
        'shop_isle_text_control' => true,
		'shop_isle_subtext_control' => true,
		'shop_isle_label_control' => false,
		'shop_isle_icon_control' => false,
		'shop_isle_description_control' => true,
		'shop_isle_box_label' => __('Team member','shop-isle'),
		'shop_isle_box_add_label' => __('Add new team member','shop-isle')
	) ) );
	
	/***********************************************************************************/
	/******  About us page - instructions for users when not on About us page  *********/
	/***********************************************************************************/
	
	$wp_customize->add_section( 'shop_isle_aboutus_page_instructions', array(
        'title'    => __( 'About us page', 'shop-isle' ),
        'priority' => 52
    ) );
	
	$wp_customize->add_setting( 'shop_isle_aboutus_page_instructions' );
	
	$wp_customize->add_control( new ShopIsle_Aboutus_Page_Instructions( $wp_customize, 'shop_isle_aboutus_page_instructions', array(
	    'section' => 'shop_isle_aboutus_page_instructions',
		'active_callback' => 'shop_isle_is_not_aboutus_page',
	)));
	
	
	if ( class_exists( 'WP_Customize_Panel' ) ):
	
		$wp_customize->add_section( 'shop_isle_about_page_video_section', array(
			'title'    => __( 'Video', 'shop-isle' ),
			'priority' => 2,
			'panel' => 'panel_team'
		) );
		
	else:
	
		$wp_customize->add_section( 'shop_isle_about_page_video_section', array(
			'title'    => __( 'About us page - video', 'shop-isle' ),
			'priority' => 53
		) );

	endif;
	
	/* Video title */
	$wp_customize->add_setting( 'shop_isle_about_page_video_title', array(
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'default' => __( 'Presentation', 'shop-isle'), 
		'transport' => 'postMessage'
	));

	$wp_customize->add_control( 'shop_isle_about_page_video_title', array(
		'label'    => __( 'Title', 'shop-isle' ),
		'section'  => 'shop_isle_about_page_video_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'    => 1,
	));
	
	/* Video subtitle */
	$wp_customize->add_setting( 'shop_isle_about_page_video_subtitle', array(
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'default' => __( 'What the video about our new products', 'shop-isle'), 
		'transport' => 'postMessage'
	));

	$wp_customize->add_control( 'shop_isle_about_page_video_subtitle', array(
		'label'    => __( 'Subtitle', 'shop-isle' ),
		'section'  => 'shop_isle_about_page_video_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'    => 2,
	));
	
	/* Video background */
	$wp_customize->add_setting( 'shop_isle_about_page_video_background', array(
		'default' => get_template_directory_uri().'/assets/images/background-video.jpg', 
		'transport' => 'postMessage',
		'sanitize_callback' => 'esc_url'
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'shop_isle_about_page_video_background', array(
		'label'    => __( 'Background', 'shop-isle' ),
		'section'  => 'shop_isle_about_page_video_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'    => 3,
	)));
	
	/* Video link */
	$wp_customize->add_setting( 'shop_isle_about_page_video_link', array(
		'sanitize_callback' => 'shop_isle_sanitize_text',
		'transport' => 'postMessage'
	));

	$wp_customize->add_control( 'shop_isle_about_page_video_link', array(
		'label'    => __( 'Video', 'shop-isle' ),
		'section'  => 'shop_isle_about_page_video_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'    => 4,
	));
	
	if ( class_exists( 'WP_Customize_Panel' ) ):
	
		$wp_customize->add_section( 'shop_isle_about_page_advantages_section', array(
			'title'    => __( 'Our advantages', 'shop-isle' ),
			'priority' => 3,
			'panel' => 'panel_team'
		) );
		
	else:
	
		$wp_customize->add_section( 'shop_isle_about_page_advantages_section', array(
			'title'    => __( 'About us page - our advantages', 'shop-isle' ),
			'priority' => 54
		) );

	endif;
	
	/* Our advantages title */
	$wp_customize->add_setting( 'shop_isle_our_advantages_title', array(
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'default' => __( 'Our advantages', 'shop-isle'), 
		'transport' => 'postMessage'
	));

	$wp_customize->add_control( 'shop_isle_our_advantages_title', array(
		'label'    => __( 'Title', 'shop-isle' ),
		'section'  => 'shop_isle_about_page_advantages_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority'    => 1,
	));
	
	/* Advantages */
	$wp_customize->add_setting( 'shop_isle_advantages', array(
		'sanitize_callback' => 'shop_isle_sanitize_repeater',
		'default' => json_encode(array( array('icon_value' => 'icon_lightbulb' , 'text' => __('Ideas and concepts','shop-isle'), 'subtext' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','shop-isle')), array('icon_value' => 'icon_tools' , 'text' => __('Designs & interfaces','shop-isle'), 'subtext' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','shop-isle')), array('icon_value' => 'icon_cogs' , 'text' => __('Highly customizable','shop-isle'), 'subtext' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','shop-isle')), array('icon_value' => 'icon_like', 'text' => __('Easy to use','shop-isle'), 'subtext' => __('Lorem ipsum dolor sit amet, consectetur adipiscing elit.','shop-isle')))), 
		));
		
	$wp_customize->add_control( new Shop_Isle_Repeater_Controler( $wp_customize, 'shop_isle_advantages', array(
		'label'   => __('Add new advantage','shop-isle'),
		'section' => 'shop_isle_about_page_advantages_section',
		'active_callback' => 'shop_isle_is_aboutus_page',
		'priority' => 2,
        'shop_isle_image_control' => false,
        'shop_isle_link_control' => false,
        'shop_isle_text_control' => true,
		'shop_isle_subtext_control' => true,
		'shop_isle_label_control' => false,
		'shop_isle_icon_control' => true,
		'shop_isle_description_control' => false,
		'shop_isle_box_label' => __('Advantage','shop-isle'),
		'shop_isle_box_add_label' => __('Add new advantage','shop-isle')
	) ) );
	
	/*********************************/
	/**********  404 page  ***********/
	/*********************************/
	
	$wp_customize->add_section( 'shop_isle_404_section', array(
        'title'    => __( '404 Not found page', 'shop-isle' ),
        'priority' => 54
    ) );
	
	/* Background */
	$wp_customize->add_setting( 'shop_isle_404_background', array(
		'default' => get_template_directory_uri().'/assets/images/404.jpg', 
		'transport' => 'postMessage',
		'sanitize_callback' => 'esc_url'
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'shop_isle_404_background', array(
		'label'    => __( 'Background image', 'shop-isle' ),
		'section'  => 'shop_isle_404_section',
		'priority'    => 1,
	)));
	
	/* Title */
	$wp_customize->add_setting( 'shop_isle_404_title', array(
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'default' => __( 'Error 404', 'shop-isle'), 
		'transport' => 'postMessage',
	));

	$wp_customize->add_control( 'shop_isle_404_title', array(
		'label'    => __( 'Title', 'shop-isle' ),
		'section'  => 'shop_isle_404_section',
		'priority'    => 2,
	));
	
	/* Text */
	$wp_customize->add_setting( 'shop_isle_404_text', array(
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'default' => __( 'The requested URL was not found on this server.<br> That is all we know.', 'shop-isle'), 
		'transport' => 'postMessage'
	));

	$wp_customize->add_control( 'shop_isle_404_text', array(
		'type' 		   => 'textarea',
		'label'    => __( 'Text', 'shop-isle' ),
		'section'  => 'shop_isle_404_section',
		'priority'    => 3,
	));
	
	/* Button link */
	$wp_customize->add_setting( 'shop_isle_404_link', array(
		'sanitize_callback' => 'esc_url', 
		'default' => '#', 
		'transport' => 'postMessage'
	));

	$wp_customize->add_control( 'shop_isle_404_link', array(
		'label'    => __( 'Button link', 'shop-isle' ),
		'section'  => 'shop_isle_404_section',
		'priority'    => 4,
	));
	
	/* Button label */
	$wp_customize->add_setting( 'shop_isle_404_label', array(
		'sanitize_callback' => 'shop_isle_sanitize_text', 
		'default' => __( 'Back to home page', 'shop-isle'), 
		'transport' => 'postMessage'
	));

	$wp_customize->add_control( 'shop_isle_404_label', array(
		'label'    => __( 'Button label', 'shop-isle' ),
		'section'  => 'shop_isle_404_section',
		'priority'    => 5,
	));
	
	/********************************************************/
	/************** ADVANCED OPTIONS  ***********************/
	/********************************************************/
	
	$wp_customize->add_section( 'shop_isle_general_section' , array(
		'title'       => __( 'Advanced options', 'shop-isle' ),
      	'priority'    => 55
	));
	
	$blogname = $wp_customize->get_control('blogname');
	$blogdescription = $wp_customize->get_control('blogdescription');
	$show_on_front = $wp_customize->get_control('show_on_front');
	$page_on_front = $wp_customize->get_control('page_on_front');
	$page_for_posts = $wp_customize->get_control('page_for_posts');
	
	if(!empty($blogname)):
		$blogname->section = 'shop_isle_general_section';
		$blogname->priority = 1;
	endif;
	
	if(!empty($blogdescription)):
		$blogdescription->section = 'shop_isle_general_section';
		$blogdescription->priority = 2;
	endif;
	
	if(!empty($show_on_front)):
		$show_on_front->section = 'shop_isle_general_section';
		$show_on_front->priority = 3;
	endif;
	
	if(!empty($page_on_front)):
		$page_on_front->section = 'shop_isle_general_section';
		$page_on_front->priority = 4;
	endif;
	
	if(!empty($page_for_posts)):
		$page_for_posts->section = 'shop_isle_general_section';
		$page_for_posts->priority = 5;
	endif;
	
	$wp_customize->remove_section('static_front_page');
	$wp_customize->remove_section('title_tagline');
	
	$nav_menu_locations_primary = $wp_customize->get_control('nav_menu_locations[primary]');
	if(!empty($nav_menu_locations_primary)){
		$nav_menu_locations_primary->section = 'shop_isle_general_section';
		$nav_menu_locations_primary->priority = 6;
	}
	
	/* Disable preloader */
	$wp_customize->add_setting( 'shop_isle_disable_preloader', array( 
		'sanitize_callback' => 'shop_isle_sanitize_text',
		'transport' => 'postMessage'
	));
	
	$wp_customize->add_control( 'shop_isle_disable_preloader', array(
		'type' => 'checkbox',
		'label' => __('Disable preloader?','shop-isle'),
		'description' => __('If this box is checked, the preloader will be disabled from homepage.','shop-isle'),
		'section' => 'shop_isle_general_section',
		'priority'    => 7,
	));
}

function shop_isle_is_contact_page() { 
	return is_page_template('template-contact.php');
};
function shop_isle_is_not_contact_page() { 
	return !is_page_template('template-contact.php');
};

function shop_isle_is_aboutus_page() { 
	return is_page_template('template-about.php');
};
function shop_isle_is_not_aboutus_page() { 
	return !is_page_template('template-about.php');
};

function shop_isle_sanitize_repeater($input){
	  
	$input_decoded = json_decode($input,true);
	$allowed_html = array(
								'br' => array(),
								'em' => array(),
								'strong' => array(),
								'a' => array(
									'href' => array(),
									'class' => array(),
									'id' => array(),
									'target' => array()
								),
								'button' => array(
									'class' => array(),
									'id' => array()
								)
							);
	
	
	if(!empty($input_decoded)) {
		foreach ($input_decoded as $boxk => $box ){
			foreach ($box as $key => $value){
				if ($key == 'text'){
					$value = html_entity_decode($value);
					$input_decoded[$boxk][$key] = wp_kses( $value, $allowed_html);
				} else {
					$input_decoded[$boxk][$key] = wp_kses_post( force_balance_tags( $value ) );
				}

			}
		}

		return json_encode($input_decoded);
	}
	
	return $input;
}

function wp_themeisle_customize_preview_js() {
	wp_enqueue_script( 'wp_themeisle_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'wp_themeisle_customize_preview_js' );