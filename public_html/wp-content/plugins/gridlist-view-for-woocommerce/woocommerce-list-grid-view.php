<?php
/**
 * Plugin Name: Grid/List View for WooCommerce
 * Plugin URI: http://berocket.com/product/woocommerce-grid-list-view
 * Description: Plugin for WooCommerce which add grid/list and products per page toggles to your shop
 * Version: 1.0.2
 * Author: BeRocket
 * Requires at least: 4.0
 * Author URI: http://berocket.com
 */
define( "BeRocket_List_Grid_version", '1.0.2' );
define( "BeRocket_LGV_domain", 'BeRocket_LGV_domain'); 
define( "LGV_TEMPLATE_PATH", plugin_dir_path( __FILE__ ) . "templates/" );
require_once(plugin_dir_path( __FILE__ ).'includes/widget.php');
require_once(plugin_dir_path( __FILE__ ).'includes/functions.php');
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Class BeRocket_LGV
 */
class BeRocket_LGV {

    public static $br_lgv_cookie_defaults = array('grid', 'default');

    /**
     * Defaults values
     */
    public static $defaults = array(
        'br_lgv_buttons_page_option'    => array(
            'default_style'                 => 'grid',
            'custom_class'                  => '',
            'above_order'                   => '',
            'under_order'                   => '1',
            'above_paging'                  => '',
            'position'                      => 'left',
            'padding'                       => array(
                'top'                           => '5',
                'bottom'                        => '5',
                'left'                          => '0',
                'right'                         => '0',
            ),
        ),
        'br_lgv_product_count_option'   => array(
            'use'                           => '1',
            'custom_class'                  => '',
            'products_per_page'             => '24',
            'value'                         => '12,24,48,all',
            'explode'                       => '/',
        ),
        'br_lgv_liststyle_option'       => array(),
        'br_lgv_css_option'             => array(),
        'br_lgv_javascript_option'      => array(
            'script'                        => array(
                'before_style_set'              => '',
                'after_style_set'               => '',
                'after_style_list'              => '',
                'after_style_grid'              => '',
                'before_get_cookie'             => '',
                'after_get_cookie'              => '',
                'before_buttons_reselect'       => '',
                'after_buttons_reselect'        => '',
                'before_product_reselect'       => '',
                'after_product_reselect'        => '',
                'before_page_reload'            => '',
                'before_ajax_product_reload'    => '',
                'after_ajax_product_reload'     => '',
            ),
        ),
    );
    
    function __construct () {
        register_activation_hook(__FILE__, array( __CLASS__, 'activation' ) );
        register_uninstall_hook(__FILE__, array( __CLASS__, 'deactivation' ) );

        if ( ( is_plugin_active( 'woocommerce/woocommerce.php' ) || is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) && br_get_woocommerce_version() >= 2.1 ) {
            add_action ( 'init', array( __CLASS__, 'init' ) );
            add_action ( 'wp_head', array( __CLASS__, 'set_styles' ) );
            add_action ( 'admin_init', array( __CLASS__, 'register_lgv_options' ) );
            add_action ( 'woocommerce_after_shop_loop_item', array( __CLASS__, 'additional_product_data' ) );
            add_action ( "widgets_init", function () {
                register_widget("berocket_lgv_widget");
            });
            add_filter ( 'post_class', array( __CLASS__, 'post_class' ), 9999 );
            add_action ( 'admin_menu', array( __CLASS__, 'lgv_options' ) );
            add_shortcode( 'br_grid_list', array( __CLASS__, 'shortcode' ) );
        }
    }
    /**
     * Function that use for WordPress init action
     *
     * @return void
     */
    public static function init () {
        $lgv_options = BeRocket_LGV::get_lgv_option('br_lgv_buttons_page_option');
        BeRocket_LGV::$br_lgv_cookie_defaults[0] = $lgv_options['default_style'];
        br_lgv_get_cookie( 0, true );
        wp_enqueue_script("jquery");
        wp_enqueue_script( 'berocket_jquery_cookie', plugins_url( 'js/jquery.cookie.js', __FILE__ ), array( 'jquery' ), BeRocket_List_Grid_version );
        wp_enqueue_script( 'berocket_lgv_grid_list', plugins_url( 'js/grid_view.js', __FILE__ ), array( 'jquery' ), BeRocket_List_Grid_version );
        $lgv_js_options = BeRocket_LGV::get_lgv_option('br_lgv_javascript_option');
        if ( @ $lgv_js_options['script'] && is_array( $lgv_js_options['script'] ) ) {
            $lgv_js_options['script'] = array_merge( BeRocket_LGV::$defaults['br_lgv_javascript_option']['script'], $lgv_js_options['script'] );
        } else {
            $lgv_js_options['script'] = BeRocket_LGV::$defaults['br_lgv_javascript_option']['script'];
        }
        wp_localize_script(
            'berocket_lgv_grid_list',
            'lgv_options',
            array( 'user_func' => apply_filters( 'berocket_lgv_user_func', $lgv_js_options['script'] ) )
        );
        wp_register_style( 'berocket_lgv_style', plugins_url( 'css/shop_lgv.css', __FILE__ ), "", BeRocket_List_Grid_version );
        wp_enqueue_style( 'berocket_lgv_style' );
        wp_register_style( 'font-awesome', plugins_url( 'css/font-awesome.min.css', __FILE__ ) );
        wp_enqueue_style( 'font-awesome' );
        $lgv_options_pc = BeRocket_LGV::get_lgv_option('br_lgv_product_count_option');
        if( @ $lgv_options['above_order'] ) {
            add_action ( 'woocommerce_before_shop_loop', array(__CLASS__, 'show_buttons_fix'), 3 );
        }
        if( @ $lgv_options['under_order'] ) {
            add_action ( 'woocommerce_before_shop_loop', array(__CLASS__, 'show_buttons_fix'), 100 );
        }
        if( @ $lgv_options['above_paging'] ) {
            add_action ( 'woocommerce_after_shop_loop', array(__CLASS__, 'show_buttons_fix'), 3 );
        }
        add_action ( 'br_lgv_before_list_grid_buttons', array(__CLASS__, 'show_product_count'), 20 );
        if ( @ $lgv_options_pc['use'] ) {
            $product_count_per_page = br_lgv_get_cookie( 1 );
            if( (int)$product_count_per_page ) {
                add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.$product_count_per_page.';' ), 999999 );
            } elseif ( $product_count_per_page == 'all' ) {
                add_filter( 'loop_shop_per_page', create_function( '$cols', 'return -1;' ), 999999 );
            } elseif ( @ $lgv_options_pc['products_per_page'] ) {
                add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.@ $lgv_options_pc['products_per_page'].';' ), 999999 );
            }
        } elseif ( @ $lgv_options_pc['products_per_page'] ) {
            add_filter( 'loop_shop_per_page', create_function( '$cols', 'return '.@ $lgv_options_pc['products_per_page'].';' ), 999999 );
        }
    }

    /**
     * Function set styles in wp_head WordPress action
     *
     * @return void
     */
    public static function set_styles () {
        $lgv_options = BeRocket_LGV::get_lgv_option('br_lgv_buttons_page_option');
        $lgv_pc_options = BeRocket_LGV::get_lgv_option('br_lgv_product_count_option');
        $lgv_ls_options = BeRocket_LGV::get_lgv_option('br_lgv_liststyle_option');
        ?>
        <style>
            <?php if ( ! @ $lgv_options['custom_class'] ) { ?>
                div.berocket_lgv_widget a.berocket_lgv_button{
                    <?php echo @ $lgv_options['button_style']['normal'] ?>
                }
                div.berocket_lgv_widget a.berocket_lgv_button:hover{
                    <?php echo @ $lgv_options['button_style']['hover'] ?>
                }
                div.berocket_lgv_widget a.berocket_lgv_button.selected{
                    <?php echo @ $lgv_options['button_style']['selected'] ?>
                }
            <?php } ?>
            .br_lgv_product_count_block span.br_lgv_product_count{
                <?php echo @ $lgv_pc_options['button_style']['split'] ?>
            }
            .br_lgv_product_count_block span.br_lgv_product_count.text{
                <?php echo @ $lgv_pc_options['button_style']['text'] ?>
            }
        </style>
        <?php
    }
    /**
     * Function add inside product additional data
     *
     * @return void
     */
    public static function additional_product_data() {
        if ( is_product_category() || is_shop() ) {
            $template = 'additional_product_data';
            BeRocket_LGV::br_get_template_part( apply_filters( 'lgv_product_data_template', $template ) );
        }
    }
    /**
     * Filter for add additional class to products in shop
     *
     * @param array $classes array with classes
     *
     * @return array
     */
    public static function post_class ( $classes ) {
        if ( in_array( 'product', $classes ) && ( is_product_category() || is_shop() ) ) {
            $product_style = br_lgv_get_cookie ( 0 );
            if ( $product_style == 'list' ) {
                $classes[] = 'berocket_lgv_list';
            } else {
                $classes[] = 'berocket_lgv_grid';
            }
            $classes[] = 'berocket_lgv_list_grid';
            apply_filters( 'lgv_product_classes', $classes );
        }
        return $classes;
    }
    /**
     * Load template
     *
     * @access public
     *
     * @param string $name template name
     *
     * @return void
     */
    public static function br_get_template_part( $name = '' ) {
        $template = '';

        // Look in your_child_theme/woocommerce-filters/name.php
        if ( $name ) {
            $template = locate_template( "woocommerce-list-grid/{$name}.php" );
        }

        // Get default slug-name.php
        if ( ! $template && $name && file_exists( LGV_TEMPLATE_PATH . "{$name}.php" ) ) {
            $template = LGV_TEMPLATE_PATH . "{$name}.php";
        }

        // Allow 3rd party plugin filter template file from their plugin
        $template = apply_filters( 'lgv_get_template_part', $template, $name );

        if ( $template ) {
            load_template( $template, false );
        }
    }
    /**
     * Function display List/Grid buttons
     *
     * @access public
     *
     * @return void
     */
    public static function show_buttons_fix() {
        $lgv_options = BeRocket_LGV::get_lgv_option('br_lgv_buttons_page_option');
        echo '<div style="clear:both;"></div>';
        set_query_var( 'title', '' );
        set_query_var( 'position', apply_filters( 'lgv_buttons_position', @ $lgv_options['position'] ) );
        set_query_var( 'padding', apply_filters( 'lgv_buttons_padding', @ $lgv_options['padding'] ) );
        set_query_var( 'custom_class', apply_filters( 'lgv_buttons_custom_class', @ $lgv_options['custom_class'] ) );
        BeRocket_LGV::br_get_template_part( apply_filters( 'lgv_buttons_template', 'list-grid' ) );
        echo '<div style="clear:both;"></div>';
    }
    /**
     * Function display product count links
     *
     * @access public
     *
     * @return void
     */
    public static function show_product_count() {
        $lgv_options_pc = BeRocket_LGV::get_lgv_option('br_lgv_product_count_option');
        if ( @ $lgv_options_pc['use'] ) {
            set_query_var( 'position', apply_filters( 'lgv_product_count_position', '' ) );
            set_query_var( 'custom_class', apply_filters( 'lgv_product_count_custom_class', @ $lgv_options_pc['custom_class'] ) );
            BeRocket_LGV::br_get_template_part( apply_filters( 'lgv_product_count_template', 'product_count' ) );
        }
    }
    /**
     * Function display product count links with clear fix divs before and after
     *
     * @access public
     *
     * @return void
     */
    public static function show_product_count_fix() {
        $lgv_options_pc = BeRocket_LGV::get_lgv_option('br_lgv_product_count_option');
        if ( @ $lgv_options_pc['use'] ) {
            echo '<div style="clear:both;"></div>';
            set_query_var( 'position', apply_filters( 'lgv_product_count_fix_position', @ $lgv_options_pc['position'] ) );
            set_query_var( 'custom_class', apply_filters( 'lgv_product_count_fix_custom_class', @ $lgv_options_pc['custom_class'] ) );
            BeRocket_LGV::br_get_template_part( apply_filters( 'lgv_product_count_template', 'product_count' ) );
            echo '<div style="clear:both;"></div>';
        }
    }
    /**
     * Function adding styles/scripts and settings to admin_init WordPress action
     *
     * @access public
     *
     * @return void
     */
    public static function register_lgv_options () {
        wp_enqueue_script( 'berocket_aapf_widget-colorpicker', plugins_url( 'js/colpick.js', __FILE__ ), array( 'jquery' ) );
        wp_enqueue_script( 'berocket_lgv_admin', plugins_url( 'js/admin_lgv.js', __FILE__ ), array( 'jquery' ), BeRocket_List_Grid_version );
        wp_register_style( 'berocket_aapf_widget-colorpicker-style', plugins_url( 'css/colpick.css', __FILE__ ) );
        wp_enqueue_style( 'berocket_aapf_widget-colorpicker-style' );
        wp_register_style( 'berocket_lgv_admin_style', plugins_url( 'css/admin_lgv.css', __FILE__ ), "", BeRocket_List_Grid_version );
        wp_enqueue_style( 'berocket_lgv_admin_style' );
        register_setting('br_lgv_buttons_page_option', 'br_lgv_buttons_page_option', array( __CLASS__, 'sanitize_lgv_option' ));
        register_setting('br_lgv_product_count_option', 'br_lgv_product_count_option', array( __CLASS__, 'sanitize_lgv_option' ));
        register_setting('br_lgv_liststyle_option', 'br_lgv_liststyle_option', array( __CLASS__, 'sanitize_lgv_option' ));
        register_setting('br_lgv_css_option', 'br_lgv_css_option', array( __CLASS__, 'sanitize_lgv_option' ));
        register_setting('br_lgv_javascript_option', 'br_lgv_javascript_option', array( __CLASS__, 'sanitize_lgv_option' ));
        add_settings_section( 
            'br_lgv_buttons_page',
            'Grid/List View Buttons Settings',
            'br_lgv_buttons_display_callback',
            'br_lgv_buttons_page_option'
        );

        add_settings_section( 
            'br_lgv_products_count_page',
            'Grid/List View Products Count Settings',
            'br_lgv_product_count_display_callback',
            'br_lgv_product_count_option'
        );

        add_settings_section( 
            'br_lgv_liststyle_page',
            'Grid/List View List Style Settings',
            'br_lgv_liststyle_display_callback',
            'br_lgv_liststyle_option'
        );

        add_settings_section( 
            'br_lgv_css_page',
            'Grid/List View List CSS Settings',
            'br_lgv_css_display_callback',
            'br_lgv_css_option'
        );
        add_settings_section( 
            'br_lgv_javascript_page',
            'Grid/List View List JavaScript Settings',
            'br_lgv_javascript_display_callback',
            'br_lgv_javascript_option'
        );
    }
    /**
     * Function add options button to admin panel
     *
     * @access public
     *
     * @return void
     */
    public static function lgv_options() {
        add_submenu_page( 'woocommerce', __('Grid/List View settings', 'BeRocket_LGV_domain'), __('Grid/List View', 'BeRocket_LGV_domain'), 'manage_options', 'br-list-grid-view', array(
            __CLASS__,
            'lgv_option_form'
        ) );
    }
    /**
     * Function add options form to settings page
     *
     * @access public
     *
     * @return void
     */
    public static function lgv_option_form() {
        include LGV_TEMPLATE_PATH . "settings.php";
    }
    /**
     * Function set default settings to database
     *
     * @return void
     */
    public function activation () {
        foreach ( self::$defaults as $key => $val ) {
            $options = BeRocket_LGV::get_lgv_option( $key );
            foreach ( $val as $key2 => $val2 ) {
                $options[ $key2 ] = $val2;
            }
            update_option( $key, $options );
        }
    }
    /**
     * Function remove settings from database
     *
     * @return void
     */
    public function deactivation () {
        foreach ( self::$defaults as $key => $val ) {
            delete_option( $key );
        }
    }
    
    public static function sanitize_lgv_option( $input ) {
        $default = BeRocket_LGV::$defaults[$input['settings_name']];
        $result = self::recursive_array_set( $default, $input );
        return $result;
    }
    public static function recursive_array_set( $default, $options ) {
        foreach( $default as $key => $value ) {
            if( array_key_exists( $key, $options ) ) {
                if( is_array( $value ) ) {
                    if( is_array( $options[$key] ) ) {
                        $result[$key] = self::recursive_array_set( $value, $options[$key] );
                    } else {
                        $result[$key] = self::recursive_array_set( $value, array() );
                    }
                } else {
                    $result[$key] = $options[$key];
                }
            } else {
                if( is_array( $value ) ) {
                    $result[$key] = self::recursive_array_set( $value, array() );
                } else {
                    $result[$key] = '';
                }
            }
        }
        return $result;
    }
    public static function get_lgv_option( $option_name ) {
        $options = get_option( $option_name );
        if ( @ $options && is_array ( $options ) ) {
            $options = array_merge( BeRocket_LGV::$defaults[$option_name], $options );
        } else {
            $options = BeRocket_LGV::$defaults[$option_name];
        }
        return $options;
    }
}

new BeRocket_LGV;
