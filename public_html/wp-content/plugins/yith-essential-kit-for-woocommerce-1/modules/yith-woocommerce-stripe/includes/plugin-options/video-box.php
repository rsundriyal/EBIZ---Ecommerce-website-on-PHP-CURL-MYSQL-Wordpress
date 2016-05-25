<?php
/*  Copyright 2013  Your Inspiration Themes  (email : plugins@yithemes.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'YITH_WCSTRIPE' ) ) {
	exit;
} // Exit if accessed directly

return array(
	'name' => __( 'Upgrade to the PREMIUM VERSION', 'yith-stripe' ),
	'type' => 'videobox',
	'default' => array(
		'plugin_name'        => __( 'YITH WooCommerce Stripe', 'yith-stripe' ),
		'title_first_column' => __( 'Discover the Advanced Features', 'yith-stripe' ),
		'description_first_column' => __('Upgrade to the PREMIUM VERSION of YITH WooCommerce Stripe to benefit from all features!', 'yith-stripe'),

		'video' => array(
			'video_id'           => '121024640',
			'video_image_url'    =>  YITH_WCSTRIPE_URL.'assets/images/yith-woocommerce-stripe.jpg',
			'video_description'  => __( 'YITH WooCommerce Stripe', 'yit' ),
		),
		'title_second_column' => __( 'Get Support and Pro Features', 'yith-stripe' ),
		'description_second_column' => __('By purchasing the premium version of the plugin, you will take advantage of the advanced features of the product and you will get one year of free updates and support through our platform available 24h/24.', 'yith-stripe'),
		'button' => array(
			'href' => YITH_WCStripe()->admin->get_premium_landing_uri(),
			'title' => __( 'Get Support and Pro Features', 'yith-stripe' )
		)
	),
	'id'   => 'yith_stripe_general_videobox'
);