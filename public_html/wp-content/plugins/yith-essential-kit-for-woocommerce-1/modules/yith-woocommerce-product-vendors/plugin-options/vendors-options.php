<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

return apply_filters( 'yith_wpv_panel_vendors_options', array(

        'vendors' => array(

            'vendors_options_start' => array(
                'type' => 'sectionstart',
            ),

            'vendors_options_title' => array(
                'title' => __( 'Product management', 'yith_wc_product_vendors' ),
                'type'  => 'title',
                'desc'  => '',
                'id'    => 'yith_wpv_vendors_options_title'
            ),

            'vendors_color_name'    => array(
                'title'   => __( 'Vendor name label color', 'yith_wc_product_vendors' ),
                'type'    => 'color',
                'desc'    => __( 'Use in shop page and single product page', 'yith_wc_product_vendors' ),
                'id'      => 'yith_vendors_color_name',
                'default' => '#bc360a'
            ),

            'vendors_options_end'   => array(
                'type' => 'sectionend',
            ),

            'vendors_order_start'           => array(
                'type' => 'sectionstart',
            ),

            'vendors_order_title'           => array(
                'title' => __( 'Order management', 'yith_wc_product_vendors' ),
                'type'  => 'title',
                'desc'  => '',
                'id'    => 'yith_wpv_vendors_orders_title'
            ),

            'vendors_order_management'      => array(
                'title'   => __( 'Enable order management', 'yith_wc_product_vendors' ),
                'type'    => 'checkbox',
                'desc'    => __( 'If you enable this option, each vendor will be able to manage orders on his/her own products independently.', 'yith_wc_product_vendors' ),
                'id'      => 'yith_wpv_vendors_option_order_management',
                'default' => 'no'
            ),

            'vendors_order_synchronization' => array(
                'title'   => __( 'Order synchronization', 'yith_wc_product_vendors' ),
                'type'    => 'checkbox',
                'desc'    => __( "All changes to general orders will be synchronized with the individual vendor's order", 'yith_wc_product_vendors' ),
                'id'      => 'yith_wpv_vendors_option_order_synchronization',
                'default' => 'yes'
            ),

            'vendors_order_end'             => array(
                'type' => 'sectionend',
            ),
        )
    ), 'vendors'
);