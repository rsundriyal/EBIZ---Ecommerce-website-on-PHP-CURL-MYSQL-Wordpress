<?php
/**
 * Frontend class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Ajax Navigation
 * @version 1.3.2
 */

if ( ! defined( 'YITH_WCAN' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCAN_Frontend' ) ) {
    /**
     * Frontend class.
     * The class manage all the frontend behaviors.
     *
     * @since 1.0.0
     */
    class YITH_WCAN_Frontend {
        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */
        public $version;

        /**
         * Constructor
         *
         * @access public
         * @since  1.0.0
         */
        public function __construct( $version ) {
            $this->version = $version;

            //Actions
            add_action( 'init', array( $this, 'woocommerce_layered_nav_init' ), 99 );

            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );

            add_action( 'body_class', array( $this, 'body_class' ) );

            // YITH WCAN Loaded
            do_action( 'yith_wcan_loaded' );
        }

        /**
         * Enqueue frontend styles and scripts
         *
         * @access public
         * @return void
         * @since  1.0.0
         */
        public function enqueue_styles_scripts() {
            if ( yith_wcan_can_be_displayed() ) {
                $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

                wp_enqueue_style( 'yith-wcan-frontend', YITH_WCAN_URL . 'assets/css/frontend.css', false, $this->version );
                wp_enqueue_script( 'yith-wcan-script', YITH_WCAN_URL . 'assets/js/yith-wcan-frontend' . $suffix . '.js', array( 'jquery' ), $this->version, true );

                $custom_style = yith_wcan_get_option( 'yith_wcan_custom_style', '' );

                ! empty( $custom_style ) && wp_add_inline_style( 'yith-wcan-frontend', sanitize_text_field( $custom_style ) );

                $args = apply_filters( 'yith_wcan_ajax_frontend_classes', array(
                        'container'             => yith_wcan_get_option('yith_wcan_ajax_shop_container', '.products'),
                        'pagination'            => yith_wcan_get_option('yith_wcan_ajax_shop_pagination', 'nav.woocommerce-pagination'),
                        'result_count'          => yith_wcan_get_option('yith_wcan_ajax_shop_result_container', '.woocommerce-result-count'),
                        'wc_price_slider'       => array(
                            'wrapper'   => '.price_slider',
                            'min_price' => '.price_slider_amount #min_price',
                            'max_price' => '.price_slider_amount #max_price',
                        ),
                        'is_mobile'             => wp_is_mobile(),
                        'scroll_top'            => yith_wcan_get_option('yith_wcan_ajax_scroll_top_class', '.yit-wcan-container'),
                        'change_browser_url'    => 'yes' == yith_wcan_get_option( 'yith_wcan_change_browser_url', 'yes' ) ? true : false
                    )
                );

                wp_localize_script( 'yith-wcan-script', 'yith_wcan', apply_filters( 'yith-wcan-frontend-args', $args ) );
            }
        }


        /**
         * Layered Nav Init
         *
         * @package    WooCommerce/Widgets
         * @access     public
         * @return void
         */
        public function woocommerce_layered_nav_init() {

            if ( is_active_widget( false, false, 'yith-woo-ajax-navigation', true ) && ! is_admin() ) {

                global $_chosen_attributes, $woocommerce;

                $_chosen_attributes = array();

                /* FIX TO WOOCOMMERCE 2.1 */
                $attibute_taxonomies = function_exists( 'wc_get_attribute_taxonomies' ) ? $attribute_taxonomies = wc_get_attribute_taxonomies() :  $attribute_taxonomies = $woocommerce->get_attribute_taxonomies();

                if ( $attribute_taxonomies ) {
                    foreach ( $attribute_taxonomies as $tax ) {

                        $attribute = wc_sanitize_taxonomy_name( $tax->attribute_name );

                        /* FIX TO WOOCOMMERCE 2.1 */
                        if ( function_exists( 'wc_attribute_taxonomy_name' ) ) {
                            $taxonomy = wc_attribute_taxonomy_name( $attribute );
                        }
                        else {
                            $taxonomy = $woocommerce->attribute_taxonomy_name( $attribute );
                        }

                        $name            = 'filter_' . $attribute;
                        $query_type_name = 'query_type_' . $attribute;

                        if ( ! empty( $_GET[$name] ) && taxonomy_exists( $taxonomy ) ) {

                            $_chosen_attributes[ $taxonomy ]['terms'] = explode( ',', $_GET[ $name ] );

                            if ( empty( $_GET[ $query_type_name ] ) || ! in_array( strtolower( $_GET[ $query_type_name ] ), array( 'and', 'or' ) ) )
                                $_chosen_attributes[ $taxonomy ]['query_type'] = apply_filters( 'woocommerce_layered_nav_default_query_type', 'and' );
                            else
                                $_chosen_attributes[ $taxonomy ]['query_type'] = strtolower( $_GET[ $query_type_name ] );

                        }
                    }
                }

                if ( version_compare( preg_replace( '/-beta-([0-9]+)/', '', $woocommerce->version ), '2.1', '<' ) ) {
                    add_filter( 'loop_shop_post_in', 'woocommerce_layered_nav_query' );
                }
                else {
                    add_filter( 'loop_shop_post_in', array( WC()->query, 'layered_nav_query' ) );
                }


            }
        }

        /**
         * Add a body class(es)
         *
         * @param $classes The classes array
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0
         * @return array
         */
        public function body_class( $classes ) {
            $classes[] = apply_filters( 'yith_wcan_body_class',  'yith-wcan-free' );
            return $classes;
        }
    }
}
