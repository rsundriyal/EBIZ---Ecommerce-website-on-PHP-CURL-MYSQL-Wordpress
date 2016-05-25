<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
?>
<div class="form-field yith-choosen">
    <label for="yith_vendor_owner"><?php _e( 'Vendor Shop Owner', 'yith_wc_product_vendors' ); ?></label>
    <input type="hidden" class="wc-customer-search" id="key_user" name="yith_vendor_data[owner]" data-placeholder="<?php esc_attr_e( 'Search for a customer&hellip;', 'woocommerce' ); ?>" data-allow_clear="true" />
    <br />
    <span class="description"><?php _e( 'User that can manage products in this vendor shop and view sale reports.', 'yith_wc_product_vendors' ); ?></span>
</div>

<div class="form-field">
    <label for="yith_vendor_paypal_email"><?php _e( 'PayPal email address', 'yith_wc_product_vendors' ); ?></label>
    <input type="text" class="regular-text" name="yith_vendor_data[paypal_email]" id="yith_vendor_paypal_email" value="" /><br />
    <span class="description"><?php _e( 'Vendor\'s PayPal email address where profits will be delivered.', 'yith_wc_product_vendors' ); ?></span>
</div>

<div class="form-field">
    <label class="yith_vendor_enable_selling_label" for="yith_vendor_enable_selling"><?php _e( 'Enable sales', 'yith_wc_product_vendors' ); ?></label>
    <input type="checkbox" name="yith_vendor_data[enable_selling]" id="yith_vendor_enable_selling" value="yes" checked /><br />
    <span class="description"><?php _e( 'Enable or disable product sales.', 'yith_wc_product_vendors' ); ?></span>
</div>

<div class="form-field">
    <div class="yith-vendor-commission">
        <?php _e( 'Commission:', 'yith_wc_product_vendors' ); ?>
        <?php echo ' ' . $commission * 100 . '%'?>
    </div>
    <input type="hidden" name="yith_vendor_data[commission]" value="<?php echo $commission * 100 ?>" checked /><br />
    <span class="description"><?php _e( 'Percentage of the total sale price that this vendor receives', 'yith_wc_product_vendors' ); ?></span>
</div>