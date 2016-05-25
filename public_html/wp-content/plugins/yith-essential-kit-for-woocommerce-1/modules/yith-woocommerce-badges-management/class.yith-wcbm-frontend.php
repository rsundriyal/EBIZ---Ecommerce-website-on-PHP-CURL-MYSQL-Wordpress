<?php
/**
 * Frontend class
 *
 * @author  Yithemes
 * @package YITH WooCommerce Badge Management
 * @version 1.1.1
 */

if ( !defined( 'YITH_WCBM' ) ) {
    exit;
} // Exit if accessed directly

require_once( 'functions.yith-wcbm.php' );

if ( !class_exists( 'YITH_WCBM_Frontend' ) ) {
    /**
     * Frontend class.
     * The class manage all the Frontend behaviors.
     *
     * @since 1.0.0
     */
    class YITH_WCBM_Frontend {

        /**
         * Single instance of the class
         *
         * @var \YITH_WCBM_Frontend
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */
        public $version = YITH_WCBM_VERSION;

        /**
         * @type bool
         */
        private $is_in_sidebar = false;

        /**
         * @type bool
         * @since 1.2.7
         */
        private $is_in_minicart = false;

        /**
         * Returns single instance of the class
         *
         * @return \YITH_WCBM_Frontend
         * @since 1.0.0
         */
        public static function get_instance() {
            if ( is_null( self::$instance ) ) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Constructor
         *
         * @access public
         * @since  1.0.0
         */
        public function __construct() {

            // Action to add custom badge in single product page
            add_filter( 'woocommerce_single_product_image_html', array( $this, 'show_badge_on_product' ), 10, 2 );

            // add frontend css
            add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

            // edit sale flash badge
            add_filter( 'woocommerce_sale_flash', array( $this, 'sale_flash' ), 10, 2 );

            // POST Thumbnail [to add custom badge in shop page]
            add_filter( 'post_thumbnail_html', array( $this, 'add_box_thumb' ), 999, 2 );

            // action to set this->is_in_sidebar
            add_action( 'dynamic_sidebar_before', array( $this, 'set_is_in_sidebar' ) );
            add_action( 'dynamic_sidebar_after', array( $this, 'unset_is_in_sidebar' ) );

            // action to set this->is_in_minicart
            add_action( 'woocommerce_before_mini_cart', array( $this, 'set_is_in_minicart' ) );
            add_action( 'woocommerce_after_mini_cart', array( $this, 'unset_is_in_minicart' ) );
        }

        public function add_box_thumb( $thumb, $post_id ) {
            return $this->show_badge_on_product( $thumb, $post_id );
        }

        /**
         * Set this->is in minicart to true
         *
         * @access public
         * @since  1.2.7
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function set_is_in_minicart() {
            $this->is_in_minicart = true;
        }

        /**
         * Set this->is in minicart to false
         *
         * @access public
         * @since  1.2.7
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function unset_is_in_minicart() {
            $this->is_in_minicart = false;
        }

        /**
         * Set this->is in sidebar to true
         *
         * @access public
         * @since  1.1.4
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function set_is_in_sidebar() {
            $this->is_in_sidebar = true;
        }

        /**
         * Set this->is in sidebar to false
         *
         * @access public
         * @since  1.1.4
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function unset_is_in_sidebar() {
            $this->is_in_sidebar = false;
        }

        /**
         * Return true if is in sidebar
         *
         * @access public
         * @return bool
         * @since  1.1.4
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function is_in_sidebar() {
            return $this->is_in_sidebar;
        }

        /**
         * Return true if is in email
         *
         * @access public
         * @return bool
         * @since  1.2.15 [premium]
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function is_in_email() {
            return !!did_action( 'woocommerce_email_header' );
        }

        /**
         * Return true if is allowed badge showing
         * for example prevent badge showing in Wishilist Emails
         *
         * @access public
         * @return bool
         * @since  1.2.16 [premium]
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function is_allowed_badge_showing() {
            $hide_in_sidebar = get_option( 'yith-wcbm-hide-in-sidebar', 'yes' ) == 'yes';
            $show_in_sidebar = !$hide_in_sidebar;

            $allowed = ( !$this->is_in_sidebar() || $show_in_sidebar );
            $allowed = $allowed && !is_cart() && !$this->is_in_minicart;
            $allowed = $allowed && !is_checkout();
            $allowed = $allowed && !$this->is_in_email();
            $allowed = $allowed && !did_action( 'send_yith_waitlist_mail_instock' );
            $allowed = $allowed && !did_action( 'send_yith_waitlist_mail_subscribe' );

            return $allowed;
        }

        /**
         * Hide or show default sale flash badge
         *
         * @access public
         * @return string
         *
         * @param $val string value of filter woocommerce_sale_flash
         *
         * @since  1.0.0
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function sale_flash( $val, $post ) {
            $hide_on_sale_default = get_option( 'yith-wcbm-hide-on-sale-default' ) == 'yes' ? true : false;

            $product_id = $post->ID;
            $product_id = $this->get_wpml_parent_id( $product_id );

            $badge_overrides_default_on_sale = get_option( 'yith-wcbm-product-badge-overrides-default-on-sale', 'yes' ) == 'yes';

            $bm_meta  = get_post_meta( $product_id, '_yith_wcbm_product_meta', true );
            $id_badge = ( isset( $bm_meta[ 'id_badge' ] ) ) ? $bm_meta[ 'id_badge' ] : '';

            if ( $hide_on_sale_default || ( $id_badge != '' && $badge_overrides_default_on_sale ) ) {
                return '';
            }

            return $val;
        }


        /**
         * Get the badge Id based on current language
         *
         * @access public
         * @return int
         *
         * @param $id_badge string id of badge
         *
         * @since  1.0.0
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function get_wmpl_badge_id( $id_badge ) {
            return $id_badge;
        }

        /**
         * Edit image in products
         *
         * @access public
         * @return string
         *
         * @param $val string product image
         *
         * @since  1.0.0
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function show_badge_on_product( $val, $product_id ) {
            // prevent multiple badge copies
            if ( strpos( $val, 'container-image-and-badge' ) > 0 || !$this->is_allowed_badge_showing() )
                return $val;

            $product_id = $this->get_wpml_parent_id( $product_id );
            $bm_meta    = get_post_meta( $product_id, '_yith_wcbm_product_meta', true );
            $id_badge   = ( isset( $bm_meta[ 'id_badge' ] ) ) ? $bm_meta[ 'id_badge' ] : '';

            $badge_container = "<div class='container-image-and-badge'>" . $val;
            $badge_content   = '';

            if ( !defined( 'YITH_WCBM_PREMIUM' ) ) {
                $badge_content .= yith_wcbm_get_badge( $id_badge, $product_id );
            } else {
                $badge_content .= yith_wcbm_get_badges_premium( $id_badge, $product_id );
            }

            if ( empty( $badge_content ) )
                return $val;

            $badge_container .= $badge_content . "</div><!--container-image-and-badge-->";

            return $badge_container;

        }

        public function enqueue_scripts() {
            wp_enqueue_style( 'yith_wcbm_badge_style', YITH_WCBM_ASSETS_URL . '/css/frontend.css' );
            wp_enqueue_style( 'googleFontsOpenSans', '//fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' );
        }

        public function get_wpml_parent_id( $id, $post_type = 'product' ) {

            global $sitepress;
            if ( isset( $sitepress ) ) {

                $default_language = $sitepress->get_default_language();

                if ( function_exists( 'icl_object_id' ) ) {
                    $id = icl_object_id( $id, $post_type, true, $default_language );
                } else {
                    if ( function_exists( 'wpml_object_id_filter' ) ) {
                        $id = wpml_object_id_filter( $id, $post_type, true, $default_language );
                    }
                }
            }

            return $id;
        }
    }
}
/**
 * Unique access to instance of YITH_WCBM_Frontend class
 *
 * @return \YITH_WCBM_Frontend
 * @since 1.0.0
 */
function YITH_WCBM_Frontend() {
    return YITH_WCBM_Frontend::get_instance();
}

?>
