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

	'layout' => array(

		'reviews_summary_section_title'          => array(
			'name' => __( 'Review summary options', 'yith-woocommerce-advanced-reviews' ),
			'type' => 'title',
			'desc' => '',
			'id'   => 'ywar_settings_review_summary_title',
		),
		'review_summary_bar_color'               => array(
			'name'    => __( 'Background bar color', 'yith-woocommerce-advanced-reviews' ),
			'type'    => 'color',
			'desc'    => '',
			'id'      => 'ywar_summary_bar_color',
			'default' => '#f4f4f4'
		),
		'reviews_summary_percentage_bar_color'   => array(
			'name'    => __( 'Percentage bar color', 'yith-woocommerce-advanced-reviews' ),
			'type'    => 'color',
			'desc'    => '',
			'id'      => 'ywar_summary_percentage_bar_color',
			'default' => '#a9709d'
		),
		'reviews_summary_percentage_value'       => array(
			'name'    => __( 'Show percentage value', 'yith-woocommerce-advanced-reviews' ),
			'type'    => 'checkbox',
			'desc'    => __( 'Show % value on percentage bars.', 'yith-woocommerce-advanced-reviews' ),
			'id'      => 'ywar_summary_percentage_value',
			'default' => 'yes'
		),
		'reviews_summary_percentage_value_color' => array(
			'name'    => __( 'Percentage value color', 'yith-woocommerce-advanced-reviews' ),
			'type'    => 'color',
			'desc'    => '',
			'id'      => 'ywar_summary_percentage_value_color',
			'default' => '#a9709d'
		),
		'reviews_summary_end'                    => array(
			'type' => 'sectionend',
			'id'   => 'ywar_settings_reviews_summary_end'
		),
	),
);