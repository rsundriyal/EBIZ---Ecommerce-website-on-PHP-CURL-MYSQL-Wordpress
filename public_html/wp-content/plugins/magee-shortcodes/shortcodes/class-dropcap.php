<?php
class Magee_Dropcap {

	public static $args;
    private  $id;


	/**
	 * Initiate the shortcode
	 */
	public function __construct() {
		add_filter( 'magee_attr_dropcap-shortcode', array( $this, 'attr' ) );
        add_shortcode( 'ms_dropcap', array( $this, 'render' ) );
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
				'color'             =>'',
				'boxed'				=>'yes',
				'boxed_radius'		=>'0',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		if(is_numeric($boxed_radius))
		$boxed_radius = $boxed_radius.'px';
		
		$html = sprintf( '<span %s>%s</span>', Magee_Core::attributes( 'dropcap-shortcode' ), do_shortcode( Magee_Core::fix_shortcodes($content)) );
		
		return $html;
	}
	
	
	function attr() {

		$attr['class'] = 'magee-dropcap dropcap';
		$attr['style'] = '';
		
		if( self::$args['boxed'] == 'yes' ) {
			$attr['class'] .= ' dropcap-boxed';
			
			if( self::$args['boxed_radius'] || 
				self::$args['boxed_radius'] === '0'
			) {
			    if(is_numeric(self::$args['boxed_radius']))
				self::$args['boxed_radius'] = self::$args['boxed_radius'].'px';
				
				$attr['style'] = sprintf( 'border-radius:%s;', self::$args['boxed_radius'] );
			}			

			$attr['style'] .= sprintf( 'background-color:%s;', self::$args['color'] );	
		} else {
			$attr['style'] .= sprintf( 'color:%s;', self::$args['color'] );
		}
		
		if( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class'];
		}

		if( self::$args['id'] ) {
			$attr['id'] = self::$args['id'];
		}		

		return $attr;

	}
	
}

new Magee_Dropcap();