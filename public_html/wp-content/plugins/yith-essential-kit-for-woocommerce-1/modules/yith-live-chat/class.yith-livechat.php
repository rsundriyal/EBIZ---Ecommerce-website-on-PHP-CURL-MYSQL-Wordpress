<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

/**
 * Main class
 *
 * @class   YITH_Livechat
 * @package Yithemes
 * @since   1.0.0
 * @author  Your Inspiration Themes
 */

if ( !class_exists( 'YITH_Livechat' ) ) {

    class YITH_Livechat {

        /**
         * @var string $_options_name The name for the options db entry
         */
        public $_options_name = 'live_chat';

        /**
         * Panel object
         *
         * @var     /Yit_Plugin_Panel object
         * @since   1.0.0
         * @see     plugin-fw/lib/yit-plugin-panel.php
         */
        protected $_panel = null;

        /**
         * @var $_premium string Premium tab template file name
         */
        protected $_premium = 'premium.php';

        /**
         * @var string Premium version landing link
         */
        protected $_premium_landing = 'http://yithemes.com/themes/plugins/yith-live-chat/';

        /**
         * @var string Plugin official documentation
         */
        protected $_official_documentation = 'http://yithemes.com/docs-plugins/yith-live-chat/';

        /**
         * @var string Yith Live Chat panel page
         */
        protected $_panel_page = 'yith_live_chat_panel';

        /**
         * @var string Yith Live Chat console page
         */
        protected $_console_page = 'yith_live_chat';

        /**
         * @var null User info
         */
        var $user = null;

        /**
         * @var null Session info
         */
        var $session = null;

        /**
         * @var null plugin options
         */
        var $options = null;

        /**
         * @var null default plugin options
         */
        var $defaults = null;

        /**
         * Single instance of the class
         *
         * @var \YITH_Livechat
         * @since 1.1.0
         */
        protected static $instance;

        /**
         * Returns single instance of the class
         *
         * @return \YITH_Livechat
         * @since 1.1.0
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
         * @since   1.0.0
         * @return  mixed
         * @author  Alberto Ruggiero
         */
        public function __construct() {

            add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 12 );
            add_filter( 'plugin_action_links_' . plugin_basename( YLC_DIR . '/' . basename( YLC_FILE ) ), array( $this, 'action_links' ) );
            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

            $this->defaults = $this->ylc_get_defaults();

            // Include required files
            $this->includes();

            $this->options = get_option( 'yit_' . $this->_options_name . '_options' );

            if ( is_admin() ) {

                add_action( 'admin_menu', array( $this, 'add_menu_page' ), 5 );
                add_action( 'yith_live_chat_premium', array( $this, 'premium_tab' ) );
                add_action( 'yit_panel_custom-text', array( $this, 'custom_text_template' ), 10, 3 );
                add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

            }

            $plugin_enable      = $this->options['plugin-enable'];
            $firebase_appurl    = $this->options['firebase-appurl'];
            $firebase_appsecret = $this->options['firebase-appsecret'];

            if ( $plugin_enable == 'yes' ) {


                if ( !empty( $firebase_appurl ) && !empty( $firebase_appsecret ) ) {

                    $this->session = new YLC_Session();

                    add_action( 'init', array( $this, 'user_init' ), 0 );

                    if ( is_admin() ) {

                        add_action( 'admin_menu', array( $this, 'add_console_page' ), 5 );

                    }
                    else {

                        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
                        add_action( 'wp_footer', array( $this, 'show_chat' ) );

                    }
                }
                else {

                    add_action( 'admin_notices', array( $this, 'admin_notices' ) );

                }

            }

        }

        /**
         * Include required core files
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function includes() {

            require_once( 'includes/firebase/firebase-token-generator.php' );
            require_once( 'includes/class-ylc-user.php' );
            require_once( 'includes/class-ylc-session.php' );
            require_once( 'includes/functions-ylc-server.php' );
            require_once( 'includes/functions-ylc-commons.php' );
            require_once( 'includes/functions-ylc-ajax.php' );

        }

        /**
         * Add styles and scripts for Chat Console or Chat Frontend
         *
         * @since   1.1.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function admin_frontend_scripts() {

            //Google Fonts
            wp_register_style( 'ylc-google-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,700italic,400,700,600', array(), null );
            wp_enqueue_style( 'ylc-google-fonts' );

            //Load FontAwesome
            $this->load_fontawesome();

            // AutoSize Plug-in
            wp_register_script( 'jquery-autosize', YLC_ASSETS_URL . '/js/jquery.autosize' . $this->is_script_debug_active() . '.js', array( 'jquery' ), '1.17.1' );
            wp_enqueue_script( 'jquery-autosize' );

            //Firebase Engine
            wp_register_script( 'ylc-firebase', YLC_ASSETS_URL . '/js/firebase.js' );
            wp_enqueue_script( 'ylc-firebase' );

        }

        /**
         * Load FontAwesome
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function load_fontawesome() {

            $css_prefix = is_admin() ? 'yit-' : '';
            wp_enqueue_style( $css_prefix . 'font-awesome', YLC_ASSETS_URL . '/css/font-awesome' . $this->is_script_debug_active() . '.css' );

        }

        /**
         * User Init
         *
         * @since   1.1.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function user_init() {

            if ( current_user_can( 'answer_chat' ) && is_admin() ) {

                define( 'YLC_OPERATOR', true );

            }
            else {

                define( 'YLC_GUEST', true );

            }

            $display_name = '';
            $user_email   = '';

            if ( is_user_logged_in() ) {

                $current_user = wp_get_current_user();;
                $user_id      = $current_user->ID;
                $display_name = $current_user->display_name;
                $user_email   = $current_user->user_email;

            }
            else {

                $user_id = $this->session->get( 'visitor_id' );

                if ( empty( $user_id ) ) {

                    $user_id = uniqid( rand(), false );
                    $this->session->set( 'visitor_id', $user_id );

                }

            }

            $this->user = ( object ) array(
                'ID'           => $user_id,
                'display_name' => $display_name,
                'user_email'   => $user_email,
                'user_ip'      => ylc_get_ip_address(),
                'current_page' => ylc_get_current_page_url(),
            );

        }

        /**
         * User Authentication
         *
         * @since   1.0.0
         * @return  string
         * @author  Alberto Ruggiero
         */
        public function user_auth() {

            if ( empty( $this->options['firebase-appsecret'] ) ) {
                return;
            }

            $token_gen = new Services_FirebaseTokenGenerator( esc_html( $this->options['firebase-appsecret'] ) );
            $prefix    = ( is_user_logged_in() && !defined( 'YLC_OPERATOR' ) ) ? 'usr-' : '';
            $data      = array(
                'uid'         => $prefix . $this->user->ID,
                'is_operator' => ( defined( 'YLC_OPERATOR' ) ) ? true : false,
            );
            $opts      = array(
                'admin' => ( current_user_can( 'manage_options' ) ) ? true : false,
                'debug' => true
            );

            return $token_gen->createToken( $data, $opts );

        }

        /**
         * Get all strings for frontend and backend
         *
         * @since   1.1.0
         * @return  array
         * @author  Alberto Ruggiero
         */
        public function get_strings() {

            $options = $this->options;

            return array(
                'months'       => array(
                    'jan' => __( 'January', 'yith-live-chat' ),
                    'feb' => __( 'February', 'yith-live-chat' ),
                    'mar' => __( 'March', 'yith-live-chat' ),
                    'apr' => __( 'April', 'yith-live-chat' ),
                    'may' => __( 'May', 'yith-live-chat' ),
                    'jun' => __( 'June', 'yith-live-chat' ),
                    'jul' => __( 'July', 'yith-live-chat' ),
                    'aug' => __( 'August', 'yith-live-chat' ),
                    'sep' => __( 'September', 'yith-live-chat' ),
                    'oct' => __( 'October', 'yith-live-chat' ),
                    'nov' => __( 'November', 'yith-live-chat' ),
                    'dec' => __( 'December', 'yith-live-chat' )
                ),
                'months_short' => array(
                    'jan' => __( 'Jan', 'yith-live-chat' ),
                    'feb' => __( 'Feb', 'yith-live-chat' ),
                    'mar' => __( 'Mar', 'yith-live-chat' ),
                    'apr' => __( 'Apr', 'yith-live-chat' ),
                    'may' => __( 'May', 'yith-live-chat' ),
                    'jun' => __( 'Jun', 'yith-live-chat' ),
                    'jul' => __( 'Jul', 'yith-live-chat' ),
                    'aug' => __( 'Aug', 'yith-live-chat' ),
                    'sep' => __( 'Sep', 'yith-live-chat' ),
                    'oct' => __( 'Oct', 'yith-live-chat' ),
                    'nov' => __( 'Nov', 'yith-live-chat' ),
                    'dec' => __( 'Dec', 'yith-live-chat' )
                ),
                'time'         => array(
                    'suffix'  => __( 'ago', 'yith-live-chat' ),
                    'seconds' => __( 'less than a minute', 'yith-live-chat' ),
                    'minute'  => __( 'about a minute', 'yith-live-chat' ),
                    'minutes' => __( '%d minutes', 'yith-live-chat' ),
                    'hour'    => __( 'about an hour', 'yith-live-chat' ),
                    'hours'   => __( 'about %d hours', 'yith-live-chat' ),
                    'day'     => __( 'a day', 'yith-live-chat' ),
                    'days'    => __( '%d days', 'yith-live-chat' ),
                    'month'   => __( 'about a month', 'yith-live-chat' ),
                    'months'  => __( '%d months', 'yith-live-chat' ),
                    'year'    => __( 'about a year', 'yith-live-chat' ),
                    'years'   => __( '%d years', 'yith-live-chat' ),
                ),
                'fields'       => array(
                    'name'       => __( 'Your Name', 'yith-live-chat' ),
                    'name_ph'    => __( 'Please enter your name', 'yith-live-chat' ),
                    'email'      => __( 'Your Email', 'yith-live-chat' ),
                    'email_ph'   => __( 'Please enter your email', 'yith-live-chat' ),
                    'message'    => __( 'Your Message', 'yith-live-chat' ),
                    'message_ph' => __( 'Write your question', 'yith-live-chat' ),
                ),
                'msg'          => array(
                    'chat_title'        => ylc_sanitize_text( esc_html( $options['text-chat-title'] ) ),
                    'prechat_msg'       => ylc_sanitize_text( esc_html( $options['text-welcome'] ), true ),
                    'welc_msg'          => ylc_sanitize_text( esc_html( $options['text-start-chat'] ), true ),
                    'start_chat'        => __( 'Start Chat', 'yith-live-chat' ),
                    'offline_body'      => ylc_sanitize_text( esc_html( $options['text-offline'] ), true ),
                    'busy_body'         => ylc_sanitize_text( esc_html( $options['text-busy'] ), true ),
                    'close_msg'         => ylc_sanitize_text( esc_html( $options['text-close'] ), true ),
                    'close_msg_user'    => __( 'The user has closed the conversation', 'yith-live-chat' ),
                    'reply_ph'          => __( 'Type here and hit enter to chat', 'yith-live-chat' ),
                    'send_btn'          => __( 'Send', 'yith-live-chat' ),
                    'no_op'             => __( 'No operators online', 'yith-live-chat' ),
                    'no_msg'            => __( 'No messages found', 'yith-live-chat' ),
                    'sending'           => __( 'Sending', 'yith-live-chat' ),
                    'connecting'        => __( 'Connecting', 'yith-live-chat' ),
                    'writing'           => __( '%s is writing', 'yith-live-chat' ),
                    'please_wait'       => __( 'Please wait', 'yith-live-chat' ),
                    'chat_online'       => __( 'Chat Online', 'yith-live-chat' ),
                    'chat_offline'      => __( 'Chat Offline', 'yith-live-chat' ),
                    'your_msg'          => __( 'Your message', 'yith-live-chat' ),
                    'end_chat'          => __( 'End chat', 'yith-live-chat' ),
                    'conn_err'          => __( 'Connection error!', 'yith-live-chat' ),
                    'you'               => __( 'You', 'yith-live-chat' ),
                    'online_btn'        => __( 'Online', 'yith-live-chat' ),
                    'offline_btn'       => __( 'Offline', 'yith-live-chat' ),
                    'field_empty'       => __( 'Please fill out all required fields', 'yith-live-chat' ),
                    'invalid_email'     => __( 'Email is invalid', 'yith-live-chat' ),
                    'invalid_username'  => __( 'Username is invalid', 'yith-live-chat' ),
                    'user_name'         => __( 'User Name', 'yith-live-chat' ),
                    'user_email'        => __( 'User Email', 'yith-live-chat' ),
                    'user_ip'           => __( 'IP Address', 'yith-live-chat' ),
                    'user_page'         => __( 'Current Page', 'yith-live-chat' ),
                    'connect'           => __( 'Connect', 'yith-live-chat' ),
                    'disconnect'        => __( 'Disconnect', 'yith-live-chat' ),
                    'you_offline'       => __( 'You are offline', 'yith-live-chat' ),
                    'save_chat'         => __( 'Save chat', 'yith-live-chat' ),
                    'ntf_close_console' => __( 'If you leave the chat, you will be logged out. However you will be able to save the conversations into your server when you will come back in the console!', 'yith-live-chat' ),
                    'new_msg'           => __( 'New Message', 'yith-live-chat' ),
                    'new_user_online'   => __( 'New User Online', 'yith-live-chat' ),
                    'saving'            => __( 'Saving', 'yith-live-chat' ),
                    'waiting_users'     => ( defined( 'YLC_PREMIUM' ) ) ? __( 'User queue: %d', 'yith-live-chat' ) : __( 'There are people waiting to talk', 'yith-live-chat' ),
                    'good'              => __( 'Good', 'yith-live-chat' ),
                    'bad'               => __( 'Bad', 'yith-live-chat' ),
                    'chat_evaluation'   => __( 'Was this conversation useful? Vote this chat session.', 'yith-live-chat' ),
                    'talking_label'     => __( 'Talking with %s', 'yith-live-chat' ),
                    'timer'             => __( 'Elapsed time', 'yith-live-chat' ),
                    'chat_copy'         => __( 'Receive the copy of the chat via e-mail', 'yith-live-chat' ),
                    'already_logged'    => __( 'A user is already logged in with the same email address', 'yith-live-chat' ),
                    'current_shop'      => __( '%s shop', 'yith-live-chat' ),
                    'macro_title'       => __( 'Apply Macro', 'yith-live-chat' ),
                    'macro_opts'        => apply_filters( 'ylc_macro_options', '' ),
                    'macro_err'         => __( 'No results match', 'yith-live-chat' ),
                )
            );

        }

        /**
         * Get suffix if SCRIPT_DEBUG is inactive
         *
         * @since   1.1.0
         * @return  array
         * @author  Alberto Ruggiero
         */
        public function is_script_debug_active() {

            return defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

        }

        /**
         * Get options defaults
         *
         * @since   1.1.0
         * @return  array
         * @author  Alberto Ruggiero
         */
        public function ylc_get_defaults() {

            $defaults = array(
                'plugin-enable'      => 'no',
                'firebase-appurl'    => '',
                'firebase-appsecret' => '',
                'text-chat-title'    => __( 'Chat with us', 'yith-live-chat' ),
                'text-welcome'       => __( 'Have you got question? Write to us!', 'yith-live-chat' ),
                'text-start-chat'    => __( 'Questions, doubts, issues? We\'re here to help you!', 'yith-live-chat' ),
                'text-close'         => __( 'This chat session has ended', 'yith-live-chat' ),
                'text-offline'       => __( 'None of our operators are available at the moment. Please, try again later.', 'yith-live-chat' ),
                'text-busy'          => __( 'Our operators are busy. Please try again later', 'yith-live-chat' ),
            );

            if ( defined( 'YLC_PREMIUM' ) ) {

                $defaults = $this->ylc_get_defaults_premium( $defaults );

            }

            return $defaults;

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

            $admin_tabs = array(
                'general' => __( 'General', 'yith-live-chat' ),
                'texts'   => __( 'Messages', 'yith-live-chat' )
            );

            if ( defined( 'YLC_PREMIUM' ) ) {
                $admin_tabs['offline']    = __( 'Offline Messages', 'yith-live-chat' );
                $admin_tabs['transcript'] = __( 'Conversation', 'yith-live-chat' );
                $admin_tabs['style']      = __( 'Appearance', 'yith-live-chat' );
                //$admin_tabs['autoplay']         = __( 'Autoplay', 'yith-live-chat' );
                $admin_tabs['user'] = __( 'Users', 'yith-live-chat' );
            }
            else {
                $admin_tabs['premium-landing'] = __( 'Premium Version', 'yith-live-chat' );
            }

            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => __( 'Live Chat', 'yith-live-chat' ),
                'menu_title'       => __( 'Live Chat', 'yith-live-chat' ),
                'capability'       => 'manage_options',
                'parent'           => $this->_options_name,
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'admin-tabs'       => $admin_tabs,
                'plugin-url'       => YLC_URL,
                'options-path'     => YLC_DIR . 'plugin-options'
            );

            $this->_panel = new YIT_Plugin_Panel( $args );

        }

        /**
         * Add YITH Live Chat console page
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function add_console_page() {

            $page_title = __( 'YITH Live Chat', 'yith-live-chat' );

            /* === Add Chat Console Page === */
            if ( current_user_can( 'manage_options' ) ) {

                add_menu_page( $page_title, $page_title, 'manage_options', $this->_console_page, array( $this, 'get_console_template' ), YLC_ASSETS_URL . '/images/favicon.png', 63 );

            }
            else {

                if ( defined( 'YITH_WPV_PREMIUM' ) && YITH_WPV_PREMIUM ) {

                    if ( get_option( 'yith_wpv_vendors_option_live_chat_management' ) != 'yes' ) {
                        return;

                    }

                }

                if ( current_user_can( 'answer_chat' ) ) {

                    add_menu_page( $page_title, $page_title, 'answer_chat', $this->_console_page, array( $this, 'get_console_template' ), YLC_ASSETS_URL . '/images/favicon.png', 63 );

                }
            }

        }

        /**
         * Advise if the plugin cannot be performed
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function admin_notices() {

            ?>

            <div class="error">
                <p>
                    <?php _e( 'Please enter Firebase App URL and Firebase App Secret for YITH Live Chat', 'yith-live-chat' ); ?>
                </p>
            </div>

            <?php

        }

        /**
         * Add styles and scripts for options panel and chat console
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function admin_scripts() {

            switch ( ylc_get_current_page() ) {

                case $this->_panel_page:

                    wp_register_style( 'ylc-styles', YLC_ASSETS_URL . '/css/ylc-styles' . $this->is_script_debug_active() . '.css' );
                    wp_enqueue_style( 'ylc-styles' );

                    break;

                case $this->_console_page:

                    $this->admin_frontend_scripts();

                    //YLC Console Engine
                    wp_register_script( 'ylc-engine-console', YLC_ASSETS_URL . '/js/ylc-engine-console' . $this->is_script_debug_active() . '.js', array( 'jquery', 'ylc-firebase' ) );
                    wp_enqueue_script( 'ylc-engine-console' );

                    $js_vars = array(
                        'ajax_url'             => str_replace( array( 'https:', 'http:' ), '', admin_url( 'admin-ajax.php' ) ),
                        'plugin_url'           => YLC_ASSETS_URL,
                        'is_premium'           => ( defined( 'YLC_PREMIUM' ) ) ? true : false,
                        'company_avatar'       => apply_filters( 'ylc_company_avatar', '' ),
                        'default_user_avatar'  => apply_filters( 'ylc_default_avatar', '', 'user' ),
                        'default_admin_avatar' => apply_filters( 'ylc_default_avatar', '', 'admin' ),
                        'yith_wpv_active'      => ( defined( 'YLC_PREMIUM' ) && defined( 'YITH_WPV_PREMIUM' ) ) ? true : false,
                        'active_vendor'        => apply_filters( 'ylc_vendor', array(
                            'vendor_id'   => 0,
                            'vendor_name' => ''
                        ) ),
                        'vendor_only_chat'     => apply_filters( 'ylc_vendor_only', false ),
                        'templates'            => array(
                            'console_chat_line'    => file_get_contents( YLC_DIR . 'templates/chat-backend/console-chat-line.php' ),
                            'console_user_item'    => file_get_contents( YLC_DIR . 'templates/chat-backend/console-user-item.php' ),
                            'console_conversation' => file_get_contents( YLC_DIR . 'templates/chat-backend/console-conversation.php' ),
                            'console_user_info'    => file_get_contents( YLC_DIR . 'templates/chat-backend/console-user-info.php' ),
                            'console_user_tools'   => file_get_contents( YLC_DIR . 'templates/chat-backend/console-user-tools.php' ),
                            'premium'              => apply_filters( 'ylc_templates_premium', array(), 'console' ),
                        ),
                        'strings'              => $this->get_strings()
                    );
                    wp_localize_script( 'ylc-engine-console', 'ylc', $js_vars );

                    // Console stylesheet
                    wp_register_style( 'ylc-console', YLC_ASSETS_URL . '/css/ylc-console' . $this->is_script_debug_active() . '.css' );
                    wp_enqueue_style( 'ylc-console' );

                    break;

            }

        }

        /**
         * Create / Update Chat Operator Role
         *
         * @since   1.0.0
         *
         * @param   $role
         *
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function ylc_operator_role( $role ) {

            remove_role( 'ylc_chat_op' ); // First clean role
            $op_role = add_role( 'ylc_chat_op', __( 'YITH Live Chat Operator', 'yith-live-chat' ) ); // Create operator role
            $op_role->add_cap( 'answer_chat' ); // Add common operator capability

            switch ( $role ) {

                /** N/A */
                case 'none':
                    $op_role->add_cap( 'read' );
                    break;
                /** Other roles */
                default:
                    $r = get_role( $role ); // Get editor role

                    // Add editor caps to chat operator
                    foreach ( $r->capabilities as $custom_role => $v ) {
                        $op_role->add_cap( $custom_role );
                    }
            }

        }

        /**
         * Load Console Template
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function get_console_template() {

            require_once( YLC_TEMPLATE_PATH . '/chat-backend/chat-console.php' );

        }

        /**
         * Load Custom Text Template
         *
         * @since   1.0.0
         *
         * @param   $option
         * @param   $db_value
         * @param   $custom_attributes
         *
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function custom_text_template( $option, $db_value, $custom_attributes ) {

            require_once( YLC_TEMPLATE_PATH . '/admin/custom-text.php' );

        }

        /**
         * FRONTEND FUNCTIONS
         */

        /**
         * Enqueue Scripts
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function enqueue_scripts() {

            $show_chat = apply_filters( 'ylc_can_show_chat', true );

            if ( $show_chat ) {

                $this->admin_frontend_scripts();

                wp_register_style( 'ylc-frontend', YLC_ASSETS_URL . '/css/ylc-frontend' . $this->is_script_debug_active() . '.css' );
                wp_enqueue_style( 'ylc-frontend' );

                wp_register_script( 'ylc-engine-frontend', YLC_ASSETS_URL . '/js/ylc-engine-frontend' . $this->is_script_debug_active() . '.js', array( 'jquery', 'ylc-firebase' ) );
                wp_enqueue_script( 'ylc-engine-frontend' );

                $js_vars = array(
                    'ajax_url'             => str_replace( array( 'https:', 'http:' ), '', admin_url( 'admin-ajax.php' ) ),
                    'plugin_url'           => YLC_ASSETS_URL,
                    'frontend_op_access'   => ( current_user_can( 'answer_chat' ) ) ? true : false,
                    'is_premium'           => ( defined( 'YLC_PREMIUM' ) ) ? true : false,
                    'show_busy_form'       => apply_filters( 'ylc_busy_form', false ),
                    'max_guests'           => apply_filters( 'ylc_max_guests', 2 ),
                    'send_transcript'      => apply_filters( 'ylc_send_transcript', false ),
                    'chat_evaluation'      => apply_filters( 'ylc_chat_evaluation', false ),
                    'company_avatar'       => apply_filters( 'ylc_company_avatar', '' ),
                    'default_user_avatar'  => apply_filters( 'ylc_default_avatar', '', 'user' ),
                    'default_admin_avatar' => apply_filters( 'ylc_default_avatar', '', 'admin' ),
                    'autoplay_opts'        => apply_filters( 'ylc_autoplay_opts', array() ),
                    'yith_wpv_active'      => ( defined( 'YLC_PREMIUM' ) && defined( 'YITH_WPV_PREMIUM' ) ) ? true : false,
                    'active_vendor'        => apply_filters( 'ylc_vendor', array(
                        'vendor_id'   => 0,
                        'vendor_name' => ''
                    ) ),
                    'vendor_only_chat'     => apply_filters( 'ylc_vendor_only', false ),
                    'templates'            => array(
                        'chat_popup'        => file_get_contents( YLC_DIR . 'templates/chat-frontend/chat-popup.php' ),
                        'chat_connecting'   => file_get_contents( YLC_DIR . 'templates/chat-frontend/chat-connecting.php' ),
                        'chat_btn'          => file_get_contents( YLC_DIR . 'templates/chat-frontend/chat-btn.php' ),
                        'chat_offline'      => file_get_contents( YLC_DIR . 'templates/chat-frontend/chat-offline.php' ),
                        'chat_login'        => file_get_contents( YLC_DIR . 'templates/chat-frontend/chat-login.php' ),
                        'chat_conversation' => file_get_contents( YLC_DIR . 'templates/chat-frontend/chat-conversation.php' ),
                        'chat_line'         => file_get_contents( YLC_DIR . 'templates/chat-frontend/chat-line.php' ),
                        'premium'           => apply_filters( 'ylc_templates_premium', array(), 'frontend' ),
                    ),
                    'strings'              => $this->get_strings()
                );

                wp_localize_script( 'ylc-engine-frontend', 'ylc', $js_vars );

            }

        }

        /**
         * Load Chat Box
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function show_chat() {

            $show_chat = apply_filters( 'ylc_can_show_chat', true );

            if ( $show_chat ) {

                require_once( YLC_TEMPLATE_PATH . '/chat-frontend/chat-container.php' );

            }

        }

        /**
         * YITH FRAMEWORK
         */

        /**
         * Enqueue css file
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
            $premium_tab_template = YLC_TEMPLATE_PATH . '/admin/' . $this->_premium;
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
         *
         * @since   1.0.0
         *
         * @param   $links | links plugin array
         *
         * @return  mixed
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @use     plugin_action_links_{$plugin_file_name}
         */
        public function action_links( $links ) {

            $links[] = '<a href="' . admin_url( "admin.php?page={$this->_panel_page}" ) . '">' . __( 'Settings', 'yith-live-chat' ) . '</a>';

            if ( defined( 'YLC_FREE_INIT' ) ) {
                $links[] = '<a href="' . $this->get_premium_landing_uri() . '" target="_blank">' . __( 'Premium Version', 'yith-live-chat' ) . '</a>';
            }

            return $links;
        }

        /**
         * plugin_row_meta
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
         * @return  Array
         * @author  Andrea Grillo <andrea.grillo@yithemes.com>
         * @use     plugin_row_meta
         */
        public function plugin_row_meta( $plugin_meta, $plugin_file, $plugin_data, $status ) {
            if ( ( defined( 'YLC_INIT' ) && ( YLC_INIT == $plugin_file ) ) ||
                ( defined( 'YLC_FREE_INIT' ) && ( YLC_FREE_INIT == $plugin_file ) )
            ) {

                $plugin_meta[] = '<a href="' . $this->_official_documentation . '" target="_blank">' . __( 'Plugin Documentation', 'yith-live-chat' ) . '</a>';
            }

            return $plugin_meta;
        }

    }

}