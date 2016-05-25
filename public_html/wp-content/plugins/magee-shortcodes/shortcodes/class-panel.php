<?php
class Magee_Panel {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_panel', array( $this, 'render' ) );
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
				'title' 				=>'',
				'border_color'			=>'',
				'title_background_color' =>'',
				'title_color' 		=>'',
				'border_radius'			=>'',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$add_class  = uniqid('panel-');
		$class     .= ' '.$add_class;
		$css_style  = '';
		
		if( is_numeric($border_radius) )
		$border_radius = $border_radius.'px';

		if( $title_color )
		$css_style .= '.'.$add_class.' h3.panel-title{color:'.esc_attr($title_color).';}';
		if( $border_color )
		$css_style .= '.'.$add_class.'{border-color:'.esc_attr($border_color).';}';
		if( $title_background_color )
		$css_style .= '.'.$add_class.' .panel-heading{background-color:'.esc_attr($title_background_color).';over-flow:hidden;}';
		
		if( $border_radius )
		$css_style .= '.'.$add_class.'{border-radius:'.esc_attr($border_radius).';}';
		
		$styles  = sprintf( '<style type="text/css" scoped="scoped">%s </style>',$css_style);		
		$content = do_shortcode( Magee_Core::fix_shortcodes($content));
        $html    = sprintf('%s<div class="panel magee-panel %s" id="%s">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">%s</h3>
                                        </div>
                                        <div class="panel-body">
                                            %s
                                        </div>
                                    </div>',$styles,esc_attr($class),esc_attr($id),esc_attr($title),$content);
		
		return $html;
	}
	
}

new Magee_Panel();