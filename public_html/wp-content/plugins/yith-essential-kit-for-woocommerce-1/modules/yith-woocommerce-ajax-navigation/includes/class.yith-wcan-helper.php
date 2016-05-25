<?php
/**
 * Main class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Ajax Navigation
 * @version 1.3.2
 */

if ( ! defined( 'YITH_WCAN' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAN_Helper' ) ) {
    /**
     * YITH WooCommerce Ajax Navigation Helper
     *
     * @since 1.0.0
     */
    class YITH_WCAN_Helper {

        /*
         * Get Woocommerce Attribute Taxonomies
         *
         * @since 1.0.0
         * @access public
         */
        public static function attribute_taxonomies() {
            global $woocommerce;

            if ( ! isset( $woocommerce ) ) {
                return array();
            }

            $attributes = array();
            if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
                $attribute_taxonomies = wc_get_attribute_taxonomies();
            }
            else {
                $attribute_taxonomies = $woocommerce->get_attribute_taxonomies();
            }

            if ( empty( $attribute_taxonomies ) ) {
                return array();
            }
            foreach ( $attribute_taxonomies as $attribute ) {

                /* FIX TO WOOCOMMERCE 2.1 */
                if ( function_exists( 'wc_attribute_taxonomy_name' ) ) {
                    $taxonomy = wc_attribute_taxonomy_name( $attribute->attribute_name );
                }
                else {
                    $taxonomy = $woocommerce->attribute_taxonomy_name( $attribute->attribute_name );
                }


                if ( taxonomy_exists( $taxonomy ) ) {
                    $attributes[] = $attribute->attribute_name;
                }
            }

            return $attributes;
        }

    }
}