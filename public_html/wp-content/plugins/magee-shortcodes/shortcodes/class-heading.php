<?php
class Magee_Title {

	public static $args;
    private  $id;


	/**
	 * Initiate the shortcode
	 */
	public function __construct() {

        add_shortcode( 'ms_heading', array( $this, 'render' ) );
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
				'id' 					=> '',
				'class' 				=> '',
				'style'					=> 'none',	
				'color'				    => '',
				'border_color'          => '',
				'text_align'            => '',
				'font_weight'            => '400',
				'font_size'            => '36px',
				'margin_top'            => '',
				'margin_bottom'         => '',
				'border_width'           => '5px',
				'responsive_text'       => '',
			), $args 
		);
		
		extract( $defaults );
		self::$args = $defaults;
		
		
		$uniqid = uniqid('heading-');
		$class .=' '.$uniqid;
 		if(is_numeric($font_size))
		$font_size = $font_size.'px';
		if(is_numeric($font_weight))
		$font_weight = $font_weight.'px';
		if(is_numeric($margin_top))
		$margin_top = $margin_top.'px';
		if(is_numeric($margin_bottom))
		$margin_bottom = $margin_bottom.'px';
		if(is_numeric($border_width))
		$border_width = $border_width.'px';
		
		$html  = '<style type="text/css">
		                          
                                    .'.$uniqid.'.magee-heading{
                                        font-size:'.$font_size.';
                                        font-weight:'.$font_weight.';
                                        margin-top:'.$margin_top.';
                                        margin-bottom:'.$margin_bottom.';
                                        color: '.$color.';
                                        border-color: '.$border_color.';
                                        text-align: '.$text_align.';
                                    }
                                    .'.$uniqid.'.heading-border .heading-inner {
                                        border-width: '.$border_width.';
                                    }
								.'.$uniqid.'.heading-doubleline .heading-inner:before,
								.'.$uniqid.'.heading-doubleline .heading-inner:after {
									    border-color: '.$border_color.';
									    border-width: '.$border_width.';
									}
                                </style>';
		if( $responsive_text == 'yes'){
		$html .= '<script>' ; 
		$html .= 'jQuery(function($) {  
		          if($("#magee-sc-form-preview").length>0){
				  
				     $("#magee-sc-form-preview").ready(function(){
					      if($("#magee-sc-form-preview").contents().find("body").width() <1200){	
						  newPercentage = (($("#magee-sc-form-preview").contents().find("body").width() / 1200) * 100) + "%";
						  $("#magee-sc-form-preview").contents().find(".'.$uniqid.' .heading-inner").css({"font-size": newPercentage});
						  }	
					 });
				     $("#preview",window.parent.document).resize(function (){
					      
						  if($("#magee-sc-form-preview").contents().find("body").width() <1200){
						  newPercentage = (($("#magee-sc-form-preview").contents().find("body").width() / 1200) * 100) + "%";
						  $("#magee-sc-form-preview").contents().find(".'.$uniqid.' .heading-inner").css({"font-size": newPercentage});
						  }else{
						  $("#magee-sc-form-preview").contents().find(".'.$uniqid.' .heading-inner").css({"font-size": "'.$font_size.'"});
						  }
					  });     
				  }else{
				      $(document).ready(function () {	
						  if($(window).width() <1200){	
						  newPercentage = (($(window).width() / 1200) * 100) + "%";
						  $(".'.$uniqid.' .heading-inner").css({"font-size": newPercentage});
						  }	
					  });			
					  $(window).on("resize", function (){
						  if($(window).width() <1200){
						  newPercentage = (($(window).width() / 1200) * 100) + "%";
						  $(".'.$uniqid.' .heading-inner").css({"font-size": newPercentage});
						  }else{
						  $(".'.$uniqid.' .heading-inner").css({"font-size": "'.$font_size.'"});
						  }
					  });   
				  
				  
				  }    	
					  
		         });
		     </script>' ;
		}	
		if( $style == 'none'){
		$html .= '<h1 class="magee-heading  '.esc_attr($class).'" id="'.$id.'"><span class="heading-inner">'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</span></h1>';
		}else{					
		$html .= '<h1 class="magee-heading heading-'.$style.' '.esc_attr($class).'" id="'.$id.'"><span class="heading-inner">'.do_shortcode( Magee_Core::fix_shortcodes($content)).'</span></h1>'; }
		
		
		return $html;
	}
	
}

new Magee_Title();