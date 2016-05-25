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

global $yith_wcas;
return array(

	'settings' => array(

        'section_general_settings_videobox'         => array(
          'name' => __( 'Upgrade to the PREMIUM VERSION', 'yith-woocommerce-ajax-search' ),
          'type' => 'videobox',
          'default' => array(
              'plugin_name'        => __( 'YITH WooCommerce Ajax Search', 'yith-woocommerce-ajax-search' ),
              'title_first_column' => __( 'Discover the Advanced Features', 'yith-woocommerce-ajax-search' ),
              'description_first_column' => __('Upgrade to the PREMIUM VERSION
of YITH WOOCOMMERCE AJAX SEARCH to benefit from all features!', 'yith-woocommerce-ajax-search'),
              'video' => array(
                  'video_id'           => '118917627',
                  'video_image_url'    =>  YITH_WCAS_ASSETS_IMAGES_URL.'ajax-search-premium.jpg',
                  'video_description'  => __( 'YITH WooCommerce Ajax Search', 'yith-woocommerce-ajax-search' ),
              ),
              'title_second_column' => __( 'Get Support and Pro Features', 'yith-woocommerce-ajax-search' ),
              'description_second_column' => __('By purchasing the premium version of the plugin, you will take advantage of the advanced features of the product and you will get one year of free updates and support through our platform available 24h/24.', 'yith-woocommerce-ajax-search'),
              'button' => array(
                  'href' => $yith_wcas->obj->get_premium_landing_uri(),
                  'title' => 'Get Support and Pro Features'
              )
          ),
          'id'   => 'yith_wcas_general_videobox'
      ),

		'section_general_settings'          => array(
			'name' => __( 'General settings', 'yith-woocommerce-ajax-search' ),
			'type' => 'title',
			'custom_attributes' => array(
				'disabled' => 'disabled'
			),
			'id'   => 'yith_wcas_general'
		),

        'search_input_label' => array(
            'name' => __( 'Search input label', 'yith-woocommerce-ajax-search' ),
            'type'    => 'text',
            'desc' => __( 'Label for Search input field.', 'yith-woocommerce-ajax-search' ),
            'id'      => 'yith_wcas_search_input_label',
            'default' => __( 'Search for products', 'yith-woocommerce-ajax-search' ),
        ),

        'search_submit_label' => array(
            'name' => __( 'Search submit label', 'yith-woocommerce-ajax-search' ),
            'type'    => 'text',
            'desc' => __( 'Label for Search input field.', 'yith-woocommerce-ajax-search' ),
            'id'      => 'yith_wcas_search_submit_label',
            'default' => __( 'Search', 'yith-woocommerce-ajax-search' )
        ),

        'trigger_min_chars' => array(
            'name' => __( 'Minimum number of characters', 'yith-woocommerce-ajax-search' ),
            'desc' => __( 'Minimum number of characters required to trigger autosuggest.', 'yith-woocommerce-ajax-search' ),
            'id'   => 'yith_wcas_min_chars',
            'default' => '3',
            'css' 		=> 'width:50px;',
            'type' 		=> 'number',
            'custom_attributes' => array(
                'min' 	=> 1,
                'max'   => 10,
                'step' 	=> 1
            )
        ),

        'trigger_max_result_num' => array(
            'name' => __( 'Maximum number of results', 'yith-woocommerce-ajax-search' ),
            'desc' => __( 'Maximum number of results showed within the autosuggest box.', 'yith-woocommerce-ajax-search' ),
            'id'   => 'yith_wcas_posts_per_page',
            'default' => '3',
            'css' 		=> 'width:50px;',
            'type' 		=> 'number',
            'custom_attributes' => array(
                'min' 	=> 1,
                'max'   => 15,
                'step' 	=> 1
            )
        ),

        'section_ajax_search_settings_end'      => array(
            'type' => 'sectionend',
            'id'   => 'yith_wcas_general_end'
        )
	),
);