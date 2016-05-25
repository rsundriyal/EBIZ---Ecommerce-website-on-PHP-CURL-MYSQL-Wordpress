<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( !defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( !class_exists( 'YWRR_Review_Reminder' ) ) {

    /**
     * Implements features of YWRR plugin
     *
     * @class   YWRR_Review_Reminder
     * @package Yithemes
     * @since   1.0.0
     * @author  Your Inspiration Themes
     */
    class YWRR_Review_Reminder {

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
        protected $_premium_landing = 'http://yithemes.com/themes/plugins/yith-woocommerce-review-reminder/';

        /**
         * @var string Plugin official documentation
         */
        protected $_official_documentation = 'http://yithemes.com/docs-plugins/yith_woocommerce_review_reminder/';

        /**
         * @var string Yith WooCommerce Review Reminder panel page
         */
        protected $_panel_page = 'yith_ywrr_panel';

        /**
         * @var array
         */
        protected $_email_types = array();

        /**
         * @var array
         */
        var $_email_templates = array();

        /**
         * Single instance of the class
         *
         * @var \YWRR_Review_Reminder
         * @since 1.1.5
         */
        protected static $instance;

        /**
         * Returns single instance of the class
         *
         * @return \YWRR_Review_Reminder
         * @since 1.1.5
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

            $this->_email_types = array(
                'request' => array(
                    'class' => 'YWRR_Request_Mail',
                    'file'  => 'class-ywrr-request-email.php',
                ),
            );

            // Load Plugin Framework
            add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 12 );

            //Add action links
            add_filter( 'plugin_action_links_' . plugin_basename( YWRR_DIR . '/' . basename( YWRR_FILE ) ), array( $this, 'action_links' ) );
            add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 4 );

            // Include required files
            $this->includes();

            //  Add stylesheets and scripts files
            add_action( 'admin_menu', array( $this, 'add_menu_page' ), 5 );
            add_action( 'yith_review_reminder_premium', array( $this, 'premium_tab' ) );

            if ( is_admin() ) {

                add_action( 'admin_enqueue_scripts', array( $this, 'ywrr_admin_scripts' ) );
                add_action( 'ywrr_howto', array( $this, 'get_howto_content' ) );
                add_action( 'ywrr_blocklist', array( YWRR_Blocklist_Table(), 'output' ) );
                add_action( 'admin_notices', array( $this, 'ywrr_protect_unsubscribe_page_notice' ) );
                add_action( 'wp_trash_post', array( $this, 'ywrr_protect_unsubscribe_page' ), 10, 1 );
                add_action( 'before_delete_post', array( $this, 'ywrr_protect_unsubscribe_page' ), 10, 1 );
            }
            else {

                add_action( 'template_redirect', array( $this, 'unsubscribe_review_request' ) );
                add_shortcode( 'ywrr_unsubscribe', array( $this, 'ywrr_unsubscribe' ) );
                add_filter( 'wp_get_nav_menu_items', array( $this, 'ywrr_hide_unsubscribe_page' ), 10, 3 );

            }

            /* if ( get_option( 'ywrr_enable_plugin' ) == 'yes' ) {

                 add_action( 'woocommerce_order_status_completed', array( YWRR_Schedule(), 'schedule_mail' ), 10, 2 );
                 add_action( 'ywrr_daily_send_mail_job', array( YWRR_Schedule(), 'daily_schedule' ) );

             }*/
            add_action( 'init', array( $this, 'ywrr_create_pages' ) );

            add_filter( 'woocommerce_email_classes', array( $this, 'ywrr_custom_email' ) );

            add_option( 'ywrr_mail_schedule_day', 7 );
            add_option( 'ywrr_mail_template', 'base' );

            add_action( 'ywrr_email_header', array( $this, 'ywrr_email_header' ), 10, 2 );
            add_action( 'ywrr_email_footer', array( $this, 'ywrr_email_footer' ), 10, 2 );

        }

        /**
         * Files inclusion
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        private function includes() {

            include_once( 'includes/class-ywrr-emails.php' );
            include_once( 'includes/class-ywrr-blocklist.php' );
            include_once( 'includes/class-ywrr-schedule.php' );

            if ( is_admin() ) {
                include_once( 'includes/admin/class-yith-custom-table.php' );
                include_once( 'includes/admin/class-ywrr-ajax.php' );
                include_once( 'templates/admin/class-yith-wc-custom-textarea.php' );
                include_once( 'templates/admin/class-ywrr-custom-send.php' );
                include_once( 'templates/admin/blocklist-table.php' );
            }

        }

        /**
         * Initializes Javascript with localization
         *
         * @since   1.1.5
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function ywrr_admin_scripts() {
            global $post;

            $suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

            wp_enqueue_style( 'ywrr-admin', YWRR_ASSETS_URL . 'css/ywrr-admin' . $suffix . '.css' );

            wp_enqueue_script( 'ywrr-admin', YWRR_ASSETS_URL . 'js/ywrr-admin' . $suffix . '.js' );

            $params = apply_filters( 'ywrr_admin_scripts_filter', array(
                'ajax_url'               => admin_url( 'admin-ajax.php' ),
                'after_send_test_email'  => __( 'Test email has been sent successfully!', 'yith-woocommerce-review-reminder' ),
                'test_mail_wrong'        => __( 'Please insert a valid email address', 'yith-woocommerce-review-reminder' ),
                'before_send_test_email' => __( 'Sending test email...', 'yith-woocommerce-review-reminder' ),
            ), $post );

            wp_localize_script( 'ywrr-admin', 'ywrr_admin', $params );

        }

        /**
         * Get placeholder reference content.
         *
         * @since   1.1.5
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function get_howto_content() {

            ?>
            <div id="plugin-fw-wc">
                <h3>
                    <?php _e( 'Placeholder reference', 'yith-woocommerce-review-reminder' ); ?>
                </h3>
                <table class="form-table">
                    <tbody>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{customer_name}</b>
                        </th>
                        <td class="forminp">
                            <?php _e( 'Replaced with the customer\'s name', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{customer_email}</b>
                        </th>
                        <td class="forminp">
                            <?php _e( 'Replaced with the customer\'s email', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{site_title}</b>
                        </th>
                        <td class="forminp">
                            <?php _e( 'Replaced with the site title', 'yith-woocommerce-review-reminder' ); ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{order_id}</b>
                        </th>
                        <td class="forminp">
                            <?php _e( 'Replaced with the order ID', 'yith-woocommerce-review-reminder' ); ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{order_date}</b>
                        </th>
                        <td class="forminp">
                            <?php _e( 'Replaced with the date and time of the order', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{order_date_completed}</b>
                        </th>
                        <td class="forminp">
                            <?php _e( 'Replaced with the date the order was marked completed', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{order_list}</b>
                        </th>
                        <td class="forminp">
                            <?php _e( 'Replaced with a list of products purchased but not reviewed (Do not forget it!!!)', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{days_ago}</b>
                        </th>
                        <td class="forminp">
                            <?php _e( 'Replaced with the days ago the order was made', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <b>{unsubscribe_link}</b>
                        </th>
                        <td class="forminp">
                            <?php _e( 'Replaced with the link to the unsubscribe page (If you use standard WooCommerce template, do not forget it!)', 'yith-woocommerce-review-reminder' ) ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <?php
        }

        /**
         * Get the email header.
         *
         * @since   1.0.0
         *
         * @param   $email_heading
         * @param   $template
         *
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function ywrr_email_header( $email_heading, $template = false ) {

            if ( !$template ) {
                $template = get_option( 'ywrr_mail_template' );
            }

            if ( array_key_exists( $template, $this->_email_templates ) ) {

                $path   = $this->_email_templates[$template]['path'];
                $folder = $this->_email_templates[$template]['folder'];

                wc_get_template( $folder . '/email-header.php', array( 'email_heading' => $email_heading ), '', $path );

            }
            else {

                wc_get_template( 'emails/email-header.php', array( 'email_heading' => $email_heading, 'mail_type' => 'yith-review-reminder' ) );

            }

        }

        /**
         * Get the email footer.
         *
         * @since   1.0.0
         *
         * @param   $unsubscribe
         * @param   $template
         *
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function ywrr_email_footer( $unsubscribe, $template = false ) {

            if ( !$template ) {
                $template = get_option( 'ywrr_mail_template' );
            }

            if ( array_key_exists( $template, $this->_email_templates ) ) {

                $path   = $this->_email_templates[$template]['path'];
                $folder = $this->_email_templates[$template]['folder'];

                wc_get_template( $folder . '/email-footer.php', array( 'unsubscribe' => $unsubscribe ), '', $path );

            }
            else {

                wc_get_template( 'emails/email-footer.php', array( 'mail_type' => 'yith-review-reminder' ) );

            }

        }

        /**
         * Set the list item for the selected template.
         *
         * @since   1.0.0
         *
         * @param   $item_list
         * @param   $template
         *
         * @return  string
         * @author  Alberto Ruggiero
         */
        public function ywrr_email_items_list( $item_list, $template = false ) {

            if ( !$template ) {
                $template = get_option( 'ywrr_mail_template' );
            }

            if ( array_key_exists( $template, $this->_email_templates ) ) {

                $path   = $this->_email_templates[$template]['path'];
                $folder = $this->_email_templates[$template]['folder'];

                $style = wc_get_template_html( $folder . '/email-items-list.php', array( 'item_list' => $item_list ), '', $path );

            }
            elseif ( defined( 'YITH_WCET_PREMIUM' ) && get_option( 'ywrr_mail_template_enable' ) == 'yes' ) {

                $style = wc_get_template_html( '/emails/woocommerce2.4/emails/email-items-list.php', array( 'item_list' => $item_list ), '', YITH_WCET_TEMPLATE_PATH );

            }
            else {

                $style = wc_get_template_html( 'emails/email-items-list.php', array( 'item_list' => $item_list ), '', YWRR_TEMPLATE_PATH );

            }


            return $style;

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

            if ( defined( 'YWRR_PREMIUM' ) && YWRR_PREMIUM ) {

                $admin_tabs['premium-mail'] = __( 'Mail Settings', 'yith-woocommerce-review-reminder' );
                $admin_tabs['settings']     = __( 'Request Settings', 'yith-woocommerce-review-reminder' );
                $admin_tabs['mandrill']     = __( 'Mandrill Settings', 'yith-woocommerce-review-reminder' );
                $admin_tabs['schedule']     = __( 'Schedule List', 'yith-woocommerce-review-reminder' );

            }
            else {

                $admin_tabs['mail'] = __( 'Mail Settings', 'yith-woocommerce-review-reminder' );

            }

            $admin_tabs['blocklist'] = __( 'Blocklist', 'yith-woocommerce-review-reminder' );
            $admin_tabs['howto']     = __( 'How-To', 'yith-woocommerce-review-reminder' );

            if ( !defined( 'YWRR_PREMIUM' ) || !YWRR_PREMIUM ) {

                $admin_tabs['premium-landing'] = __( 'Premium Version', 'yith-woocommerce-review-reminder' );

            }

            $args = array(
                'create_menu_page' => true,
                'parent_slug'      => '',
                'page_title'       => __( 'Review Reminder', 'yith-woocommerce-review-reminder' ),
                'menu_title'       => __( 'Review Reminder', 'yith-woocommerce-review-reminder' ),
                'capability'       => 'manage_options',
                'parent'           => '',
                'parent_page'      => 'yit_plugin_panel',
                'page'             => $this->_panel_page,
                'admin-tabs'       => $admin_tabs,
                'options-path'     => YWRR_DIR . '/plugin-options'
            );

            $this->_panel = new YIT_Plugin_Panel_WooCommerce( $args );
        }

        /**
         * Creates the unsubscribe page
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function ywrr_create_pages() {

            if ( get_option( 'ywrr_unsubscribe_page_id' ) ) {
                return;
            }

            $page_data = array(
                'post_status'    => 'publish',
                'post_type'      => 'page',
                'post_author'    => 1,
                'post_name'      => _x( 'unsubscribe', 'Page slug', 'yith-woocommerce-review-reminder' ),
                'post_title'     => _x( 'Unsubscribe', 'Page title', 'yith-woocommerce-review-reminder' ),
                'post_content'   => '[ywrr_unsubscribe]',
                'post_parent'    => 0,
                'comment_status' => 'closed'
            );
            $page_id   = wp_insert_post( $page_data );

            update_option( 'ywrr_unsubscribe_page_id', $page_id );

        }

        /**
         * Add the YWRR_Request_Mail class to WooCommerce mail classes
         *
         * @since   1.0.0
         *
         * @param   $email_classes
         *
         * @return  array
         * @author  Alberto Ruggiero
         */
        public function ywrr_custom_email( $email_classes ) {

            foreach ( $this->_email_types as $type => $email_type ) {
                $email_classes[$email_type['class']] = include( "includes/emails/{$email_type['file']}" );
            }

            return $email_classes;
        }

        /**
         * Notifies the inability to delete the page
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function ywrr_protect_unsubscribe_page_notice() {
            global $post_type, $pagenow;

            if ( $pagenow == 'edit.php' && $post_type == 'page' && isset( $_GET['impossible'] ) ) {
                echo '<div id="message" class="error"><p>' . __( 'The unsubscribe page cannot be deleted', 'yith-woocommerce-review-reminder' ) . '</p></div>';
            }
        }

        /**
         * Prevent the deletion of unsubscribe page
         *
         * @since   1.0.0
         *
         * @param   $post_id
         *
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function ywrr_protect_unsubscribe_page( $post_id ) {
            if ( $post_id == get_option( 'ywrr_unsubscribe_page_id' ) ) {

                $query_args = array(
                    'post_type'  => 'page',
                    'impossible' => '1'
                );
                $error_url  = esc_url( add_query_arg( $query_args, admin_url( 'edit.php' ) ) );

                wp_redirect( $error_url );
                exit();
            }
        }

        /**
         * FRONTEND FUNCTIONS
         */

        /**
         * Hides unsubscribe page from menus
         *
         * @since   1.0.0
         *
         * @param   $items
         * @param   $menu
         * @param   $args
         *
         * @return  array
         * @author  Andrea Grillo
         */
        public function ywrr_hide_unsubscribe_page( $items, $menu, $args ) {

            foreach ( $items as $key => $value ) {
                if ( 'unsubscribe' === basename( $value->url ) ) {
                    unset( $items[$key] );
                }
            }

            return $items;

        }

        /**
         * Unsubscribe page shortcode.
         *
         * @since   1.0.0
         * @return  string
         * @author  Alberto Ruggiero
         */
        public function ywrr_unsubscribe() {
            echo '<div class ="woocommerce">';

            wc_get_template( 'unsubscribe.php', array(), YWRR_TEMPLATE_PATH, YWRR_TEMPLATE_PATH );

            echo '</div>';
        }

        /**
         * Handles the unsubscribe form
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function unsubscribe_review_request() {

            if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
                return;
            }

            if ( empty( $_POST['action'] ) || 'unsubscribe_review_request' !== $_POST['action'] || empty( $_POST['_wpnonce'] ) || !wp_verify_nonce( $_POST['_wpnonce'], 'unsubscribe_review_request' ) ) {
                return;
            }
            $customer_id    = !empty( $_POST['account_id'] ) ? $_POST['account_id'] : 0;
            $customer_email = !empty( $_POST['account_email'] ) ? sanitize_email( $_POST['account_email'] ) : '';

            if ( empty( $customer_email ) || !is_email( $customer_email ) ) {
                wc_add_notice( __( 'Please provide a valid email address.', 'yith-woocommerce-review-reminder' ), 'error' );
            }
            elseif ( $customer_email !== urldecode( base64_decode( $_GET['email'] ) ) ) {
                wc_add_notice( __( 'Please retype the email address as provided.', 'yith-woocommerce-review-reminder' ), 'error' );
            }

            if ( wc_notice_count( 'error' ) === 0 ) {

                if ( true == YWRR_Blocklist()->check_blocklist( $customer_id, $customer_email ) ) {

                    try {
                        YWRR_Blocklist()->add_to_blocklist( $customer_id, $customer_email );
                        wc_add_notice( __( 'Unsubscribe was successful.', 'yith-woocommerce-review-reminder' ) );
                        wp_safe_redirect( get_permalink( get_option( 'ywrr_unsubscribe_page_id' ) ) );
                        exit;

                    } catch ( Exception $e ) {

                        wc_add_notice( __( 'An error has occurred', 'yith-woocommerce-review-reminder' ), 'error' );

                    }

                }
                else {
                    wc_add_notice( __( 'You have already unsubscribed', 'yith-woocommerce-review-reminder' ), 'error' );
                }

            }
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
            $premium_tab_template = YWRR_TEMPLATE_PATH . '/admin/' . $this->_premium;
            if ( file_exists( $premium_tab_template ) ) {
                include_once( $premium_tab_template );
            }
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

            $links[] = '<a href="' . admin_url( "admin.php?page={$this->_panel_page}" ) . '">' . __( 'Settings', 'yith-woocommerce-review-reminder' ) . '</a>';

            if ( defined( 'YWRR_FREE_INIT' ) ) {
                $links[] = '<a href="' . $this->_premium_landing . '" target="_blank">' . __( 'Premium Version', 'yith-woocommerce-review-reminder' ) . '</a>';
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
            if ( ( defined( 'YWRR_INIT' ) && ( YWRR_INIT == $plugin_file ) ) ||
                ( defined( 'YWRR_FREE_INIT' ) && ( YWRR_FREE_INIT == $plugin_file ) )
            ) {

                $plugin_meta[] = '<a href="' . $this->_official_documentation . '" target="_blank">' . __( 'Plugin Documentation', 'yith-woocommerce-review-reminder' ) . '</a>';
            }

            return $plugin_meta;
        }

        /**
         * Get the premium landing uri
         *
         * @since   1.0.0
         * @return  string
         * @author  Alberto Ruggiero
         */
        public function get_premium_landing_uri() {
            return defined( 'YITH_REFER_ID' ) ? $this->_premium_landing . '?refer_id=' . YITH_REFER_ID : $this->_premium_landing;
        }

    }

}