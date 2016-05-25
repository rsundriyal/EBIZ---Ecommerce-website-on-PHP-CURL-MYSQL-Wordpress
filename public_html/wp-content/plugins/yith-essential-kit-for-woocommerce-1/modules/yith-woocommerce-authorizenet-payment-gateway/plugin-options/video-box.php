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

if ( ! defined( 'YITH_WCAUTHNET' ) ) {
	exit;
} // Exit if accessed directly

return array(
	'name' => __( 'Upgrade to the PREMIUM VERSION', 'yith-wcauthnet' ),
	'type' => 'videobox',
	'default' => array(
		'plugin_name'        => __( 'YITH WooCommerce Authorize.net', 'yith-wcauthnet' ),
		'title_first_column' => __( 'Discover the Advanced Features', 'yith-wcauthnet' ),
		'description_first_column' => __('Upgrade to the PREMIUM VERSION of YITH WooCommerce Authorize.net to benefit from all features!', 'yith-wcauthnet'),

		'video' => array(
			'video_id'           => '121450270',
			'video_image_url'    =>  YITH_WCAUTHNET_URL.'assets/images/yith-woocommerce-authorize-net.jpg',
			'video_description'  => __( 'YITH WooCommerce Authorize.net', 'yith-wcauthnet' ),
		),
		'title_second_column' => __( 'Get Support and Pro Features', 'yith-wcauthnet' ),
		'description_second_column' => __('By purchasing the premium version of the plugin, you will take advantage of the advanced features of the product and you will get one year of free updates and support through our platform available 24h/24.', 'yith-wcauthnet'),
		'button' => array(
			'href' => YITH_WCAUTHNET_Admin()->get_premium_landing_uri(),
			'title' => __( 'Get Support and Pro Features', 'yith-wcauthnet' )
		)
	),
	'id'   => 'yith_wcauthnet_general_videobox'
);