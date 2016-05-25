<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'YITH_JetPack' ) ) {
    /**
     * Manage all features of a YIT Theme
     */
    class YITH_JetPack {

        const PLUGIN_LIST_FILTER_MODULE_NAME = 'yith_jetpack_modules';

        const ACTIVATED_MODULES_OPTION_BASE_NAME = 'yith_jetpack_active_modules';

        const DEACTIVATED_PLUGIN_OPTION_NAME = 'yith_jetpack_deactivated_plugin';

        const MODULE_LIST_OPTION_NAME = 'yith_jetpack_inserted_modules';

        const MODULE_LIST_ACTIVATION_HOOK_OPTION_NAME = 'yith_jetpack_activation_hook';

        const MODULES_LIST_QUERY_VALUE = 'yith-jetpack-modules';

        const PLUGIN_LIST_HIDE_NOTICE_OPTION_NAME = 'yith_jetpack_m_hide_notice';

        protected $index = 0;

        /** @var array plugin path */
        protected $_plugin_path = '';

        protected $_package_title = '';

        public $_plugin_list_filter_module_name = null;

        protected $_activate_module_option_name = null;

        protected $_deactivated_plugin_option_name = null;

        protected $_module_list_option_name = null;

        protected $_module_activation_hook_option_name = null;

        protected $_modules_list_query_value = null;

        protected $_plugin_list_hide_notice_option_name = null;

        /** @var array All modules to active */
        protected $_modules = null;

        /** @var array All modules ativated */
        protected $_active_modules = array();

        /**
         * Constructor.
         *
         * @since 1.0.0
         */
        public function __construct( $path, $title , $index ) {

            $this->$index = $index;
            $this->_plugin_path = $path;
            $this->_menu_title  = $title;
            $this->_plugin_list_filter_module_name  = self::PLUGIN_LIST_FILTER_MODULE_NAME.$this->$index;
            $this->_activate_module_option_name  = self::ACTIVATED_MODULES_OPTION_BASE_NAME.$this->$index;
            $this->_deactivated_plugin_option_name  = self::DEACTIVATED_PLUGIN_OPTION_NAME.$this->$index;
            $this->_module_list_option_name  = self::MODULE_LIST_OPTION_NAME.$this->$index;
            $this->_module_activation_hook_option_name = self::MODULE_LIST_ACTIVATION_HOOK_OPTION_NAME.$this->$index;
            $this->_modules_list_query_value  = self::MODULES_LIST_QUERY_VALUE.$this->$index;
            $this->_plugin_list_hide_notice_option_name = self::PLUGIN_LIST_HIDE_NOTICE_OPTION_NAME.$this->$index;

            add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );

            add_action( 'plugins_loaded', array( $this, 'load_modules' ) , 5 );

            // admin page
            add_action( 'admin_init', array( $this, 'deactivate_singular_plugins' ) );
            add_action( 'admin_init', array( $this, 'activate_module_action' ) );
            add_action( 'admin_init', array( $this, 'deactivate_module_action' ) );
            add_action( 'admin_init', array( $this, 'deactivate_modules_after_premium_installed' ) );
            add_action( 'activate_plugin', array( $this, 'deactivate_modules_after_premium_installed' ) );
            add_action( 'deactivate_plugin', array( $this, 'reset_yith_jetpack_option' ) );
            add_action( 'admin_menu', array( $this, 'add_admin_modules_page' ), 100 );

            add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );

            add_action( 'admin_notices', array( $this , 'new_added_plugin_admin_notice' ) );

            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename( YJP_DIR . '/' . basename( $this->_plugin_path ) ), array(
                $this,
                'action_links'
            ) );

            // filter list of plugin
            add_filter( 'all_plugins', array( $this, 'remove_modules' ), 10, 1 );
            // add notice
            add_action( 'admin_notices', array( $this, 'notice' ), 20 );
            // hide notice
            add_action( 'admin_init', array( $this, 'hide_notice' ) );

        }

        /**
         * Remove modules from plugins list.
         *
         * @param array $plugins
         * @return mixed
         * @author Andrea Frascaspata
         */
        public function remove_modules( $plugins ) {

            $modules = $this->get_modules();

            foreach ( $modules as $module => $args ) {
                if ( ! is_plugin_active( $module . '/' . $args['file'] ) ) {
                    $unset =  $module . '/' . $args['file'];
                    unset( $plugins[ $unset ] );
                }
            }

            return $plugins;
        }

        /**
         * Add admin notice
         *
         * @author Andrea Frascaspata
         */
        public function notice() {

            global $pagenow;

            if( $pagenow != 'plugins.php' || get_option( $this->_plugin_list_hide_notice_option_name ) ) {
                return;
            }

            $modules = $this->get_modules();
            if( count( $modules ) < 2 ) return;

            $i=0;
            $plugin_info = array();
            foreach( $modules as $module ) {
                $plugin_info[] =  $module['name'];
                $i++;
                if( $i == 2 ) break;
            }
            ?>
            <div id="yit-framework-notice" class="update-nag settings-error notice is-dismissible">
                <p><?php
                    $url = menu_page_url( $this->_modules_list_query_value, false );
                    printf( __( 'Some plugins as %s, %s , etc.. have been removed from this plugins list. You can activate or deactive it from <a href="%s">%s</a> panel.', 'yith-essential-kit-for-woocommerce-1' ), $plugin_info[0] , $plugin_info[1] , $url , $this->_menu_title );
                    ?></p>
                <div class="action-link">
                    <a class="dismiss-notice" href="<?php echo esc_url( add_query_arg( $this->_plugin_list_hide_notice_option_name, 1 ) ); ?>"><?php _e( 'Dismiss this notice', 'yit' ); ?></a>
                </div>
            </div>
            <?php

            $notice = ob_get_clean();

            echo apply_filters( 'yith_jetpack_framework_modules_notice', $notice );
        }

        /**
         * Hide notice
         *
         * @author Andrea Frascaspata
         */
        public function hide_notice() {
            if( ! isset( $_GET[ $this->_plugin_list_hide_notice_option_name ] ) || ! $_GET[ $this->_plugin_list_hide_notice_option_name ] ) {
                return;
            }

            update_option( $this->_plugin_list_hide_notice_option_name , true );
        }

        /**
         * Reset YIT_Framework option
         *
         * @since 1.0.0
         * @author Andrea Frascaspata
         */
        public function reset_yith_jetpack_option( $plugin ) {

            if ( $plugin == plugin_basename( $this->_plugin_path ) ) {
                delete_option( $this->_activate_module_option_name );
                delete_option( $this->_deactivated_plugin_option_name );
                delete_option( $this->_module_list_option_name );
                delete_option( $this->_plugin_list_hide_notice_option_name );
            }

        }
		
		  /**
		   * Load plugin framework
		   *
		   * @author Andrea Grillo <andrea.grillo@yithemes.com>
		   * @since  1.0
		   * @return void
		   */
        public function plugin_fw_loader() {
            if ( ! defined( 'YIT_CORE_PLUGIN' ) ) {
                global $plugin_fw_data;
                $plugin_fw_file = array_shift( $plugin_fw_data );
                require_once( $plugin_fw_file );
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
         * @use      plugin_action_links_{$plugin_file_name}
         */
        public function action_links( $links ) {

            $links[] = '<a href="' . esc_url( admin_url( "admin.php?page=".$this->_modules_list_query_value ) ) . '">' . __( 'Plugins List', 'yith-essential-kit-for-woocommerce-1' ) . '</a>';

            return $links;
        }

        /**
         * Get the plugin url.
         *
         * @return string
         *
         * @author     Antonino Scarfi' <antonino.scarfi@yithemes.com>
         * @since      2.0.0
         */
        public function plugin_url() {
            return trailingslashit( plugins_url( '/', $this->_plugin_path ) );
        }

        /**
         * Get the plugin path.
         *
         * @return string
         *
         * @author     Antonino Scarfi' <antonino.scarfi@yithemes.com>
         * @since      2.0.0
         */
        public function plugin_path() {
            return trailingslashit( plugin_dir_path( $this->_plugin_path ) );
        }

        /**
         * Retrieve the pathname to the module file
         *
         * @param $module string The module to find the file specified on second parameter
         * @param $path   string The relative path to a file
         *
         * @return string
         * @since 1.0.0
         */
        public function module_path( $module, $path = '' ) {
            return trailingslashit( $this->plugin_path() . 'modules/' . $module ) . $path;
        }

        /**
         * Get wordpress yithemes plugin list
         *
         * @return array
         * @since 1.0.0
         */
        public function get_wordpress_plugins() {

            $args['per_page'] = 500;
            $args['fields']   = array( "last_updated" => true, "icons" => true, "active_installs" => true, "downloaded" => true );
            $args['author']   = 'yithemes';

            require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );

            $api = plugins_api( 'query_plugins', $args );

            if ( isset( $api ) && is_object( $api ) ) return (array) $api->plugins;
            else {
                return array();
            }

        }

        /**
         * Load the file with all modules
         *
         * @return array
         * @since 1.0.0
         */
        public function get_modules() {
            if ( ! empty( $this->_modules ) ) {
                return $this->_modules;
            }

            $this->_modules = include_once( $this->plugin_path() . 'modules.php' );

            foreach ( $this->_modules as $module => &$args ) {

                $main_file = ! empty( $args['file'] ) ? $args['file'] : 'init.php';
                $path      = $this->module_path( $module, $main_file );

                if ( ! file_exists( $path ) ) {
                    unset( $this->_modules[$module] );
                    if ( count( $this->_modules ) - 1 == 0 ) {
                        break;
                    }
                    else {
                        continue;
                    }
                }

                $args['file'] = $main_file;

            }

            return $this->_modules;
        }


        /**
         * Load all active modules
         */
        public function load_modules() {
            $modules        = $this->get_modules();
            $active_modules = $this->active_modules();
            foreach ( $modules as $module => $args ) {
                if ( in_array( $module, array_keys( $active_modules ) ) ) {

                    $path = $this->module_path( $module, $args['file'] );

                    include_once( $path );

                    $this->register_activation_hook( $path ) ;

                }
            }

        }


        /**
         * Sort by downloaded
         */
        public function sort_modules( $a, $b ) {

            $downloaded_a = ( isset( $a['wp_info'] ) ? $a['wp_info']['downloaded'] : 0 );
            $downloaded_b = ( isset( $b['wp_info'] ) ? $b['wp_info']['downloaded'] : 0 );

            if ( $downloaded_a == $downloaded_b ) return 0;
            return ( $downloaded_a > $downloaded_b ) ? - 1 : 1;
        }

        /**
         * Load the file with all modules
         *
         * @return array
         * @since 1.0.0
         */
        public function active_modules() {
            if ( ! empty( $this->_active_modules ) ) {
                return $this->_active_modules;
            }

            $modules = $this->get_modules();
            $active  = get_option( $this->_activate_module_option_name, array() );

            foreach ( $active as $m ) {
                if ( isset( $modules[$m] ) ) {
                    $this->_active_modules[$m] = $modules[$m];
                }
            }

            return $this->_active_modules;
        }

        /**
         * get Admin Modules List
         *
         * @return array
         * @since 1.0.0
         */
        public function get_admin_modules_list() {

            $transient_list_name = sanitize_title( $this->_menu_title.'_modules');

            if( defined('YIT_DEBUG') && YIT_DEBUG ) delete_transient( $transient_list_name );

            $modules = get_transient( $transient_list_name ) ;

            if ( ! $modules )  {
                $plugins        = $this->get_wordpress_plugins();
                $modules        = $this->get_modules();

                foreach ( $plugins as $plugin ) {

                    if ( is_object( $plugin ) ) {
                        $plugin = (array) $plugin;
                    }

                    if ( ! in_array( $plugin['slug'], array_keys( $modules ) ) ) {
                        continue;
                    }


                    if ( ! isset( $module_data['repository'] ) ) {
                        $modules[$plugin['slug']]['wp_info'] = $plugin;
                    }
                }

                set_transient( $transient_list_name , $modules, DAY_IN_SECONDS );
            }

            return  $modules;
        }

        /**
         * Activate a module
         *
         * @param $module string The module to activate
         *
         * @since 1.0.0
         * @return bool
         */
        public function activate_module( $module ) {
            $modules          = $this->get_modules();
            $active_modules   = $this->active_modules();
            $is_all_activated = ( $module == 'all' );

            if ( ( ! $is_all_activated ) && ( ! in_array( $module, array_keys( $modules ) ) || in_array( $module, array_keys( $active_modules ) ) ) ) {
                return false;
            }

            if ( $is_all_activated ) {

                $plugin_filter_status = ! isset( $_GET['plugin_status'] ) ? 'all' : $_GET['plugin_status'];

                $this->_active_modules = $modules;

                $recommended_modules_list = apply_filters( 'yith_jetpack_recommended_list' , array() );

                foreach ( $this->_active_modules as $key => $item ) {

                    $is_active = in_array( $key, array_keys( $active_modules ) );
                    $is_recommended = in_array( $key, $recommended_modules_list );

                    if ( is_plugin_active( $key . '/' . $item['file'] ) ) {
                        deactivate_plugins( $key . '/' . $item['file'] );
                    }
                    else if( !$is_active && ( ( isset( $item['premium_constat'] ) ) || ( $plugin_filter_status == 'recommended' && !$is_recommended ) ) ) {

                        if( is_array( $item['premium_constat'] ) ) {
                              foreach( $item['premium_constat'] as $single_premium_constant ) {
                                    if( defined( $single_premium_constant ) ) {
                                        unset( $this->_active_modules[ $key ] );
                                        break;
                                    }
                              }
                        }
                        else if( defined( $item['premium_constat'] ) ) {
                            unset( $this->_active_modules[ $key ] );
                        }

                    }

                    if( $plugin_filter_status == 'recommended' && !$is_recommended ) {
                        unset( $this->_active_modules[ $key ] );
                    }
                }

            }
            else {

                $module_data = $modules[$module];
                if ( is_plugin_active( $module . '/' . $module_data['file'] ) ) {
                    deactivate_plugins( $module . '/' . $module_data['file'] );
                }
                else if( isset( $module_data['premium_constat'] ) && defined( $module_data['premium_constat'] ) ) {
                    return false;
                }

                $this->_active_modules[$module] = $module_data;
            }

            update_option( $this->_activate_module_option_name, array_keys( $this->_active_modules ) );

            return true;
        }

        /**
         * Deactivate a module
         *
         * @param $module string The module to deactivate
         *
         * @since 1.0.0
         * @return bool
         */
        public function deactivate_module( $module ) {
            $modules        = $this->get_modules();
            $active_modules = $this->active_modules();

            if ( $module != 'all' && ( ! in_array( $module, array_keys( $modules ) ) || ! in_array( $module, array_keys( $active_modules ) ) ) ) {
                return false;
            }

            if ( 'all' == $module ) {

                $plugin_filter_status = ! isset( $_GET['plugin_status'] ) ? 'all' : $_GET['plugin_status'];
                $recommended_modules_list = apply_filters( 'yith_jetpack_recommended_list' , array() );

                if ( $plugin_filter_status == 'recommended' ) {
                    foreach ( $this->_active_modules as $key => $item ) {
                        $is_recommended = in_array( $key, $recommended_modules_list );
                        if ( $is_recommended ) {
                            $this->register_deactivation_hook( $this->module_path( $key , $item['file'] ) );
                            unset( $this->_active_modules[$key] );
                        }
                    }
                }
                else {
                    foreach ( $this->_active_modules as $key => $item ) {
                        $this->register_deactivation_hook( $this->module_path( $key , $item['file'] ) );
                    }
                    $this->_active_modules = array();
                }

            }
            else {
                if ( isset( $this->_active_modules[$module] ) ) {
                    $this->register_deactivation_hook( $this->module_path( $module , $this->_active_modules[$module]['file'] ) );
                    unset( $this->_active_modules[$module] );
                }
            }

            update_option( $this->_activate_module_option_name, array_keys( $this->_active_modules ) );

            return true;
        }

        /**
         * Deactivate a module
         *
         * @param $premium_constant string The premium constant related to the module
         *
         * @since 1.0.0
         * @return bool
         */
        public function deactivate_module_by_premium_constant( $premium_constant ) {
            $active_modules = $this->active_modules();
            foreach ( $active_modules as $module => $args ) {
                if( $premium_constant == $args['premium_constat'] ) {
                    $this->deactivate_module($module);
                    return true;
                }
            }

            return false;
        }

        /**
         * Get the plugin url.
         *
         *
         * @author     Andrea Frascaspata <andrea.frascaspata@yithemes.com>
         * @since      1.0.0
         */
        public function deactivate_modules_after_premium_installed( $plugin ) {

            $active_modules = $this->active_modules();

            foreach ( $active_modules as $module => $args ) {
                    if( is_array( $args['premium_constat'] ) ) {
                         foreach( $args['premium_constat'] as $single_premium_constant ){
                             if(defined( $single_premium_constant ) ){
                                 $this->deactivate_module( $module );
                                 break;
                             }
                         }
                    }
                    else if ( isset( $args['premium_constat'] ) && defined( $args['premium_constat'] ) ) {
                        $this->deactivate_module( $module );
                    }
            }

        }

        /**
         * Add the admin page for modules management
         *
         * @since 1.0.0
         */
        public function add_admin_modules_page() {

            global $admin_page_hooks;

            if( ! isset( $admin_page_hooks['yit_plugin_panel'] ) ){
                $position = apply_filters( 'yit_plugins_menu_item_position', '62.32' );
                add_menu_page( 'yit_plugin_panel', __( 'YIT Plugins', 'yith-essential-kit-for-woocommerce-1' ), 'nosuchcapability', 'yit_plugin_panel', NULL, $this->plugin_url() . '/assets/images/yithemes-icon.png', $position );
            }

            $title = $this->_menu_title;

            $new_plugins_count = $this->get_new_added_plugin();

            if( $new_plugins_count > 0 ) {
                $title .= '<span class="awaiting-mod count-2"><span class="pending-count">'.( $new_plugins_count ).'</span></span>';
            }

            add_submenu_page( 'yit_plugin_panel', $title, $title, 'install_plugins', $this->_modules_list_query_value , array( $this, 'admin_modules_page' ) );

            /* === Duplicate Items Hack === */
            remove_submenu_page( 'yit_plugin_panel', 'yit_plugin_panel' );

        }

        public function get_new_added_plugin(){
            $modules = $this->get_modules();
            $modules_count = count( $modules );
            $modules_inserted_count = count( get_option( $this->_module_list_option_name , array() ) );

            if ( $modules_inserted_count > 0 ) {
                return $modules_count - $modules_inserted_count;
            }

            else {
                return 0;
            }
        }

        /**
         * Displays an admin notice to adive there are new plugins added to the jetpack
         *
         */
        function new_added_plugin_admin_notice() {
            if ( !is_super_admin() )
                return false;

            $new_plugins_count = $this->get_new_added_plugin();

            if( $new_plugins_count > 0 ) {
                echo "<div class='update-nag'>" . sprintf( __( 'There are new plugins available on <b>%s</b>, <a href="%s">take a look at them</a> !' , 'yith-essential-kit-for-woocommerce-1' ), $this->_menu_title, esc_url( admin_url( "admin.php?page=".$this->_modules_list_query_value."&plugin_status=inactive" ) ) ) . "</div>";
            }
        }


        /**
         * Print sigle plugin info
         *
         * @since 1.0.0
         */
        public function print_single_plugin( $module_data, $is_active , $is_new , $is_recommended , $is_premium_installed , $refer_id ) {

            $plugins_allowedtags = array(
                'a'    => array( 'href' => array(), 'title' => array(), 'target' => array() ),
                'abbr' => array( 'title' => array() ), 'acronym' => array( 'title' => array() ),
                'code' => array(), 'pre' => array(), 'em' => array(), 'strong' => array(),
                'ul'   => array(), 'ol' => array(), 'li' => array(), 'p' => array(), 'br' => array()
            );


            include ( YJP_TEMPLATE_PATH . '/yith-single-plugin.php' );

        }


        /**
         * Show the admin page content
         *
         * @since 1.0.0
         */
        public function admin_modules_page() {
            include ( YJP_TEMPLATE_PATH . '/yith-list-plugins.php' );
        }

        /**
         * Trigger action of module activate
         *
         * @since 1.0.0
         */
        public function activate_module_action() {
            if ( empty( $_GET['page'] ) || $_GET['page'] != $this->_modules_list_query_value || ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'activate-yit-plugin' ) ) {
                return;
            }

            $modules           = $this->get_modules();
            $activated_modules = $this->active_modules();
            $module            = $_GET['module'];

            // exit if is not a valid module
            if ( empty( $_GET['module'] ) || 'all' != $module && ! in_array( $module, array_keys( $modules ) ) ) {
                wp_die( __( 'The module is not valid.', 'yith-essential-kit-for-woocommerce-1' ) . sprintf( ' <a href="%s">%s</a>', remove_query_arg( array( 'action', 'module', '_wpnonce' ) ), __( 'Back to modules', 'yith-essential-kit-for-woocommerce-1' ) ) );
            }

            // exit if is a module already activated
            if ( 'all' != $module && in_array( $module, array_keys( $activated_modules ) ) ) {
                wp_die( __( 'The module is already activated.', 'yith-essential-kit-for-woocommerce-1' ) . sprintf( ' <a href="%s">%s</a>', remove_query_arg( array( 'action', 'module', '_wpnonce' ) ), __( 'Back to modules', 'yith-essential-kit-for-woocommerce-1' ) ) );
            }

            if ( ! $this->activate_module( $module ) ) {
                wp_die( __( "Activation of the module is not possible.", 'yith-essential-kit-for-woocommerce-1' ) . sprintf( ' <a href="%s">%s</a>', remove_query_arg( array( 'action', 'module', '_wpnonce' ) ), __( 'Back to modules', 'yith-essential-kit-for-woocommerce-1' ) ) );
            }

            wp_redirect( add_query_arg( 'message', 'all' == $module ? 'activated-all' : 'activated', remove_query_arg( array( 'action', 'module', '_wpnonce' ) ) ) );
            exit();
        }

        /**
         * Trigger action of module activate
         *
         * @since 1.0.0
         */
        public function deactivate_module_action() {
            if ( empty( $_GET['page'] ) || $_GET['page'] != $this->_modules_list_query_value || ! isset( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'deactivate-yit-plugin' ) ) {
                return;
            }

            $modules           = $this->get_modules();
            $activated_modules = $this->active_modules();
            $module            = $_GET['module'];

            // exit if is not a valid module
            if ( empty( $_GET['module'] ) || 'all' != $module && ! in_array( $module, array_keys( $modules ) ) ) {
                wp_die( __( 'The module is not valid.', 'yith-essential-kit-for-woocommerce-1' ) . sprintf( ' <a href="%s">%s</a>', remove_query_arg( array( 'action', 'module', '_wpnonce' ) ), __( 'Back to modules', 'yith-essential-kit-for-woocommerce-1' ) ) );
            }

            // exit if is a module already activated
            if ( 'all' != $module && ! in_array( $module, array_keys( $activated_modules ) ) ) {
                wp_die( __( 'The module is already deactivated.', 'yith-essential-kit-for-woocommerce-1' ) . sprintf( ' <a href="%s">%s</a>', remove_query_arg( array( 'action', 'module', '_wpnonce' ) ), __( 'Back to modules', 'yith-essential-kit-for-woocommerce-1' ) ) );
            }

            if ( ! $this->deactivate_module( $module ) ) {
                wp_die( __( "Activation of the module is not possible.", 'yith-essential-kit-for-woocommerce-1' ) . sprintf( ' <a href="%s">%s</a>', remove_query_arg( array( 'action', 'module', '_wpnonce' ) ), __( 'Back to modules', 'yith-essential-kit-for-woocommerce-1' ) ) );
            }

            wp_redirect( add_query_arg( 'message', 'all' == $module ? 'deactivated-all' : 'deactivated', remove_query_arg( array( 'action', 'module', '_wpnonce' ) ) ) );
            exit();
        }

        /**
         * Check the status of singular plugin activated already in the website
         *
         * @since 1.0.0
         */
        public function deactivate_singular_plugins() {
            if ( get_option( $this->_deactivated_plugin_option_name ) ) {
                return;
            }

            $modules = $this->get_modules();

            $to_active = array();

            // active only modules of plugin activated
            foreach ( $modules as $module => $args ) {
                if ( is_plugin_active( $module . '/' . $args['file'] ) ) {
                    $to_active[] = $module;
                    deactivate_plugins( $module . '/' . $args['file'] );
                    $this->activate_module( $module );
                }
            }

            update_option( $this->_deactivated_plugin_option_name, true );

            wp_safe_redirect( wp_unslash( $_SERVER['REQUEST_URI'] ) );
            exit();
        }

        /**
         * Admin Enqueue Script
         *
         * add scripts and styles to sidebar panel
         *
         * @return   void
         * @since    1.0
         * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
         */
        public function admin_enqueue_scripts() {
             if( isset($_GET['page']) && $_GET['page']==$this->_modules_list_query_value) {
                 wp_enqueue_style( 'yit-layout', YJP_ASSETS_URL . '/css/list-layout.css' );
             }
        }

        /**
         * Activation Hook
         *
         * call activation action
         *
         * @author   Andrea Frascaspata <andrea.frascaspata@yithemes.it>
         */
        public function register_activation_hook( $path  ) {

            $activation_list =  get_option( $this->_module_activation_hook_option_name, array() );
            $file = plugin_basename( $path );
            if ( ! in_array( $file, array_keys( $activation_list ) ) ) {

                do_action( 'activate_' . $file );

                $activation_list[$file] = true;
                update_option( $this->_module_activation_hook_option_name , $activation_list);

            }

        }

        /**
         * Deactivation Hook
         *
         * call deactivation action
         *
         * @author   Andrea Frascaspata <andrea.frascaspata@yithemes.it>
         */
        public function register_deactivation_hook( $path ) {

            $activation_list =  get_option( $this->_module_activation_hook_option_name, array() );
            $file = plugin_basename( $path );
            do_action( 'deactivate_' . $file );

            unset( $activation_list[$file] );
            update_option( $this->_module_activation_hook_option_name , $activation_list);
        }

    }
}
