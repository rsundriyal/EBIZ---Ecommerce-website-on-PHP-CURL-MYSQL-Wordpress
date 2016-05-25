<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

include_once( WC()->plugin_path() . '/includes/admin/reports/class-wc-admin-report.php' );
?>


<tr valign="top">
	<th scope="row" class="titledesc">
		<?php echo esc_html( $value['title'] ) ?>
	</th>

	<td class="forminp plugin-option">
		<div class="tax-report">
			<span class="description"><?php echo esc_html( $value['desc'] ) ?></span>
			<?php YITH_WooCommerce_EU_VAT::get_instance()->get_report(); ?>
		</div>
	</td>
</tr>