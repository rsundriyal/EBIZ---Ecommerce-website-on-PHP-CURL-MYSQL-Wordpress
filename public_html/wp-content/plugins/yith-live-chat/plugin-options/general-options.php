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

$firebase_url = '<a target="_blank" href="http://www.firebase.com">http://www.firebase.com</a>';

$defaults = YITH_Live_Chat()->defaults;

$vendor_only = ( defined( 'YLC_PREMIUM' ) && defined( 'YITH_WPV_PREMIUM' ) && YITH_WPV_PREMIUM ) ? array(
    'name' => __( 'Show popup only in vendors\' pages', 'yith-live-chat' ),
    'desc' => __( 'Show the chat popup only in vendors\' pages and hide it in entire shop pages (You must have enabled the premium version of YITH WooCommerce Multi Vendor)', 'yith-live-chat' ),
    'id'   => 'only-vendor-chat',
    'type' => 'on-off',
    'std'  => $defaults['only-vendor-chat'],
) : '';

$show_all_pages = ( defined( 'YLC_PREMIUM' ) && YLC_PREMIUM ) ? array(
    'name' => __( 'Show popup in all pages', 'yith-live-chat' ),
    'desc' => __( 'Show the chat popup in all pages', 'yith-live-chat' ),
    'id'   => 'showing-pages-all',
    'type' => 'on-off',
    'std'  => $defaults['showing-pages-all'],
) : '';

$selected_pages = ( defined( 'YLC_PREMIUM' ) && YLC_PREMIUM ) ? array(
    'name' => __( 'Pages selection', 'yith-live-chat' ),
    'desc' => __( 'Select the pages where you want to show the chat popup', 'yith-live-chat' ),
    'id'   => 'showing-pages',
    'type' => 'custom-select',
    'std'  => $defaults['showing-pages'],
) : '';

return array(
    'general' => array(
        /* =================== HOME =================== */
        'home'     => array(
            array(
                'name' => __( 'YITH Live Chat: General Settings', 'yith-live-chat' ),
                'type' => 'title'
            ),
            array(
                'type' => 'close'
            )
        ),
        /* =================== END SKIN =================== */

        /* =================== GENERAL =================== */
        'settings' => array(
            array(
                'name' => __( 'Enable Live Chat', 'yith-live-chat' ),
                'desc' => __( 'Activate/Deactivate the live chat features. ', 'yith-live-chat' ),
                'id'   => 'plugin-enable',
                'type' => 'on-off',
                'std'  => $defaults['plugin-enable']
            ),
            array(
                'name'              => __( 'Firebase App URL', 'yith-live-chat' ),
                'desc'              => __( 'URL of your Firebase application. If you don\'t have one, get a free Firebase application here: ', 'yith-live-chat' ) . $firebase_url,
                'id'                => 'firebase-appurl',
                'type'              => 'custom-text',
                'std'               => $defaults['firebase-appurl'],
                'custom_attributes' => array(
                    'required' => 'required',
                    'style'    => 'width: 200px'
                )
            ),
            array(
                'name'              => __( 'Firebase App Secret', 'yith-live-chat' ),
                'desc'              => __( 'It can be found under the "Secrets" menu in your Firebase app dashboard', 'yith-live-chat' ),
                'id'                => 'firebase-appsecret',
                'type'              => 'text',
                'std'               => $defaults['firebase-appsecret'],
                'custom_attributes' => array(
                    'required' => 'required',
                    'style'    => 'width: 100%'
                )
            ),
            $show_all_pages,
            $selected_pages,
            $vendor_only,
        )
    )
);