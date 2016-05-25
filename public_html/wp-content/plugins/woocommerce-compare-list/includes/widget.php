<?php

// +----------------------------------------------------------------------+
// | Copyright 2014  Madpixels  (email : contact@madpixels.net)           |
// +----------------------------------------------------------------------+
// | This program is free software; you can redistribute it and/or modify |
// | it under the terms of the GNU General Public License, version 2, as  |
// | published by the Free Software Foundation.                           |
// |                                                                      |
// | This program is distributed in the hope that it will be useful,      |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the        |
// | GNU General Public License for more details.                         |
// |                                                                      |
// | You should have received a copy of the GNU General Public License    |
// | along with this program; if not, write to the Free Software          |
// | Foundation, Inc., 51 Franklin St, Fifth Floor, Boston,               |
// | MA 02110-1301 USA                                                    |
// +----------------------------------------------------------------------+
// | Author: Eugene Manuilov <eugene.manuilov@gmail.com>                  |
// +----------------------------------------------------------------------+

// prevent direct access
if ( !defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 404 Not Found', true, 404 );
	exit;
}

// add action hooks
add_action( 'widgets_init', 'wccm_widgets_init' );

/**
 * Registers widgets.
 *
 * @since 1.1.0
 * @action widgets_init
 */
function wccm_widgets_init() {
	register_widget( 'WCCM_Widget_Recent_Compares' );
}

/**
 * Recent compare lists widget.
 *
 * @since 1.1.0
 */
class WCCM_Widget_Recent_Compares extends WP_Widget {

	/**
	 * Constructor.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 */
	public function __construct() {
		parent::__construct( 'wccm_recent_compare_lists', esc_html__( 'WooCommerce Recent Compares', 'wccm' ), array(
			'description' => esc_html__( 'Shows a list of user most recent compares on your site.', 'wccm' ),
		) );
	}

	/**
	 * Renders widget settings form.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 * @param array $instance The array of values, associated with current widget instance.
	 */
	public function form( $instance ) {
		$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$width = isset( $instance['width'] ) ? esc_attr( $instance['width'] ) : '';
		$height = isset( $instance['height'] ) ? esc_attr( $instance['height'] ) : '';

		?><p><label for="<?php echo $this->get_field_id( 'title' ) ?>"><?php esc_html_e( 'Title:', 'wccm' ) ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ) ?>" name="<?php echo $this->get_field_name( 'title' ) ?>" type="text" value="<?php echo $title ?>"></p>

		<p><label for="<?php echo $this->get_field_id( 'width' ) ?>"><?php esc_html_e( 'Thumbnails Width:', 'wccm' ) ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'width' ) ?>" name="<?php echo $this->get_field_name( 'width' ) ?>" type="text" value="<?php echo $width ?>"></p>

		<p><label for="<?php echo $this->get_field_id( 'height' ) ?>"><?php esc_html_e( 'Thumbnails Height:', 'wccm' ) ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'height' ) ?>" name="<?php echo $this->get_field_name( 'height' ) ?>" type="text" value="<?php echo $height ?>"></p><?php
	}

	/**
	 * Renders widget.
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 * @param array $args The array of widget settings.
	 * @param array $instance The array of widget instance settings.
	 */
	public function widget( $args, $instance ) {
		$lists = isset( $_COOKIE['compare-lists'] ) ? explode( ',', $_COOKIE['compare-lists'] ) : array();
		if ( empty( $lists ) ) {
			return;
		}

		$thumbs = array();
		$filter_options = array(
			'options' => array(
				'min_range' => 16,
				'default'   => 48,
			),
		);

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? __( 'Recent Compares', 'wccm' ) : $instance['title'], $instance, $this->id_base );
		$width = !empty( $instance['width'] ) ? filter_var( $instance['width'], FILTER_VALIDATE_INT, $filter_options ) : 48;
		$height = !empty( $instance['height'] ) ? filter_var( $instance['height'], FILTER_VALIDATE_INT, $filter_options ) : 48;

		echo $args['before_widget'];
			echo $args['before_title'], $title, $args['after_title'];

			foreach ( $lists as $list ) {
				$ids = array_filter( array_map( 'intval', explode( '-', $list ) ) );
				echo '<p>';
					echo '<a href="', wccm_get_compare_page_link( $ids ), '">';
						foreach ( $ids as $id ) {
							if ( !isset( $thumbs[$id] ) ) {
								$thumbs[$id] = get_the_post_thumbnail( $id, array( $width, $height ) );
							}

							echo $thumbs[$id];
						}
					echo '</a>';
				echo '</p>';
			}
		echo $args['after_widget'];
	}

}