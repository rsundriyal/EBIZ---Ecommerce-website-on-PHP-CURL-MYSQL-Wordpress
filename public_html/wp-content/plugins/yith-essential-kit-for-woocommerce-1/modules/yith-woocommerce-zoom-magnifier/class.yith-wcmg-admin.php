<?php
/**
 * Admin class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce Zoom Magnifier
 * @version 1.1.2
 */

if ( ! defined( 'YITH_WCMG' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists( 'YITH_WCMG_Admin' ) ) {
    /**
     * Admin class.
     * The class manage all the admin behaviors.
     *
     * @since 1.0.0
     */
    class YITH_WCMG_Admin {
        /**
         * Plugin options
         *
         * @var array
         * @access public
         * @since 1.0.0
         */
        public $options = array();

        /**
         * Various links
         *
         * @var string
         * @access public
         * @since 1.0.0
         */
        public $banner_url = 'http://cdn.yithemes.com/plugins/yith_magnifier.php?url';
        public $banner_img = 'http://cdn.yithemes.com/plugins/yith_magnifier.php';
        public $doc_url = 'http://yithemes.com/docs-plugins/yith_magnifier/';

        /**
         * Constructor
         *
         * @access public
         * @since 1.0.0
         */
        public function __construct(  ) {

            //Actions
            add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );

            add_action( 'woocommerce_update_options_yith_wcmg', array( $this, 'update_options' ) );

            add_action( 'woocommerce_admin_field_banner', array( $this, 'admin_fields_banner' ) );
            add_action( 'admin_print_footer_scripts', array( $this, 'admin_fields_image_deps' ) );

	        add_filter( 'woocommerce_catalog_settings', array( $this, 'add_catalog_image_size' ) );

            //Apply filters
            $this->banner_url = apply_filters( 'yith_wcmg_banner_url', $this->banner_url );

            // YITH WCMG Loaded
            do_action( 'yith_wcmg_loaded' );
        }

        /**
         * Add Zoom Image size to Woocommerce -> Catalog
         *
         * @access public
         *
         * @param array $settings
         *
         * @return array
         */
        public function add_catalog_image_size( $settings ) {
            $tmp = $settings[count( $settings ) - 1];
            unset( $settings[count( $settings ) - 1] );

            $settings[] = array(
                'name'     => __( 'Image Size', 'yith-woocommerce-zoom-magnifier' ),
                'desc'     => __( 'The size of the images used within the magnifier box', 'yith-woocommerce-zoom-magnifier' ),
                'id'       => 'woocommerce_magnifier_image',
                'css'      => '',
                'type'     => 'image_width',
                'default'  => array(
                    'width'  => 600,
                    'height' => 600,
                    'crop'   => true
                ),
                'std'      => array(
                    'width'  => 600,
                    'height' => 600,
                    'crop'   => true
                ),
                'desc_tip' => true
            );
            $settings[] = $tmp;
            return $settings;
        }

        /**
         * Create new Woocommerce admin field: image deps
         *
         * @access public
         *
         * @param array $value
         *
         * @return void
         * @since 1.0.0
         */
        public function admin_fields_image_deps( $value ) {
            global $woocommerce;

            $force = get_option( 'yith_wcmg_force_sizes' ) == 'yes';

            if ( $force ) {
                $value['desc'] = 'These values ??are automatically calculated based on the values ??of the Single product. If you\'d like to customize yourself the values, please disable the "Forcing Zoom Image sizes" in "Magnifier" tab.';
            }

            if ( $force && isset( $_GET['page'] ) && isset( $_GET['tab'] ) && ( $_GET['page'] == 'woocommerce_settings' || $_GET['page'] == 'wc-settings' ) && $_GET['tab'] == 'catalog' ): ?>
                <script>
                    jQuery(document).ready(function ($) {
                        $('#woocommerce_magnifier_image-width, #woocommerce_magnifier_image-height, #woocommerce_magnifier_image-crop').attr('disabled', 'disabled');

                        $('#shop_single_image_size-width, #shop_single_image_size-height').on('keyup', function () {
                            var value = parseInt($(this).val());
                            var input = (this.id).indexOf('width') >= 0 ? 'width' : 'height';

                            if (!isNaN(value)) {
                                $('#woocommerce_magnifier_image-' + input).val(value * 2);
                            }
                        });

                        $('#shop_single_image_size-crop').on('change', function () {
                            if ($(this).is(':checked')) {
                                $('#woocommerce_magnifier_image-crop').attr('checked', 'checked');
                            } else {
                                $('#woocommerce_magnifier_image-crop').removeAttr('checked');
                            }
                        });

                        $('#mainform').on('submit', function () {
                            $(':disabled').removeAttr('disabled');
                        });
                    });
                </script>
            <?php endif;
        }


        /**
         * Enqueue admin styles and scripts
         *
         * @access public
         * @return void
         * @since 1.0.0
         */
        public function enqueue_styles_scripts() {
            wp_enqueue_script( 'jquery-ui' );
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-mouse' );
            wp_enqueue_script( 'jquery-ui-slider' );

            wp_enqueue_style( 'yith_wcmg_admin', YITH_WCMG_URL . 'assets/css/admin.css' );
        }
    }
}
