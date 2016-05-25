<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


return array(

	'settings' => array(

        'section_general_settings_videobox'         => array(
            'name' => __( 'Upgrade to the PREMIUM VERSION', 'yith-woocommerce-request-a-quote' ),
            'type' => 'videobox',
            'default' => array(
                'plugin_name'        => __( 'YITH Woocommerce Request A Quote', 'yith-woocommerce-request-a-quote' ),
                'title_first_column' => __( 'Discover the Advanced Features', 'yith-woocommerce-request-a-quote' ),
                'description_first_column' => __('Upgrade to the PREMIUM VERSION of YITH Woocommerce Request A Quote to benefit from all features!', 'yith-woocommerce-request-a-quote'),
                'video' => array(
                    'video_id'           => '123722478',
                    'video_image_url'    =>  YITH_YWRAQ_ASSETS_URL.'/images/request-a-quote.jpg',
                    'video_description'  => __( 'YITH WooCommerce Request A Quote', 'yit' ),
                ),
                'title_second_column' => __( 'Get Support and Pro Features', 'yith-woocommerce-request-a-quote' ),
                'description_second_column' => __('By purchasing the premium version of the plugin, you will benefit from the advanced features of the product and you will get one year of free update and support through our platform available 24h/24.', 'yith-woocommerce-request-a-quote'),
                'button' => array(
                    'href' => YITH_YWRAQ_Admin()->get_premium_landing_uri(),
                    'title' => 'Get Support and Pro Features'
                )
            ),
            'id'   => 'yith_wraq_general_videobox'
        ),

		'section_general_settings'     => array(
			'name' => __( 'Request a Quote - General settings', 'yith-woocommerce-request-a-quote' ),
			'type' => 'title',
			'id'   => 'ywraq_section_general'
		),

        'page_id' => array(
            'name'     => __( 'Request Quote Page', 'yith-woocommerce-request-a-quote' ),
            'desc'     => __( 'Page contents: [yith_ywraq_request_quote]', 'yith-woocommerce-request-a-quote' ),
            'id'       => 'ywraq_page_id',
            'type'     => 'single_select_page',
            'class'    => 'yith-ywraq-chosen',
            'css'      => 'min-width:300px',
            'desc_tip' => false,
        ),

        'show_btn_link' => array(
            'name'    => __( 'Button type', 'yith-woocommerce-request-a-quote' ),
            'desc'    => '',
            'id'      => 'ywraq_show_btn_link',
            'type'    => 'select',
            'options' => array(
                'link'   => __( 'Link', 'yith-woocommerce-request-a-quote' ),
                'button' => __( 'Button', 'yith-woocommerce-request-a-quote' ),
            ),
            'default' => 'button',
        ),

        'show_btn_link_text' => array(
            'name'    => __( 'Button/Link text', 'yith-woocommerce-request-a-quote' ),
            'desc'    => '',
            'id'      => 'ywraq_show_btn_link_text',
            'type'    => 'text',
            'default' => __('Add to quote', 'yith-woocommerce-request-a-quote'),
        ),

        'hide_add_to_cart' => array(
            'name'    => __( 'Hide "Add to cart" button', 'yith-woocommerce-request-a-quote' ),
            'desc'    => '',
            'id'      => 'ywraq_hide_add_to_cart',
            'type'    => 'checkbox',
            'default' => 'no'
        ),


        'section_general_settings_end' => array(
			'type' => 'sectionend',
			'id'   => 'ywraq_section_general_end'
		)
	)
);