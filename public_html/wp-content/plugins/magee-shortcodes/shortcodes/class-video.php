<?php
class Magee_Video {
    
	
	public static $args;
	private $id;
    
	/**
	 * Initiate the shortcode
	 */
    public function __construct() {
	 
	    add_shortcode( 'ms_video', array( $this,'render' ) );
	
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
			     'id'                    =>'',
				 'class'                 =>'',
				 'width'                 =>'',
				 'height'                =>'',
				 'mute'                  =>'',
				 'mp4_url'               =>'',
				 'ogv_url'               =>'',
				 'webm_url'               =>'',
				 'poster'                =>'',
				 'autoplay'        =>'',
				 'loop'            =>'',    
				 'controls'        =>'',  
				        'position'   => 'left'
			 ),$args
	     );
	     
		 extract( $defaults );
		 self::$args = $defaults;
		 $html = '';
		 if(is_numeric($width))
			$width = $width.'px';
		 if(is_numeric($height))
			$height = $height.'px'; 
		 if( $mute == 'yes'):
		 $mute = 'muted';
		 else:
		 $mute = '';
		 endif;
		 if( $controls == 'yes'):
		 $controls = 'controls';
		 else:
		 $controls = '';
		 endif;
		 if( $loop == 'yes'):
		 $loop = 'loop';
		 else:
		 $loop = '';
		 endif;
		 if( $autoplay == 'yes'):       
		 $autoplay = 'autoplay'	;
		 else:
		 $autoplay = '';
		 endif;	        
		 if( $mp4_url !=='' || $ogv_url !=='' || $webm_url !=='' ){ $html .= '<video  class="'.esc_attr($class).'" id="'.esc_attr($id).'"  width="'.$width.'" height="'.$height.'" '.$mute.' '.$controls.' '.$loop.' '.$autoplay.' >';
		 $html .= '<source src="'.esc_url($mp4_url).'" type="video/mp4">
		           <source src="'.esc_url($ogv_url).'" type="video/mp4">
				   <source src="'.esc_url($webm_url).'" type="video/mp4">';
		 	      
         $html .= '</video>';}
		 else{
		 
		 $html .= '<image src="'.esc_url($poster).'">'	;
		 }
		 return $html;
		 	 
	 } 
	 
}

new Magee_Video();