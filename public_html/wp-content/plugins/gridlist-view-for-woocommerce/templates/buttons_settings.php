<?php $options = BeRocket_LGV::get_lgv_option('br_lgv_buttons_page_option'); ?>
<input name="br_lgv_buttons_page_option[settings_name]" type="hidden" value="br_lgv_buttons_page_option">
<table class="form-table lgv_admin_settings buttons">
    <tr>
        <th><?php _e( 'Default style', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <select name="br_lgv_buttons_page_option[default_style]">
                <option <?php if( $options['default_style'] == 'grid' ) echo 'selected'; ?> value="grid"><?php _e( 'Grid', 'BeRocket_LGV_domain' ) ?></option>
                <option <?php if( $options['default_style'] == 'list' ) echo 'selected'; ?> value="list"><?php _e( 'List', 'BeRocket_LGV_domain' ) ?></option>
            </select>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Custom class', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <input name="br_lgv_buttons_page_option[custom_class]" type="text" value="<?php echo @ $options['custom_class']; ?>">
            <br>
            <label><?php _e( 'If custom class seted options is not used.', 'BeRocket_LGV_domain' ) ?></label>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Buttons display', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <input name="br_lgv_buttons_page_option[above_order]" type="checkbox" value="1" <?php if( @ $options['above_order'] ) echo 'checked'; ?>><label><?php _e( 'Above order by menu', 'BeRocket_LGV_domain' ) ?></label>
            <br>
            <input name="br_lgv_buttons_page_option[under_order]" type="checkbox" value="1" <?php if( @ $options['under_order'] ) echo 'checked'; ?>><label><?php _e( 'Under order by menu', 'BeRocket_LGV_domain' ) ?></label>
            <br>
            <input name="br_lgv_buttons_page_option[above_paging]" type="checkbox" value="1" <?php if( @ $options['above_paging'] ) echo 'checked'; ?>><label><?php _e( 'Above pagination', 'BeRocket_LGV_domain' ) ?></label>
            <br>
            <label><?php _e( 'Display grid and list buttons on shop page.', 'BeRocket_LGV_domain' ) ?></label>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Buttons position', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <select name="br_lgv_buttons_page_option[position]">
                <option <?php if( $options['position'] == 'left' ) echo 'selected'; ?> value="left"><?php _e( 'Left', 'BeRocket_LGV_domain' ) ?></option>
                <option <?php if( $options['position'] == 'right' ) echo 'selected'; ?> value="right"><?php _e( 'Right', 'BeRocket_LGV_domain' ) ?></option>
            </select>
            <br>
            <label><?php _e( 'Buttons position on shop page.', 'BeRocket_LGV_domain' ) ?></label>
        </td>
    </tr>
    <tr>
        <th><?php _e( 'Paddings', 'BeRocket_LGV_domain' ) ?></th>
        <td>
            <table>
                <tr>
                    <td><label><?php _e( 'Under buttons', 'BeRocket_LGV_domain' ) ?></label></td>
                    <td><input type="text" name="br_lgv_buttons_page_option[padding][top]" value="<?php echo @ $options['padding']['top'] ?>"> <label><?php _e( 'px', 'BeRocket_LGV_domain' ) ?></label></td>
                </tr><tr>
                    <td><label><?php _e( 'Above buttons', 'BeRocket_LGV_domain' ) ?></label></td>
                    <td><input type="text" name="br_lgv_buttons_page_option[padding][bottom]" value="<?php echo @ $options['padding']['bottom'] ?>"> <label><?php _e( 'px', 'BeRocket_LGV_domain' ) ?></label></td>
                </tr><tr>
                    <td><label><?php _e( 'Before buttons', 'BeRocket_LGV_domain' ) ?></label></td>
                    <td><input type="text" name="br_lgv_buttons_page_option[padding][left]" value="<?php echo @ $options['padding']['left'] ?>"> <label><?php _e( 'px', 'BeRocket_LGV_domain' ) ?></label></td>
                </tr><tr>
                    <td><label><?php _e( 'After buttons', 'BeRocket_LGV_domain' ) ?></label></td>
                    <td><input type="text" name="br_lgv_buttons_page_option[padding][right]" value="<?php echo @ $options['padding']['right'] ?>"> <label><?php _e( 'px', 'BeRocket_LGV_domain' ) ?></label></td>
                </tr><tr>
                    <td colspan="2"><label><?php _e( 'Buttons position on shop page.', 'BeRocket_LGV_domain' ) ?></label></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<div class="lgv_toggle_next" data-select="this" data-find="next"><?php _e( 'Presets', 'BeRocket_LGV_domain' ) ?></div>
<div style="font-size: 18px; padding: 1em; clear: both;">
<?php
$buttons_style = array(
    array(
        'presets' => array( 'size_normal', 'border_radius_normal', 'color_theme_white', 'box-shadow_theme_white' ),
        'style'   => 'width: 2em; height: 2em; font-size: 1em; line-height: 2em; color: rgb(51, 51, 51); border-radius: 5px; background: linear-gradient(rgb(255, 255, 255), rgb(220, 220, 220)) repeat scroll 0% 0% rgb(255, 255, 255); border-width: 0px; border-color: rgb(0, 0, 0); box-shadow: 0px 0px 0px 1px rgb(221, 221, 221) inset, 0px 1px 1px 0px rgb(255, 255, 255);',
        'name'    => 'default'
    ),
    array(
        'presets' => array( 'size_normal', 'border_radius_round', 'color_theme_white', 'box-shadow_theme_white_gloss' ),
        'style'   => 'width: 2em; height: 2em; font-size: 1em; line-height: 2em; color: rgb(51, 51, 51); border-radius: 100em; background: linear-gradient(rgb(255, 255, 255), rgb(220, 220, 220)) repeat scroll 0% 0% rgb(255, 255, 255); border-width: 0px; border-color: rgb(221, 221, 221); box-shadow: 0px 0px 0px 1px rgb(221, 221, 221) inset, 0px -78px 1px -60px rgb(221, 221, 221) inset;',
        'name'    => 'white_round_gloss'
    ),
    array(
        'presets' => array( 'size_normal', 'border_radius_square', 'color_theme_white', 'box-shadow_theme_white_metalize' ),
        'style'   => 'width: 2em; height: 2em; font-size: 1em; line-height: 2em; color: rgb(51, 51, 51); border-radius: 0px; background: linear-gradient(rgb(255, 255, 255), rgb(220, 220, 220)) repeat scroll 0% 0% rgb(255, 255, 255); border-width: 0px; border-color: rgb(0, 0, 0); box-shadow: 0px 0px 0px 1px rgb(17, 17, 17) inset, 0px -70px 25px -60px rgb(0, 0, 0) inset;',
        'name'    => 'white_square_metalize'
    ),
    array(
        'presets' => array( 'size_normal', 'border_radius_smooth', 'color_theme_black', 'box-shadow_theme_float' ),
        'style'   => 'width: 2em; height: 2em; font-size: 1em; line-height: 2em; color: rgb(204, 112, 0); border-radius: 20%; background: linear-gradient(rgb(85, 85, 85), rgb(0, 0, 0)) repeat scroll 0% 0% rgb(85, 85, 85); border-width: 0px; border-color: rgb(0, 0, 0); box-shadow: 0px 0px 0px 1px rgb(221, 221, 221) inset, -3px 3px 1px 1px rgb(34, 34, 34);',
        'name'    => 'black_float'
    ),
    array(
        'presets' => array( 'size_normal', 'border_radius_round', 'color_theme_black', 'box-shadow_theme_black_gloss' ),
        'style'   => 'width: 2em; height: 2em; font-size: 1em; line-height: 2em; color: rgb(204, 112, 0); border-radius: 100em; background: linear-gradient(rgb(85, 85, 85), rgb(0, 0, 0)) repeat scroll 0% 0% rgb(85, 85, 85); border-width: 0px; border-color: rgb(0, 0, 0); box-shadow: 0px 0px 0px 1px rgb(17, 17, 17) inset, 0px -78px 1px -60px rgb(0, 0, 0) inset;',
        'name'    => 'black_float'
    ),
    array(
        'presets' => array( 'size_normal', 'border_radius_normal', 'color_theme_orange', 'box-shadow_theme_blue' ),
        'style'   => 'width: 2em; height: 2em; font-size: 1em; line-height: 2em; color: rgb(17, 17, 17); border-radius: 5px; background: linear-gradient(rgb(255, 128, 0), rgb(170, 96, 0)) repeat scroll 0% 0% rgb(255, 128, 0); border-width: 0px; border-color: rgb(0, 0, 0); box-shadow: 0px 0px 0px 1px rgb(221, 221, 221) inset, 0px 0px 2px 1px rgb(119, 119, 255);',
        'name'    => 'orange_blue'
    ),
    array(
        'presets' => array( 'size_normal', 'border_radius_round', 'color_theme_orange', 'box-shadow_theme_float' ),
        'style'   => 'width: 2em; height: 2em; font-size: 1em; line-height: 2em; color: rgb(17, 17, 17); border-radius: 100em; background: linear-gradient(rgb(255, 128, 0), rgb(170, 96, 0)) repeat scroll 0% 0% rgb(255, 128, 0); border-width: 0px; border-color: rgb(0, 0, 0); box-shadow: 0px 0px 0px 1px rgb(221, 221, 221) inset, -3px 3px 1px 1px rgb(34, 34, 34);',
        'name'    => 'orange_round_float'
    ),
    array(
        'presets' => array( 'size_height2x', 'border_radius_round', 'color_theme_white', 'box-shadow_theme_white' ),
        'style'   => 'width: 2em; height: 4em; font-size: 1em; line-height: 4em; color: rgb(51, 51, 51); border-radius: 100em; background: linear-gradient(rgb(255, 255, 255), rgb(220, 220, 220)) repeat scroll 0% 0% rgb(255, 255, 255); border-width: 0px; border-color: rgb(0, 0, 0); box-shadow: 0px 0px 0px 1px rgb(221, 221, 221) inset, 0px 1px 1px 0px rgb(255, 255, 255);',
        'name'    => 'height2x_white'
    ),
    array(
        'presets' => array( 'size_width2x', 'border_radius_square', 'color_theme_black', 'box-shadow_theme_black_gloss' ),
        'style'   => 'width: 4em; height: 2em; font-size: 1em; line-height: 2em; color: rgb(204, 112, 0); border-radius: 0px; background: linear-gradient(rgb(85, 85, 85), rgb(0, 0, 0)) repeat scroll 0% 0% rgb(85, 85, 85); border-width: 0px; border-color: rgb(0, 0, 0); box-shadow: 0px 0px 0px 1px rgb(17, 17, 17) inset, 0px -78px 1px -60px rgb(0, 0, 0) inset;',
        'name'    => 'height2x_white'
    ),
);
lgv_generate_styler_presets_buttons ( $buttons_style );
?>
</div>
<div class="lgv_toggle_next" data-select="this" data-find="next"><?php _e( 'Presets', 'BeRocket_LGV_domain' ) ?></div>
<div style="display: none;">
<?php
$buttons_style = array(
    'size' => array(
        'description' => __( 'Button size', 'BeRocket_LGV_domain' ),
        'buttons' => array(
            'smaller' => array(
                'label' => __( 'Smaller', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value' => 1.6,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'width',
                    ),
                    array(
                        'value' => 1.6,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'height',
                    ),
                    array(
                        'value' => 1.6,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'line-height',
                    ),
                    array(
                        'value' => 0.7,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'font-size',
                    ),
                ),
            ),
            'small' => array(
                'label' => __( 'Small', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value' => 1.6,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'width',
                    ),
                    array(
                        'value' => 1.6,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'height',
                    ),
                    array(
                        'value' => 1.6,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'line-height',
                    ),
                    array(
                        'value' => 0.9,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'font-size',
                    ),
                ),
            ),
            'normal' => array(
                'label' => __( 'Normal', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value' => 2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'width',
                    ),
                    array(
                        'value' => 2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'height',
                    ),
                    array(
                        'value' => 2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'line-height',
                    ),
                    array(
                        'value' => 1,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'font-size',
                    ),
                ),
            ),
            'big' => array(
                'label' => __( 'Big', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value' => 2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'width',
                    ),
                    array(
                        'value' => 2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'height',
                    ),
                    array(
                        'value' => 2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'line-height',
                    ),
                    array(
                        'value' => 1.2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'font-size',
                    ),
                ),
            ),
            'bigger' => array(
                'label' => __( 'Bigger', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value' => 2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'width',
                    ),
                    array(
                        'value' => 2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'height',
                    ),
                    array(
                        'value' => 2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'line-height',
                    ),
                    array(
                        'value' => 1.5,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'font-size',
                    ),
                ),
            ),
            'height2x' => array(
                'label' => __( 'Normal 2x height', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value' => 2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'width',
                    ),
                    array(
                        'value' => 4,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'height',
                    ),
                    array(
                        'value' => 4,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'line-height',
                    ),
                    array(
                        'value' => 1,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'font-size',
                    ),
                ),
            ),
            'width2x' => array(
                'label' => __( 'Normal 2x width', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value' => 4,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'width',
                    ),
                    array(
                        'value' => 2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'height',
                    ),
                    array(
                        'value' => 2,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'line-height',
                    ),
                    array(
                        'value' => 1,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'font-size',
                    ),
                ),
            ),
        ),
    ),
    'border_radius' => array(
        'description' => __( 'Rounded border corners', 'BeRocket_LGV_domain' ),
        'buttons' => array(
            'square' => array(
                'label' => __( 'Square', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value' => 0,
                        'ex'    => 'px',
                        'name'  => 'all',
                        'option' => 'border-radius',
                    ),
                ),
            ),
            'normal' => array(
                'label' => __( 'Normal', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value' => 5,
                        'ex'    => 'px',
                        'name'  => 'all',
                        'option' => 'border-radius',
                    ),
                ),
            ),
            'smooth' => array(
                'label' => __( 'Smooth', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value' => 0.5,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'border-radius',
                    ),
                ),
            ),
            'round' => array(
                'label' => __( 'Round', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value' => 100,
                        'ex'    => 'em',
                        'name'  => 'all',
                        'option' => 'border-radius',
                    ),
                ),
            ),
        ),
    ),
    'color_theme' => array(
        'description' => __( 'Color theme', 'BeRocket_LGV_domain' ),
        'buttons' => array(
            'white' => array(
                'label' => __( 'White', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value'  => array( '#333333' ),
                        'name'   => 'all',
                        'option' => 'color',
                    ),
                    array(
                        'value'  => array( '#ffffff', '#dcdcdc' ),
                        'name'   => 'normal',
                        'option' => 'background',
                    ),
                    array(
                        'value'  => array( '#dcdcdc', '#ffffff' ),
                        'name'   => 'hover',
                        'option' => 'background',
                    ),
                    array(
                        'value'  => array( '#dcdcdc', '#ffffff' ),
                        'name'   => 'selected',
                        'option' => 'background',
                    ),
                ),
            ),
            'gray' => array(
                'label' => __( 'Gray', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value'  => array( '#111111' ),
                        'name'   => 'all',
                        'option' => 'color',
                    ),
                    array(
                        'value'  => array( '#bbbbbb', '#909090' ),
                        'name'   => 'normal',
                        'option' => 'background',
                    ),
                    array(
                        'value'  => array( '#909090', '#bbbbbb' ),
                        'name'   => 'hover',
                        'option' => 'background',
                    ),
                    array(
                        'value'  => array( '#909090', '#bbbbbb' ),
                        'name'   => 'selected',
                        'option' => 'background',
                    ),
                ),
            ),
            'orange' => array(
                'label' => __( 'Orange', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value'  => array( '#111111' ),
                        'name'   => 'all',
                        'option' => 'color',
                    ),
                    array(
                        'value'  => array( '#ff8000', '#aa6000' ),
                        'name'   => 'normal',
                        'option' => 'background',
                    ),
                    array(
                        'value'  => array( '#aa6000', '#ff8000' ),
                        'name'   => 'hover',
                        'option' => 'background',
                    ),
                    array(
                        'value'  => array( '#aa6000', '#ff8000' ),
                        'name'   => 'selected',
                        'option' => 'background',
                    ),
                ),
            ),
            'black' => array(
                'label' => __( 'Black', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value'  => array( '#cc7000' ),
                        'name'   => 'all',
                        'option' => 'color',
                    ),
                    array(
                        'value'  => array( '#555555', '#000000' ),
                        'name'   => 'normal',
                        'option' => 'background',
                    ),
                    array(
                        'value'  => array( '#000000', '#555555' ),
                        'name'   => 'hover',
                        'option' => 'background',
                    ),
                    array(
                        'value'  => array( '#000000', '#555555' ),
                        'name'   => 'selected',
                        'option' => 'background',
                    ),
                ),
            ),
        ),
    ),
    'box-shadow_theme' => array(
        'description' => __( 'Box shadow style', 'BeRocket_LGV_domain' ),
        'buttons' => array(
            'white' => array(
                'label' => __( 'White', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#dddddd' ),
                            '1' => array( 'inset' => '0', 'x' => '0', 'y' => '1', 'radius' => '1', 'size' => '0', 'color' => '#ffffff' ),
                        ),
                        'name'   => 'normal',
                        'option' => 'box-shadow',
                    ),
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#dddddd' ),
                            '1' => array( 'inset' => '0', 'x' => '0', 'y' => '1', 'radius' => '1', 'size' => '0', 'color' => '#ffffff' ),
                        ),
                        'name'   => 'hover',
                        'option' => 'box-shadow',
                    ),
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#bbbbbb' ),
                            '1' => array( 'inset' => '1', 'x' => '0', 'y' => '1', 'radius' => '3', 'size' => '0', 'color' => 'rgba(0,0,0,0.5)' ),
                            '2' => array( 'inset' => '0', 'x' => '0', 'y' => '1', 'radius' => '2', 'size' => '0', 'color' => '#ffffff' ),
                        ),
                        'name'   => 'selected',
                        'option' => 'box-shadow',
                    ),
                ),
            ),
            'blue' => array(
                'label' => __( 'Blue', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#dddddd' ),
                            '1' => array( 'inset' => '0', 'x' => '0', 'y' => '0', 'radius' => '2', 'size' => '1', 'color' => '#7777ff' ),
                        ),
                        'name'   => 'normal',
                        'option' => 'box-shadow',
                    ),
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#dddddd' ),
                            '1' => array( 'inset' => '0', 'x' => '0', 'y' => '0', 'radius' => '3', 'size' => '2', 'color' => '#7777ff' ),
                        ),
                        'name'   => 'hover',
                        'option' => 'box-shadow',
                    ),
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#7777ff' ),
                            '1' => array( 'inset' => '1', 'x' => '0', 'y' => '1', 'radius' => '3', 'size' => '0', 'color' => 'rgba(0,0,0,0.5)' ),
                            '2' => array( 'inset' => '0', 'x' => '0', 'y' => '1', 'radius' => '2', 'size' => '0', 'color' => '#ffffff' ),
                        ),
                        'name'   => 'selected',
                        'option' => 'box-shadow',
                    ),
                ),
            ),
            'float' => array(
                'label' => __( 'Float', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#dddddd' ),
                            '1' => array( 'inset' => '0', 'x' => '-3', 'y' => '3', 'radius' => '1', 'size' => '1', 'color' => '#222222' ),
                        ),
                        'name'   => 'normal',
                        'option' => 'box-shadow',
                    ),
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#dddddd' ),
                            '1' => array( 'inset' => '0', 'x' => '-1', 'y' => '1', 'radius' => '1', 'size' => '1', 'color' => '#222222' ),
                        ),
                        'name'   => 'hover',
                        'option' => 'box-shadow',
                    ),
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#bbbbbb' ),
                            '1' => array( 'inset' => '1', 'x' => '0', 'y' => '1', 'radius' => '3', 'size' => '0', 'color' => 'rgba(0,0,0,0.5)' ),
                            '2' => array( 'inset' => '0', 'x' => '0', 'y' => '1', 'radius' => '2', 'size' => '0', 'color' => '#ffffff' ),
                        ),
                        'name'   => 'selected',
                        'option' => 'box-shadow',
                    ),
                ),
            ),
            'white_gloss' => array(
                'label' => __( 'White gloss', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#dddddd' ),
                            '1' => array( 'inset' => '1', 'x' => '0', 'y' => '-78', 'radius' => '1', 'size' => '-60', 'color' => '#dddddd' ),
                        ),
                        'name'   => 'normal',
                        'option' => 'box-shadow',
                    ),
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#dddddd' ),
                            '1' => array( 'inset' => '1', 'x' => '0', 'y' => '78', 'radius' => '1', 'size' => '-60', 'color' => '#dddddd' ),
                        ),
                        'name'   => 'hover',
                        'option' => 'box-shadow',
                    ),
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#bbbbbb' ),
                            '1' => array( 'inset' => '1', 'x' => '0', 'y' => '1', 'radius' => '3', 'size' => '0', 'color' => 'rgba(0,0,0,0.5)' ),
                            '2' => array( 'inset' => '1', 'x' => '0', 'y' => '78', 'radius' => '15', 'size' => '-60', 'color' => '#dddddd' ),
                        ),
                        'name'   => 'selected',
                        'option' => 'box-shadow',
                    ),
                ),
            ),
            'white_metalize' => array(
                'label' => __( 'White metalize', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#111111' ),
                            '1' => array( 'inset' => '1', 'x' => '0', 'y' => '-70', 'radius' => '25', 'size' => '-60', 'color' => '#000000' ),
                        ),
                        'name'   => 'normal',
                        'option' => 'box-shadow',
                    ),
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#111111' ),
                            '1' => array( 'inset' => '1', 'x' => '0', 'y' => '70', 'radius' => '25', 'size' => '-60', 'color' => '#000000' ),
                        ),
                        'name'   => 'hover',
                        'option' => 'box-shadow',
                    ),
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#333333' ),
                            '1' => array( 'inset' => '1', 'x' => '0', 'y' => '1', 'radius' => '3', 'size' => '0', 'color' => 'rgba(0,0,0,0.5)' ),
                            '2' => array( 'inset' => '1', 'x' => '0', 'y' => '75', 'radius' => '20', 'size' => '-60', 'color' => '#000000' ),
                        ),
                        'name'   => 'selected',
                        'option' => 'box-shadow',
                    ),
                ),
            ),
            'black_gloss' => array(
                'label' => __( 'Black gloss', 'BeRocket_LGV_domain' ),
                'options' => array(
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#111111' ),
                            '1' => array( 'inset' => '1', 'x' => '0', 'y' => '-78', 'radius' => '1', 'size' => '-60', 'color' => '#000000' ),
                        ),
                        'name'   => 'normal',
                        'option' => 'box-shadow',
                    ),
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#111111' ),
                            '1' => array( 'inset' => '1', 'x' => '0', 'y' => '78', 'radius' => '1', 'size' => '-60', 'color' => '#000000' ),
                        ),
                        'name'   => 'hover',
                        'option' => 'box-shadow',
                    ),
                    array(
                        'value'  => array( 
                            '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#333333' ),
                            '1' => array( 'inset' => '1', 'x' => '0', 'y' => '1', 'radius' => '3', 'size' => '0', 'color' => 'rgba(0,0,0,0.5)' ),
                            '2' => array( 'inset' => '1', 'x' => '0', 'y' => '78', 'radius' => '15', 'size' => '-60', 'color' => '#000000' ),
                        ),
                        'name'   => 'selected',
                        'option' => 'box-shadow',
                    ),
                ),
            ),
        ),
    ),
);
lgv_generate_styler_sets ( $buttons_style );
?>
</div>
<div style="clear: both;"></div>
<?php
$buttons_style = array(
    'options'     => @ $options['button'],
    'option_name' => 'br_lgv_buttons_page_option[button]',
    'blocks'     => array(
        array(
            'name'        => 'all',
            'class'       => '.berocket_lgv_button_test',
            'hide'        => false,
            'description' => '',
            'buttons'     => array(
                array(
                    'hider'   => __( 'Buttons style', 'BeRocket_LGV_domain' ),
                    'css'     =>array(
                        'width'           => array(
                            'default'     => array( 'value' => 2, 'ex' => 'em' ),
                            'type'        => 'size',
                            'description' => __( 'Button width', 'BeRocket_LGV_domain' ),
                        ),
                        'height'          => array(
                            'default'     => array( 'value' => 2, 'ex' => 'em' ),
                            'type'        => 'size',
                            'description' => __( 'Button height', 'BeRocket_LGV_domain' ),
                        ),
                        'font-size'       => array(
                            'default'     => array( 'value' => 1, 'ex' => 'em' ),
                            'type'        => 'size',
                            'description' => __( 'Text size', 'BeRocket_LGV_domain' ),
                        ),
                        'line-height'     => array(
                            'default'     => array( 'value' => 2, 'ex' => 'em' ),
                            'type'        => 'size',
                            'description' => __( 'Line height', 'BeRocket_LGV_domain' ),
                        ),
                        'color'           => array(
                            'default'     => array( '0' => '#333333' ),
                            'type'        => 'color',
                            'description' => __( 'Text color', 'BeRocket_LGV_domain' ),
                        ),
                        'border-radius'     => array(
                            'default'     => array( 'value' => 5, 'ex' => 'px' ),
                            'type'        => 'size',
                            'description' => __( 'Rounded border corners', 'BeRocket_LGV_domain' ),
                        ),
                    ),
                ),
            ),
        ),
        array(
            'name'        => 'normal',
            'class'       => '.berocket_lgv_button_test',
            'hide'        => false,
            'description' => '',
            'buttons'     => array(
                array(
                    'hider'   => __( 'Normal buttons style', 'BeRocket_LGV_domain' ),
                    'css'     =>array(
                        'background'      => array(
                            'default'     => array( '0' => '#ffffff', '1' => '#dcdcdc' ),
                            'type'        => 'color',
                            'description' => __( 'Background color', 'BeRocket_LGV_domain' ),
                        ),
                        'border-width'     => array(
                            'default'     => array( 'value' => 0, 'ex' => 'px' ),
                            'type'        => 'size',
                            'description' => __( 'Border width', 'BeRocket_LGV_domain' ),
                        ),
                        'border-color'    => array(
                            'default'     => array( '0' => '#000000' ),
                            'type'        => 'color',
                            'description' => __( 'Border color', 'BeRocket_LGV_domain' ),
                        ),
                        'box-shadow'    => array(
                            'default'     => array(
                                '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#dddddd' ),
                                '1' => array( 'inset' => '0', 'x' => '0', 'y' => '1', 'radius' => '1', 'size' => '0', 'color' => '#ffffff' ),
                            ),
                            'type'        => 'box-shadow',
                            'description' => __( 'Box shadow', 'BeRocket_LGV_domain' ),
                        ),
                    ),
                ),
            ),
        ),
        array(
            'name'        => 'hover',
            'class'       => '.berocket_lgv_button_test',
            'hide'        => false,
            'description' => '',
            'buttons'     => array(
                array(
                    'hider'   => __( 'Mouse over buttons style', 'BeRocket_LGV_domain' ),
                    'css'     =>array(
                        'background'      => array(
                            'default'     => array( '0' => '#dcdcdc', '1' => '#ffffff' ),
                            'type'        => 'color',
                            'description' => __( 'Background color', 'BeRocket_LGV_domain' ),
                        ),
                        'border-width'     => array(
                            'default'     => array( 'value' => 0, 'ex' => 'px' ),
                            'type'        => 'size',
                            'description' => __( 'Border width', 'BeRocket_LGV_domain' ),
                        ),
                        'border-color'    => array(
                            'default'     => array( '0' => '#000000' ),
                            'type'        => 'color',
                            'description' => __( 'Border color', 'BeRocket_LGV_domain' ),
                        ),
                        'box-shadow'    => array(
                            'default'     => array(
                                '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#dddddd' ),
                                '1' => array( 'inset' => '0', 'x' => '0', 'y' => '1', 'radius' => '1', 'size' => '0', 'color' => '#ffffff' ),
                            ),
                            'type'        => 'box-shadow',
                            'description' => __( 'Box shadow', 'BeRocket_LGV_domain' ),
                        ),
                    ),
                ),
            ),
        ),
        array(
            'name'        => 'selected',
            'class'       => '.berocket_lgv_button_test',
            'hide'        => false,
            'description' => '',
            'buttons'     => array(
                array(
                    'hider'   => __( 'Selected buttons style', 'BeRocket_LGV_domain' ),
                    'css'     =>array(
                        'background'      => array(
                            'default'     => array( '0' => '#dcdcdc', '1' => '#ffffff' ),
                            'type'        => 'color',
                            'description' => __( 'Background color', 'BeRocket_LGV_domain' ),
                        ),
                        'border-width'     => array(
                            'default'     => array( 'value' => 0, 'ex' => 'px' ),
                            'type'        => 'size',
                            'description' => __( 'Border width', 'BeRocket_LGV_domain' ),
                        ),
                        'border-color'    => array(
                            'default'     => array( '0' => '#000000' ),
                            'type'        => 'color',
                            'description' => __( 'Border color', 'BeRocket_LGV_domain' ),
                        ),
                        'box-shadow'    => array(
                            'default'     => array(
                                '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#bbbbbb' ),
                                '1' => array( 'inset' => '1', 'x' => '0', 'y' => '1', 'radius' => '3', 'size' => '0', 'color' => 'rgba(0,0,0,0.5)' ),
                                '2' => array( 'inset' => '0', 'x' => '0', 'y' => '1', 'radius' => '2', 'size' => '0', 'color' => '#ffffff' ),
                            ),
                            'type'        => 'box-shadow',
                            'description' => __( 'Box shadow', 'BeRocket_LGV_domain' ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
lgv_generate_styler ( $buttons_style );
?>
<input type="button" class="set_all_default button-secondary" data-default="<?php _e( 'Set all to default', 'BeRocket_LGV_domain' ) ?>" value="<?php _e( 'Set all to default', 'BeRocket_LGV_domain' ) ?>">
<div class="lgv_buttons_preview">
    <p><?php _e( 'Normal', 'BeRocket_LGV_domain' ) ?></p>
    <a href="list" class="berocket_lgv_button_test normal"><i class="fa fa-bars"></i></a>
    <p><?php _e( 'Mouse over', 'BeRocket_LGV_domain' ) ?></p>
    <a href="list" class="berocket_lgv_button_test hover"><i class="fa fa-bars"></i></a>
    <p><?php _e( 'Selected', 'BeRocket_LGV_domain' ) ?></p>
    <a href="list" class="berocket_lgv_button_test selected"><i class="fa fa-bars"></i></a>
</div>