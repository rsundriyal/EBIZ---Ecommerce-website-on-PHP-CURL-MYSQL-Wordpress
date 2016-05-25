<?php
/**
 * Frontend class
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce EU VAT
 * @version 1.1.2
 */

if ( ! defined ( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly

if ( ! class_exists ( 'YITH_WooCommerce_EU_VAT' ) ) {
    /**
     * Admin class.
     * The class manage all the Frontend behaviors.
     *
     * @since 1.0.0
     */
    class YITH_WooCommerce_EU_VAT {

        /**
         * Single instance of the class
         *
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * Returns single instance of the class
         *
         * @since 1.0.0
         */
        public static function get_instance () {
            if ( is_null ( self::$instance ) ) {
                self::$instance = new self();
            }

            return self::$instance;
        }

        /**
         * Constructor
         *
         * @access public
         * @since  1.0.0
         */
        public function __construct () {
            //Actions
            add_action ( 'admin_enqueue_scripts', array ( $this, 'enqueue_styles_scripts' ) );

            add_action ( 'admin_enqueue_scripts', array ( $this, 'admin_scripts' ) );

            add_filter ( 'woocommerce_admin_reports', array ( $this, 'add_eu_vat_admin_report' ) );

            add_action ( 'woocommerce_checkout_order_processed', array (
                $this,
                'store_checkout_order_data',
            ) );

            add_action ( 'woocommerce_check_cart_items', array ( $this, 'check_eu_customer_cart' ) );
            add_action ( 'woocommerce_checkout_process', array ( $this, 'check_eu_customer_checkout' ) );

            /**
             * On plugin init check query vars for commands to import default tax rates
             */
            add_action ( "admin_init", array ( $this, "check_import_actions" ) );
        }

        /**
         * On plugin init check query vars for commands to import default tax rates
         */
        function  check_import_actions () {
            if ( ! isset( $_GET[ "install-tax-rates" ] ) ) {
                return;
            }

            if ( "standard" == $_GET[ "install-tax-rates" ] ) {
                //  import standard tax rates
                YITH_Tax_Rates::get_instance ()->install_standard_rates ();
            } elseif ( "reduced" == $_GET[ "install-tax-rates" ] ) {
                //  import reduced tax rates
            }
            wp_redirect ( esc_url_raw ( remove_query_arg ( "install-tax-rates" ) ) );

        }

        /**
         * Enqueue admin styles and scripts
         *
         * @access public
         * @return void
         * @since  1.0.0
         */
        public function enqueue_styles_scripts () {

            wp_enqueue_style ( 'yith_ywev_admin', YITH_YWEV_ASSETS_URL . '/css/ywev_admin.css' );
        }

        public function admin_scripts ( $hook ) {

            if ( 'yit-plugins_page_yith_woocommerce_eu_vat' != $hook ) {
                return;
            }

            $suffix = defined ( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

            $suffix = '';
            $path   = WC ()->plugin_url () . '/assets/js/admin/reports' . $suffix . '.js';
            wp_enqueue_script ( 'wc-reports', $path, array ( 'jquery', 'jquery-ui-datepicker' ), WC_VERSION );
        }


        /**
         * Check if the current cart should be checked for tax usage
         *
         * @return bool
         */
        public function should_check_eu_taxes () {
            //  If woocommerce will not calculate taxes, nothing should be done for eu vat compliance
            $is_woocommerce_calc_taxes = get_option ( 'woocommerce_calc_taxes' );
            if ( 'yes' != $is_woocommerce_calc_taxes ) {
                return false;
            }

            //  if it shouldn't warning a eu customer, nothing should be done
            $is_checkout_forbidden = get_option ( 'ywev_forbid_checkout', 'no' );
            if ( 'yes' != $is_checkout_forbidden ) {
                return false;
            }

            return true;
        }

        /**
         * Check if the current customer is from the EU area
         *
         * @return bool
         */
        public function is_eu_customer () {
            //  check customer taxable address...
            $taxable_address = WC ()->customer->get_taxable_address ();
            //  ...and check if it's part of european countries
            $eu_vat_countries = WC ()->countries->get_european_union_countries ( 'eu_vat' );

            //  If it's not a european customer, nothing should be done
            if ( $taxable_address[ 0 ] && in_array ( $taxable_address[ 0 ], $eu_vat_countries ) ) {
                return true;
            }

            return false;
        }

        /**
         * Check if current cart contains digital goods to be treated with EU VAT laws
         *
         * @return bool
         */
        public function current_cart_contains_digital_goods () {
            //  Check if the cart contains product that fall into EU VAT compliance and stop checkout if the customer if from EU area.
            $items_on_cart = WC ()->cart->get_cart ();

            foreach ( $items_on_cart as $cart_item ) {
                if ( empty( $cart_item[ 'data' ] ) ) {
                    continue;
                }

                /** @var WC_Product $_product */
                $_product   = $cart_item[ 'data' ];
                $tax_status = $_product->get_tax_status ();

                //  Warning the customer if the product is subjected to EU VAT laws
                if ( $_product->is_virtual () && 'taxable' == $tax_status ) {
                    return true;
                }
            }

            return false;
        }

        public function cart_contains_product_not_purchasable () {

            if ( ! $this->should_check_eu_taxes () ) {
                return false;
            }

            if ( ! $this->is_eu_customer () ) {
                return false;
            }

            return $this->current_cart_contains_digital_goods ();
        }

        /**
         * Show a warning for eu customer when they go to cart page
         */
        public function check_eu_customer_cart () {
            if ( 'yes' != get_option ( 'ywev_show_forbid_warning', 'no' ) ) {
                return false;
            }

            if ( $this->cart_contains_product_not_purchasable () ) {
                $warning_message = get_option ( 'ywev_forbid_warning_message', '' );
                wc_add_notice ( $warning_message, 'notice' );
            }
        }

        /**
         * Check if the order should be stopped.
         */
        public function check_eu_customer_checkout () {
            if ( $this->cart_contains_product_not_purchasable () ) {
                $warning_message = get_option ( 'ywev_forbid_error_message', '' );
                wc_add_notice ( $warning_message, 'error' );
            }
        }

        public function store_checkout_order_data ( $order_id ) {

            $order_storing_data            = array ();
            $order_storing_data[ "taxes" ] = array ();
            $order_storing_data_taxes      = &$order_storing_data[ "taxes" ];

            $eu_vat_tax_used_list = get_option ( 'ywev_eu_vat_tax_list', array () );

            //  Collect information about the order taxes...
            $order   = wc_get_order ( $order_id );
            $post_id = ( isset( $order->post ) ) ? $order->post->ID : $order->id;

            $line_items = $order->get_items ( 'line_item' );

            foreach ( $line_items as $item_id => $item ) {

                $_product  = $order->get_product_from_item ( $item );
                $item_meta = $order->get_item_meta ( $item_id );

                //  Only for products set as virtual
                if ( ! isset( $_product ) || ! $_product->is_virtual () ) {
                    continue;
                }

                $line_tax_data = isset( $item[ 'line_tax_data' ] ) ? $item[ 'line_tax_data' ] : '';
                $tax_data      = maybe_unserialize ( $line_tax_data );

                if ( isset( $tax_data[ 'total' ] ) ) {
                    $tax_data_total = $tax_data[ 'total' ];
                    foreach ( $tax_data_total as $key => $value ) {

                        //  check if tax rate is on the list of selected tax rate to be recorded for EU VAT reporting
                        if ( isset( $eu_vat_tax_used_list[ $key ] ) ) {
                            if ( isset( $order_storing_data_taxes[ $key ] ) ) {
                                $order_storing_data_taxes[ $key ] += $value;
                            } else {
                                $order_storing_data_taxes[ $key ] = $value;
                            }
                        }
                    }
                }
            }

            //... add data about customer location
            $location = WC ()->customer->get_taxable_address ();
            //  the result should be an array as follow :
            //  of array( $country, $state, $postcode, $city ) );
            if ( is_array ( $location ) && ( 4 == count ( $location ) ) ) {
                $taxable_location[ "COUNTRY" ]   = $location[ 0 ];
                $taxable_location[ "STATE" ]     = $location[ 1 ];
                $taxable_location[ "POST_CODE" ] = $location[ 2 ];
                $taxable_location[ "CITY" ]      = $location[ 3 ];

                $order_storing_data[ 'Localization' ] = $taxable_location;
            }

            update_post_meta ( $post_id, '_ywev_order_vat_paid', $order_storing_data );
        }

        public function add_eu_vat_admin_report ( $reports ) {
            if ( isset( $reports[ 'taxes' ] ) ) {
                $reports[ 'taxes' ][ 'reports' ][ 'yith_eu_vat' ] = array (
                    'title'       => __ ( 'EU VAT Reports', 'yith-woocommerce-eu-vat' ),
                    'description' => '',
                    'hide_title'  => true,
                    'callback'    => array ( $this, 'get_report' ),
                );
            }

            return $reports;
        }

        public function get_report () {

            include_once ( YITH_YWEV_TEMPLATE_DIR . '/report/class.yith-ywev-report-eu-vat-taxes.php' );

            $report = new YITH_YWEV_Report_EU_VAT_Taxes();
            $report->output_report ();
        }
    }
}