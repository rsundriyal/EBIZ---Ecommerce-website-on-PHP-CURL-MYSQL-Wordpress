<?php
class Magee_Alert {

	public static $args;
    private  $id;

	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_alert', array( $this, 'render' ) );
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
				'icon'					=>'',	
				'background_color' 		=>'',
				'text_color' 			=>'',
				//'border_color'		    =>'',
				'border_width'			=>'',
				'border_radius'			=>'',
				'dismissable'			=>'',
				'box_shadow'			=>'',
			), $args
		);
		
		extract( $defaults );
		self::$args = $defaults;
		$add_class  = uniqid('alert-');
		$class     .= ' '.$add_class;
		$css_style  = '';
		$icon_str   = '';
		if( is_numeric($border_width) )
		$border_width = $border_width.'px';
		if( is_numeric($border_radius) )
		$border_radius = $border_radius.'px';
		
		if( $background_color )
		$css_style .= 'background-color:'.esc_attr($background_color).';';
		if( $text_color ){
		$css_style .= 'color:'.esc_attr($text_color).';';
		$css_style .= 'border-color:'.esc_attr($text_color).';';
		}
		if( $border_width )
		$css_style .= 'border-width:'.esc_attr($border_width).';';
		if( $border_radius )
		$css_style .= 'border-radius:'.esc_attr($border_radius).';';
		
		if( $box_shadow == 'yes' )
		$class .= ' box-shadow';
		
		
		if( $dismissable == 'yes' ){
		$icon_str .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>';
		$class .= ' alert-dismissible';
		}
		
		if( stristr($icon,'fa-')):
		$icon_str .= '<i class="fa '.esc_attr($icon).'"></i>';
		else:
		$icon_str .= '<img class="image-instead" src="'.esc_attr($icon).'" style="padding-right:10px"/>';
		
		endif;
		$styles  = sprintf( '<style type="text/css" scoped="scoped">.%s{%s} </style>', $add_class ,$css_style);		
		$content = $icon_str.do_shortcode( Magee_Core::fix_shortcodes($content));
		$script  = '<script>
         jQuery(function($){
						if($("#magee-sc-form-preview").length>0){
								$("#magee-sc-form-preview").contents().find(".close").on("click",function(){
								   $("#magee-sc-form-preview").contents().find(".'.$add_class.'").remove();
								});
						}
				});		
		</script>';
		$html    = sprintf(' %s<div class="alert magee-alert %s " role="alert" id= "%s">%s</div>%s',$styles,$class,$id,$content,$script);
        
		
		return $html;
	}
	
}

new Magee_Alert();