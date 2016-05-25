<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Implements features of FREE version of YITH WooCommerce Tab Manager plugin
 *
 * @class   YITH_WC_Tab_Manager
 * @package YITHEMES
 * @since   1.0.0
 * @author  Your Inspiration Themes
 *
*/

if ( !class_exists( 'YITH_WC_Tab_Manager' ) ) {

    class YITH_WC_Tab_Manager {


    	 /**
         * Single instance of the class
         *
         * @var \YITH_WCTM
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * Post type name
         *
         * @var string
         * @since 1.0.0
         */
        public $post_type_name = 'ywtm_tab';

        /**
         * @var Panel
         */
        protected $_panel;

        /**
         * @var $_premium string Premium tab template file name
         */
        protected $_premium = 'premium.php';

        /**
         * @var string Premium version landing link
         */
        protected $_premium_landing_url = 'http://yithemes.com/themes/plugins/yith-woocommerce-tab-manager/';

        /**
         * @var string Plugin official documentation
         */
        protected $_official_documentation = 'http://yithemes.com/docs-plugins/yith-woocommerce-tab-manager/';

        /**
         * @var string Yith WooCommerce Tab manager panel page
         */
        protected $_panel_page = 'yith_wc_tab_manager_panel';

        /**
         * Default type Tab
         * @var string
         */
        protected  $_default_type   =   'global';
        /**
         * Default tab layout
         * @var string
         */
        protected  $_default_layout =   'default';

        /**
         * Priority Tab penalty
         * @var int
         */
        protected $priority =   30;


        /**
         * Returns single instance of the class
         *
         * @return \YITH_WCTM
         * @since 1.0.0
         */
         public static function get_instance(){
            if( is_null( self::$instance ) ){
                self::$instance = new self( $_REQUEST );
            }

            return self::$instance;
        }

        /**
         * Constructor
         *
         * Initialize plugin and registers actions and filters to be used
         *
         * @since  1.0
         * @author YITHEMES
         */
    
	public function __construct()
        {

            // Load Plugin Framework
            add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );
            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename( YWTM_DIR . '/' . basename( YWTM_FILE ) ), array(
                $this,
                'action_links'
            ) );


            //Enqueue admin style
            add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_style'));

            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );
            add_action( 'yith_tab_manager_premium', array( $this, 'premium_tab' ) );

            //  Add action menu
            add_action( 'admin_menu', array( $this, 'add_menu_page' ), 5 );

            //Add action register post type
            add_action('init', array($this, 'tabs_post_type'), 10);

            add_filter('manage_edit-' . $this->post_type_name . '_columns', array($this, 'edit_columns'));
            add_action('manage_' . $this->post_type_name . '_posts_custom_column', array($this, 'custom_columns'), 10, 2);
            //Custom Tab Message
            add_filter('post_updated_messages',array ($this,'custom_tab_messages'));
            //register metabox to tab manager
            add_action('admin_init', array($this, 'add_tab_metabox'), 1);



            if ( get_option( 'ywtm_enable_plugin' ) == 'yes' ) {

                //add tabs to woocommerce
                add_filter('woocommerce_product_tabs', array($this, 'add_tabs_woocommerce'), 98);
            }

        }


        /**
         * Enqueue css file
         *
         * @since  1.0
         * @access public
         * @return void
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         */
        public function plugin_fw_loader() {
            if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
                global $plugin_fw_data;
                if( ! empty( $plugin_fw_data ) ){
                    $plugin_fw_file = array_shift( $plugin_fw_data );
                    require_once( $plugin_fw_file );
                }
            }
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
        public function add_menu_page() {
            if ( ! empty( $this->_panel ) ) {
                return;
            }

            $admin_tabs = array(
                'settings'      => __( 'Settings', 'yith-woocommerce-tab-manager' ),
            );

            if( !defined( 'YWTM_PREMIUM' ) )
                $admin_tabs['premium-landing'] = __( 'Premium Version', 'yith-woocommerce-tab-manager' );

            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => __( 'Tab Manager', 'yith-woocommerce-tab-manager' ),
                'menu_title'       => __( 'Tab Manager', 'yith-woocommerce-tab-manager' ),
                'capability'       => 'manage_options',
                'parent'           => '',
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'admin-tabs'       => $admin_tabs,
                'options-path'     => YWTM_DIR . '/plugin-options'
            );

            $this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
        }

        /**
         * Premium Tab Template
         *
         * Load the premium tab template on admin page
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @return  void
         */
        public function premium_tab() {
            $premium_tab_template = YWTM_TEMPLATE_PATH . '/admin/' . $this->_premium;
            if ( file_exists( $premium_tab_template ) ) {
                include_once( $premium_tab_template );
            }
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

            $links[] = '<a href="' . admin_url( "admin.php?page={$this->_panel_page}" ) . '">' . __( 'Settings', 'yith-woocommerce-tab-manager' ) . '</a>';

            if ( defined( 'YWTM_FREE_INIT' ) ) {
                $links[] = '<a href="' . $this->get_premium_landing_uri() . '" target="_blank">' . __( 'Premium Version', 'yith-woocommerce-tab-manager' ) . '</a>';
            }

            return $links;
        }

        /**
         * Register admin free style
         * @author YITHEMES
         * @since 1.0.0
         * @fire admin_enqueue_scripts hook
         */
        public function enqueue_admin_style()
        {
            wp_enqueue_style( 'woocommerce_admin_styles', WC()->plugin_url() . '/assets/css/admin.css', array(), YWTM_VERSION );
            wp_enqueue_style( 'yit-tab-style', YWTM_ASSETS_URL . 'css/yith-tab-manager-admin.css', array(), YWTM_VERSION );
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
            if ( ( defined( 'YWTM_INIT' ) && ( YWTM_INIT == $plugin_file ) ) ||
                ( defined( 'YWTM_FREE_INIT' ) && ( YWTM_FREE_INIT == $plugin_file ) )
            ) {

                $plugin_meta[] = '<a href="' . $this->_official_documentation . '" target="_blank">' . __( 'Plugin Documentation', 'yith-woocommerce-tab-manager' ) . '</a>';
            }

            return $plugin_meta;
        }


        /**
         * tabs_post_type
         *
         * Register a Global Tab post type
         *
         * @author YITHEMES
         * @since 1.0.0
         */
     public  function tabs_post_type() {


         $args = apply_filters('yith_wctm_post_type',array(
                 'label'                =>  __('ywtm_tab', 'yith-woocommerce-tab-manager'),
                 'description'          =>  __('Yith Tab Manager Description', 'yith-woocommerce-tab-manager'),
                 'labels'               =>  $this->get_tab_taxonomy_label(),
                 'supports'             =>  array('title'),
                 'hierarchical'         =>  true,
                 'public'               =>  false,
                 'show_ui'              =>  true,
                 'show_in_menu'         =>  true,
                 'show_in_nav_menus'    =>  false,
                 'show_in_admin_bar'    =>  false,
                 'menu_position'        =>  57,
                 'menu_icon'            =>  'dashicons-feedback',
                 'can_export'           =>  true,
                 'has_archive'          =>  false,
                 'exclude_from_search'  =>  true,
                 'publicly_queryable'   =>  false,
                 'capability_type'      =>  'post',
                 )
         );



    	register_post_type( $this->post_type_name, $args );
    
    }

        /**
         * Get the tab taxonomy label
         *
         * @param   $arg string The string to return. Defaul empty. If is empty return all taxonomy labels
         *
         * @author Andrea Grillo <andrea.grillo@yithemes.com>
         * @since  1.0.0
         *
         * @return Array taxonomy label
         * @fire yith_tab_manager_taxonomy_label hooks
         */
        protected  function get_tab_taxonomy_label( $arg = '' ) {

            $label = apply_filters( 'yith_tab_manager_taxonomy_label', array(
                    'name'                  =>  _x('YITH WooCommerce Tab Manager', 'Post Type General Name', 'yith-woocommerce-tab-manager'),
                    'singular_name'         =>  _x('Tab', 'Post Type Singular Name', 'yith-woocommerce-tab-manager'),
                    'menu_name'             =>  __('Tab Manager', 'yith-woocommerce-tab-manager'),
                    'parent_item_colon'     =>  __('Parent Item:', 'yith-woocommerce-tab-manager'),
                    'all_items'             =>  __('All Tabs', 'yith-woocommerce-tab-manager'),
                    'view_item'             =>  __('View Tabs', 'yith-woocommerce-tab-manager'),
                    'add_new_item'          =>  __('Add New Tab', 'yith-woocommerce-tab-manager'),
                    'add_new'               =>  __('Add New Tab', 'yith-woocommerce-tab-manager'),
                    'edit_item'             =>  __('Edit Tab', 'yith-woocommerce-tab-manager'),
                    'update_item'           =>  __('Update Tab', 'yith-woocommerce-tab-manager'),
                    'search_items'          =>  __('Search Tab', 'yith-woocommerce-tab-manager'),
                    'not_found'             =>  __('Not found', 'yith-woocommerce-tab-manager'),
                    'not_found_in_trash'    =>  __('Not found in Trash', 'yith-woocommerce-tab-manager'),
                    )
                );
            return ! empty( $arg ) ? $label[ $arg ] : $label;
        }

        /**
         * Customize the messages for Tabs
         * @param $messages
         * @author YITHEMES
         *
         * @return array
         * @fire post_updated_messages filter
         */
        public function custom_tab_messages ( $messages ) {

           $singular_name  =   $this->get_tab_taxonomy_label('singular_name');
           $messages[$this->post_type_name] =   array (

               0    =>  '',
               1    =>  sprintf(__('%s updated','yith-woocommerce-tab-manager') , $singular_name ) ,
               2    =>  __('Custom field updated', 'yith-woocommerce-tab-manager'),
               3    =>  __('Custom field deleted', 'yith-woocommerce-tab-manager'),
               4    =>  sprintf(__('%s updated','yith-woocommerce-tab-manager') , $singular_name ) ,
               5    =>  isset( $_GET['revision'] ) ? sprintf( __( 'Tab restored to version %s', 'yith-woocommerce-tab-manager' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
               6    =>  sprintf( __('%s published', 'yith-woocommerce-tab-manager' ), $singular_name ),
               7    => sprintf( __('%s saved', 'yith-woocommerce-tab-manager' ), $singular_name ),
               8    => sprintf( __('%s submitted', 'yith-woocommerce-tab-manager' ), $singular_name ),
               9    => sprintf( __('%s', 'yith-woocommerce-tab-manager'), $singular_name ),
               10   =>  sprintf( __('%s draft updated', 'yith-woocommerce-tab-manager'), $singular_name )
           );


            return $messages;
        }

    /**
    * add_tab_metabox
     * Register metabox for global tab
     * @author YITHEMES
     * @since 1.0.0
    */
    public function  add_tab_metabox() {
    	$args	=	include_once( YWTM_INC . '/metabox/tab-metabox.php');

        if (!function_exists( 'YIT_Metabox' ) ) {
    		require_once( YWTM_DIR.'plugin-fw/yit-plugin.php' );
    	}
    	$metabox    =   YIT_Metabox('yit-tab-manager-setting');
    	$metabox->init($args);

    }

    /**
    * get_tabs
    * build the global tab
    *
    * @author YITHEMES
    * @return mixed
    */
   public function get_tabs() {

       /*Custom query for gets all post 'Tab'*/
      $args    =   array (
           'post_type'      =>  'ywtm_tab'  ,
           'post_status'    =>  'publish',
           'posts_per_page' =>  -1,
           'suppress_filters' =>  0

       );
       $q_tabs 	= 	get_posts( $args );
       $tabs 	=	array();

       foreach ($q_tabs as $tab){


           if( true==get_post_meta(  $tab->ID, '_ywtm_show_tab', true ) ) {

               $attr_tab = array();
               $attr_tab['title']                  =   $tab->post_title;
               $attr_tab['priority']               =   get_post_meta($tab->ID, '_ywtm_order_tab', true);
               $attr_tab['id']                     =   $tab->ID;
               $tabs[$tab->post_title.'_'.$tab->ID] =  $attr_tab;

             }
           }
       return $tabs;

      }

  /**
   * add_global_tabs_woocommerce
   *
   * @author YITHEMES
   * @since 1.0.0
   * @param $tabs
   * @return mixed
   * @use woocommerce_product_tabs filter
   */
   public function add_tabs_woocommerce ( $tabs ) {

       $yith_tabs       =   $this->get_tabs();
       $priority  =   $this->get_priority();

       foreach ($yith_tabs as $tab ){

           $tabs[$tab["id"]] = array(
               'title'		=>	__( $tab['title'], 'yith-woocommerce-tab-manager' ),
               'priority' 	=>	$tab['priority']+$priority,
               'callback' 	=>	array ( $this, 'put_content_tabs' )
           );

         }

       return $tabs;
   }

   /**
    * put_content_tabs
    * Put the content at the tabs
    * @param $key
    * @param $tab
    */
    public function put_content_tabs ( $key, $tab ) {

        $args['content'] =  get_post_meta( $key, '_ywtm_text_tab', true );

        yit_plugin_get_template( YWTM_DIR, $this->_default_layout.'.php', $args );
     }

   /**
    * get_coeff_priority
    * Set the coefficient for tabs priority
    * @author YITHEMES
    * @return int
    */
    protected function get_priority() {

        return $this->priority;
    }


   /** Edit Columns Table
    * @param $columns
    * @return mixed
    */
    function edit_columns( $columns ) {
    
    	$columns = apply_filters('yith_add_column_tab', array(
    			'cb' => '<input type="checkbox" />',
    			'title' => __('Title', 'yith-woocommerce-tab-manager'),
    			'is_show' => __('Is Visible', 'yith-woocommerce-tab-manager'),
    			'tab_position' => __('Tab Position', 'yith-woocommerce-tab-manager'),
    			'date' => __('Date', 'yith-woocommerce-tab-manager'),
    	             )
                 ) ;
    
    	return $columns;
    }

    /**
     * Print the content columns
     * @param $column
     * @param $post_id
     */
    public function custom_columns( $column, $post_id ) {
        switch ($column) {
            case 'is_show' :
                $show = get_post_meta($post_id, '_ywtm_show_tab', true);

                if ($show)
                    echo '<mark class="show tips" data-tip="yes">yes</mark>';
                else
                    echo '<mark class="hide tips" data-tip="no">no</mark>';
                break;

            case 'tab_position' :
                $tab_position = get_post_meta($post_id, '_ywtm_order_tab', true);
                echo $tab_position;
                break;


        }
    }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @author  Andrea Grillo <andrea.grillo@YITHEMES.com>
         * @return  string The premium landing link
         */
        public function get_premium_landing_uri(){
            return defined( 'YITH_REFER_ID' ) ? $this->_premium_landing_url . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing_url.'?refer_id=1030585';
        }
    }
}
