<?php

$frontend = array(

    'frontend' => array(

        'header'   => array(

            array( 'type' => 'open' ),

            array(
                'name' => __( 'Frontend Settings', 'yith-woocommerce-ajax-navigation' ),
                'type' => 'title'
            ),

            array( 'type' => 'close' )
        ),

        'settings' => array(

            array( 'type' => 'open' ),

            array(
                'id'   => 'yith_wcan_frontend_description',
                'name' => _x( 'How To:', 'Admin panel: option description', 'yith-woocommerce-ajax-navigation' ),
                'type' => 'wcan_description',
                'desc' => _x( "If your theme use the WooCommerce standard templates, you don't need to change the following values.
                                Otherwise, add the classes used in the template of your theme.
                                If you don't know them, please contact the developer of your theme to receive the correct classes.", 'Admin: Panel section description', 'yith-woocommerce-ajax-navigation' ),
            ),

            array(
                'name' => __( 'Product Container', 'yith-woocommerce-ajax-navigation' ),
                'desc' => __( 'Put here the CSS class or id for the product container', 'yith-woocommerce-ajax-navigation' ) . ' (Default: <strong>.products</strong>)',
                'id'   => 'yith_wcan_ajax_shop_container',
                'type' => 'text',
                'std'  => '.products'
            ),

            array(
                'name' => __( 'Shop Pagination Container', 'yith-woocommerce-ajax-navigation' ),
                'desc' => __( 'Put here the CSS class or id for the shop pagination container', 'yith-woocommerce-ajax-navigation' ) . ' (Default: <strong>nav.woocommerce-pagination</strong>)',
                'id'   => 'yith_wcan_ajax_shop_pagination',
                'type' => 'text',
                'std'  => 'nav.woocommerce-pagination'
            ),

            array(
                'name' => __( 'Result Count Container', 'yith-woocommerce-ajax-navigation' ),
                'desc' => __( 'Put here the CSS class or id for the result count container', 'yith-woocommerce-ajax-navigation' ) . ' (Default: <strong>.woocommerce-result-count</strong>)',
                'id'   => 'yith_wcan_ajax_shop_result_container',
                'type' => 'text',
                'std'  => '.woocommerce-result-count'
            ),

            array(
                'name' => __( 'Scroll top anchor', 'yith-woocommerce-ajax-navigation' ),
                'desc' => __( 'Put here the HTML tag for the scroll top in mobile', 'yith-woocommerce-ajax-navigation' ) . ' (Default: <strong>.yit-wcan-container</strong>)',
                'id'   => 'yith_wcan_ajax_scroll_top_class',
                'type' => 'text',
                'std'  => '.yit-wcan-container'
            ),

            array( 'type' => 'close' ),
        ),
    )
);

return apply_filters( 'yith_wcan_panel_frontend_options', $frontend );