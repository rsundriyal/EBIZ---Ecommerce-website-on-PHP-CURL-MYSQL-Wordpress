<?php
if( ! function_exists( 'br_get_woocommerce_version' ) ){
    /**
     * Public function to get WooCommerce version
     *
     * @return float|NULL
     */
    function br_get_woocommerce_version() {
        if ( ! function_exists( 'get_plugins' ) )
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
        $plugin_folder = get_plugins( '/' . 'woocommerce' );
        $plugin_file = 'woocommerce.php';

        if ( isset( $plugin_folder[$plugin_file]['Version'] ) ) {
            return $plugin_folder[$plugin_file]['Version'];
        } else {
            return NULL;
        }
    }
}
if( ! function_exists( 'br_is_plugin_active' ) ) {
    function br_is_plugin_active( $plugin_name, $version = '1.0.0.0', $version_end = '9.9.9.9' ) { 
        switch ( $plugin_name ) {
            case 'filters':
                if ( defined ( "BeRocket_AJAX_filters_version" ) && 
                BeRocket_AJAX_filters_version >= $version && 
                BeRocket_AJAX_filters_version <= $version_end ) {
                    return true;
                } else {
                    return false;
                }
            case 'list-grid':
                if ( defined ( "BeRocket_List_Grid_version" ) && 
                BeRocket_List_Grid_version >= $version && 
                BeRocket_List_Grid_version <= $version_end ) {
                    return true;
                } else {
                    return false;
                }
            case 'more-products':
                if ( defined ( "BeRocket_Load_More_Products_version" ) && 
                BeRocket_Load_More_Products_version >= $version && 
                BeRocket_Load_More_Products_version <= $version_end ) {
                    return true;
                } else {
                    return false;
                }
        }
    }
}
if( ! function_exists( 'br_lgv_get_cookie' ) ) {
    /**
     * Public function to get cookies data
     *
     * @param int $position cookie position ( 0 - list/grid, 1 - product count )
     *
     * @return string|false
     */
    function br_lgv_get_cookie( $position, $set_cookie = false ) {
        $cookie_lgv_result = BeRocket_LGV::$br_lgv_cookie_defaults;
        if ( @ $_COOKIE['br_lgv_stat'] ) {
            $cookie_lgv = @ $_COOKIE['br_lgv_stat'];
            $cookie_lgv = (string)$cookie_lgv;
            if ( strpos( $cookie_lgv, '|' ) !== FALSE ) {
                $cookie_lgv = explode( '|', $cookie_lgv );
            } else {
                $cookie_lgv = array( $cookie_lgv );
            }
            for ( $i = 0; $i < count( $cookie_lgv ); $i++ ) {
                $cookie_lgv_result[$i] = $cookie_lgv[$i];
            }
        } elseif( $set_cookie ) {
            $cookie_lgv = implode( '|', $cookie_lgv_result );
            setcookie ( 'br_lgv_stat', $cookie_lgv, 0, '/', $_SERVER['HTTP_HOST']|$_SERVER['SERVER_NAME'] );
        }
        $result = $cookie_lgv_result[$position];
        if ( $result ) {
            return $result;
        } else {
            return false;
        }
    }
}
if( ! function_exists( 'br_lgv_buttons_display_callback' ) ) {
    /**
     * Function for buttons settings callback
     *
     * @return void
     */
    function br_lgv_buttons_display_callback() { 
        include LGV_TEMPLATE_PATH . "buttons_settings.php";
    }
}
if( ! function_exists( 'br_lgv_product_count_display_callback' ) ) {
    /**
     * Function for product count settings callback
     *
     * @return void
     */
    function br_lgv_product_count_display_callback() { 
        include LGV_TEMPLATE_PATH . "product_count_settings.php";
    }
}
if( ! function_exists( 'br_lgv_liststyle_display_callback' ) ) {
    /**
     * Function for list settings callback
     *
     * @return void
     */
    function br_lgv_liststyle_display_callback() { 
        include LGV_TEMPLATE_PATH . "liststyle_settings.php";
    }
}
if( ! function_exists( 'br_lgv_css_display_callback' ) ) {
    /**
     * Function for css settings callback
     *
     * @return void
     */
    function br_lgv_css_display_callback() { 
        include LGV_TEMPLATE_PATH . "css_settings.php";
    }
}
if( ! function_exists( 'br_lgv_javascript_display_callback' ) ) {
    /**
     * Function for javascript settings callback
     *
     * @return void
     */
    function br_lgv_javascript_display_callback() { 
        include LGV_TEMPLATE_PATH . "javascript_settings.php";
    }
}
if( ! function_exists( 'br_lgv_license_display_callback' ) ) {
    /**
     * Function for license settings callback
     *
     * @return void
     */
    function br_lgv_license_display_callback() { 
        include LGV_TEMPLATE_PATH . "license_settings.php";
    }
}
if( ! function_exists( 'generate_size_block' ) ) {
    /**
     * Function generate inputs for size editing
     *
     * @param array $array_args arguments for generate
     *
     * @return void
     */
    function generate_size_block( $array_args ) {
        extract( $array_args );
        $input_number = rand();
        ?>
        <div data-type="size">
            <table class="lgv_table_styler">
                <tr>
                    <th colspan="2"><p class="br_lgv_description_label"><label><?php echo $description; ?></label></p></th>
                </tr><tr>
                    <td><input id="<?php echo $data_button_type, '_', $data_option, '_value', '_', $input_number; ?>" class="<?php echo $data_button_type, '_', $data_option, '_value'; ?>" data-option="<?php echo $data_option; ?>" data-value="value" data-type="float" type="text" data-default="<?php echo $data_default['value']; ?>" name="<?php echo $name, '[value]'; ?>" value="<?php echo ( isset( $value['value'] ) ? @ $value['value'] : $data_default['value'] ); ?>"></td>
                    <td>
                    <select  class="<?php echo $data_button_type, '_', $data_option, '_ex'; ?>" data-option="<?php echo $data_option; ?>" data-value="ex" data-type="text" data-default="<?php echo $data_default['ex']; ?>" name="<?php echo $name, '[ex]'; ?>">
                        <option value="em" <?php if( @ $value['ex'] == 'em' || ( ! @ $value['ex'] && $data_default['ex'] == 'em' ) ) echo 'selected'; ?>><?php _e( 'em', 'BeRocket_LGV_domain' ) ?></option>
                        <option value="px" <?php if( @ $value['ex'] == 'px' || ( ! @ $value['ex'] && $data_default['ex'] == 'px' ) ) echo 'selected'; ?>><?php _e( 'px', 'BeRocket_LGV_domain' ) ?></option>
                        <option value="%" <?php if( @ $value['ex'] == '%' || ( ! @ $value['ex'] && $data_default['ex'] == '%' ) ) echo 'selected'; ?>><?php _e( '%', 'BeRocket_LGV_domain' ) ?></option>
                        <option value="initial" <?php if( @ $value['ex'] == 'initial' || ( ! @ $value['ex'] && $data_default['ex'] == 'initial' ) ) echo 'selected'; ?>><?php _e( 'initial', 'BeRocket_LGV_domain' ) ?></option>
                        <option value="inherit" <?php if( @ $value['ex'] == 'inherit' || ( ! @ $value['ex'] && $data_default['ex'] == 'inherit' ) ) echo 'selected'; ?>><?php _e( 'inherit', 'BeRocket_LGV_domain' ) ?></option>
                    </select>
                    <input name="<?php echo $name, '[type]'; ?>" value="size" type="hidden">
                    </td>
                </tr>
                <tr>
                    <td></td><td><input type="button" class="set_default button-secondary" data-default="<?php _e( 'Set default', 'BeRocket_LGV_domain' ) ?>" value="<?php _e( 'Set default', 'BeRocket_LGV_domain' ) ?>"></td>
                </tr>
            </table>
            <script>
                (function ($){
                    $(document).ready( function () {
                        set_buttons( $('#<?php echo $data_button_type, '_', $data_option, '_value', '_', $input_number; ?>'), '<?php echo $button_class ?>' );
                    });
                })(jQuery);
            </script>
        </div>
        <?php
    }
}
if( ! function_exists( 'generate_color_block' ) ) {
    /**
     * Function generate inputs for color editing
     *
     * @param array $array_args arguments for generate
     *
     * @return void
     */
    function generate_color_block( $array_args ) {
        extract( $array_args );
        $input_number = rand();
        ?>
        <div data-type="color">
            <table class="lgv_table_styler">
                <tr>
                    <th colspan="<?php echo count($data_default); ?>"><p class="br_lgv_description_label"><label><?php echo $description; ?></label></p></th>
                </tr>
                <tr>
                <?php
                    for( $i = 0; $i < count($data_default); $i++ ) {
                        ?>
                        <td>
                            <div class="colorpicker_field" data-color="<?php echo ( @ $value[$i] ? @ $value[$i] : $data_default[$i] ); ?>"></div>
                            <input name="<?php echo $name, '[', $i, ']'; ?>" data-option="<?php echo $data_option; ?>" data-value="<?php echo $i; ?>" data-type="color" data-default="<?php echo $data_default[$i]; ?>" value="<?php echo ( @ $value[$i] ? @ $value[$i] : $data_default[$i] ); ?>" id="<?php echo $data_button_type, '_', $data_option, '_value_', $i, '_', $input_number; ?>" class="<?php echo $data_button_type, '_', $data_option, '_value'; ?>" type="hidden">
                            <input name="<?php echo $name, '[type]'; ?>" value="color" type="hidden">
                            <script>
                                (function ($){
                                    $(document).ready( function () {
                                        set_buttons( $('#<?php echo $data_button_type, '_', $data_option, '_value_', $i, '_', $input_number; ?>'), '<?php echo $button_class ?>' );
                                    });
                                })(jQuery);
                            </script>
                        </td>
                        <?php
                    }
                ?>
                </tr>
                <tr>
                    <td colspan="<?php echo count($data_default); ?>"><input type="button" class="set_default button-secondary" data-default="<?php _e( 'Set default', 'BeRocket_LGV_domain' ) ?>" value="<?php _e( 'Set default', 'BeRocket_LGV_domain' ) ?>"></td>
                </tr>
            </table>
        </div>
        <?php
    }
}
if( ! function_exists( 'generate_box_shadow_block' ) ) {
    /**
     * Function generate inputs for box shadow editing
     *
     * @param array $array_args arguments for generate
     *
     * @return void
     */
    function generate_box_shadow_block( $array_args ) {
        extract( $array_args );
        $input_number = rand();
        ?>
        <div>
            <p class="br_lgv_description_label"><label><?php echo $description; ?></label></p>
        <?php
        $shadow_count = count( $data_default );
        if ( count( @ $value ) > $shadow_count ) {
            $shadow_count = count( @ $value );
        }
        for( $i = 0; $i < $shadow_count; $i++ ) {
            ?>
            <p class="br_lgv_description_label"><label><?php echo __( 'Shadow', 'BeRocket_LGV_domain' ).' '.( $i + 1 ); ?></label></p>
            <div data-type="box-shadow" class="box-shadow <?php echo $data_button_type; ?>">
                <label>
                    <input id="<?php echo $data_button_type, '_', $data_option, '_inset_', $i, '_', $input_number; ?>" class="inset <?php echo $data_button_type, '_', $data_option, '_inset'; ?>" name="<?php echo $name, '[', $i, '][inset]'; ?>" type="checkbox" value="1" data-option="<?php echo $data_option; ?>" data-value="inset" data-type="text" data-default="<?php echo $data_default[$i]['inset']; ?>" <?php if( @ $value[$i]['inset'] || ( ! @ $value[$i]['color'] && @ $data_default[$i]['inset'] ) ) echo "checked" ?>>
                    <?php _e( 'Shadow inside buttons', 'BeRocket_LGV_domain' ) ?>
                </label>
                <br>
                <label><?php _e( 'Horizontal position', 'BeRocket_LGV_domain' ) ?></label>
                <br>
                <input id="<?php echo $data_button_type, '_', $data_option, '_x_', $i, '_', $input_number; ?>" class="x <?php echo $data_button_type, '_', $data_option, '_x'; ?>" name="<?php echo $name, '[', $i, '][x]'; ?>" type="range" min="-100" max="100" data-option="<?php echo $data_option; ?>" data-value="x" data-type="float" data-default="<?php echo $data_default[$i]['x']; ?>" value="<?php echo ( @ $value[$i]['x'] ? @ $value[$i]['x'] : @ $data_default[$i]['x'] ); ?>"><label><span class="value_container"><?php echo ( @ $value[$i]['x'] ? @ $value[$i]['x'] : @ $data_default[$i]['x'] ); ?></span>px</label>
                <br>
                <label><?php _e( 'Vertical position', 'BeRocket_LGV_domain' ) ?></label>
                <br>
                <input class="y <?php echo $data_button_type, '_', $data_option, '_y'; ?>" name="<?php echo $name, '[', $i, '][y]'; ?>" type="range" min="-100" max="100" data-option="<?php echo $data_option; ?>" data-value="y" data-type="float" data-default="<?php echo $data_default[$i]['y']; ?>" value="<?php echo ( @ $value[$i]['y'] ? @ $value[$i]['y'] : @ $data_default[$i]['y'] ); ?>"><label><span class="value_container"><?php echo ( @ $value[$i]['y'] ? @ $value[$i]['y'] : @ $data_default[$i]['y'] ); ?></span>px</label>
                <br>
                <label><?php _e( 'Smoothing radius', 'BeRocket_LGV_domain' ) ?></label>
                <br>
                <input class="radius <?php echo $data_button_type, '_', $data_option, '_radius'; ?>" name="<?php echo $name, '[', $i, '][radius]'; ?>" type="range" min="0" max="200" data-option="<?php echo $data_option; ?>" data-value="radius" data-type="float" data-default="<?php echo $data_default[$i]['radius']; ?>" value="<?php echo ( @ $value[$i]['radius'] ? @ $value[$i]['radius'] : @ $data_default[$i]['radius'] ); ?>"><label><span class="value_container"><?php echo ( @ $value[$i]['radius'] ? @ $value[$i]['radius'] : @ $data_default[$i]['radius'] ); ?></span>px</label>
                <br>
                <label><?php _e( 'Size', 'BeRocket_LGV_domain' ) ?></label>
                <br>
                <input class="size <?php echo $data_button_type, '_', $data_option, '_size'; ?>" name="<?php echo $name, '[', $i, '][size]'; ?>" type="range" min="-100" max="100" data-option="<?php echo $data_option; ?>" data-value="size" data-type="float" data-default="<?php echo $data_default[$i]['size']; ?>" value="<?php echo ( @ $value[$i]['size'] ? @ $value[$i]['size'] : @ $data_default[$i]['size'] ); ?>"><label><span class="value_container"><?php echo ( @ $value[$i]['size'] ? @ $value[$i]['size'] : @ $data_default[$i]['size'] ); ?></span>px</label>
                <br>
                <label><?php _e( 'Color', 'BeRocket_LGV_domain' ) ?></label>
                <br>
                <div class="colorpicker_field" data-color="<?php echo ( @ $value[$i]['color'] ? @ $value[$i]['color'] : $data_default[$i]['color'] ); ?>"></div>
                <input class="color <?php echo $data_button_type, '_', $data_option, '_color'; ?>" name="<?php echo $name, '[', $i, '][color]'; ?>" type="hidden" data-option="<?php echo $data_option; ?>" data-value="color" data-type="color" data-default="<?php echo $data_default[$i]['color']; ?>" value="<?php echo ( @ $value[$i]['color'] ? @ $value[$i]['color'] : @ $data_default[$i]['color'] ); ?>">
                <br>
                <input type="button" class="set_default button-secondary" data-default="<?php _e( 'Set default', 'BeRocket_LGV_domain' ) ?>" value="<?php _e( 'Set default', 'BeRocket_LGV_domain' ) ?>">
                <script>
                    (function ($){
                        $(document).ready( function () {
                            set_buttons( $('#<?php echo $data_button_type, '_', $data_option, '_x_', $i, '_', $input_number; ?>'), '<?php echo $button_class ?>' );
                        });
                    })(jQuery);
                </script>
            </div>
            
            <?php
        }
        ?>
        </div>
        <?php
    }
}
if( ! function_exists( 'generate_input_text_block' ) ) {
    /**
     * Function generate text input
     *
     * @param array $array_args arguments for generate
     *
     * @return void
     */
    function generate_input_text_block( $array_args ) {
        extract( $array_args );
        $input_number = rand();
        ?>
        <table class="form-table">
            <tr>
                <th><?php echo @ $data_default['label'] ?></th>
                <td>
                    <div>
                        <input data-default="<?php echo @ $data_default['value'] ?>" type="text" name="<?php echo $name; ?>" value="<?php echo ( @ $value ? @ $value : $data_default['value'] ); ?>">
                        <br>
                        <label><?php echo @ $description ?></label>
                    </div>
                </td>
            </tr>
        </table>
        <?php
    }
}
if( ! function_exists( 'generate_select_block' ) ) {
    /**
     * Function generate select for different properties editing
     *
     * @param array $array_args arguments for generate
     *
     * @return void
     */
    function generate_select_block( $array_args ) {
        extract( $array_args );
        $input_number = rand();
        ?>
        <table class="form-table">
            <tr>
                <th><?php echo @ $description ?></th>
                <td>
                    <div>
                        <select data-option="<?php echo $data_option; ?>" data-value="value" data-type="select" data-default="<?php echo $data_default['default']; ?>" id="<?php echo $data_button_type, '_', $data_option, '_value_', $input_number; ?>" name="<?php echo $name; ?>" class="<?php echo $data_button_type, '_', $data_option, '_value'; ?>">
                        <?php foreach ( $data_default['value'] as $key => $val ) { ?>
                            <option value="<?php echo $key; ?>"<?php if ( @ $key == ( @ $value ? @ $value : $data_default['default'] ) ) echo 'selected'; ?>><?php echo $val; ?></option>
                        <?php } ?>
                        </select>
                        <br>
                        <input type="button" class="set_default button-secondary" data-default="<?php _e( 'Set default', 'BeRocket_LGV_domain' ) ?>" value="<?php _e( 'Set default', 'BeRocket_LGV_domain' ) ?>">
                        <script>
                            (function ($){
                                $(document).ready( function () {
                                    set_buttons( $('#<?php echo $data_button_type, '_', $data_option, '_value_', $input_number; ?>'), '<?php echo $button_class ?>' );
                                });
                            })(jQuery);
                        </script>
                    </div>
                </td>
            </tr>
        </table>
        <?php
    }
}
if( ! function_exists( 'lgv_generate_styler' ) ) {
    /**
     * Function generate inputs for editing properties for different buttons and blocks
     * $buttons_style = array(
     *     'options'     => @ $options['button'],
     *     'option_name' => 'br_lgv_buttons_page_option[button]',
     *     'blocks'     => array(
     *         array(
     *             'name'        => 'all',
     *             'class'       => '.berocket_lgv_button_test',
     *             'hide'        => false,
     *             'description' => '',
     *             'buttons'     => array(
     *                 array(
     *                     'hider'   => __( 'Buttons style', 'BeRocket_LGV_domain' ),
     *                     'css'     =>array(
     *                         'width'           => array(
     *                             'default'     => array( 'value' => 2, 'ex' => 'em' ),
     *                             'type'        => 'size',
     *                             'description' => __( 'Button width', 'BeRocket_LGV_domain' ),
     *                         ),
     *                         'background'      => array(
     *                             'default'     => array( '0' => '#ffffff', '1' => '#dcdcdc' ),
     *                             'type'        => 'color',
     *                             'description' => __( 'Background color', 'BeRocket_LGV_domain' ),
     *                         ),
     *                         'box-shadow'    => array(
     *                             'default'     => array(
     *                                 '0' => array( 'inset' => '1', 'x' => '0', 'y' => '0', 'radius' => '0', 'size' => '1', 'color' => '#dddddd' ),
     *                                 '1' => array( 'inset' => '0', 'x' => '0', 'y' => '1', 'radius' => '1', 'size' => '0', 'color' => '#ffffff' ),
     *                             ),
     *                             'type'        => 'box-shadow',
     *                             'description' => __( 'Box shadow', 'BeRocket_LGV_domain' ),
     *                         ),
     *                     ),
     *                 ),
     *             ),
     *         ),
     *     ),
     * );
     * 
     * @param array $args_array arguments for generate
     *
     * @return void
     */
    function lgv_generate_styler ( $args_array ) {
        extract( $args_array );
        foreach ( $blocks as $block ) {
            $block_name = $block['name'];
            $block_class = $block['class'];
            $description = $block['description'];
            ?>
    <div class="<?php echo $block_name; ?>_editor lgv_editor lgv_editor_info" <?php if ( $block['hide'] ) echo 'style="display: none;"'; ?> data-button_type="<?php echo $block_name; ?>" data-button_class="<?php echo $block_class; ?>">
        <h3><?php echo $description; ?></h3>
        <table class="form-table lgv_admin_settings styler">
            <?php
            $buttons = $block['buttons'];
            foreach( $buttons as $button ) {
                if ( isset( $button['hider'] ) ) {
                    $block_name = ( isset($button['modname']) ? $button['modname'] : $block['name'] );
                    $block_class = ( isset($button['modclass']) ? $button['modclass'] : $block['class'] );
                    $css = $button['css'];
                    ?>
                    <tr><th class="lgv_toggle_next" data-select="parent" data-find="next"><?php echo $button['hider']; ?></th></tr>
                    <tr style="display: none;" class="lgv_styler">
                    <?php
                } else {
                    $css = $button;
                    ?>
                    <tr class="lgv_styler">
                    <?php
                }
                ?>
                <td>
                <?php
                if( isset($button['modname']) || isset($button['modclass']) ) {
                    echo '<div class="lgv_editor_info" data-button_class="'.$block_class.'" data-button_type="'.$block_name.'">';
                }
                foreach ( $css as $key => $val ) {
                    $args = array (
                        'data_button_type' => $block_name,
                        'button_class'     => $block_class,
                        'data_option'      => $key,
                        'value'            => @ $options[$block_name][$key],
                        'name'             => $option_name.'['.$block_name.']['.$key.']',
                        'description'      => $val['description'],
                        'data_default'     => $val['default'],
                    );
                    if ( $val['type'] == 'size' ) {
                        generate_size_block( $args );
                    } else if ( $val['type'] == 'color' ) {
                        generate_color_block( $args );
                    } else if ( $val['type'] == 'box-shadow' ) {
                        generate_box_shadow_block( $args );
                    } else if ( $val['type'] == 'text' ) {
                        generate_input_text_block( $args );
                    } else if ( $val['type'] == 'select' ) {
                        generate_select_block( $args );
                    } else if ( $val['type'] == 'custom' ) {
                        $input_number = rand();
                        $text = $val['text'];
                        $script = $val['script'];
                        $args['id']= $args['data_button_type'] . '_' . $args['data_option'] . '_' . $input_number;
                        $text = lgv_generate_styler_replacer( $text, $args );
                        $script = lgv_generate_styler_replacer( $script, $args );
                        ?>
                        <p class="br_lgv_description_label"><label><?php echo $args['description']; ?></label></p>
                        <div>
                            <?php
                            echo $text;
                            ?>
                            <script>
                                <?php
                                echo $script;
                                ?>
                            </script>
                        </div>
                        <?php
                    }
                }
                if( @ $button['modname'] || @ $button['modclass'] ) {
                    echo '</div>';
                }
                ?>
                </td>
                </tr>
                <?php
            }
            ?>
        </table>
    </div>
            <?php
        }
    }
}
if( ! function_exists( 'lgv_generate_styler_sets' ) ) {
    /**
     * Function generate buttons for set different properties in inputs generated lgv_generate_styler
     * $buttons_style = array(
     *     'add_to_cart' => array(
     *         'description' => __( 'Add to cart button style', 'BeRocket_LGV_domain' ),
     *         'buttons' => array(
     *             'default' => array(
     *                 'label' => __( 'Default', 'BeRocket_LGV_domain' ),
     *                 'options' => array(
     *                     array(
     *                         'value'  => 'after_img',
     *                         'name'   => 'lgv_addtocart_advanced',
     *                         'option' => 'position_on',
     *                     ),
     *                     array(
     *                         'value'  => 1,
     *                         'ex'     => 'em',
     *                         'name'   => 'add_to_cart_button',
     *                         'option' => 'font-size',
     *                     ),
     *                     array(
     *                         'value'  => array( '#515151' ),
     *                         'name'   => 'lgv_addtocart_a_advanced',
     *                         'option' => 'color',
     *                     ),
     *                     array(
     *                         'value'  => array( '#515151' ),
     *                         'name'   => 'lgv_addtocart_a_hover_advanced',
     *                         'option' => 'color',
     *                     ),
     *                 ),
     *             ),
     *         ),
     *     ),
     * );
     *
     * @param array $args_array arguments for generate
     *
     * @return void
     */
    function lgv_generate_styler_sets ( $args_array ) {
        ?>
        <table class="form-table lgv_admin_settings styler">
        <?php
            foreach ( $args_array as $option_name => $settings ) {
                ?>
                <tr><th><?php echo $settings['description']; ?></th></tr>
                <tr><td>
                <?php
                    foreach ( $settings['buttons'] as $button_name => $button ) {
                        if ( @ $button['options'] == 'spliter' ) {
                            ?>
                            <p><?php echo $button['label']; ?></p>
                            <?php
                        } else {
                            ?>
                            <input type="button" id="<?php echo $option_name.'_'.$button_name; ?>" class="button-secondary" data-default="<?php echo $button['label'] ?>" value="<?php echo $button['label'] ?>">
                            <script>
                                jQuery( '#<?php echo $option_name.'_'.$button_name; ?>' ).click( function () {
                                    <?php
                                    foreach ( $button['options'] as $option_value ) {
                                        if ( is_array ( $option_value['value'] ) ) {
                                            for ( $i = 0; $i < count( $option_value['value'] ); $i++ ) {
                                                if ( is_array ( $option_value['value'][$i] ) ) {
                                                    ?>
                                                    if ( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_inset' ?>' ).length > <?php echo $i ?> ) {
                                                        jQuery( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_inset' ?>' ).get( <?php echo $i ?> ) ).prop( 'checked', <?php echo ( @ $option_value['value'][$i]['inset'] ? 'true' : 'false' ); ?> ).trigger( 'change' );
                                                    }
                                                    if ( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_x' ?>' ).length > <?php echo $i ?> ) {
                                                        jQuery( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_x' ?>' ).get( <?php echo $i ?> ) ).val( '<?php echo $option_value['value'][$i]['x']; ?>' ).trigger( 'change' );
                                                    }
                                                    if ( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_y' ?>' ).length > <?php echo $i ?> ) {
                                                        jQuery( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_y' ?>' ).get( <?php echo $i ?> ) ).val( '<?php echo $option_value['value'][$i]['y']; ?>' ).trigger( 'change' );
                                                    }
                                                    if ( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_radius' ?>' ).length > <?php echo $i ?> ) {
                                                        jQuery( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_radius' ?>' ).get( <?php echo $i ?> ) ).val( '<?php echo $option_value['value'][$i]['radius']; ?>' ).trigger( 'change' );
                                                    }
                                                    if ( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_size' ?>' ).length > <?php echo $i ?> ) {
                                                        jQuery( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_size' ?>' ).get( <?php echo $i ?> ) ).val( '<?php echo $option_value['value'][$i]['size']; ?>' ).trigger( 'change' );
                                                    }
                                                    if ( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_color' ?>' ).length > <?php echo $i ?> ) {
                                                        jQuery( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_color' ?>' ).get( <?php echo $i ?> ) ).val( '<?php echo $option_value['value'][$i]['color']; ?>' ).trigger( 'change' );
                                                        if ( jQuery( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_color' ?>' ).get( <?php echo $i ?> ) ).data( 'type' ) == 'color' ) {
                                                            jQuery( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_color' ?>' ).get( <?php echo $i ?> ) ).prev().colpickSetColor( '<?php echo $option_value['value'][$i]['color']; ?>' );
                                                        }
                                                    }
                                                    <?php
                                                } else {
                                                    ?>
                                                    if ( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_value' ?>' ).length > <?php echo $i ?> ) {
                                                        jQuery( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_value' ?>' ).get( <?php echo $i ?> ) ).val( '<?php echo $option_value['value'][$i]; ?>' ).trigger( 'change' );
                                                        if ( jQuery( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_value' ?>' ).get( <?php echo $i ?> ) ).data( 'type' ) == 'color' ) {
                                                            jQuery( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_value' ?>' ).get( <?php echo $i ?> ) ).prev().colpickSetColor( '<?php echo $option_value['value'][$i]; ?>' );
                                                        }
                                                    }
                                                    <?php
                                                }
                                            }
                                        } else {
                                            ?>
                                            if ( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_value' ?>' ).length > 0 ) {
                                                jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_value' ?>' ).val( '<?php echo $option_value['value']; ?>' ).trigger( 'change' );
                                            }
                                            if ( jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_ex' ?>' ).length > 0 ) {
                                                jQuery( '.<?php echo $option_value['name'].'_'.$option_value['option'].'_ex' ?>' ).val( '<?php echo @ $option_value['ex']; ?>' ).trigger( 'change' );
                                            }
                                            <?php
                                        }
                                    }
                                    ?>
                                });
                            </script>
                            <?php
                        }
                    }
                ?>
                </td></tr>
                <?php
            }
        ?>
        </table>
        <?php
    }
}
if( ! function_exists( 'lgv_generate_styler_presets_buttons' ) ) {
    /**
     * Function generate presets that use sets generated lgv_generate_styler_presets_buttons for buttons settings
     *
     * @param array $args_array arguments for generate
     *
     * @return void
     */
    function lgv_generate_styler_presets_buttons ( $args_array ) {
        foreach ( $args_array as $args ) {
            $class = rand();
            ?>
            <a href="#" class="berocket_lgv_button lgv_preset_<?php echo $args['name'].'_'.$class; ?>" style="<?php echo $args['style']; ?>"><i class="fa fa-bars"></i></a>
            <script>
                jQuery( '.lgv_preset_<?php echo $args['name'].'_'.$class; ?>' ).click( function ( event ) {
                    event.preventDefault();
                    jQuery('.set_all_default').trigger( 'click' );
                    <?php
                    foreach ( $args['presets'] as $preset ) {
                        ?>
                        jQuery('#<?php echo $preset; ?>').trigger( 'click' );
                        <?php
                    } 
                    ?>
                });
            </script>
            <?php
        }
    }
}
if( ! function_exists( 'lgv_generate_styler_presets_liststyle' ) ) {
    /**
     * Function generate presets that use sets generated lgv_generate_styler_presets_buttons for list settings
     *
     * @param array $args_array arguments for generate
     *
     * @return void
     */
    function lgv_generate_styler_presets_liststyle ( $args_array ) {
        foreach ( $args_array as $args ) {
            $class = rand();
            ?>
            <input type="button" class="button-secondary lgv_preset_<?php echo $args['name'].'_'.$class; ?>" data-default="<?php echo $args['label'] ?>" value="<?php echo $args['label'] ?>">
            <script>
                jQuery( '.lgv_preset_<?php echo $args['name'].'_'.$class; ?>' ).click( function ( event ) {
                    event.preventDefault();
                    jQuery('.br_lgv_liststyle.advanced .set_all_default').trigger( 'click' );
                    <?php
                    foreach ( $args['presets'] as $preset ) {
                        ?>
                        jQuery('#<?php echo $preset; ?>').trigger( 'click' );
                        <?php
                    } 
                    ?>
                });
            </script>
            <?php
        }
    }
}
if( ! function_exists( 'lgv_generate_styler_replacer' ) ) {
    /**
     * Function replace variables in custom styler inputs
     *
     * @param string $input_string custom input string
     * @param array $args arguments for replace
     *
     * @return void
     */
    function lgv_generate_styler_replacer( $input_string, $args ) {
        $input_string = str_replace( '{id}', $args['id'], $input_string );
        $input_string = str_replace( '{class}', $args['data_button_type'].'_'.$args['data_option'].'_value', $input_string );
        $input_string = str_replace( '{data_button_type}', $args['data_button_type'], $input_string );
        $input_string = str_replace( '{button_class}', $args['button_class'], $input_string );
        $input_string = str_replace( '{data_option}', $args['data_option'], $input_string );
        $input_string = str_replace( '{value}', ( isset($args['value']) ? @ $args['value'] : $args['data_default'] ), $input_string );
        $input_string = str_replace( '{name}', $args['name'], $input_string );
        $input_string = str_replace( '{data_default}', $args['data_default'], $input_string );
        $input_string = str_replace( '{set_default}', '<br><input type="button" class="set_default button-secondary" data-default="'.__( 'Set default', 'BeRocket_LGV_domain' ).'" value="'.__( 'Set default', 'BeRocket_LGV_domain' ).'">', $input_string );
        $lgv_pattern = '/{(selected|checked)\((.+?)\)}/';
        while ( preg_match( $lgv_pattern, $input_string, $lgv_matches ) ) {
            $input_string = str_replace( $lgv_matches[0], ( ( ( isset($args['value']) ? @ $args['value'] : $args['data_default'] ) == $lgv_matches[2] ) ? $lgv_matches[1] : '' ), $input_string );
        }
        return $input_string;
    }
}
if( ! function_exists( 'lgv_add_to_cart_display' ) ) {
    /**
     * Function display add to cart button or out of stock button if that set instead add to cart button
     *
     * @param bool $instead_button is set instead add to cart button
     *
     * @return void
     */
    function lgv_add_to_cart_display ( $instead_button = true ) {
        global $product;
        if ( $product->is_in_stock() ) {
            echo apply_filters( 'lgv_add_to_cart_button', 
                sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s product_type_%s">%s</a>',
                    esc_url( $product->add_to_cart_url() ),
                    esc_attr( $product->id ),
                    esc_attr( $product->get_sku() ),
                    esc_attr( isset( $quantity ) ? $quantity : 1 ),
                    $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
                    esc_attr( $product->product_type ),
                    esc_html( $product->add_to_cart_text() )
                ), $product
            );
        } else if ( @ $instead_button ) {
            ?>
            <span class="out_of_stock_button product_type_simple"><?php _e( 'Out of stock', 'BeRocket_LGV_domain' ) ?></span>
            <?php
        }
    }
}
?>