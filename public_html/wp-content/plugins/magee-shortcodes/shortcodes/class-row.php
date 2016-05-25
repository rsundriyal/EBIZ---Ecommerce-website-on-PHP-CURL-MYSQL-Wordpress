<?php
class Magee_Row {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_row', array( $this, 'render' ) );
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
				'id' 					=>'',
				'class' 				=>'',
				'no_padding'         =>''
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		
		if( $no_padding == 'yes')
		$class .= ' no-padding';

		$html = sprintf('<div id="%s" class="%s row">%s</div>',$id,$class,do_shortcode( Magee_Core::fix_shortcodes($content)));
  	
		return $html;
	}
	
}

new Magee_Row();