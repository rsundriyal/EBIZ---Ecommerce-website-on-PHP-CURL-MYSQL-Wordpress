<?php
/**
 * List/Grid widget
 */
class BeRocket_LGV_Widget extends WP_Widget 
{
	public function __construct() {
        parent::__construct("berocket_lgv_widget", "WooCommerce Grid/List View",
            array("description" => "Show list/grid view toggle buttons"));
    }
    /**
     * WordPress widget for display List/Grid buttons
     */
    public function widget($args, $instance)
    {
        if ( is_product_category() || is_shop() ) {
            $lgv_options = BeRocket_LGV::get_lgv_option('br_lgv_buttons_page_option');
            set_query_var( 'title', apply_filters( 'lgv_widget_title', @ $instance['title'] ) );
            set_query_var( 'position', @ $instance['position'] );
            set_query_var( 'padding', @ $instance['padding'] );
            set_query_var( 'custom_class', apply_filters( 'lgv_widget_custom_class', @ $lgv_options['custom_class'] ) );
            BeRocket_LGV::br_get_template_part( apply_filters( 'lgv_widget_template', 'list-grid' ) );
        }
	}
    /**
     * Update widget settings
     */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( @ $new_instance['title'] );
		return $instance;
	}
    /**
     * Widget settings form
     */
	public function form($instance)
	{
		$instance = wp_parse_args( (array) $instance, array( 'speed' => '', 'delay' => '' ) );
		$title = @ strip_tags($instance['title']);
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr( @ $title ); ?>" /></p>
		<?php
	}
}
?>