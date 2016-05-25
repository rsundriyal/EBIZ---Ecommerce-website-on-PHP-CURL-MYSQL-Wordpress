<?php
class Magee_Menu {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_menu', array( $this, 'render' ) );
	}

	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
	function render( $args, $content = '') {

		$defaults =	Magee_Core::set_shortcode_defaults(
			array(
				'menu'      => '',
				'class'      => '',
				'id'    => '',
			), $args
		);
		extract( $defaults );
		self::$args = $defaults;
		if(isset($menu)):
		$menus = array(
		   'menu' => esc_attr($menu),
		   'items_wrap' => '<ul id="%1$s '.esc_attr($id).'" class="%2$s ' . esc_attr($class) . '">%3$s</ul>'
		);
		$html = wp_nav_menu($menus);
		return $html;
		endif;
   }
}

new Magee_Menu();		