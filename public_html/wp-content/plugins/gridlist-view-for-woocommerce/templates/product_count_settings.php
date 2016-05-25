<?php $options = BeRocket_LGV::get_lgv_option('br_lgv_product_count_option'); ?>
<input name="br_lgv_product_count_option[settings_name]" type="hidden" value="br_lgv_product_count_option">
<table class="form-table lgv_admin_settings product_count">
    <tr>
        <th><?php _e( 'Use products count', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <input name="br_lgv_product_count_option[use]" type="checkbox" value="1" <?php if( @ $options['use'] ) echo 'checked'; ?>>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Custom class for buttons', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <input name="br_lgv_product_count_option[custom_class]" type="text" value="<?php echo @ $options['custom_class']; ?>">
            <br>
            <label><?php _e( 'If custom class seted options for styling is not used.', 'BeRocket_LGV_domain' ) ?></label>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Default Products Per Page', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <input name="br_lgv_product_count_option[products_per_page]" value="<?php echo @ $options['products_per_page']; ?>" type="number">
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Product count value', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <input name="br_lgv_product_count_option[value]" type="text" value="<?php echo @ $options['value']; ?>"><label><?php _e( 'You can use digits and "all"(Example:"12,24,48,all")', 'BeRocket_LGV_domain' ) ?></label>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Spliter value', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <input class="br_lgv_product_count_spliter" name="br_lgv_product_count_option[explode]" type="text" value="<?php echo @ $options['explode']; ?>"><label><?php _e( 'Any symbols without spacing', 'BeRocket_LGV_domain' ) ?></label>
        </td>
    </tr>
</table>
<?php echo '<img src="'.plugins_url( '../product_count.png', __FILE__ ).'" alt="Product Count">'; ?>
<input type="button" class="set_all_default button-secondary" data-default="<?php _e( 'Set all to default', 'BeRocket_LGV_domain' ) ?>" value="<?php _e( 'Set all to default', 'BeRocket_LGV_domain' ) ?>">