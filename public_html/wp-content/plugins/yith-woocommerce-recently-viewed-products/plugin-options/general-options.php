<?php
/**
 * GENERAL ARRAY OPTIONS
 */

$general = array(

	'general'  => array(

		array(
			'title' => __( 'General Options', 'yith-woocommerce-recently-viewed-products' ),
			'type' => 'title',
			'desc' => '',
			'id' => 'yith-wrvp-general-options'
		),

		array(
			'id'		=> 'yith-wrvp-section-title',
			'title'		=> __( 'Section title', 'yith-woocommerce-recently-viewed-products' ),
			'desc'		=> __( 'The title of the plugin section in single product page', 'yith-woocommerce-recently-viewed-products' ),
			'type'		=> 'text',
			'default' 	=> __( 'You may be interested in:', 'yith-woocommerce-recently-viewed-products' ),
			'css'      	=> 'min-width:300px;',
		),

		array(
			'id'		=> 'yith-wrvp-cookie-time',
			'title'		=> __( 'Set cookie time', 'yith-woocommerce-recently-viewed-products' ),
			'desc'		=> __( 'Set the duration (days) of the cookie that tracks customer viewed products.', 'yith-woocommerce-recently-viewed-products' ),
			'type'		=> 'text',
			'default' 	=> '30'
		),

		array(
			'id'				=> 'yith-wrvp-num-products',
			'title'				=> __( 'Set number of products', 'yith-woocommerce-recently-viewed-products' ),
			'desc'				=> __( 'Set how many products to show in plugin section (set -1 to display all).', 'yith-woocommerce-recently-viewed-products' ),
			'type'				=> 'number',
			'default' 			=> '4',
			'custom_attributes' => array(
				'min'	=> '-1'
			)
		),

		array(
			'id'		=> 'yith-wrvp-hide-out-of-stock',
			'title'		=> __( 'Hide out-of-stock products', 'yith-woocommerce-recently-viewed-products' ),
			'desc'		=> __( 'Choose whether to exclude products that are out-of-stock', 'yith-woocommerce-recently-viewed-products' ),
			'type'		=> 'checkbox',
			'default' 	=> 'no'
		),

		array(
			'type'      => 'sectionend',
			'id'        => 'yith-wrvp-end-general-options'
		)
	)
);

return apply_filters( 'yith_wrvp_panel_general_options', $general );