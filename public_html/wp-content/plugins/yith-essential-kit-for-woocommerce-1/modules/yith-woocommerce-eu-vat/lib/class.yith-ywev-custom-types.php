<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'YITH_YWEV_Custom_Types' ) ) {

	/**
	 * custom types fields
	 *
	 * @class YITH_YWZM_Custom_Types
	 * @package Yithemes
	 * @since   1.0.0
	 * @author  Your Inspiration Themes
	 */
	class YITH_YWEV_Custom_Types {

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
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			/**
			 * Register actions and filters for custom types used on the current plugin
			 */

			/** Custom types : yith_ywev_eu_vat_tax_section */
			add_action( 'woocommerce_update_option_ywev_eu_vat_tax_list', array(
				$this,
				'admin_update_ywev_eu_vat_tax_list'
			) );
			add_action( 'woocommerce_admin_field_ywev_eu_vat_tax_list', array( $this, 'show_eu_vat_tax_list' ) );

			/** Custom types : yith_ywev_eu_vat_tax_report */
			add_action( 'woocommerce_admin_field_ywev_eu_vat_tax_report', array( $this, 'show_eu_vat_tax_report' ) );
		}

		public function show_eu_vat_tax_report( $value ) {
			include( YITH_YWEV_TEMPLATE_DIR . '/admin/eu-vat-tax-report.php' );
		}

		public function show_eu_vat_tax_list( $value ) {

			include( YITH_YWEV_TEMPLATE_DIR . '/admin/eu-vat-tax-list.php' );
		}

		public function admin_update_ywev_eu_vat_tax_list( $value ) {

			$options = array(
				$value['id'] => isset( $_POST[ $value['id'] ] ) ? stripslashes_deep( $_POST[ $value['id'] ] ) : false
			);

			update_option( $value['id'], $options );

			return true;
		}
	}
}
