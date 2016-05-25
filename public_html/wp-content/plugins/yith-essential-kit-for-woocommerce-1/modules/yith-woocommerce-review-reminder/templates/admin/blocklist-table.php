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


if ( !class_exists( 'YWRR_Blocklist_Table' ) ) {

    /**
     * Displays the blocklist table in YWRR plugin admin tab
     *
     * @class   YWRR_Blocklist_Table
     * @package Yithemes
     * @since   1.0.0
     * @author  Your Inspiration Themes
     *
     */
    class YWRR_Blocklist_Table {

        /**
         * Single instance of the class
         *
         * @var \YWRR_Blocklist_Table
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * Returns single instance of the class
         *
         * @return \YWRR_Blocklist_Table
         * @since 1.0.0
         */
        public static function get_instance() {

            if ( is_null( self::$instance ) ) {

                self::$instance = new self( $_REQUEST );

            }

            return self::$instance;
        }

        /**
         * Constructor
         *
         * @since   1.1.5
         * @return  mixed
         * @author  Alberto Ruggiero
         */
        public function __construct() {

            add_filter( 'set-screen-option', array( $this, 'set_options' ), 10, 3 );
            add_action( 'current_screen', array( $this, 'add_options' ) );

        }

        /**
         * Outputs the blocklist template with insert form in plugin options panel
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function output() {

            global $wpdb;

            $table = new YITH_Custom_Table( array(
                                                'singular' => __( 'customer', 'yith-woocommerce-review-reminder' ),
                                                'plural'   => __( 'customers', 'yith-woocommerce-review-reminder' )
                                            ) );

            $table->options = array(
                'select_table'     => $wpdb->prefix . 'ywrr_email_blocklist a LEFT JOIN ' . $wpdb->prefix . 'usermeta b ON a.customer_id = b.user_id',
                'select_columns'   => array(
                    'a.id',
                    'a.customer_id',
                    'a.customer_email',
                    'MAX(CASE WHEN b.meta_key = "first_name" THEN b.meta_value ELSE NULL END) AS first_name',
                    'MAX(CASE WHEN b.meta_key = "last_name" THEN b.meta_value ELSE NULL END) AS last_name',
                    'MAX(CASE WHEN b.meta_key = "nickname" THEN b.meta_value ELSE NULL END) AS nickname',
                ),
                'select_where'     => '',
                'select_group'     => 'a.customer_email',
                'select_order'     => 'a.customer_id',
                'select_order_dir' => 'ASC',
                'search_where'     => array(
                    'a.customer_email'
                ),
                'per_page_option'  => 'user_per_page',
                'count_table'      => $wpdb->prefix . 'ywrr_email_blocklist a',
                'count_where'      => '',
                'key_column'       => 'id',
                'view_columns'     => array(
                    'cb'             => '<input type="checkbox" />',
                    'name'           => __( 'Customer', 'yith-woocommerce-review-reminder' ),
                    'customer_email' => __( 'Email', 'yith-woocommerce-review-reminder' )
                ),
                'hidden_columns'   => array(),
                'sortable_columns' => array(
                    'name'           => array( 'name', true ),
                    'customer_email' => array( 'customer_email', false )
                ),
                'custom_columns'   => array(
                    'column_name' => function ( $item, $me ) {
                        switch ( $item['customer_id'] ) {
                            case 0:
                                $customer_name = __( 'Unregistered User', 'yith-woocommerce-review-reminder' );
                                break;
                            default:

                                $query_args = array(
                                    'user_id' => $item['customer_id'],
                                );
                                $edit_url   = esc_url( add_query_arg( $query_args, admin_url( 'user-edit.php' ) ) );

                                $customer_name = '<a href="' . $edit_url . '">' . ( ( $item['first_name'] . ' ' . $item['last_name'] == ' ' ) ? $item['nickname'] : $item['first_name'] . ' ' . $item['last_name'] ) . '</a>';
                        }

                        $query_args = array(
                            'page'   => $_GET['page'],
                            'tab'    => $_GET['tab'],
                            'action' => 'delete',
                            'id'     => $item['id']
                        );
                        $delete_url = esc_url( add_query_arg( $query_args, admin_url( 'admin.php' ) ) );

                        $actions = array(
                            'delete' => '<a href="' . $delete_url . '">' . __( 'Delete', 'yith-woocommerce-review-reminder' ) . '</a>',
                        );

                        return sprintf( '%s %s', '<strong>' . $customer_name . '</strong>', $me->row_actions( $actions ) );
                    }
                ),
                'bulk_actions'     => array(
                    'actions'   => array(
                        'delete' => __( 'Delete', 'yith-woocommerce-review-reminder' ),
                    ),
                    'functions' => array(
                        'function_delete' => function () {
                            global $wpdb;

                            $ids = isset( $_GET['id'] ) ? $_GET['id'] : array();
                            if ( is_array( $ids ) ) {
                                $ids = implode( ',', $ids );
                            }

                            if ( !empty( $ids ) ) {
                                $wpdb->query( "DELETE FROM {$wpdb->prefix}ywrr_email_blocklist WHERE id IN ( $ids )" );
                            }
                        },
                    )
                ),
            );

            $table->prepare_items();

            $message = '';
            $notice  = '';

            $query_args    = array(
                'page' => $_GET['page'],
                'tab'  => $_GET['tab']
            );
            $blocklist_url = esc_url( add_query_arg( $query_args, admin_url( 'admin.php' ) ) );

            if ( 'delete' === $table->current_action() ) {
                $message = sprintf( __( 'Items deleted: %d', 'yith-woocommerce-review-reminder' ), count( $_GET['id'] ) );
            }

            if ( !empty( $_POST['nonce'] ) && wp_verify_nonce( $_POST['nonce'], basename( __FILE__ ) ) ) {

                $user = get_user_by( 'email', $_POST['email'] );

                $customer_id    = ( $user == null ? 0 : $user->ID );
                $customer_email = $_POST['email'];

                if ( true == YWRR_Blocklist()->check_blocklist( $customer_id, $customer_email ) ) {

                    try {
                        YWRR_Blocklist()->add_to_blocklist( $customer_id, $customer_email );
                        $message = sprintf( __( 'User %s added successfully', 'yith-woocommerce-review-reminder' ), '<b>' . $customer_email . '</b>' );
                    } catch ( Exception $e ) {
                        $notice = __( 'An error has occurred', 'yith-woocommerce-review-reminder' );
                    }
                }
                else {
                    $notice = sprintf( __( 'User %s already unsubscribed', 'yith-woocommerce-review-reminder' ), '<b>' . $customer_email . '</b>' );
                }
            }

            ?>
            <div class="wrap">
                <h1>
                    <?php _e( 'Blocklist', 'yith-woocommerce-review-reminder' );
                    if ( empty( $_GET['action'] ) || 'addnew' !== $_GET['action'] ) : ?>
                        <?php $query_args = array(
                            'page'   => $_GET['page'],
                            'tab'    => $_GET['tab'],
                            'action' => 'addnew'
                        );
                        $add_form_url     = esc_url( add_query_arg( $query_args, admin_url( 'admin.php' ) ) );
                        ?>
                        <a class="page-title-action" href="<?php echo $add_form_url ?>"><?php _e( 'Add New', 'yith-woocommerce-review-reminder' ); ?></a>
                    <?php endif; ?>
                </h1>
                <?php

                if ( !empty( $notice ) ) : ?>
                    <div id="notice" class="error below-h2"><p><?php echo $notice; ?></p></div>
                <?php endif;

                if ( !empty( $message ) ) : ?>
                    <div id="message" class="updated below-h2"><p><?php echo $message; ?></p></div>
                <?php endif;

                if ( !empty( $_GET['action'] ) && 'addnew' == $_GET['action'] ) : ?>
                    <form id="form" method="POST">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce( basename( __FILE__ ) ) ?>" />
                        <table class="form-table" style="width: auto">
                            <tbody>
                            <tr valign="top" class="titledesc">
                                <th scope="row">
                                    <label for="email"><?php _e( 'Add E-Mail to blocklist', 'yith-woocommerce-review-reminder' ); ?></label>
                                </th>
                                <td class="forminp forminp-email">
                                    <input id="email" name="email" type="email" required>
                                </td>
                                <td>
                                    <input type="submit" value="<?php _e( 'Add E-mail', 'yith-woocommerce-review-reminder' ) ?>" id="submit" class="button-primary" name="submit">
                                    <a class="button-secondary" href="<?php echo $blocklist_url ?>"><?php _e( 'Return to blocklist', 'yith-woocommerce-review-reminder' ) ?></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                <?php else : ?>
                    <form id="custom-table" method="GET" action="<?php echo $blocklist_url; ?>">
                        <?php $table->search_box( __( 'Search Email' ), 'email' ); ?>

                        <input type="hidden" name="page" value="<?php echo $_GET['page']; ?>" />
                        <input type="hidden" name="tab" value="<?php echo $_GET['tab'] ?>" />

                        <?php $table->display(); ?>
                    </form>
                <?php endif; ?>
            </div>
            <?php
        }

        /**
         * Add screen options for blocklist table template
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function add_options() {
            if ( 'yit-plugins_page_yith_ywrr_panel' == get_current_screen()->id && ( isset( $_GET['tab'] ) && $_GET['tab'] == 'blocklist' ) && ( !isset( $_GET['action'] ) || $_GET['action'] != 'addnew' ) ) {

                $option = 'per_page';

                $args = array(
                    'label'   => __( 'Customers', 'yith-woocommerce-review-reminder' ),
                    'default' => 10,
                    'option'  => 'user_per_page'
                );

                add_screen_option( $option, $args );

            }
        }

        /**
         * Set screen options for blocklist table template
         *
         * @since   1.0.0
         *
         * @param   $status
         * @param   $option
         * @param   $value
         *
         * @return  mixed
         * @author  Alberto Ruggiero
         */
        public function set_options( $status, $option, $value ) {

            return ( 'user_per_page' == $option ) ? $value : $status;

        }

    }

    /**
     * Unique access to instance of YWRR_Blocklist_Table class
     *
     * @return \YWRR_Blocklist_Table
     */
    function YWRR_Blocklist_Table() {

        return YWRR_Blocklist_Table::get_instance();

    }

    new YWRR_Blocklist_Table();

}