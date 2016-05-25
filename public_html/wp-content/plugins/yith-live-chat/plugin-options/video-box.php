<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

$videobox = defined( 'YLC_PREMIUM' ) ? array() : array(
    'name'    => __( 'Upgrade to the PREMIUM VERSION', 'yith-live-chat' ),
    'type'    => 'videobox',
    'default' => array(
        'plugin_name'               => __( 'YITH Live Chat', 'yith-live-chat' ),
        'title_first_column'        => __( 'Discover the Advanced Features', 'yith-live-chat' ),
        'description_first_column'  => __( 'Upgrade to the PREMIUM VERSION of YITH Live Chat to benefit from all the features!', 'yith-live-chat' ),
        'video'                     => array(
            'video_id'          => '127461393',
            'video_image_url'   => YLC_ASSETS_URL . '/images/yith-live-chat.jpg',
            'video_description' => __( 'YITH Live Chat', 'yith-live-chat' )
        ),
        'title_second_column'       => __( 'Get Support and Pro Features', 'yith-live-chat' ),
        'description_second_column' => __( 'By purchasing the premium version of the plugin, you will take advantage of the advanced features of the product, and you will get one year of free updates and support through our platform available 24h/24.', 'yith-live-chat' ),
        'button'                    => array(
            'href'  => YITH_Live_Chat()->get_premium_landing_uri(),
            'title' => 'Get Support and Pro Features'
        )
    ),
    'id'      => 'ylc_general_videobox'
);

return $videobox;
