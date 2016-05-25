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

$custom_attributes = defined( 'YITH_YWAR_PREMIUM' ) ? '' : array( 'disabled' => 'disabled' );
return array(

	'premium' => array(

		'section_vote_system_settings'     => array(
			'name' => __( 'Voting system', 'yith-woocommerce-advanced-reviews' ),
			'type' => 'title',
			'id'   => 'ywar_section_general'
		),
		'vote_system_enable'               => array(
			'name'              => __( 'Show vote section', 'yith-woocommerce-advanced-reviews' ),
			'type'              => 'checkbox',
			'desc'              => __( 'Allow user to upvote or downvote a review.', 'yith-woocommerce-advanced-reviews' ),
			'id'                => 'ywar_enable_vote_system',
			'custom_attributes' => $custom_attributes,
			'default'           => 'yes'
		),
		'vote_system_show_peoples_choice'  => array(
			'name'              => __( 'Show review votes', 'yith-woocommerce-advanced-reviews' ),
			'type'              => 'checkbox',
			'desc'              => __( 'Add a string stating how many people consider the review useful.', 'yith-woocommerce-advanced-reviews' ),
			'id'                => 'ywar_show_peoples_vote',
			'custom_attributes' => $custom_attributes,
			'default'           => 'yes'
		),
		'section_vote_system_settings_end' => array(
			'type' => 'sectionend',
			'id'   => 'ywar_section_general_end'
		),
		'section_reviews_settings'         => array(
			'name'              => __( 'Reviews settings', 'yith-woocommerce-advanced-reviews' ),
			'type'              => 'title',
			'custom_attributes' => $custom_attributes,
			'id'                => 'ywar_section_reviews'
		),
		'show_how_many_reviews'            => array(
			'name'              => __( 'How many reviews to show', 'yith-woocommerce-advanced-reviews' ),
			'type'              => 'number',
			'desc'              => __( 'Limit how many reviews to show (0 for unlimited).', 'yith-woocommerce-advanced-reviews' ),
			'id'                => 'comments_per_page', //  modify wordpress discussion setting
			'custom_attributes' => $custom_attributes,

			'default'           => '0'
		),
		'show_load_more'                   => array(
			'name'              => __( 'Show the "load more" link', 'yith-woocommerce-advanced-reviews' ),
			'type'              => 'select',
			'desc'              => __( 'Choose to show a textual link or a button to load additionally reviews.', 'yith-woocommerce-advanced-reviews' ),
			'id'                => 'ywar_show_load_more',
			'options'           => array(
				'1' => __( 'Don\'t show', 'yith-woocommerce-advanced-reviews' ),
				'2' => __( 'Show textual link', 'yith-woocommerce-advanced-reviews' ),
				'3' => __( 'Show button', 'yith-woocommerce-advanced-reviews' )
			),
			'custom_attributes' => $custom_attributes,

			'default'           => '1'
		),
		'show_reviews_dialog'              => array(
			'name'              => __( 'Modal window', 'yith-woocommerce-advanced-reviews' ),
			'type'              => 'checkbox',
			'desc'              => __( 'Show reviews filtered by users rating in a modal window.', 'yith-woocommerce-advanced-reviews' ),
			'id'                => 'ywar_reviews_dialog',
			'custom_attributes' => $custom_attributes,

			'default'           => 'no'
		),
		'reply_to_review'                  => array(
			'name'              => __( 'Reply to review', 'yith-woocommerce-advanced-reviews' ),
			'type'              => 'select',
			'desc'              => __( 'Choose who can reply to a review.', 'yith-woocommerce-advanced-reviews' ),
			'id'                => 'ywar_reply_to_review',
			'options'           => array(
				'1' => __( 'No one can reply', 'yith-woocommerce-advanced-reviews' ),
				'2' => __( 'Only administrators can reply', 'yith-woocommerce-advanced-reviews' ),
				'3' => __( 'Everyone can reply', 'yith-woocommerce-advanced-reviews' )
			),
			'custom_attributes' => $custom_attributes,

			'default'           => '2'
		),
		'load_more_text'                   => array(
			'name'              => __( 'Load more text', 'yith-woocommerce-advanced-reviews' ),
			'type'              => 'text',
			'desc'              => __( 'Text to show inside textual link or button.', 'yith-woocommerce-advanced-reviews' ),
			'id'                => 'ywar_load_more_text',
			'custom_attributes' => $custom_attributes,

			'default'           => __( 'Load more', 'yith-woocommerce-advanced-reviews' )
		),
		'section_reviews_settings_end'     => array(
			'type' => 'sectionend',
			'id'   => 'ywar_section_reviews_end'
		)
	)
);