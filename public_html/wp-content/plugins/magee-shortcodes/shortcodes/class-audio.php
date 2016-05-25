<?php
class Magee_Audio {
    
	
	public static $args;
	private $id;
    
	/**
	 * Initiate the shortcode
	 */
    public function __construct() {
	 
	    add_shortcode( 'ms_audio', array( $this,'render' ) );
	
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
				 'mute'                  =>'',
				 'mp3'                   =>'',
				 'ogg'                   =>'',
				 'wav'                   =>'',
				 'autoplay'              =>'',
				 'loop'                  =>'',    
				 'controls'              =>'', 
			 ),$args
	     );
	     
		 extract( $defaults );
		 self::$args = $defaults;
		 if( $mute =='yes'):
		 $mute = 'muted';
		 else:
		 $mute = '';
		 endif;
		 if( $autoplay == 'yes'):
		 $autoplay = 'autoplay';
		 else:
		 $autoplay = '';
		 endif;
		 if( $loop == 'yes'):
		 $loop = 'loop';
		 else:
		 $loop = '';
		 endif;
		 if( $controls == 'yes'):
		 $controls = 'controls';
		 else:
		 $controls = '';
		 endif;
		 $html = '<audio class="'.esc_attr($class).'" id="'.esc_attr($id).'" '.esc_attr($autoplay).' '.esc_attr($loop).' '.esc_attr($mute).' '.esc_attr($controls).'>';
		 if( !empty($mp3)){
		 $html .= '<source src="'.esc_url($mp3).'" type="audio/mpeg">';
		 }
		 if( !empty($ogg)){
		 $html .= '<source src="'.esc_url($ogg).'" type="audio/ogg">' ;
		 }
		 if( !empty($wav)){
		 $html .= '<source src="'.esc_url($ogg).'" type="audio/wav">' ;
		 }
		 $html .= 'Your browser does not support the audio element.' ;
		 $html .='</audio>'	 ;
		 return $html;
	 } 	 
}		 
new Magee_Audio();		 