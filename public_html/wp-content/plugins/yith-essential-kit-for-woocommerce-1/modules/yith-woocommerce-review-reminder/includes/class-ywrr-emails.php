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

if ( !class_exists( 'YWRR_Emails' ) ) {

    /**
     * Implements email functions for YWRR plugin
     *
     * @class   YWRR_Emails
     * @package Yithemes
     * @since   1.0.0
     * @author  Your Inspiration Themes
     *
     */
    class YWRR_Emails {

        /**
         * Single instance of the class
         *
         * @var \YWRR_Emails
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * Returns single instance of the class
         *
         * @return \YWRR_Emails
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
         * @since   1.0.0
         * @return  mixed
         * @author  Alberto Ruggiero
         */
        public function __construct() {

        }

        /**
         * Prepares and send the review request mail
         *
         * @since   1.0.0
         *
         * @param   $order_id int the order id
         * @param   $days
         * @param   $items_to_review
         * @param   $stored_items
         *
         * @return  bool
         * @author  Alberto Ruggiero
         */
        public function send_email( $order_id, $days, $items_to_review = array(), $stored_items = array() ) {

            if ( defined( 'YWRR_PREMIUM' ) ) {

                if ( empty( $stored_items ) ) {

                    if ( empty( $items_to_review ) ) {

                        $list = YWRR_Emails_Premium()->get_review_list( $order_id );

                    }
                    else {

                        $list = YWRR_Emails_Premium()->get_review_list_forced( $items_to_review, $order_id );

                    }
                }
                else {

                    $list = $stored_items;

                }

            }
            else {

                $list = $this->get_review_list( $order_id );

            }


            $wc_email = WC_Emails::instance();
            $email    = $wc_email->emails['YWRR_Request_Mail'];

            return $email->trigger( $order_id, $list, $days );

        }

        /**
         * Prepares the list of items to review from stored options
         *
         * @since   1.0.0
         *
         * @param   $order_id int the order id
         *
         * @return  array
         * @author  Alberto Ruggiero
         */
        public function get_review_list( $order_id ) {
            global $wpdb;

            $items = array();

            $line_items = $wpdb->get_results( $wpdb->prepare( "
                    SELECT    a.order_item_name,
                              MAX(CASE WHEN b.meta_key = '_product_id' THEN b.meta_value ELSE NULL END) AS product_id
                    FROM      {$wpdb->prefix}woocommerce_order_items a INNER JOIN {$wpdb->prefix}woocommerce_order_itemmeta b ON a.order_item_id= b.order_item_id
                    WHERE     a.order_id = %d AND a.order_item_type = 'line_item'
                    GROUP BY  a.order_item_name
                    ORDER BY  a.order_item_id ASC
                    ", $order_id ) );


            foreach ( $line_items as $item ) {
                $items[$item->product_id]['name'] = $item->order_item_name;
                $items[$item->product_id]['id']   = $item->product_id;
            }

            return $items;
        }

    }

    /**
     * Unique access to instance of YWRR_Emails class
     *
     * @return \YWRR_Emails
     */
    function YWRR_Emails() {
        return YWRR_Emails::get_instance();
    }

}