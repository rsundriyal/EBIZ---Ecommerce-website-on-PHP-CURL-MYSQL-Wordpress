<?php

/**
 * YWAR_Review_Report
 *
 * @author  Your Inspiration Themes
 * @package YITH WooCommerce EU VAT
 * @version 1.0.0
 */
class YITH_YWEV_Report_EU_VAT_Taxes extends WC_Admin_Report {

	/**
	 * Get the legend for the main chart sidebar
	 * @return array
	 */
	public function get_chart_legend() {
		return array();
	}

	/**
	 * Output an export link
	 */
	public function get_export_button() {

		$current_range = ! empty( $_GET['range'] ) ? sanitize_text_field( $_GET['range'] ) : 'last_month';
		?>
		<a
			href="#"
			download="report-<?php echo esc_attr( $current_range ); ?>-<?php echo date_i18n( 'Y-m-d', current_time( 'timestamp' ) ); ?>.csv"
			class="export_csv"
			data-export="table"
			>
			<?php _e( 'Export CSV', 'yith-woocommerce-eu-vat' ); ?>
		</a>
	<?php
	}

	/**
	 * Output the report
	 */
	public function output_report() {

		$ranges = array(
			'year'       => __( 'Year', 'yith-woocommerce-eu-vat' ),
			'last_month' => __( 'Last Month', 'yith-woocommerce-eu-vat' ),
			'month'      => __( 'This Month', 'yith-woocommerce-eu-vat' ),
		);

		$current_range = ! empty( $_GET['range'] ) ? sanitize_text_field( $_GET['range'] ) : 'last_month';

		if ( ! in_array( $current_range, array( 'custom', 'year', 'last_month', 'month', '7day' ) ) ) {
			$current_range = 'last_month';
		}

		$this->calculate_current_range( $current_range );

		$hide_sidebar = true;

		include( YITH_YWEV_TEMPLATE_DIR . '/report/yith-html-report-eu-vat.php' );
	}


	/**
	 * Get the main chart
	 *
	 * @return string
	 */
	public function get_main_chart() {
		$start_date = date( "Y-m-d", $this->start_date );
		$end_date   = date( "Y-m-d", $this->end_date );

		global $wpdb;
		$eu_vat_orders = $wpdb->get_results(
			"SELECT orders.ID,
                    orders.post_date_gmt,
					order_meta.meta_value
				FROM {$wpdb->prefix}posts AS orders
				LEFT JOIN {$wpdb->prefix}postmeta AS order_meta ON
						(order_meta.post_id = orders.ID)
				WHERE
                	(orders.post_status = 'wc-completed')
                    AND (orders.post_type = 'shop_order')
					AND orders.post_date >= '$start_date 00:00:00'
					AND orders.post_date <= '$end_date 23:59:59'
					AND order_meta.meta_key IN ('_ywev_order_vat_paid')
				" );

		$taxes_by_countries  = array();
		$orders_by_countries = array();
		foreach ( $eu_vat_orders as $eu_vat_order ) {
			$order_metas = $eu_vat_order->meta_value;
			$order_metas = maybe_unserialize( $order_metas );

			$localization = $order_metas['Localization'];
			$taxes        = $order_metas['taxes'];

			$country = $localization['COUNTRY'];

			if ( isset( $orders_by_countries[ $country ] ) ) {
				$orders_by_countries[ $country ] = $orders_by_countries[ $country ] + 1;
			} else {

				$orders_by_countries[ $country ] = 1;
			}

			if ( ! isset( $taxes_by_countries[ $country ] ) ) {
				$taxes_by_countries[ $country ] = 0;
			}

			foreach ( $taxes as $tax_amount ) {
				$taxes_by_countries[ $country ] += $tax_amount;
			}
		}

		?>
		<table class="widefat">
			<thead>
			<tr>
				<th><?php _e( 'Country', 'yith-woocommerce-eu-vat' ); ?></th>
				<th class="total_row"><?php _e( 'Number of orders', 'yith-woocommerce-eu-vat' ); ?></th>
				<th class="total_row"><?php _e( 'Total tax amount', 'yith-woocommerce-eu-vat' ); ?></th>
			</tr>
			</thead>
			<?php if ( $taxes_by_countries ) : ?>
				<tbody>
				<?php
				foreach ( $taxes_by_countries as $key => $value ) {
					?>
					<tr>
						<th scope="row"><?php echo $key; ?></th>
						<td class="total_row"><?php echo $orders_by_countries[ $key ]; ?></td>
						<td class="total_row"><?php echo wc_price( $value ); ?></td>
					</tr>
				<?php
				}
				?>
				</tbody>
				<tfoot>
				<tr>
					<th scope="row"><?php _e( 'Totals', 'yith-woocommerce-eu-vat' ); ?></th>
					<th class="total_row"><?php echo array_sum( $orders_by_countries ); ?></th>
					<th class="total_row"><?php echo wc_price( array_sum( $taxes_by_countries ) ); ?></th>
				</tr>
				</tfoot>
			<?php else : ?>
				<tbody>
				<tr>
					<td><?php _e( 'No taxes found in this period', 'yith-woocommerce-eu-vat' ); ?></td>
				</tr>
				</tbody>
			<?php endif; ?>
		</table>
	<?php
	}
}
