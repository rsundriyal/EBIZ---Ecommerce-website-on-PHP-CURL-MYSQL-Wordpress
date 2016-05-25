<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tax_classes = ywev_get_tax_classes();
foreach ( $tax_classes as &$class ) {
	$class = sanitize_title( $class );
}

$tax_classes[] = '';

$eu_vat_tax_used_list = get_option( 'ywev_eu_vat_tax_list', array() );
?>


<tr valign="top">
	<th scope="row" class="titledesc">
		<?php echo esc_html( $value['title'] ) ?>
	</th>

	<td class="forminp plugin-option">
		<div class="ywev-import-tax-rates">
			<a href="<?php echo esc_url(add_query_arg( "install-tax-rates", "standard" )); ?>"
			   class="button"><?php _e( "Import standard tax rates", 'yith-woocommerce-eu-vat' ); ?></a>
		</div>
		<div class="tax-class-table">
			<span class="description"><?php echo esc_html( $value['desc'] ) ?></span>
			<table id="eu_vat_selection">
				<thead>
				<tr>
					<th class="select-tax">
						<input type="checkbox" name="select_all" id="select_all"
						       value="1" onClick="toggle(this)"/>
					</th>

					<th class="country-code"><?php _e( 'Country code', 'yith-woocommerce-eu-vat' ); ?></th>

					<th class="state-code"><?php _e( 'State code', 'yith-woocommerce-eu-vat' ); ?></th>

					<th class="post-code"><?php _e( 'ZIP/Postcode', 'yith-woocommerce-eu-vat' ); ?></th>

					<th class="city"><?php _e( 'City', 'yith-woocommerce-eu-vat' ); ?></th>

					<th class="rate"><?php _e( 'Rate %', 'yith-woocommerce-eu-vat' ); ?></th>
					<th class="tax-class"><?php _e( 'Tax class', 'yith-woocommerce-eu-vat' ); ?></th>

					<th class="tax-name"><?php _e( 'Tax name', 'yith-woocommerce-eu-vat' ); ?></th>

				</tr>
				</thead>
				<tbody id="rates">
				<?php
				global $wpdb;
				$query = sprintf( "SELECT * FROM {$wpdb->prefix}woocommerce_tax_rates
						WHERE tax_rate_class IN ('%s')
						ORDER BY tax_rate_order", implode( "','", array_values( $tax_classes ) )
				);
				$rates = $wpdb->get_results( $query );


				foreach ( $rates as $rate ) {
					?>
					<tr>
						<td class="select-tax">
							<input type="checkbox" class="checkbox"
							       name="ywev_eu_vat_tax_list[<?php echo $rate->tax_rate_id ?>]"
							       value="1" <?php yith_is_checked_html( $eu_vat_tax_used_list, $rate->tax_rate_id ); ?> />
						</td>

						<td class="country-code">
							<?php echo esc_attr( $rate->tax_rate_country ) ?>
						</td>

						<td class="state-code">
							<?php echo esc_attr( $rate->tax_rate_state ) ?>
						</td>

						<td class="post-code">
							<?php
							$locations = $wpdb->get_col( $wpdb->prepare( "SELECT location_code FROM {$wpdb->prefix}woocommerce_tax_rate_locations WHERE location_type='postcode' AND tax_rate_id = %d ORDER BY location_code", $rate->tax_rate_id ) );

							echo esc_attr( implode( '; ', $locations ) );
							?>
						</td>

						<td class="city">
							<?php
							$locations = $wpdb->get_col( $wpdb->prepare( "SELECT location_code FROM {$wpdb->prefix}woocommerce_tax_rate_locations WHERE location_type='city' AND tax_rate_id = %d ORDER BY location_code", $rate->tax_rate_id ) );
							echo esc_attr( implode( '; ', $locations ) );
							?>
						</td>

						<td class="rate">
							<?php echo esc_attr( $rate->tax_rate ) ?>
						</td>
						<td class="tax-class">
							<?php echo $rate->tax_rate_class ? esc_html( $rate->tax_rate_class ) : __( 'Standard', 'yith-woocommerce-eu-vat' ); ?>
						</td>
						<td class="tax-name">
							<?php echo esc_attr( $rate->tax_rate_name ) ?>
						</td>
					</tr>
				<?php
				}
				?>
				</tbody>

			</table>
		</div>
	</td>
</tr>

<script type="text/javascript">
	function toggle(source) {
		checkboxes = document.getElementsByTagName('input');
		for (var i = 0, n = checkboxes.length; i < n; i++) {
			checkboxes[i].checked = source.checked;
		}
	}
</script>