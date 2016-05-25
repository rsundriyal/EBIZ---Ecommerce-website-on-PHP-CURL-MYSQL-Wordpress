<?php
/**
 * Main class
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Ajax Navigation
 * @version 1.1.4
 */

if ( !defined( 'YITH_WOOCOMPARE' ) ) { exit; } // Exit if accessed directly

if( !class_exists( 'YITH_WOOCOMPARE' ) ) {
    /**
     * YITH WooCommerce Ajax Navigation Widget
     *
     * @since 1.0.0
     */
    class YITH_Woocompare_Widget extends WP_Widget {

        function __construct() {
            $widget_ops = array (
	            'classname' => 'yith-woocompare-widget',
	            'description' => __( 'The widget show the list of products added in the compare table.', 'yith-woocommerce-compare'
	            )
            );

	        parent::__construct( 'yith-woocompare-widget', __( 'YITH Woocommerce Compare Widget', 'yith-woocommerce-compare' ), $widget_ops );
        }


        function widget( $args, $instance ) {
            global $yith_woocompare;

            /**
             * WPML Support
             */
            $lang = defined( 'ICL_LANGUAGE_CODE' ) ? ICL_LANGUAGE_CODE : false;

            extract( $args );

            yit_wpml_register_string( 'Widget', 'widget_yit_compare_title_text', $instance['title'] );
            $localized_widget_title = yit_wpml_string_translate( 'Widget', 'widget_yit_compare_title_text', $instance['title'] );

            echo $before_widget . $before_title . $localized_widget_title . $after_title; ?>

            <ul class="products-list" data-lang="<?php echo $lang ?>">
                <?php echo $yith_woocompare->obj->list_products_html(); ?>
            </ul>

            <a href="<?php echo $yith_woocompare->obj->remove_product_url('all') ?>" data-product_id="all" class="clear-all"><?php _e( 'Clear all', 'yith-woocommerce-compare' ) ?></a>
            <a href="<?php echo add_query_arg( array( 'iframe' => 'true' ), $yith_woocompare->obj->view_table_url() ) ?>" class="compare button"><?php _e( 'Compare', 'yith-woocommerce-compare' ) ?></a>

            <?php echo $after_widget;
        }


        function form( $instance ) {
            global $woocommerce;

            $defaults = array(
                'title' => '',
            );

            $instance = wp_parse_args( (array) $instance, $defaults ); ?>

            <p>
                <label>
                    <strong><?php _e( 'Title', 'yit' ) ?>:</strong><br />
                    <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
                </label>
            </p>
        <?php
        }

        function update( $new_instance, $old_instance ) {
            $instance = $old_instance;

            $instance['title'] = strip_tags( $new_instance['title'] );

            return $instance;
        }

    }
}