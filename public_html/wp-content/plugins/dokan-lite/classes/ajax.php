<?php
/**
 * Ajax handler for Dokan
 *
 * @package Dokan
 */
class Dokan_Ajax {

    /**
     * Singleton object
     *
     * @staticvar boolean $instance
     * @return \self
     */
    public static function init() {

        static $instance = false;

        if ( !$instance ) {
            $instance = new self;
        }

        return $instance;
    }

    /**
     * Init ajax handlers
     *
     * @return void
     */
    function init_ajax() {
        //withdraw note
        $withdraw = Dokan_Admin_Withdraw::init();
        add_action( 'wp_ajax_note', array( $withdraw, 'note_update' ) );
        add_action( 'wp_ajax_withdraw_ajax_submission', array( $withdraw, 'withdraw_ajax' ) );

        //settings
        $settings = Dokan_Template_Settings::init();
        add_action( 'wp_ajax_dokan_settings', array( $settings, 'ajax_settings' ) );

        add_action( 'wp_ajax_dokan-mark-order-complete', array( $this, 'complete_order' ) );
        add_action( 'wp_ajax_dokan-mark-order-processing', array( $this, 'process_order' ) );
        add_action( 'wp_ajax_dokan_grant_access_to_download', array( $this, 'grant_access_to_download' ) );
        add_action( 'wp_ajax_dokan_add_order_note', array( $this, 'add_order_note' ) );
        add_action( 'wp_ajax_dokan_delete_order_note', array( $this, 'delete_order_note' ) );
        add_action( 'wp_ajax_dokan_change_status', array( $this, 'change_order_status' ) );
        add_action( 'wp_ajax_dokan_contact_seller', array( $this, 'contact_seller' ) );
        add_action( 'wp_ajax_nopriv_dokan_contact_seller', array( $this, 'contact_seller' ) );

        add_action( 'wp_ajax_dokan_revoke_access_to_download', array( $this, 'revoke_access_to_download' ) );
        add_action( 'wp_ajax_nopriv_dokan_revoke_access_to_download', array( $this, 'revoke_access_to_download' ) );

        add_action( 'wp_ajax_dokan_toggle_seller', array( $this, 'toggle_seller_status' ) );

        add_action( 'wp_ajax_shop_url', array($this, 'shop_url_check') );
        add_action( 'wp_ajax_nopriv_shop_url', array($this, 'shop_url_check') );

        add_filter( 'woocommerce_cart_item_name', array($this, 'seller_info_checkout'), 10, 2 );
    }

    /**
     * Injects seller name on checkout page
     *
     * @param array $item_data
     * @param array $cart_item
     * @return array
     */
    function seller_info_checkout( $item_data, $cart_item ) {
        $info   = dokan_get_store_info( $cart_item['data']->post->post_author );
        $seller = sprintf( __( '<br><strong> Seller:</strong> %s', 'dokan' ), $info['store_name'] );
        $data   = $item_data . $seller;

        return apply_filters( 'dokan_seller_info_checkout', $data, $info, $item_data, $cart_item );
    }

    /**
     * chop url check
     */
    function shop_url_check() {
        global $user_ID;

        if ( !wp_verify_nonce( $_POST['_nonce'], 'dokan_reviews' ) ) {
            wp_send_json_error( array(
                'type' => 'nonce',
                'message' => __( 'Are you cheating?', 'dokan' )
            ) );
        }

        $url_slug = $_POST['url_slug'];
        $check    = true;
        $user     = get_user_by( 'slug', $url_slug );

        if ( $user != '' ) {
            $check = false;
        }

        // check if a customer wants to migrate, his username should be available
        if ( is_user_logged_in() && dokan_is_user_customer( $user_ID ) ) {
            $current_user = wp_get_current_user();

            if ( $current_user->user_nicename == $user->user_nicename ) {
                $check = true;
            }
        }

        echo $check;
    }

    /**
     * Mark a order as complete
     *
     * Fires from seller dashboard in frontend
     */
    function complete_order() {
        if ( !is_admin() ) {
            die();
        }

        if ( !current_user_can( 'dokandar' ) || dokan_get_option( 'order_status_change', 'dokan_selling', 'on' ) != 'on' ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'dokan' ) );
        }

        if ( !check_admin_referer( 'dokan-mark-order-complete' ) ) {
            wp_die( __( 'You have taken too long. Please go back and retry.', 'dokan' ) );
        }

        $order_id = isset($_GET['order_id']) && (int) $_GET['order_id'] ? (int) $_GET['order_id'] : '';
        if ( !$order_id ) {
            die();
        }

        if ( !dokan_is_seller_has_order( get_current_user_id(), $order_id ) ) {
            wp_die( __( 'You do not have permission to change this order', 'dokan' ) );
        }

        $order = new WC_Order( $order_id );
        $order->update_status( 'completed' );

        wp_safe_redirect( wp_get_referer() );
        die();
    }

    /**
     * Mark a order as processing
     *
     * Fires from frontend seller dashboard
     */
    function process_order() {
        if ( !is_admin() ) {
            die();
        }

        if ( !current_user_can( 'dokandar' ) && dokan_get_option( 'order_status_change', 'dokan_selling', 'on' ) != 'on' ) {
            wp_die( __( 'You do not have sufficient permissions to access this page.', 'dokan' ) );
        }

        if ( !check_admin_referer( 'dokan-mark-order-processing' ) ) {
            wp_die( __( 'You have taken too long. Please go back and retry.', 'dokan' ) );
        }

        $order_id = isset( $_GET['order_id'] ) && (int) $_GET['order_id'] ? (int) $_GET['order_id'] : '';
        if ( !$order_id ) {
            die();
        }

        if ( !dokan_is_seller_has_order( get_current_user_id(), $order_id ) ) {
            wp_die( __( 'You do not have permission to change this order', 'dokan' ) );
        }

        $order = new WC_Order( $order_id );
        $order->update_status( 'processing' );

        wp_safe_redirect( wp_get_referer() );
    }

    /**
     * Grant download permissions via ajax function
     *
     * @access public
     * @return void
     */
    function grant_access_to_download() {

        check_ajax_referer( 'grant-access', 'security' );

        global $wpdb;

        $order_id       = intval( $_POST['order_id'] );
        $product_ids    = $_POST['product_ids'];
        $loop           = intval( $_POST['loop'] );
        $file_counter   = 0;
        $order          = new WC_Order( $order_id );

        if ( ! is_array( $product_ids ) ) {
            $product_ids = array( $product_ids );
        }

        foreach ( $product_ids as $product_id ) {
            $product    = get_product( $product_id );
            $files      = $product->get_files();

            if ( ! $order->billing_email )
                die();

            if ( $files ) {
                foreach ( $files as $download_id => $file ) {
                    if ( $inserted_id = wc_downloadable_file_permission( $download_id, $product_id, $order ) ) {

                        // insert complete - get inserted data
                        $download = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}woocommerce_downloadable_product_permissions WHERE permission_id = %d", $inserted_id ) );

                        $loop ++;
                        $file_counter ++;

                        if ( isset( $file['name'] ) ) {
                            $file_count = $file['name'];
                        } else {
                            $file_count = sprintf( __( 'File %d', 'woocommerce' ), $file_counter );
                        }

                        include dirname( dirname( __FILE__ ) ) . '/templates/orders/order-download-permission-html.php';
                    }
                }
            }
        }

        die();
    }

    /**
     * Update a order status
     *
     * @return void
     */
    function change_order_status() {

        check_ajax_referer( 'dokan_change_status' );

        $order_id     = intval( $_POST['order_id'] );
        $order_status = $_POST['order_status'];

        $order = new WC_Order( $order_id );
        $order->update_status( $order_status );

        $statuses     = wc_get_order_statuses();
        $status_label = isset( $statuses[$order_status] ) ? $statuses[$order_status] : $order_status;
        $status_class = dokan_get_order_status_class( $order_status );

        echo '<label class="dokan-label dokan-label-' . $status_class . '">' . $status_label . '</label>';
        exit;
    }

    /**
     * Seller store page email contact form handler
     *
     * Catches the form submission from store page
     */
    function contact_seller() {
        $posted = $_POST;

        check_ajax_referer( 'dokan_contact_seller' );

        $contact_name    = sanitize_text_field( $posted['name'] );
        $contact_email   = sanitize_text_field( $posted['email'] );
        $contact_message = strip_tags( $posted['message'] );
        $error_template  = '<div class="alert alert-danger">%s</div>';

        if ( empty( $contact_name ) ) {
            $message = sprintf( $error_template, __( 'Please provide your name.', 'dokan' ) );
            wp_send_json_error( $message );
        }

        if ( empty( $contact_name ) ) {
            $message = sprintf( $error_template, __( 'Please provide your name.', 'dokan' ) );
            wp_send_json_error( $message );
        }

        $seller = get_user_by( 'id', (int) $posted['seller_id'] );

        if ( !$seller ) {
            $message = sprintf( $error_template, __( 'Something went wrong!', 'dokan' ) );
            wp_send_json_error( $message );
        }

        Dokan_Email::init()->contact_seller( $seller->user_email, $contact_name, $contact_email, $contact_message );

        $success = sprintf( '<div class="alert alert-success">%s</div>', __( 'Email sent successfully!', 'dokan' ) );
        wp_send_json_success( $success );
        exit;
    }

    function revoke_access_to_download() {
        check_ajax_referer( 'revoke-access', 'security' );

        if ( ! current_user_can( 'dokandar' ) ) {
            die(-1);
        }

        global $wpdb;

        $download_id = $_POST['download_id'];
        $product_id  = intval( $_POST['product_id'] );
        $order_id    = intval( $_POST['order_id'] );

        $wpdb->query( $wpdb->prepare( "DELETE FROM {$wpdb->prefix}woocommerce_downloadable_product_permissions WHERE order_id = %d AND product_id = %d AND download_id = %s;", $order_id, $product_id, $download_id ) );

        do_action( 'woocommerce_ajax_revoke_access_to_product_download', $download_id, $product_id, $order_id );

        die();
    }

    /**
     * Add order note via ajax
     */
    public function add_order_note() {

        check_ajax_referer( 'add-order-note', 'security' );

        if ( !is_user_logged_in() ) {
            die(-1);
        }
        if ( ! current_user_can( 'dokandar' ) ) {
            die(-1);
        }

        $post_id   = absint( $_POST['post_id'] );
        $note      = wp_kses_post( trim( stripslashes( $_POST['note'] ) ) );
        $note_type = $_POST['note_type'];

        $is_customer_note = $note_type == 'customer' ? 1 : 0;

        if ( $post_id > 0 ) {
            $order      = wc_get_order( $post_id );
            $comment_id = $order->add_order_note( $note, $is_customer_note );

            echo '<li rel="' . esc_attr( $comment_id ) . '" class="note ';
            if ( $is_customer_note ) {
                echo 'customer-note';
            }
            echo '"><div class="note_content">';
            echo wpautop( wptexturize( $note ) );
            echo '</div><p class="meta"><a href="#" class="delete_note">'.__( 'Delete note', 'woocommerce' ).'</a></p>';
            echo '</li>';
        }

        // Quit out
        die();
    }

    /**
     * Delete order note via ajax
     */
    public function delete_order_note() {

        check_ajax_referer( 'delete-order-note', 'security' );

        if ( !is_user_logged_in() ) {
            die(-1);
        }

        if ( ! current_user_can( 'dokandar' ) ) {
            die(-1);
        }

        $note_id = (int) $_POST['note_id'];

        if ( $note_id > 0 ) {
            wp_delete_comment( $note_id );
        }

        // Quit out
        die();
    }

    /**
     * Enable/disable seller selling capability from admin seller listing page
     *
     * @return type
     */
    function toggle_seller_status() {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }

        $user_id = isset( $_POST['user_id'] ) ? intval( $_POST['user_id'] ) : 0;
        $status = sanitize_text_field( $_POST['type'] );

        if ( $user_id && in_array( $status, array( 'yes', 'no' ) ) ) {
            update_user_meta( $user_id, 'dokan_enable_selling', $status );

            if ( $status == 'no' ) {
                $this->make_products_pending( $user_id );
            }
        }
        exit;
    }

    /**
     * Make all the products to pending once a seller is deactivated for selling
     *
     * @param int $seller_id
     */
    function make_products_pending( $seller_id ) {
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'author' => $seller_id,
            'orderby' => 'post_date',
            'order' => 'DESC'
        );

        $product_query = new WP_Query( $args );
        $products = $product_query->get_posts();

        if ( $products ) {
            foreach ($products as $pro) {
                wp_update_post( array( 'ID' => $pro->ID, 'post_status' => 'pending' ) );
            }
        }
    }

}

