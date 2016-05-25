<?php
class Magee_Icon {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_icon', array( $this, 'render' ) );
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
				'id' =>'',
				'class' =>'',
				'icon' =>'',
				'color' => '',
				'size' => '',
				'icon_box' => '',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		if(is_numeric($size))
		$size = $size.'px';
		
		$html      = '';
		$css_style = '';
		$uniqid    = ' magee-fa-icon icon-boxed';
		if( $size )
		$css_style .= 'font-size:'.$size.';';
		if( $icon_box == 'yes'){
		    $icon .= $uniqid;
			if( $color )
			$css_style .= 'background:'.$color.';';
		    if( $icon != '')
			$html = sprintf('<i id="%s" class="%s fa %s" style="%s"></i>',$id,$class,$icon,$css_style); 
			}
		else{
			if( $color )
			$css_style .= 'color:'.$color.';';
			if( $icon != '')
			$html = sprintf('<i id="%s" class="%s fa %s" style="%s"></i>',$id,$class,$icon,$css_style);
  	         }
		return $html;
	}
	
}

new Magee_Icon();