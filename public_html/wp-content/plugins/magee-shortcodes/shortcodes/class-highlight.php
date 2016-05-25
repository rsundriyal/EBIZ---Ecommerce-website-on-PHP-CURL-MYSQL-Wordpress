<?php
class Magee_Highlight {

	public static $args;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

		add_filter( 'magee_attr_highlight-shortcode', array( $this, 'attr' ) );
		add_shortcode( 'ms_highlight', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode
	 * @param  array $args	 Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string		  HTML output
	 */
	function render( $args, $content = '') {

		$defaults = Magee_Core::set_shortcode_defaults(
			array(
				'class'		=> '',			
				'id'		=> '',
				'background_color' => '#007005',
				'border_radius'	=> '0',
			), $args 
		);

		extract( $defaults );

		self::$args = $defaults;
		
		$html = sprintf( '<span %s>%s</span>', Magee_Core::attributes( 'highlight-shortcode' ), do_shortcode( Magee_Core::fix_shortcodes($content)) );

		return $html;

	}

	function attr() {
	
		$attr = array();

		$attr['class'] = 'magee-highlight';

		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class']; 
		}
		
		if( self::$args['id'] ) {
			$attr['id'] = self::$args['id']; 
		}

	   if(is_numeric(self::$args['border_radius']))
	   self::$args['border_radius'] = self::$args['border_radius'].'px';
	   	
	   $attr['style']  = sprintf( 'border-radius:%s;', self::$args['border_radius'] );
	   $attr['style'] .= sprintf( 'background-color:%s;', self::$args['background_color'] );

		return $attr;

	}

}

new Magee_Highlight();