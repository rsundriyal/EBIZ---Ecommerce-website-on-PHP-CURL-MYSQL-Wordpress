<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

$tax_settings = array(
	'tax' => array(
		array(
			'name' => __( 'Tax Settings', 'yith-woocommerce-eu-vat' ),
			'type' => 'title',
			'desc' => '',
			'id'   => 'ywev_tax_settings'
		),
		array(
			'name'    => __( 'EU VAT taxes', 'yith-woocommerce-eu-vat' ),
			'desc'    => __( 'Select the taxes that have to be registered at the checkout to respect the EU VAT law terms.', 'yith-woocommerce-eu-vat' ),
			'id'      => 'ywev_eu_vat_tax_list',
			'std'     => 'no',
			'default' => 'no',
			'type'    => 'ywev_eu_vat_tax_list'
		),
		array( 'type' => 'sectionend', 'id' => 'ywev_tax_settings_end' ),

		array(
			'name' => __( 'Tax Report', 'yith-woocommerce-eu-vat' ),
			'type' => 'title',
			'desc' => '',
			'id'   => 'ywev_tax_report'
		),
		array(
			'name'    => __( 'EU VAT taxes report', 'yith-woocommerce-eu-vat' ),
			'desc'    => '',
			'id'      => 'ywev_eu_vat_tax_report',
			'std'     => 'no',
			'default' => 'no',
			'type'    => 'ywev_eu_vat_tax_report'
		),
		array( 'type' => 'sectionend', 'id' => 'ywev_tax_report_end' )

	)
);

return apply_filters( 'yith_ywev_tax_settings_options', $tax_settings );