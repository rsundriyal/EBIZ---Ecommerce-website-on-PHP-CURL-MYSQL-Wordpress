<?php
/**
 * Frontend class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Zoom Magnifier
 * @version 1.1.2
 */

if ( ! defined ( 'YITH_WCMG' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists ( 'YITH_WCMG_Frontend' ) ) {
    /**
     * Admin class.
     * The class manage all the Frontend behaviors.
     *
     * @since 1.0.0
     */
    class YITH_WCMG_Frontend {


        /**
         * Constructor
         *
         * @access public
         * @since  1.0.0
         */
        public function __construct ( ) {

            // add the action only when the loop is initializate
            add_action ( 'template_redirect', array ( $this, 'render' ) );
        }

        public function render () {
            if ( yith_wcmg_is_enabled () && ! apply_filters ( 'yith_wczm_featured_video_enabled', false ) ) {
                //change the templates
                remove_action ( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
                remove_action ( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
                add_action ( 'woocommerce_before_single_product_summary', array ( $this, 'show_product_images' ), 20 );
                add_action ( 'woocommerce_product_thumbnails', array ( $this, 'show_product_thumbnails' ), 20 );

                //custom styles and javascripts
                add_action ( 'wp_enqueue_scripts', array ( $this, 'enqueue_styles_scripts' ) );

                //add attributes to product variations
                add_filter ( 'woocommerce_available_variation', array ( $this, 'available_variation' ), 10, 3 );
            }
        }


        /**
         * Change product-single.php template
         *
         * @access public
         * @return void
         * @since  1.0.0
         */
        public function show_product_images () {

            /** FIX WOO 2.1 */
            $wc_get_template = function_exists ( 'wc_get_template' ) ? 'wc_get_template' : 'woocommerce_get_template';
            $wc_get_template( 'single-product/product-image-magnifier.php', array (), '', YITH_YWZM_DIR . 'templates/' );
        }


        /**
         * Change product-thumbnails.php template
         *
         * @access public
         * @return void
         * @since  1.0.0
         */
        public function show_product_thumbnails () {

            /** FIX WOO 2.1 */
            $wc_get_template = function_exists ( 'wc_get_template' ) ? 'wc_get_template' : 'woocommerce_get_template';

            $wc_get_template( 'single-product/product-thumbnails-magnifier.php', array (), '', YITH_YWZM_DIR . 'templates/' );
        }


        /**
         * Enqueue styles and scripts
         *
         * @access public
         * @return void
         * @since  1.0.0
         */
        public function enqueue_styles_scripts () {
            global $post;

            $suffix = defined ( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

            wp_register_script ( 'yith-magnifier-slider',
                YITH_WCMG_URL . 'assets/js/jquery.carouFredSel' . $suffix . '.js',
                array (
                    'jquery',
                    'jquery-migrate',
                ),
                YITH_YWZM_VERSION,
                true );

            wp_register_script ( 'yith-magnifier',
                YITH_WCMG_URL . 'assets/js/yith_magnifier' . $suffix . '.js',
                array ( 'jquery' ),
                YITH_YWZM_VERSION,
                true );

            wp_register_script ( 'yith_wcmg_frontend',
                YITH_WCMG_URL . 'assets/js/frontend' . $suffix . '.js',
                array (
                    'jquery',
                    'yith-magnifier',
                ),
                YITH_YWZM_VERSION,
                true );

            wp_register_style ( 'yith-magnifier', YITH_WCMG_URL . 'assets/css/yith_magnifier.css' );

            if ( is_product () || ( ! empty( $post->post_content ) && strstr ( $post->post_content, '[product_page' ) ) ) {
                wp_enqueue_script ( 'yith-magnifier-slider' );
                wp_enqueue_script ( 'yith-magnifier' );
                wp_enqueue_script ( 'yith_wcmg_frontend' );

                wp_enqueue_style ( 'yith-magnifier' );

                $css = file_exists ( get_stylesheet_directory () . '/woocommerce/yith_magnifier.css' ) ? get_stylesheet_directory_uri () . '/woocommerce/yith_magnifier.css' : YITH_WCMG_URL . 'assets/css/frontend.css';
                wp_enqueue_style ( 'yith_wcmg_frontend', $css );
                /*
                    $append_text_css = '.yith_magnifier_zoom_wrap::after {
                        content: "' . __ ( "Roll over image to zoom in", "yith-woocommerce-zoom-magnifier" ) . '";
                        margin: 0 auto;
                        display: inline-block;
                        text-align:center;
                        font-size: 10px;
                        }
                    ';

                    wp_add_inline_style ( 'yith_wcmg_frontend', $append_text_css );
                */
            }
        }


        /**
         * Add attributes to product variations
         *
         * @access public
         * @return void
         * @since  1.0.0
         */
        public function available_variation ( $data, $wc_prod, $variation ) {

            $attachment_id = get_post_thumbnail_id ( $variation->get_variation_id () );
            $attachment    = wp_get_attachment_image_src ( $attachment_id, 'shop_magnifier' );

            $data[ 'image_magnifier' ] = $attachment ? current ( $attachment ) : '';

            return $data;
        }

    }
}
