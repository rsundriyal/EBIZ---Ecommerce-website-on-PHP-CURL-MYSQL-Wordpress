<?php

if ( !defined( 'ABSPATH' ) || !defined( 'YITH_YWRAQ_VERSION' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Implements features of YITH Woocommerce Request A Quote
 *
 * @class   YITH_Request_Quote
 * @package YITH Woocommerce Request A Quote
 * @since   1.0.0
 * @author  Yithemes
 */
if ( !class_exists( 'YITH_Request_Quote' ) ) {

    class YITH_Request_Quote {

        /**
         * Single instance of the class
         *
         * @var \YITH_Request_Quote
         */

        protected static $instance;

        /**
         * Session object
         */
        public $session_class;


        /**
         * Content of session
         */
        public $raq_content = array();


        /**
         * Returns single instance of the class
         *
         * @return \YITH_Request_Quote
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
         * Initialize plugin and registers actions and filters to be used
         *
         * @since  1.0.0
         * @author Emanuela Castorina
         */
        public function __construct() {

			add_action( 'init', array( $this, 'start_session' ));

            /* plugin */
            add_action( 'plugins_loaded', array( $this, 'plugin_fw_loader' ), 15 );

            /* ajax action */
            add_action( 'wp_ajax_yith_ywraq_action', array( $this, 'ajax' ) );
            add_action( 'wp_ajax_nopriv_yith_ywraq_action', array( $this, 'ajax' ) );

            /* session settings */
            add_action( 'wp_loaded', array( $this, 'init' ) ); // Get raq after WP and plugins are loaded.
            add_action( 'wp_loaded', array( $this, 'ywraq_time_validation_schedule' ) );
            add_action( 'wp', array( $this, 'maybe_set_raq_cookies' ), 99 ); // Set cookies
            add_action( 'shutdown', array( $this, 'maybe_set_raq_cookies' ), 0 ); // Set cookies before shutdown and ob flushing

            /* email actions and filter */
            add_filter( 'woocommerce_email_classes', array( $this, 'add_woocommerce_emails' ) );
            add_action( 'woocommerce_init', array( $this, 'load_wc_mailer' ) );
            add_action( 'init', array( $this, 'send_message' ));

            add_action( 'ywraq_clean_cron', array( $this, 'clean_session') );

            /* general actions */
            add_filter( 'woocommerce_locate_core_template', array( $this, 'filter_woocommerce_template' ), 10, 3 );
            add_filter( 'woocommerce_locate_template', array( $this, 'filter_woocommerce_template' ), 10, 3 );


        }

		/**
		 * Initialize session and cookies
		 *
		 * @since  1.0.0
		 * @author Emanuela Castorina
		 */
		function start_session(){

			if( ! isset( $_COOKIE['woocommerce_items_in_cart'] ) ) {
				do_action( 'woocommerce_set_cart_cookies', true );
			}
			$this->session_class = new YITH_YWRAQ_Session();
			$this->set_session();
		}

        /**
         * Initialize functions
         *
         * @since  1.0.0
         * @author Emanuela Castorina
         */
        function init() {
            $this->get_raq_for_session();
            $this->session_class->set_customer_session_cookie(true);
        }

        /**
         * Load YIT Plugin Framework
         *
         * @since  1.0.0
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
         * Get request quote list
         *
         * @since  1.0.0
         * @return array
         * @author Emanuela Castorina
         */
        function get_raq_return() {
            return $this->raq_content;
        }

        /**
         * Get all errors in HTML mode or simple string.
         *
         * @param bool $html
         * @return string
         * @since 1.0.0
         */
        public function get_errors( $errors , $html = true ) {
            return implode( ( $html ? '<br />' : ', ' ), $errors );
        }

        /**
         * is_empty
         *
         * return true if the list is empty
         * @since  1.0.0
         * @return bool
         * @author Emanuela Castorina
         */
        public function is_empty() {
            return empty( $this->raq_content );
        }

        /**
         * get_item_number
         *
         * return true if the list is empty
         * @since  1.0.0
         * @return bool
         * @author Emanuela Castorina
         */
        public function get_raq_item_number() {
            return count( $this->raq_content );
        }

        /**
         * Get request quote list from session
         *
         * @since  1.0.0
         * @return array
         * @author Emanuela Castorina
         */
        function get_raq_for_session() {
            $this->raq_content = $this->session_class->get( 'raq', array() );
            return $this->raq_content;
        }

        /**
         * Sets the php session data for the request a quote
         *
         * @since  1.0.0
         * @return void
         * @author Emanuela Castorina
         */
        public function set_session( $raq_session = array(), $can_be_empty = false ) {
            if ( empty( $raq_session ) && ! $can_be_empty ) {
                $raq_session = $this->get_raq_for_session();
            }

            // Set raq  session data
            $this->session_class->set( 'raq', $raq_session );

            do_action( 'yith_raq_updated' );
        }

        /**
         * Unset the session
         *
         * @since  1.0.0
         * @return void
         * @author Emanuela Castorina
         */
        public function unset_session() {
            // Set raq and coupon session data
            $this->session_class->__unset( 'raq' );
        }

        /**
         * Set Request a quote cookie
         *
         * @since  1.0.0
         * @return void
         * @author Emanuela Castorina
         */
        function maybe_set_raq_cookies() {
            $set = true;

            if ( !headers_sent() ) {
                if ( sizeof( $this->raq_content ) > 0 ) {
                    $this->set_rqa_cookies( true );
                    $set = true;
                }
                elseif ( isset( $_COOKIE['yith_ywraq_items_in_raq'] ) ) {
                    $this->set_rqa_cookies( false );
                    $set = false;
                }
            }

            do_action( 'yith_ywraq_set_raq_cookies', $set );
        }

        /**
         * Set hash cookie and items in raq.
         *
         * @since  1.0.0
         * @access private
         * @return void
         * @author Emanuela Castorina
         */
        private function set_rqa_cookies( $set = true ) {
            if ( $set ) {
                wc_setcookie( 'yith_ywraq_items_in_raq', 1 );
                wc_setcookie( 'yith_ywraq_hash', md5( json_encode( $this->raq_content ) ) );
            }
            elseif ( isset( $_COOKIE['yith_ywraq_items_in_raq'] ) ) {
                wc_setcookie( 'yith_ywraq_items_in_raq', 0, time() - HOUR_IN_SECONDS );
                wc_setcookie( 'yith_ywraq_hash', '', time() - HOUR_IN_SECONDS );
            }
            do_action( 'yith_ywraq_set_rqa_cookies', $set );
        }

        /**
         * Check if the product is in the list
         */
        public function exists( $product_id, $variation_id = false ) {

            if ( $variation_id ) {
                //variation product
                $key_to_find = md5( $product_id . $variation_id );
            } else {
                $key_to_find = md5( $product_id );
            }

            if ( array_key_exists( $key_to_find, $this->raq_content ) ) {
                $this->errors[] = __( 'Product already in the list.', 'yith-woocommerce-request-a-quote' );
                return true;
            }

            return false;
        }

        /**
         * Add an item to request quote list
         */
        public function add_item( $product_raq ) {

            $product_raq['quantity'] = ( isset( $product_raq['quantity'] ) ) ? (int) $product_raq['quantity'] : 1;

            $return = '';
            if ( !isset( $product_raq['variation_id'] ) ) {
                //single product
                if ( !$this->exists( $product_raq['product_id'] ) ) {
                    $raq = array(
                        'product_id' => $product_raq['product_id'],
                        'quantity'   => $product_raq['quantity']
                    );

                    $this->raq_content[md5( $product_raq['product_id'] )] = $raq;


                }
                else {
                    $return = 'exists';
                }
            }
            else {
                //variable product
                if ( !$this->exists( $product_raq['product_id'], $product_raq['variation_id'] ) ) {

                    $raq = array(
                        'product_id'   => $product_raq['product_id'],
                        'variation_id' => $product_raq['variation_id'],
                        'quantity'     => $product_raq['quantity']
                    );

                    $variations = array();

                    foreach ( $product_raq as $key => $value ) {

                        if ( stripos( $key, 'attribute' ) !== false ) {
                            $variations[$key] = $value;
                        }
                    }

                    $raq ['variations'] = $variations;

                    $this->raq_content[md5( $product_raq['product_id'] . $product_raq['variation_id'] )] = $raq;

                }
                else {
                    $return = 'exists';
                }
            }


            if ( $return != 'exists' ) {

                $this->set_session( $this->raq_content );

                $return = 'true';

                $this->set_rqa_cookies( sizeof( $this->raq_content ) > 0 );
            }


            return $return;

        }

        /**
         * Remove an item form the request list
         */
        public function remove_item( $key ) {
            if ( isset( $this->raq_content[$key] ) ) {
                unset( $this->raq_content[$key] );
                $this->set_session( $this->raq_content, true );
                return true;
            }
            else {
                return false;
            }
        }

        /**
         * Clear the list
         */
        public function clear_raq_list() {
            $this->raq_content = array();
            $this->set_session( $this->raq_content, true );
        }

        /**
         * Update an item in the raq list
         */
        public function update_item( $key, $field = false, $value ) {

            if ( $field && isset( $this->raq_content[$key][$field] ) ) {
                $this->raq_content[$key][$field] = $value;
                $this->set_session( $this->raq_content );

            }
            elseif ( isset( $this->raq_content[$key] ) ) {
                $this->raq_content[$key] = $value;
                $this->set_session( $this->raq_content );
            }
            else {
                return false;
            }

            $this->set_session( $this->raq_content );
            return true;
        }

        /**
         * Switch a ajax call
         */
        public function ajax() {
            if ( isset( $_POST['ywraq_action'] ) ) {
                if ( method_exists( $this, 'ajax_' . $_POST['ywraq_action'] ) ) {
                    $s = 'ajax_' . $_POST['ywraq_action'];
                    $this->$s();
                }
            }
        }

        /**
         * Add an item to request quote list in ajax mode
         *
         * @return string
         * @since  1.0.0
         */
        public function ajax_add_item() {
            $return  = 'false';
            $message = '';
            $errors = array();

            $product_id         = ( isset( $_POST['product_id'] ) && is_numeric( $_POST['product_id'] ) ) ? (int) $_POST['product_id'] : false;
            $is_valid_variation = isset( $_POST['variation_id'] ) ? !( ( empty( $_POST['variation_id'] ) || !is_numeric( $_POST['variation_id'] ) ) ) : true;

            $is_valid = $is_valid_variation;

            if ( !$is_valid ) {
                $errors[] = __( 'Error occurred while adding product to Request a Quote list.', 'yith-woocommerce-request-a-quote' );
            }
            else {
                $return = $this->add_item( $_POST );
            }

            if ( $return == 'true' ) {
                $message = apply_filters( 'yith_ywraq_product_added_to_list_message', __( 'Product added!', 'yith-woocommerce-request-a-quote' ) );
            }
            elseif ( $return == 'exists' ) {
                $message = apply_filters( 'yith_ywraq_product_already_in_list_message', __( 'Product already in the list.', 'yith-woocommerce-request-a-quote' ) );
            }
            elseif ( count( $errors ) > 0 ) {
                $message = apply_filters( 'yith_ywraq_error_adding_to_list_message', $this->get_errors($errors) );
            }

            wp_send_json(
                array(
                    'result'       => $return,
                    'message'      => $message,
                    'label_browse' => ywraq_get_browse_list_message(),
                    'rqa_url'      => $this->get_raq_page_url(),
                )
            );
        }

        /**
         * Remove an item from the list in ajax mode
         *
         * @return string
         * @since  1.0.0
         */
        public function ajax_remove_item() {
            $product_id = ( isset( $_POST['product_id'] ) && is_numeric( $_POST['product_id'] ) ) ? (int) $_POST['product_id'] : false;
            $is_valid   = $product_id && isset( $_POST['key'] );
            if ( $is_valid ) {
                echo $this->remove_item( $_POST['key'] );
            }
            else {
                echo false;
            }
            die();
        }

        /**
         * Check if an element exist the list in ajax mode
         *
         * @return string
         * @since  1.0.0
         */
        public function ajax_variation_exist() {
            if ( isset( $_POST['product_id'] ) && isset( $_POST['variation_id'] ) ) {

                $message = '';
                $return  = $this->exists( $_POST['product_id'], $_POST['variation_id'] );
                if ( $return == 'true' ) {
                    $message = apply_filters( 'yith_ywraq_product_already_in_list_message', __( 'Product already in the list.', 'yith-woocommerce-request-a-quote' ) );
                }

                wp_send_json(
                    array(
                        'result'       => $return,
                        'message'      => $message,
                        'label_browse' => ywraq_get_browse_list_message(),
                        'rqa_url'      => $this->get_raq_page_url(),
                    )
                );
            }
        }

        /**
         * Return the url of request quote page
         *
         * @return string
         * @since 1.0.0
         */
        public function get_raq_page_url() {
            $option_value = get_option( 'ywraq_page_id' );
            $base_url     = get_the_permalink( $option_value );

            return apply_filters( 'ywraq_request_page_url', $base_url );
        }

        /**
         * Locate default templates of woocommerce in plugin, if exists
         *
         * @param $core_file     string
         * @param $template      string
         * @param $template_base string
         *
         * @return string
         * @since  1.0.0
         */
        public function filter_woocommerce_template( $core_file, $template, $template_base ) {
            $located = yith_ywraq_locate_template( $template );

            if( $located ){
                return $located;
            }
            else{
                return $core_file;
            }
        }

        /**
         * Get all errors in HTML mode or simple string.
         *
         * @return void
         * @since 1.0.0
         */
        public function send_message() {

            $errors = array();

            if ( ! isset( $_POST['rqa_name'] ) ) {
               return;
            }else {


                $regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';

                if ( empty( $_POST['rqa_name'] ) ) {
                    $errors[] = '<p>' . __( 'Please enter a name', 'yith-woocommerce-request-a-quote' ) . '</p>';
                }

                if ( ! isset( $_POST['rqa_email'] ) || empty( $_POST['rqa_email'] ) || ! preg_match( $regex, $_POST['rqa_email'] ) ) {
                    $errors[] = '<p>' . __( 'Please enter a valid email', 'yith-woocommerce-request-a-quote' ) . '</p>';
                }

                if ( YITH_Request_Quote()->is_empty() ) {
                    $errors[] = '<p>' . __( 'Your list is empty, add products to the list to send a request', 'yith-woocommerce-request-a-quote' ) . '</p>';
                }

                if ( empty( $errors ) ) {

                    $args = array(
                        'user_name'    => $_POST['rqa_name'],
                        'user_email'   => $_POST['rqa_email'],
                        'user_message' => nl2br( $_POST['rqa_message'] ),
                        'raq_content'  => YITH_Request_Quote()->get_raq_return()
                    );

                    do_action( 'ywraq_process', $args );
                    do_action( 'send_raq_mail', $args );
                    wp_redirect( YITH_Request_Quote()->get_raq_page_url(), 301 );
                    exit();
                }
            }

            yith_ywraq_add_notice( $this->get_errors( $errors ), 'error' );

        }

        /**
         * Filters woocommerce available mails, to add wishlist related ones
         *
         * @param $emails array
         *
         * @return array
         * @since 1.0
         */
        public function add_woocommerce_emails( $emails ) {
            $emails['YITH_YWRAQ_Send_Email_Request_Quote'] = include( YITH_YWRAQ_INC . 'emails/class.yith-ywraq-send-email-request-quote.php' );
            return $emails;
        }

        /**
         * Loads WC Mailer when needed
         *
         * @return void
         * @since 1.0
         */
        public function load_wc_mailer() {
            add_action( 'send_raq_mail', array( 'WC_Emails', 'send_transactional_email' ), 10 );
        }

        public function ywraq_time_validation_schedule(){

            if( ! wp_next_scheduled( 'ywraq_time_validation' ) ){
                $ve = get_option( 'gmt_offset' ) > 0 ? '+' : '-';
                wp_schedule_event( strtotime( '00:00 tomorrow ' . $ve . get_option( 'gmt_offset' ) . ' HOURS'), 'daily', 'ywraq_time_validation' );
            }

            if ( !wp_next_scheduled( 'ywraq_clean_cron' ) ) {
                wp_schedule_event( time(), 'daily', 'ywraq_clean_cron' );
            }
        }
        
        public function clean_session(){
            global $wpdb;
            $query = $wpdb->query("DELETE FROM ". $wpdb->prefix ."options  WHERE option_name LIKE '_yith_ywraq_session_%'");
        }
    }
}

/**
 * Unique access to instance of YITH_Request_Quote class
 *
 * @return \YITH_Request_Quote
 */
function YITH_Request_Quote() {
    return YITH_Request_Quote::get_instance();
}

