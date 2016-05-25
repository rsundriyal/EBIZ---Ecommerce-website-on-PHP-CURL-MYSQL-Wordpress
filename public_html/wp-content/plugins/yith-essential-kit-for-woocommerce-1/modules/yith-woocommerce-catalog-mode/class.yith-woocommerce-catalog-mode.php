<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( !class_exists( 'YITH_WC_Catalog_Mode' ) ) {

    /**
     * Implements features of YITH WooCommerce Catalog Mode plugin
     *
     * @class   YITH_WC_Catalog_Mode
     * @package Yithemes
     * @since   1.0.0
     * @author  Your Inspiration Themes
     */
    class YITH_WC_Catalog_Mode {

        /**
         * Panel object
         *
         * @var     /Yit_Plugin_Panel object
         * @since   1.0.0
         * @see     plugin-fw/lib/yit-plugin-panel.php
         */
        protected $_panel;

        /**
         * @var $_premium string Premium tab template file name
         */
        protected $_premium = 'premium.php';

        /**
         * @var string Premium version landing link
         */
        protected $_premium_landing = 'http://yithemes.com/themes/plugins/yith-woocommerce-catalog-mode/';

        /**
         * @var string Plugin official documentation
         */
        protected $_official_documentation = 'http://yithemes.com/docs-plugins/yith-woocommerce-catalog-mode/';

        /**
         * @var string Yith WooCommerce Catalog Mode panel page
         */
        protected $_panel_page = 'yith_wc_catalog_mode_panel';

        /**
         * Single instance of the class
         *
         * @var \YITH_WC_Catalog_Mode
         * @since 1.3.0
         */
        protected static $instance;

        /**
         * Returns single instance of the class
         *
         * @return \YITH_WC_Catalog_Mode
         * @since 1.3.0
         */
        public static function get_instance() {

            if ( is_null( self::$instance ) ) {

                self::$instance = new self;

            }

            return self::$instance;

        }

        /**
         * Constructor
         *
         * Initialize plugin and registers actions and filters to be used
         *
         * @since   1.0.0
         * @return  mixed
         * @author  Alberto Ruggiero
         */
        public function __construct() {

            if ( !function_exists( 'WC' ) ) {
                return;
            }

            // Load Plugin Framework
            add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 12 );

            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename( YWCTM_DIR . '/' . basename( YWCTM_FILE ) ), array( $this, 'action_links' ) );
            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

            //  Add stylesheets and scripts files
            add_action( 'admin_menu', array( $this, 'add_menu_page' ), 5 );
            add_action( 'yith_catalog_mode_premium', array( $this, 'premium_tab' ) );

            if ( get_option( 'ywctm_enable_plugin' ) == 'yes' && $this->check_user_admin_enable() ) {

                if ( !is_admin() || $this->is_quick_view() ) {

                    if ( get_option( 'ywctm_hide_cart_header' ) == 'yes' ) {

                        $priority = has_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ) );
                        remove_action( 'wp_loaded', array( 'WC_Form_Handler', 'add_to_cart_action' ), $priority );

                    }

                    add_action( 'wp', array( $this, 'check_pages_redirect' ) );
                    add_action( 'get_pages', array( $this, 'hide_cart_checkout_pages' ) );
                    add_action( 'woocommerce_single_product_summary', array( $this, 'hide_add_to_cart_single' ), 10 );
                    add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'hide_add_to_cart_loop' ), 5 );
                    add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
                    add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'avoid_add_to_cart' ), 10, 2 );

                    if ( defined( 'YITH_WCWL' ) && YITH_WCWL ) {
                        add_filter( 'woocommerce_loop_add_to_cart_link', array( $this, 'hide_add_to_cart_wishlist' ), 10, 2 );
                    }

                }

            }

        }

        /**
         * ADMIN FUNCTIONS
         */

        /**
         * Add a panel under YITH Plugins tab
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         * @use     /Yit_Plugin_Panel class
         * @see     plugin-fw/lib/yit-plugin-panel.php
         */
        public function add_menu_page() {

            if ( !empty( $this->_panel ) ) {
                return;
            }

            $admin_tabs = array();

            if ( defined( 'YWCTM_PREMIUM' ) ) {
                $admin_tabs['premium-settings'] = __( 'Settings', 'yith-woocommerce-catalog-mode' );
                $admin_tabs['exclusions']       = __( 'Exclusion List', 'yith-woocommerce-catalog-mode' );
                $admin_tabs['custom-url']       = __( 'Custom Button Url List', 'yith-woocommerce-catalog-mode' );

                if ( YITH_WCTM()->is_multivendor_active() ) {
                    $admin_tabs['vendors'] = __( 'Vendor Exclusion List', 'yith-woocommerce-catalog-mode' );
                }

            }
            else {
                $admin_tabs['settings']        = __( 'Settings', 'yith-woocommerce-catalog-mode' );
                $admin_tabs['premium-landing'] = __( 'Premium Version', 'yith-woocommerce-catalog-mode' );
            }


            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => __( 'Catalog Mode', 'yith-woocommerce-catalog-mode' ),
                'menu_title'       => __( 'Catalog Mode', 'yith-woocommerce-catalog-mode' ),
                'capability'       => 'manage_options',
                'parent'           => '',
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'admin-tabs'       => $admin_tabs,
                'options-path'     => YWCTM_DIR . '/plugin-options'
            );

            $this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
        }

        /**
         * FRONTEND FUNCTIONS
         */

        /**
         * Check if Catalog mode must be applied to current user
         *
         * @since   1.3.0
         *
         * @param   $post_id
         *
         * @return  bool
         * @author  Alberto Ruggiero
         */
        public function apply_catalog_mode( $post_id ) {

            $target_users = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_hide_price_users' ), $post_id, 'ywctm_hide_price_users' );

            if ( $target_users == 'country' && defined( 'YWCTM_PREMIUM' ) ) {

                return $this->country_check( $post_id );

            }
            elseif ( $target_users == 'all' ) {

                return true;

            }
            else {

                return !is_user_logged_in();

            }

        }

        /**
         * Check if catalog mode is enabled for administrator
         *
         * @since   1.0.2
         * @return  bool
         * @author  Alberto Ruggiero
         */
        public function check_user_admin_enable() {

            return !( current_user_can( 'administrator' ) && is_user_logged_in() && get_option( 'ywctm_admin_view' ) == 'no' );

        }

        /**
         * Checks if "Cart & Checkout pages" needs to be hidden
         *
         * @since   1.0.2
         * @return  bool
         * @author  Alberto Ruggiero
         */
        public function check_hide_cart_checkout_pages() {

            return get_option( 'ywctm_enable_plugin' ) == 'yes' && $this->check_user_admin_enable() && get_option( 'ywctm_hide_cart_header' ) == 'yes';

        }

        /**
         * Hides "Add to cart" button from single product page
         *
         * @since   1.0.0
         *
         * @param   $action
         *
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function hide_add_to_cart_single( $action = '' ) {

            if ( $action == '' ) {
                $action = 'woocommerce_single_product_summary';
            }

            $priority = has_action( $action, 'woocommerce_template_single_add_to_cart' );

            if ( $this->check_add_to_cart_single( $priority ) ) {

                add_action( 'woocommerce_before_add_to_cart_button', array( $this, 'hide_add_to_cart_quick_view' ), 10 );

            }

        }

        /**
         * Hide add to cart button in quick view
         *
         * @since   1.0.7
         * @return  mixed
         * @author  Francesco Licandro
         */
        public function hide_add_to_cart_quick_view() {

            $hide_variations = get_option( 'ywctm_hide_variations' );
            ob_start();

            $args = array(
                'form.cart button.single_add_to_cart_button'
            );

            if ( !class_exists( 'YITH_YWRAQ_Frontend' ) ) {

                $args[] = 'form.cart .quantity';

            }

            if ( $hide_variations == 'yes' ) {

                $args[] = 'table.variations';
                $args[] = 'form.variations_form';
                $args[] = '.single_variation_wrap .variations_button';

            }

            $classes = implode( ', ', apply_filters( 'ywctm_catalog_classes', $args ) );

            ?>
            <style>

                <?php echo $classes; ?>
                {
                    display: none !important
                }

            </style>
            <?php
            echo ob_get_clean();

        }

        /**
         * Check if price is hidden to hide add to cart button
         *
         * @since   1.0.4
         *
         * @param   $post_id
         *
         * @return  bool
         * @author  Alberto Ruggiero
         */
        public function check_price_hidden( $post_id ) {

            $hide = false;

            $hide_price = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_hide_price' ), $post_id, 'ywctm_hide_price' );

            if ( $hide_price == 'yes' ) {

                if ( $this->apply_catalog_mode( $post_id ) ) {

                    $enable_exclusion = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_exclude_hide_price' ), $post_id, 'ywctm_exclude_hide_price' );
                    $exclude_catalog  = apply_filters( 'ywctm_get_exclusion', get_post_meta( $post_id, '_ywctm_exclude_hide_price', true ), $post_id, '_ywctm_exclude_hide_price' );

                    $hide = ( $enable_exclusion != 'yes' ? true : ( $exclude_catalog != 'yes' ? true : false ) );

                    $reverse_criteria = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_exclude_hide_price_reverse' ), $post_id, 'ywctm_exclude_hide_price_reverse' );

                    if ( $enable_exclusion == 'yes' && $reverse_criteria == 'yes' ) {

                        $hide = !$hide;

                    }

                }

            }

            return $hide;

        }

        /**
         * Checks if "Add to cart" needs to be hidden
         *
         * @since   1.0.2
         *
         * @param   $priority
         * @param   $product_id
         *
         * @return  bool
         * @author  Alberto Ruggiero
         */
        public function check_add_to_cart_single( $priority = true, $product_id = false ) {

            $hide = false;

            if ( get_option( 'ywctm_enable_plugin' ) == 'yes' && $this->check_user_admin_enable() ) {

                if ( get_option( 'ywctm_hide_cart_header' ) == 'yes' ) {

                    $hide = true;

                }
                else {

                    global $post;

                    if ( !$product_id && !isset( $post ) ) {
                        return false;
                    }

                    $post_id = ( $product_id ) ? $product_id : $post->ID;

                    $hide_add_to_cart_single = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_hide_add_to_cart_single' ), $post_id, 'ywctm_hide_add_to_cart_single' );

                    if ( $hide_add_to_cart_single == 'yes' ) {

                        if ( $this->apply_catalog_mode( $post_id ) ) {

                            $enable_exclusion = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_exclude_hide_add_to_cart' ), $post_id, 'ywctm_exclude_hide_add_to_cart' );
                            $exclude_catalog  = apply_filters( 'ywctm_get_exclusion', get_post_meta( $post_id, '_ywctm_exclude_catalog_mode', true ), $post_id, '_ywctm_exclude_catalog_mode' );

                            if ( $priority ) {

                                $hide = ( $enable_exclusion != 'yes' ? true : ( $exclude_catalog != 'yes' ? true : false ) );

                            }

                            $reverse_criteria = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_exclude_hide_add_to_cart_reverse' ), $post_id, 'ywctm_exclude_hide_add_to_cart_reverse' );

                            if ( $enable_exclusion == 'yes' && $reverse_criteria == 'yes' ) {

                                $hide = !$hide;

                            }

                        }

                    }

                    if ( $this->check_price_hidden( $post_id ) ) {

                        $hide = true;

                    }

                }

            }

            return $hide;

        }

        /**
         * Checks if "Add to cart" needs to be avoided
         *
         * @since   1.0.5
         *
         * @param   $passed
         * @param   $product_id
         *
         * @return  bool
         * @author  Alberto Ruggiero
         */
        public function avoid_add_to_cart( $passed, $product_id ) {

            if ( get_option( 'ywctm_enable_plugin' ) == 'yes' && $this->check_user_admin_enable() ) {

                if ( get_option( 'ywctm_hide_cart_header' ) == 'yes' ) {

                    $passed = false;

                }
                else {

                    $hide_add_to_cart_single = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_hide_add_to_cart_single' ), $product_id, 'ywctm_hide_add_to_cart_single' );

                    if ( $hide_add_to_cart_single == 'yes' ) {

                        if ( $this->apply_catalog_mode( $product_id ) ) {

                            $enable_exclusion = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_exclude_hide_add_to_cart' ), $product_id, 'ywctm_exclude_hide_add_to_cart' );
                            $exclude_catalog  = apply_filters( 'ywctm_get_exclusion', get_post_meta( $product_id, '_ywctm_exclude_catalog_mode', true ), $product_id, '_ywctm_exclude_catalog_mode' );

                            $passed = ( $enable_exclusion != 'yes' ? false : ( $exclude_catalog != 'yes' ? false : true ) );

                            $reverse_criteria = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_exclude_hide_add_to_cart_reverse' ), $product_id, 'ywctm_exclude_hide_add_to_cart_reverse' );

                            if ( $enable_exclusion == 'yes' && $reverse_criteria == 'yes' ) {

                                $passed = !$passed;

                            }

                        }

                    }

                    if ( $this->check_price_hidden( $product_id ) ) {

                        $passed = false;

                    }

                }

            }

            return $passed;
        }

        /**
         * Checks if "Add to cart" needs to be hidden from loop page
         *
         * @since   1.0.6
         * @return  bool
         * @author  Alberto Ruggiero
         */
        public function check_hide_add_cart_loop() {

            $hide = false;

            if ( get_option( 'ywctm_hide_cart_header' ) == 'yes' ) {

                $hide = true;

            }
            else {

                global $post;

                $hide_add_to_cart_loop = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_hide_add_to_cart_loop' ), $post->ID, 'ywctm_hide_add_to_cart_loop' );
                $hide_variations       = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_hide_variations' ), $post->ID, 'ywctm_hide_variations' );

                $can_hide = true;
                $product  = wc_get_product( $post );

                if ( $product->product_type == 'variable' ) {

                    $can_hide = ( $hide_variations == 'yes' ? true : false );

                }


                if ( $hide_add_to_cart_loop == 'yes' ) {

                    if ( $this->apply_catalog_mode( $post->ID ) ) {

                        $enable_exclusion = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_exclude_hide_add_to_cart' ), $post->ID, 'ywctm_exclude_hide_add_to_cart' );
                        $exclude_catalog  = apply_filters( 'ywctm_get_exclusion', get_post_meta( $post->ID, '_ywctm_exclude_catalog_mode', true ), $post->ID, '_ywctm_exclude_catalog_mode' );

                        $hide = ( $enable_exclusion != 'yes' ? true : ( $exclude_catalog != 'yes' ? true : false ) );

                        if ( $product->product_type == 'variable' ) {

                            $hide = $can_hide;

                        }

                        $reverse_criteria = apply_filters( 'ywctm_get_vendor_option', get_option( 'ywctm_exclude_hide_add_to_cart_reverse' ), $post->ID, 'ywctm_exclude_hide_add_to_cart_reverse' );

                        if ( $enable_exclusion == 'yes' && $reverse_criteria == 'yes' ) {

                            $hide = !$hide;

                        }

                    }

                }

                if ( $this->check_price_hidden( $post->ID ) && $can_hide ) {

                    $hide = true;

                }


            }

            return $hide;
        }

        /**
         * Hides "Add to cart" button, if not excluded, from loop page
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function hide_add_to_cart_loop() {

            $ywctm_modify_woocommerce_after_shop_loop_item = apply_filters( 'ywctm_modify_woocommerce_after_shop_loop_item', true );

            if ( $this->check_hide_add_cart_loop() ) {

                if ( $ywctm_modify_woocommerce_after_shop_loop_item ) {
                    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
                }
                add_filter( 'woocommerce_loop_add_to_cart_link', '__return_empty_string', 10 );

            }
            else {

                if ( $ywctm_modify_woocommerce_after_shop_loop_item ) {
                    add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
                }

                remove_filter( 'woocommerce_loop_add_to_cart_link', '__return_empty_string', 10 );

            }

        }

        /**
         * Enqueue css file
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function enqueue_styles() {

            if ( get_option( 'ywctm_hide_cart_header' ) == 'yes' ) {

                $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

                wp_enqueue_style( 'ywctm-style', YWCTM_ASSETS_URL . '/css/yith-catalog-mode' . $suffix . '.css' );

            }

        }

        /**
         * Avoid Cart and Checkout Pages to be visited
         *
         * @since   1.0.4
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function check_pages_redirect() {

            if ( get_option( 'ywctm_hide_cart_header' ) == 'yes' ) {

                $cart     = is_page( wc_get_page_id( 'cart' ) );
                $checkout = is_page( wc_get_page_id( 'checkout' ) );

                wp_reset_query();

                if ( $cart || $checkout ) {

                    wp_redirect( home_url() );
                    exit;

                }

            }

        }

        /**
         * Removes Cart and checkout pages from menu
         *
         * @since   1.0.4
         *
         * @param   $pages
         *
         * @return  mixed
         * @author  Alberto Ruggiero
         */
        public function hide_cart_checkout_pages( $pages ) {

            if ( get_option( 'ywctm_hide_cart_header' ) == 'yes' ) {

                $excluded_pages = array(
                    wc_get_page_id( 'cart' ),
                    wc_get_page_id( 'checkout' )
                );

                for ( $i = 0; $i < count( $pages ); $i ++ ) {
                    $page = &$pages[$i];

                    if ( in_array( $page->ID, $excluded_pages ) ) {

                        unset( $pages[$i] );

                    }

                }

            }

            return $pages;

        }

        /**
         * Say if the code is execute by quick view
         *
         * @since    1.0.7
         * @return   bool
         * @author   Andrea Frascaspata <andrea.frascaspata@yithemes.com>
         */
        public function is_quick_view() {
            return defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['action'] ) && ( $_REQUEST['action'] == 'yith_load_product_quick_view' || $_REQUEST['action'] == 'yit_load_product_quick_view' );
        }

        /**
         * Hides add to cart on wishlist
         *
         * @since   1.2.2
         *
         * @param   $value
         * @param   $product
         *
         * @return  string
         * @author  Alberto Ruggiero
         */
        public function hide_add_to_cart_wishlist( $value, $product ) {

            global $yith_wcwl_is_wishlist;

            if ( $this->check_add_to_cart_single( true, $product->id ) && $yith_wcwl_is_wishlist ) {

                $value = '';

            }

            return $value;

        }

        /**
         * YITH FRAMEWORK
         */

        /**
         * Load plugin framework
         *
         * @since   1.0.0
         * @return  void
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function plugin_fw_loader() {
            if ( !defined( 'YIT_CORE_PLUGIN' ) ) {
                global $plugin_fw_data;
                if ( !empty( $plugin_fw_data ) ) {
                    $plugin_fw_file = array_shift( $plugin_fw_data );
                    require_once( $plugin_fw_file );
                }
            }
        }

        /**
         * Premium Tab Template
         *
         * Load the premium tab template on admin page
         *
         * @since   1.0.0
         * @return  void
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function premium_tab() {
            $premium_tab_template = YWCTM_TEMPLATE_PATH . '/admin/' . $this->_premium;
            if ( file_exists( $premium_tab_template ) ) {
                include_once( $premium_tab_template );
            }
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @return  string The premium landing link
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function get_premium_landing_uri() {
            return defined( 'YITH_REFER_ID' ) ? $this->_premium_landing . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing;
        }

        /**
         * Action Links
         *
         * add the action links to plugin admin page
         * @since   1.0.0
         *
         * @param   $links | links plugin array
         *
         * @return  mixed
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @use     plugin_action_links_{$plugin_file_name}
         */
        public function action_links( $links ) {

            $links[] = '<a href="' . admin_url( "admin.php?page={$this->_panel_page}" ) . '">' . __( 'Settings', 'yith-woocommerce-catalog-mode' ) . '</a>';

            if ( defined( 'YWCTM_FREE_INIT' ) ) {
                $links[] = '<a href="' . $this->get_premium_landing_uri() . '" target="_blank">' . __( 'Premium Version', 'yith-woocommerce-catalog-mode' ) . '</a>';
            }

            return $links;
        }

        /**
         * Plugin row meta
         *
         * add the action links to plugin admin page
         *
         * @since   1.0.0
         *
         * @param   $plugin_meta
         * @param   $plugin_file
         * @param   $plugin_data
         * @param   $status
         *
         * @return  array
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @use     plugin_row_meta
         */
        public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
            if ( ( defined( 'YWCTM_INIT' ) && ( YWCTM_INIT == $plugin_file ) ) ||
                ( defined( 'YWCTM_FREE_INIT' ) && ( YWCTM_FREE_INIT == $plugin_file ) )
            ) {

                $plugin_meta[] = '<a href="' . $this->_official_documentation . '" target="_blank">' . __( 'Plugin Documentation', 'yith-woocommerce-catalog-mode' ) . '</a>';
            }

            return $plugin_meta;
        }

    }

}