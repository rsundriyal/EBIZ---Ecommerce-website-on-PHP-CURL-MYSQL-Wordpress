<?php
class Magee_Dailymotion {
    
	
	public static $args;
	private $id;
    
	/**
	 * Initiate the shortcode
	 */
    public function __construct() {
	 
	    add_shortcode( 'ms_dailymotion', array( $this,'render' ) );
	
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
				 'link'                  =>'',
				 'autoplay'              =>'',
				 'loop'                  =>'',    
				 'controls'              =>'',  
			 ),$args
	     );
	    
		 extract( $defaults );
		 self::$args = $defaults;
		 if(is_numeric($width))
			$width = $width.'px';
		 if(is_numeric($height))
			$height = $height.'px'; 
		 if( $autoplay == 'yes'):
		    $autoplay = '1';
		 else:
		    $autoplay = '0';
	     endif;
		 if( $loop == 'yes'):
		    $loop = '1';
		 else:
		    $loop = '0';
	     endif;
		 if( $controls == 'yes'):
		    $controls = '1';
		 else:
		    $controls = '0';
	     endif;
		 if( $mute == 'yes'):
		    $mute = '1';
		 else:	 
		    $mute = '0';
		 endif; 
		 if( $link !== '') 
		 $link = strtok(basename(esc_url($link)),'_');
		 if( $width == '100%' || $width == '' &&  $height == '100%' || $height == ''):
		 $html = '<div id="dailymotion"><iframe id="'.esc_attr($id).'" class="'.esc_attr($class).'" src="//www.dailymotion.com/embed/video/' . $link . '?autoplay='.$autoplay.'&loop='.$loop.'&controls='.$controls.'&mute='.$mute.'" frameborder="0" allowfullscreen></iframe></div>';
		 
		 $html .= '<script>     
		 jQuery(function($) {
						if($("#magee-sc-form-preview").length>0){
							 $("#magee-sc-form-preview").ready(function(){
							 width = $("#magee-sc-form-preview").contents().find("#dailymotion").width();
							 iframewidth = $("#magee-sc-form-preview").contents().find("iframe").eq(0).width();
							 iframeheight = $("#magee-sc-form-preview").contents().find("iframe").eq(0).height();
							 op = iframeheight/iframewidth;
							 $("#magee-sc-form-preview").contents().find("iframe").eq(0).width(width-100);
							 $("#magee-sc-form-preview").contents().find("iframe").eq(0).height(op*width-100);
							 }); 
						
						}else{
							 $(document).ready(function(){
							 width = $("#dailymotion").width();
							 iframewidth = $("iframe").eq(0).width();
							 iframeheight = $("iframe").eq(0).height();
							 op = iframeheight/iframewidth;
							 $("iframe").eq(0).width(width);
							 $("iframe").eq(0).height(op*width);
							
							}); 
						}     
          });
		            </script>';
		else:
		$html = '<div id="dailymotion"><iframe id="'.esc_attr($id).'" class="'.esc_attr($class).'" width="'.$width.'" height="'.$height.'" src="//www.dailymotion.com/embed/video/' . $link . '?autoplay='.$autoplay.'&loop='.$loop.'&controls='.$controls.'&mute='.$mute.'" frameborder="0" allowfullscreen></iframe></div>';
		endif;		   
		 return $html;
	 } 
	 
}

new Magee_Dailymotion();		 