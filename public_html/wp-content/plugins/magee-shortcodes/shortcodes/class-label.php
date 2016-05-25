<?php
class Magee_Label {
    
	
	public static $args;
	private $id;
    
	/**
	 * Initiate the shortcode
	 */
    public function __construct() {
	 
	    add_shortcode( 'ms_label', array( $this,'render' ) );
	
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
				 'background_color'         => '',
			 ),$args
	     );
	    
		 extract( $defaults );
		 self::$args = $defaults;

		 $html = sprintf('<span class="label magee-label" style="background-color:%s;">%s</span>',$background_color,do_shortcode($content));
		 
		 return $html;
		 
	}	 
}

new Magee_Label(); 