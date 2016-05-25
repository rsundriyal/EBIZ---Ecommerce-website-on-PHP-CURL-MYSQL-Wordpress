<?php
/**
 * Admin class
 *
 * @author  Yithemes
 * @package YITH WooCommerce Badge Management
 * @version 1.0.0
 */

if ( !defined( 'YITH_WCBM' ) ) {
    exit;
} // Exit if accessed directly

require_once( 'functions.yith-wcbm.php' );

if ( !class_exists( 'YITH_WCBM_Admin' ) ) {
    /**
     * Admin class.
     * The class manage all the admin behaviors.
     *
     * @since 1.0.0
     */
    class YITH_WCBM_Admin {

        /**
         * Single instance of the class
         *
         * @var \YITH_WCQV_Admin
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * Plugin options
         *
         * @var array
         * @access public
         * @since  1.0.0
         */
        public $options = array();

        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */
        public $version = YITH_WCBM_VERSION;

        /**
         * @var $_panel Panel Object
         */
        protected $_panel;

        /**
         * @var string Premium version landing link
         */
        protected $_premium_landing = 'https://yithemes.com/themes/plugins/yith-woocommerce-badges-management/';

        /**
         * @var string Quick View panel page
         */
        protected $_panel_page = 'yith_wcbm_panel';

        /**
         * Various links
         *
         * @var string
         * @access public
         * @since  1.0.0
         */
        public $doc_url    = 'http://yithemes.com/docs-plugins/yith-woocommerce-badges-management/';
        public $demo_url   = 'http://plugins.yithemes.com/yith-woocommerce-badge-management';
        public $yith_url   = 'http://www.yithemes.com';
        public $plugin_url = 'https://yithemes.com/themes/plugins/yith-woocommerce-badges-management/';

        /**
         * Returns single instance of the class
         *
         * @return \YITH_WCBM
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

            add_action( 'admin_menu', array( $this, 'register_panel' ), 5 );

            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename( YITH_WCBM_DIR . '/' . basename( YITH_WCBM_FILE ) ), array( $this, 'action_links' ) );
            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

            /* Registro il custom post_id type */
            add_action( 'init', array( $this, 'post_type_register' ) );
            // Add Capabilities to Administrator and Shop Manager
            add_action( 'admin_init', array( $this, 'add_capabilities' ) );

            // Action per le metabox
            add_action( 'save_post', array( $this, 'metabox_save' ) );
            add_action( 'save_post', array( $this, 'badge_settings_save' ) );

            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

            //add_action( 'woocommerce_product_options_general_product_data', array( $this, 'badge_settings_tabs' ) );

            add_action( 'add_meta_boxes', array( $this, 'badge_settings_metabox' ) );

            // Premium Tabs
            add_action( 'yith_wcbm_premium_tab', array( $this, 'show_premium_tab' ) );
        }

        /**
         * Return an array of links for the YITH Sidebar
         *
         * @return array
         */
        public function get_panel_sidebar_links() {
            $links = array(
                array(
                    'url'   => $this->yith_url,
                    'title' => __( 'Your Inspiration Themes', 'yith-woocommerce-badges-management' )
                ),
                array(
                    'url'   => $this->doc_url,
                    'title' => __( 'Plugin Documentation', 'yith-woocommerce-badges-management' )
                ),
                array(
                    'url'   => $this->plugin_url,
                    'title' => __( 'Plugin Site', 'yith-woocommerce-badges-management' )
                ),
                array(
                    'url'   => $this->demo_url,
                    'title' => __( 'Live Demo', 'yith-woocommerce-badges-management' )
                ),
            );

            return $links;
        }

        /**
         * Action Links
         *
         * add the action links to plugin admin page
         *
         * @param $links | links plugin array
         *
         * @return   mixed Array
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         * @return mixed
         * @use      plugin_action_links_{$plugin_file_name}
         */
        public function action_links( $links ) {

            $links[] = '<a href="' . admin_url( "admin.php?page={$this->_panel_page}" ) . '">' . __( 'Settings', 'yith-woocommerce-badges-management' ) . '</a>';
            if ( defined( 'YITH_WCBM_FREE_INIT' ) ) {
                $links[] = '<a href="' . $this->_premium_landing . '" target="_blank">' . __( 'Premium Version', 'ywcm' ) . '</a>';
            }

            return $links;
        }

        /**
         * plugin_row_meta
         *
         * add the action links to plugin admin page
         *
         * @param $plugin_meta
         * @param $plugin_file
         * @param $plugin_data
         * @param $status
         *
         * @return   Array
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         * @use      plugin_row_meta
         */
        public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {

            if ( ( defined( 'YITH_WCBM_FREE_INIT' ) && YITH_WCBM_FREE_INIT == $plugin_file ) || ( defined( 'YITH_WCBM_INIT' ) && YITH_WCBM_INIT == $plugin_file ) ) {
                $plugin_meta[] = '<a href="' . $this->doc_url . '" target="_blank">' . __( 'Plugin Documentation', 'yith-woocommerce-badges-management' ) . '</a>';
            }

            return $plugin_meta;
        }

        /**
         * Add a panel under YITH Plugins tab
         *
         * @return   void
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         * @use      /Yit_Plugin_Panel class
         * @see      plugin-fw/lib/yit-plugin-panel.php
         */
        public function register_panel() {

            if ( !empty( $this->_panel ) ) {
                return;
            }

            $admin_tabs_free = array(
                'settings' => __( 'Settings', 'yith-woocommerce-badges-management' ),
                'premium'  => __( 'Premium Version', 'yith-woocommerce-badges-management' )
            );

            $admin_tabs = apply_filters( 'yith_wcbm_settings_admin_tabs', $admin_tabs_free );

            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => __( 'Badge Management', 'yith-woocommerce-badges-management' ),
                'menu_title'       => __( 'Badge Management', 'yith-woocommerce-badges-management' ),
                'capability'       => 'manage_options',
                'parent'           => '',
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'links'            => $this->get_panel_sidebar_links(),
                'admin-tabs'       => $admin_tabs,
                'options-path'     => YITH_WCBM_DIR . '/plugin-options'
            );


            /* === Fixed: not updated theme  === */
            if ( !class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {
                require_once( 'plugin-fw/lib/yit-plugin-panel-wc.php' );
            }

            $this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
        }

        public function admin_enqueue_scripts() {
            wp_enqueue_style( 'yith_wcbm_admin_style', YITH_WCBM_ASSETS_URL . '/css/admin.css' );
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
            wp_enqueue_script( 'jquery-ui-tabs' );
            wp_enqueue_style( 'jquery-ui-style-css', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css' );
            wp_enqueue_style( 'googleFontsOpenSans', '//fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300' );

            $screen     = get_current_screen();
            $metabox_js = defined( 'YITH_WCBM_PREMIUM' ) ? 'metabox_options_premium.js' : 'metabox_options.js';

            if ( 'yith-wcbm-badge' == $screen->id ) {
                wp_enqueue_script( 'yith_wcbm_metabox_options', YITH_WCBM_ASSETS_URL . '/js/' . $metabox_js, array( 'jquery', 'wp-color-picker' ), '1.0.0', true );
                wp_localize_script( 'yith_wcbm_metabox_options', 'ajax_object', array( 'assets_url' => YITH_WCBM_ASSETS_URL, 'wp_ajax_url' => admin_url( 'admin-ajax.php' ) ) );
            }
        }

        /**
         * Register Badge custom post type with options metabox
         *
         * @return   void
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function post_type_register() {
            $labels = array(
                'name'               => __( 'Badges', 'yith-woocommerce-badges-management' ),
                'singular_name'      => __( 'Badge', 'yith-woocommerce-badges-management' ),
                'add_new'            => __( 'Add Badge', 'yith-woocommerce-badges-management' ),
                'add_new_item'       => __( 'Add new Badge', 'yith-woocommerce-badges-management' ),
                'edit_item'          => __( 'Edit Badge', 'yith-woocommerce-badges-management' ),
                'view_item'          => __( 'View Badge', 'yith-woocommerce-badges-management' ),
                'not_found'          => __( 'Badge not found', 'yith-woocommerce-badges-management' ),
                'not_found_in_trash' => __( 'Badge not found in trash', 'yith-woocommerce-badges-management' )
            );

            $args = array(
                'labels'               => $labels,
                'public'               => true,
                'show_ui'              => true,
                'menu_position'        => 10,
                'exclude_from_search'  => true,
                'capability_type'      => array( 'badge', 'badges' ),
                'map_meta_cap'         => true,
                'rewrite'              => true,
                'has_archive'          => true,
                'hierarchical'         => false,
                'show_in_nav_menus'    => false,
                'menu_icon'            => 'dashicons-visibility',
                'supports'             => array( 'title' ),
                'register_meta_box_cb' => array( $this, 'register_metabox' )
            );

            register_post_type( 'yith-wcbm-badge', $args );
        }

        /**
         * Add badge management capabilities to Admin and Shop Manager
         *
         *
         * @access public
         * @since  1.0.0
         * @author Leanza Francesco <leanzafrancesco@gmail.com>
         */
        public function add_capabilities() {
            $caps = yith_wcbm_create_capabilities( array( 'badge', 'badges' ) );

            // gets the admin and shop_mamager roles
            $admin        = get_role( 'administrator' );
            $shop_manager = get_role( 'shop_manager' );

            foreach ( $caps as $cap => $value ) {
                $admin->add_cap( $cap );
                $shop_manager->add_cap( $cap );
            }
        }

        public function register_metabox() {
            add_meta_box( 'yith-wcbm-metabox', __( 'Badge Options', 'yith-woocommerce-badges-management' ), array( $this, 'metabox_render' ), 'yith-wcbm-badge', 'normal', 'high' );
        }

        public function metabox_render( $post ) {
            $bm_meta = get_post_meta( $post->ID, '_badge_meta', true );

            $default = array(
                'type'              => 'text',
                'text'              => '',
                'txt_color_default' => '#000000',
                'txt_color'         => '#000000',
                'bg_color_default'  => '#2470FF',
                'bg_color'          => '#2470FF',
                'width'             => '100',
                'height'            => '50',
                'position'          => 'top-left',
                'image_url'         => ''
            );

            $args = wp_parse_args( $bm_meta, $default );

            $args = apply_filters( 'yith_wcbm_metabox_options_content_args', $args );

            yith_wcbm_metabox_options_content( $args );
        }

        public function metabox_save( $post_id ) {
            if ( !empty( $_POST[ '_badge_meta' ] ) ) {
                $badge_meta[ 'type' ]      = ( !empty( $_POST[ '_badge_meta' ][ 'type' ] ) ) ? $_POST[ '_badge_meta' ][ 'type' ] : '';
                $badge_meta[ 'text' ]      = ( !empty( $_POST[ '_badge_meta' ][ 'text' ] ) ) ? $_POST[ '_badge_meta' ][ 'text' ] : '';
                $badge_meta[ 'txt_color' ] = ( !empty( $_POST[ '_badge_meta' ][ 'txt_color' ] ) ) ? $_POST[ '_badge_meta' ][ 'txt_color' ] : '';
                $badge_meta[ 'bg_color' ]  = ( !empty( $_POST[ '_badge_meta' ][ 'bg_color' ] ) ) ? esc_url( $_POST[ '_badge_meta' ][ 'bg_color' ] ) : '';
                $badge_meta[ 'width' ]     = ( !empty( $_POST[ '_badge_meta' ][ 'width' ] ) ) ? $_POST[ '_badge_meta' ][ 'width' ] : '';
                $badge_meta[ 'height' ]    = ( !empty( $_POST[ '_badge_meta' ][ 'height' ] ) ) ? $_POST[ '_badge_meta' ][ 'height' ] : '';
                $badge_meta[ 'position' ]  = ( !empty( $_POST[ '_badge_meta' ][ 'position' ] ) ) ? $_POST[ '_badge_meta' ][ 'position' ] : 'top-left';
                $badge_meta[ 'image_url' ] = ( !empty( $_POST[ '_badge_meta' ][ 'image_url' ] ) ) ? $_POST[ '_badge_meta' ][ 'image_url' ] : '';

                //--wpml-------------
                yith_wcbm_wpml_register_string( 'yith-woocommerce-badges-management', sanitize_title( $badge_meta[ 'text' ] ), $badge_meta[ 'text' ] );
                //-------------------

                update_post_meta( $post_id, '_badge_meta', $badge_meta );
            }
        }


        function badge_settings_metabox() {
            add_meta_box( 'yith-wcbm-badge_metabox', __( 'Product Badge', 'yith-woocommerce-badges-management' ), array( $this, 'badge_settings_tabs' ), 'product', 'side', 'core' );
        }

        /**
         * Add badge select in metabox
         *
         * @return   void
         * @since    1.0
         * @author   Leanza Francesco <leanzafrancesco@gmail.com>
         */

        function badge_settings_tabs() {
            global $post;
            $bm_meta  = get_post_meta( $post->ID, '_yith_wcbm_product_meta', true );
            $id_badge = ( isset( $bm_meta[ 'id_badge' ] ) ) ? $bm_meta[ 'id_badge' ] : '';
            ?>
            <p class="form-field">
                <select name="_yith_wcbm_product_meta[id_badge]" class="select">
                    <option value="" selected="selected"><?php echo __( 'none', 'yith-woocommerce-badges-management' ) ?></option>
                    <?php

                    $args   = ( array(
                        'posts_per_page'   => -1,
                        'post_type'        => 'yith-wcbm-badge',
                        'orderby'          => 'title',
                        'order'            => 'ASC',
                        'post_status'      => 'publish',
                        'suppress_filters' => false
                    ) );
                    $badges = get_posts( $args );

                    foreach ( $badges as $badge ) {
                        ?>
                        <option value="<?php echo $badge->ID ?>" <?php selected( $id_badge, $badge->ID ) ?>><?php echo get_the_title( $badge->ID ) ?></option><?php
                    }

                    ?>
                </select>
            </p>
            <?php
        }


        public function badge_settings_save( $post_id ) {
            if ( !empty( $_POST[ '_yith_wcbm_product_meta' ] ) ) {
                $product_meta               = $_POST[ '_yith_wcbm_product_meta' ];
                $product_meta[ 'id_badge' ] = ( !empty( $product_meta[ 'id_badge' ] ) ) ? $product_meta[ 'id_badge' ] : '';

                update_post_meta( $post_id, '_yith_wcbm_product_meta', $product_meta );
            }
        }

        /**
         * Show premium landing tab
         *
         * @return   void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function show_premium_tab() {
            $landing = YITH_WCBM_TEMPLATE_PATH . '/premium.php';
            file_exists( $landing ) && require( $landing );
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri() {
            return defined( 'YITH_REFER_ID' ) ? $this->_premium_landing . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing . '?refer_id=1030585';
        }
    }
}

/**
 * Unique access to instance of YITH_WCBM_Admin class
 *
 * @return \YITH_WCBM_Admin
 * @since 1.0.0
 */
function YITH_WCBM_Admin() {
    return YITH_WCBM_Admin::get_instance();
}

?>
