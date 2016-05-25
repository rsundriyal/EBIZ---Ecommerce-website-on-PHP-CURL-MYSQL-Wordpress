<?php $options = BeRocket_LGV::get_lgv_option('br_lgv_javascript_option'); ?>
<input name="br_lgv_javascript_option[settings_name]" type="hidden" value="br_lgv_javascript_option">
<table class="form-table lgv_admin_settings js">
    <tr>
        <th><?php _e( 'Script before list or grid style set', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][before_style_set]"><?php echo @ $options['script']['before_style_set'] ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Script after list or grid style set', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][after_style_set]"><?php echo @ $options['script']['after_style_set'] ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Script after list style set', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][after_style_list]"><?php echo @ $options['script']['after_style_list'] ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Script after grid style set', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][after_style_grid]"><?php echo @ $options['script']['after_style_grid'] ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Script before cookies get', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][before_get_cookie]"><?php echo @ $options['script']['before_get_cookie'] ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Script after cookies get', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][after_get_cookie]"><?php echo @ $options['script']['after_get_cookie'] ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Script before selected buttons List/Grid changed', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][before_buttons_reselect]"><?php echo @ $options['script']['before_buttons_reselect'] ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Script after selected buttons List/Grid changed', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][after_buttons_reselect]"><?php echo @ $options['script']['after_buttons_reselect'] ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Script before selected product count links changed', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][before_product_reselect]"><?php echo @ $options['script']['before_product_reselect'] ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Script after selected product count links changed', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][after_product_reselect]"><?php echo @ $options['script']['after_product_reselect'] ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Script before page reload on product count change', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][before_page_reload]"><?php echo @ $options['script']['before_page_reload'] ?></textarea>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Script before AJAX page reload on product count change', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][before_ajax_product_reload]"><?php echo @ $options['script']['before_ajax_product_reload'] ?></textarea>
            <br>
            <?php _e( 'Works only if WooCommerce AJAX Products Filter installed ', 'BeRocket_LGV_domain' ) ?>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Script after AJAX page reload on product count change', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <textarea class="lgv_js_style" name="br_lgv_javascript_option[script][after_ajax_product_reload]"><?php echo @ $options['script']['after_ajax_product_reload'] ?></textarea>
            <br>
            <?php _e( 'Works only if WooCommerce AJAX Products Filter installed ', 'BeRocket_LGV_domain' ) ?>
        </td>
    </tr>
</table>