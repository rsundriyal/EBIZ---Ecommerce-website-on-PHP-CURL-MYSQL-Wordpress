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
    exit; // Exit if accessed directly
}

if ( !class_exists( 'YWRR_Ajax' ) ) {

    /**
     * Implements AJAX for YWRR plugin
     *
     * @class   YWRR_Ajax
     * @package Yithemes
     * @since   1.1.5
     * @author  Your Inspiration Themes
     *
     */
    class YWRR_Ajax {

        /**
         * Constructor
         *
         * @since   1.1.5
         * @return  mixed
         * @author  Alberto Ruggiero
         */
        public function __construct() {

            add_action( 'wp_ajax_ywrr_send_test_mail', array( $this, 'send_test_mail' ) );

        }

        /**
         * Send a test mail from option panel
         *
         * @since   1.0.0
         * @return  void
         * @author  Alberto Ruggiero
         */
        public function send_test_mail() {
            ob_start();

            $total_products = wp_count_posts( 'product' );

            if ( !$total_products->publish ) {

                wp_send_json( array( 'error' => __( 'In order to send the test email, at least one product has to be published', 'yith-woocommerce-review-reminder' ) ) );

            }
            else {

                $args = array(
                    'posts_per_page' => 2,
                    'orderby'        => 'rand',
                    'post_type'      => 'product'
                );

                $random_products = get_posts( $args );

                $test_items = array();

                foreach ( $random_products as $item ) {

                    $test_items[$item->ID]['id']   = $item->ID;
                    $test_items[$item->ID]['name'] = $item->post_title;

                }

                $days       = get_option( 'ywrr_mail_schedule_day' );
                $test_email = $_POST['email'];
                $template   = $_POST['template'];

                try {

                    $wc_email     = WC_Emails::instance();
                    $email        = $wc_email->emails['YWRR_Request_Mail'];
                    $email_result = $email->trigger( 0, $test_items, $days, $test_email, $template );

                    if ( !$email_result ) {

                        wp_send_json( array( 'error' => __( 'There was an error while sending the email', 'yith-woocommerce-review-reminder' ) ) );

                    }
                    else {

                        wp_send_json( true );

                    }

                } catch ( Exception $e ) {

                    wp_send_json( array( 'error' => $e->getMessage() ) );

                }

            }

        }

    }

    new YWRR_Ajax();

}

