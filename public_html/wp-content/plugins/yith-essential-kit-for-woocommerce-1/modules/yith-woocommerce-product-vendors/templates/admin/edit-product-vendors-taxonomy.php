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
<tr class="form-field yith-choosen">
    <th scope="row" valign="top">
        <label for="key_user"><?php _e( 'Vendor Shop Owner', 'yith_wc_product_vendors' ); ?></label>
    </th>
    <td>
        <input type="hidden"
               class="wc-customer-search"
               id="key_user"
               name="yith_vendor_data[owner]"
               data-placeholder="<?php esc_attr_e( 'Search for a shop owner&hellip;', 'yith_wc_product_vendors' ); ?>"
               data-selected="<?php echo esc_attr( $owner ); ?>"
               value="<?php echo esc_attr( $owner_id ); ?>"
               data-allow_clear="true" />
        <br />
        <span class="description"><?php _e( 'User that can manage products in this shop and view sale reports.', 'yith_wc_product_vendors' ); ?></span>
    </td>
</tr>

<tr class="form-field">
    <th scope="row" valign="top">
        <label for="yith_vendor_paypal_email"><?php _e( 'PayPal email address', 'yith_wc_product_vendors' ); ?></label>
    </th>
    <td>
        <input type="text" class="regular-text" name="yith_vendor_data[paypal_email]" id="yith_vendor_paypal_email" value="<?php echo $vendor->paypal_email ?>" /><br />
        <br />
        <span class="description"><?php _e( 'Vendor\'s PayPal email address where profits will be delivered.', 'yith_wc_product_vendors' ); ?></span>
    </td>
</tr>

<tr class="form-field">
    <th scope="row" valign="top">
        <label for="yith_vendor_enable_selling"><?php _e( 'Enable sales', 'yith_wc_product_vendors' ); ?></label>
    </th>
    <td>
    	<?php $enable_selling = 'yes' == $vendor->enable_selling ? true : false; ?>
        <input type="checkbox" name="yith_vendor_data[enable_selling]" id="yith_vendor_enable_selling" value="yes" <?php checked( $enable_selling )?> /><br />
        <br />
        <span class="description"><?php _e( 'Enable or disable product sales.', 'yith_wc_product_vendors' ); ?></span>
    </td>
</tr>

<tr class="form-field">
    <th scope="row" valign="top">
        <span class="yith-vendor-commission">
            <?php _e( 'Commission:', 'yith_wc_product_vendors' ); ?>
        </span>
    </th>
    <td>
        <?php echo $vendor->get_commission() * 100 . '%'?>
        <br />
        <span class="description"><?php _e( 'Percentage of the total sale price that this vendor receives.', 'yith_wc_product_vendors' ); ?></span>
    </td>
</tr>
