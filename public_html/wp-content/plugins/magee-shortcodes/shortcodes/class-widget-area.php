<?php
class Magee_Widget_Area {
    
	
	public static $args;
	private $id;
    
	/**
	 * Initiate the shortcode
	 */
    public function __construct() {
	 
	    add_shortcode( 'ms_widget_area', array( $this,'render' ) );
	
	}
	/**
	 * Render the shortcode
	 * @param  array $args     Shortcode paramters
	 * @param  string $content Content between shortcode
	 * @return string          HTML output
	 */
     function render( $args, $content = '') {
	     
		 $defaults =  Magee_Core::set_shortcode_defaults(
		     
			 array(
			    'class'			 	=> '',
				'id'				=> '',
				'background_color'	=> '',
				'name'				=> '',
				'padding'			=> ''
			 ),$args
	     );
		 extract( $defaults );
		 self::$args = $defaults;
		 if(is_numeric($padding)){
		 $padding = $padding.'px';
		 }
		 $html = '';
		 $uniqid = uniqid('widget');
		 if(isset($background_color) || isset($padding))
		 $html .= '<style type="text/css" scoped="scoped">.'.$uniqid.'{background-color:'.esc_attr($background_color).';padding:'.esc_attr($padding).';}</style>' ;
		 
         $html .= '<div class="'.esc_attr($class).' '.$uniqid.'" id="'.esc_attr($id).'">';
	     ob_start();
			if ( function_exists( 'dynamic_sidebar' ) &&
				 dynamic_sidebar( $name )
			) {
				// All is good, dynamic_sidebar() already called the rendering
			}
		 $html .= ob_get_clean();
         $html .= '<div class="magee-widget-area">'.do_shortcode( $content ).'</div></div>';   
		 return $html; 
	 } 
	 
}

new Magee_Widget_Area();		 