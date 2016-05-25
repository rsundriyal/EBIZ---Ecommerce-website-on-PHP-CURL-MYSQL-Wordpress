<?php
/**
 * Admin class
 *
 * @author Yithemes
 * @package YITH WooCommerce Ajax Search
 * @version 1.1.1
 */

if ( !defined( 'YITH_WCAS' ) ) { exit; } // Exit if accessed directly

if( !class_exists( 'YITH_WCAS_Admin' ) ) {
    /**
     * Admin class.
	 * The class manage all the admin behaviors.
     *
     * @since 1.0.0
     */
    class YITH_WCAS_Admin {
		/**
		 * Plugin options
		 *
		 * @var array
		 * @access public
		 * @since 1.0.0
		 */
		public $options = array();

        /**
         * Plugin version
         *
         * @var string
         * @since 1.0.0
         */
        public $version;

        /**
         * @var $_panel Panel Object
         */
        protected $_panel;

        /**
         * @var $_premium string Premium tab template file name
         */
        protected $_premium = 'premium.php';

        /**
         * @var string Premium version landing link
         */
        protected $_premium_landing = 'http://yithemes.com/themes/plugins/yith-woocommerce-ajax-search/';

        /**
         * @var string Ajax Search panel page
         */
        protected $_panel_page = 'yith_wcas_panel';

        /**
         * Various links
         *
         * @var string
         * @access public
         * @since 1.0.0
         */
        public $doc_url    = 'http://yithemes.com/docs-plugins/yith-woocommerce-ajax-search/';

    	/**
		 * Constructor
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function __construct( $version ) {

            $this->version = $version;

            add_action( 'admin_menu', array( $this, 'register_panel' ), 5) ;

            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename( YITH_WCAS_DIR . '/' . basename( YITH_WCAS_FILE ) ), array( $this, 'action_links') );
            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

            add_action( 'yith_ajax_search_premium', array( $this, 'premium_tab' ) );

            add_action( 'admin_init', array( $this, 'register_pointer' ) );

            // YITH WCAS Loaded
            do_action( 'yith_wcas_loaded' );
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
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @return mixed
         * @use plugin_action_links_{$plugin_file_name}
         */
        public function action_links( $links ) {

            $links[] = '<a href="' . admin_url( "admin.php?page={$this->_panel_page}" ) . '">' . __( 'Settings', 'yith-woocommerce-ajax-search' ) . '</a>';
            $links[] = '<a href="' . $this->get_premium_landing_uri() . '" target="_blank">' . __( 'Premium Version', 'yith-woocommerce-ajax-search' ) . '</a>';

            return $links;
        }

        /**
         * Add a panel under YITH Plugins tab
         *
         * @return   void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use     /Yit_Plugin_Panel class
         * @see      plugin-fw/lib/yit-plugin-panel.php
         */
        public function register_panel() {

            if ( ! empty( $this->_panel ) ) {
                return;
            }

            $admin_tabs = array(
                'settings' => __( 'Settings', 'yith-woocommerce-ajax-search' ),
                'premium'  => __( 'Premium Version', 'yith-woocommerce-ajax-search' ),
            );

            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => __( 'Ajax Search', 'yith-woocommerce-ajax-search' ),
                'menu_title'       => __( 'Ajax Search', 'yith-woocommerce-ajax-search' ),
                'capability'       => 'manage_options',
                'parent'           => '',
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'admin-tabs'       => $admin_tabs,
                'options-path'     => YITH_WCAS_DIR . '/plugin-options'
            );


            /* === Fixed: not updated theme  === */
            if( ! class_exists( 'YIT_Plugin_Panel_WooCommerce' ) ) {
                require_once( 'plugin-fw/lib/yit-plugin-panel-wc.php' );
            }

            $this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
        }

        /**
         * Premium Tab Template
         *
         * Load the premium tab template on admin page
         *
         * @return   void
         * @since    1.0
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @return void
         */
        public function premium_tab() {
            $premium_tab_template =YITH_WCAS_TEMPLATE_PATH . '/admin/' . $this->_premium;
            if( file_exists( $premium_tab_template ) ) {
                include_once($premium_tab_template);
            }

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
         * @author   Andrea Grillo <andrea.grillo@yithemes.com>
         * @use plugin_row_meta
         */
        public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {

            if ( defined( 'YITH_WCAS_FREE_INIT' ) && YITH_WCAS_FREE_INIT == $plugin_file ) {
                $plugin_meta[] = '<a href="' . $this->doc_url . '" target="_blank">' . __( 'Plugin Documentation', 'yith-woocommerce-ajax-search' ) . '</a>';
            }
            return $plugin_meta;
        }


        public function register_pointer(){

            if( ! class_exists( 'YIT_Pointers' ) ){
                include_once( 'plugin-fw/lib/yit-pointers.php' );
            }

            $args[] = array(
                'screen_id'     => 'plugins',
                'pointer_id' => 'yith_wcas_panel',
                'target'     => '#toplevel_page_yit_plugin_panel',
                'content'    => sprintf( '<h3> %s </h3> <p> %s </p>',
                    __( 'YITH WooCommerce Ajax Search', 'yith-woocommerce-ajax-search' ),
                    __( 'In the YIT Plugin tab you can find the YITH WooCommerce Ajax Search options.
With this menu, you can access to all the settings of our plugins that you have activated.
YITH WooCommerce Ajax Search is available in an outstanding PREMIUM version with many new options, <a href="'.$this->_premium_landing.'">discover it now</a>', 'yith-woocommerce-ajax-search' )
                ),
                'position'   => array( 'edge' => 'left', 'align' => 'center' ),
                'init'  => YITH_WCAS_FREE_INIT
            );

            $args[] = array(
                'screen_id'     => 'update',
                'pointer_id' => 'yith_wcas_panel',
                'target'     => '#toplevel_page_yit_plugin_panel',
                'content'    => sprintf( '<h3> %s </h3> <p> %s </p>',
                    __( 'YITH WooCommerce Ajax Search Updated', 'yith-woocommerce-ajax-search' ),
                    __( 'From now on, you can find all the options of YITH WooCommerce Ajax Search Updated under YIT Plugin -> Ajax Search instead of WooCommerce -> Settings -> Ajax Search, as in the previous version.
When one of our plugins updates, a new voice will be added to this menu.
YITH WooCommerce Ajax Search renovates with new available options, discover the <a href="'.$this->get_premium_landing_uri().'">PREMIUM version</a>.
', 'yith-woocommerce-ajax-search' )
                ),
                'position'   => array( 'edge' => 'left', 'align' => 'center' ),
                'init'  => YITH_WCAS_FREE_INIT
            );

            YIT_Pointers()->register( $args );
        }


        /**
     * Get the premium landing uri
     *
     * @since   1.0.0
     * @author  Andrea Grillo <andrea.grillo@yithemes.com>
     * @return  string The premium landing link
     */
    public function get_premium_landing_uri(){
        return defined( 'YITH_REFER_ID' ) ? $this->_premium_landing . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing;
    }

    }
}
